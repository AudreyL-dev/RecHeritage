<?php
namespace Controllers;
require_once __DIR__ . '/../Models/User.php';
use Models\User;
class UserController
{
    private $userModel;


    public function __construct()
    {
        $this->userModel = new User();
    }
    public function signUp($postData)
    {
        if (empty($postData['email']) || empty($postData['pseudo']) || empty($postData['password']) || empty($postData['confirm_password']) || empty($postData['birthDate'])) {
            $this->redirectWithMessage(BASE_URL . "/views/signUp.php", "Tous les champs sont obligatoires.", "danger");
        }

        if ($postData['password'] !== $postData['confirm_password']) {
            $this->redirectWithMessage(str_replace('/public', '', BASE_URL) . "/views/signUp.php", "Les mots de passe ne correspondent pas.", "danger");
        }

        $message = $this->userModel->createUser(
            $postData['pseudo'],
            $postData['email'],
            $postData['password'],
            $postData['birthDate']
        );

        if ($message === "Inscription réussie.") {
            $this->redirectWithMessage(str_replace('/public', '', BASE_URL) . "/views/signIn.php", "Inscription réussie. Vous pouvez maintenant vous connecter !", "success");
        } else {
            $this->redirectWithMessage(str_replace('/public', '', BASE_URL) . "/views/signUp.php", $message, "danger");
        }
    }
    private function redirectWithMessage($url, $message, $type = 'success')
    {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type; // Ajoute le type du message (success ou danger)
        header("Location: $url");
        exit();
    }
    public function checkEmailAndRedirect($email)
    {
        if ($this->userModel->emailExists($email)) {
            $_SESSION['userEmail'] = $email;
            header('Location: /views/signIn.php');
        } else {
            $_SESSION['userEmail'] = $email;
            header('Location: /views/signUp.php');
        }
        exit();
    }
    public function signIn($postData)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_SESSION['userEmail'] ?? '';
            $password = $postData['signIn_password'] ?? '';

            if (empty($email) || empty($password)) {
                $this->redirectWithMessage("signIn.php", "Veuillez remplir tous les champs.");
            }

            $user = $this->userModel->authenticateUser($email, $password);

            if ($user !== null) {
                $_SESSION['loggedIn'] = true;
                $_SESSION['pseudo'] = $user['pseudo']; // Stocker le pseudo dans la session
                $this->redirectWithMessage("recettes.php", "Connexion réussie, bienvenue " . $user['pseudo'] . " !", "success");
            } else {
                $this->redirectWithMessage("signIn.php", "Identifiants incorrects.", "danger");
            }
        }
    }
    public function signOut()
    {

        session_unset(); // Supprime toutes les variables de session
        session_destroy(); // Détruit la session

        // Passer le message dans l'URL pour éviter qu'il soit supprimé par session_destroy()
        header("Location: " . BASE_URL . "/index.php?message=" . urlencode("Vous avez été déconnecté."));
        exit();
    }
}
