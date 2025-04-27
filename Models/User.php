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
}