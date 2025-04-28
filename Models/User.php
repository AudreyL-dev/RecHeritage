<?php
namespace Models;
require_once __DIR__ . '/Database.php';
use Models\Database;
use PDO;
use PDOException;

class User
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }
    public function getUserById($id)
    {
        try {
            $sql = "SELECT * FROM users WHERE user_id = :id";
            $query = $this->pdo->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur getUserById: " . $e->getMessage());
            return null;
        }
    }
    public function createUser($pseudo, $email, $password, $birthDate)
    {
        try {
            $sql = "INSERT INTO users (pseudo, email, password, birthDate) VALUES (:pseudo, :email, :password, :birthDate)";
            $query = $this->pdo->prepare($sql);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query->bindParam(':pseudo', $pseudo);
            $query->bindParam(':email', $email);
            $query->bindParam(':password', $hashedPassword);
            $query->bindParam(':birthDate', $birthDate);
            $query->execute();
            return "Inscription réussie.";
        } catch (PDOException $e) {
            error_log("Erreur createUser: " . $e->getMessage());
            return "Erreur lors de l'inscription.";
        }
    }

    public function authenticateUser($email, $password)
    {
        try {
            $sql = "SELECT user_id, pseudo, password, email FROM users WHERE email = :email";
            $query = $this->pdo->prepare($sql);
            $query->execute(['email' => $email]);
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return [
                    'user_id' => $user['user_id'],
                    'pseudo' => $user['pseudo'],
                    'email' => $user['email']
                ];
            }
            return null;
        } catch (PDOException $e) {
            error_log("Erreur authenticateUser: " . $e->getMessage());
            return null;
        }
    }

    public function getIdByEmail($email)
    {
        try {
            $sql = "SELECT user_id FROM users WHERE email = :email";
            $query = $this->pdo->prepare($sql);
            $query->execute(['email' => $email]);
            $user = $query->fetch(PDO::FETCH_ASSOC);
            return $user ? $user['user_id'] : null;
        } catch (PDOException $e) {
            error_log("Erreur getIdByEmail: " . $e->getMessage());
            return null;
        }
    }
    public function emailExists($email)
    {
        try {
            $sql = "SELECT email FROM users WHERE email = :email";
            $query = $this->pdo->prepare($sql);
            $query->execute(['email' => $email]);
            return $query->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (PDOException $e) {
            error_log("Erreur emailExists: " . $e->getMessage());
            return false;
        }
    }
    // Trouver un utilisateur par son email
    public function findByEmail(string $email): ?array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->execute(['email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log('Erreur findByEmail : ' . $e->getMessage());
            return null;
        }
    }
    // Sauvegarder un token de réinitialisation
    public function saveResetToken(int $userId, string $token): bool
    {
        try {
            // Appel à ta procédure stockée
            $stmt = $this->pdo->prepare('CALL create_reset_token(:user_id, :token)');
            return $stmt->execute([
                'user_id' => $userId,
                'token' => $token
            ]);
        } catch (PDOException $e) {
            error_log('Erreur saveResetToken : ' . $e->getMessage());
            return false;
        }
    }
    // Trouver un utilisateur par son token de réinitialisation
    public function findByResetToken(string $token): ?array
    {
        try {
            $stmt = $this->pdo->prepare('
            SELECT u.*
            FROM users u
            INNER JOIN password_resets pr ON pr.user_id = u.user_id
            WHERE pr.token = :token
              AND pr.expires_at > NOW()
            LIMIT 1
        ');
            $stmt->execute(['token' => $token]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log('Erreur findByResetToken : ' . $e->getMessage());
            return null;
        }
    }
    // Mettre à jour le mot de passe
    public function updatePassword(int $userId, string $hashedPassword): bool
    {
        try {
            $stmt = $this->pdo->prepare('UPDATE users SET password = :password WHERE user_id = :user_id');
            return $stmt->execute([
                'password' => $hashedPassword,
                'user_id' => $userId
            ]);
        } catch (PDOException $e) {
            error_log('Erreur updatePassword : ' . $e->getMessage());
            return false;
        }
    }
    // Supprimer un token de réinitialisation
    public function clearResetToken(int $userId): bool
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM password_resets WHERE user_id = :user_id');
            return $stmt->execute([
                'user_id' => $userId
            ]);
        } catch (PDOException $e) {
            error_log('Erreur clearResetToken : ' . $e->getMessage());
            return false;
        }
    }

}