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
            $this->redirectWithMessage(route('sign_up'), 'Tous les champs sont obligatoires.', 'danger');
        }

        if ($postData['password'] !== $postData['confirm_password']) {
            $this->redirectWithMessage(route('sign_up'), 'Les mots de passe ne correspondent pas.', 'danger');
        }

        $message = $this->userModel->createUser(
            $postData['pseudo'],
            $postData['email'],
            $postData['password'],
            $postData['birthDate']
        );

        if ($message === 'Inscription réussie.') {
            $this->redirectWithMessage(route('sign_in'), 'Inscription réussie. Vous pouvez maintenant vous connecter !', 'success');
        } else {
            $this->redirectWithMessage(route('sign_up'), $message, 'danger');
        }
    }

    public function checkEmailAndRedirect($email)
    {
        if ($this->userModel->emailExists($email)) {
            $_SESSION['userEmail'] = $email;
            header('Location: ' . route('sign_in'));
        } else {
            $_SESSION['userEmail'] = $email;
            header('Location: ' . route('sign_up'));
        }
        exit();
    }

    public function signIn($postData)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_SESSION['userEmail'] ?? '';
            $password = $postData['signIn_password'] ?? '';

            if (empty($email) || empty($password)) {
                $this->redirectWithMessage(route('sign_in'), 'Veuillez remplir tous les champs.', 'danger');
            }



            $user = $this->userModel->authenticateUser($email, $password);

            if ($user !== null) {
                $_SESSION['loggedIn'] = true;
                $_SESSION['pseudo'] = $user['pseudo'];
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['userEmail'] = $user['email'];

                $this->redirectWithMessage(route('recipes'), 'Connexion réussie, bienvenue ' . $user['pseudo'] . ' !', 'success');
            } else {
                $this->redirectWithMessage(route('sign_in'), 'Identifiants incorrects.', 'danger');
            }
        }
    }

    public function signOut()
    {
        session_unset();
        session_destroy();
        header('Location: ' . route('home'));
        exit();
    }

    private function redirectWithMessage($url, $message, $type = 'success')
    {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type;
        header("Location: $url");
        exit();
    }
}
