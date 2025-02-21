<?php
namespace Controllers;

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
            $this->redirectWithMessage("signUp.php", "Tous les champs sont obligatoires.");
        }

        if ($postData['password'] !== $postData['confirm_password']) {
            $this->redirectWithMessage("signUp.php", "Les mots de passe ne correspondent pas.");
        }

        $message = $this->userModel->createUser(
            $postData['pseudo'],
            $postData['email'],
            $postData['password'],
            $postData['birthDate']
        );

        if ($message === "Inscription réussie.") {
            $this->redirectWithMessage("signIn.php", "Inscription réussie. Vous pouvez maintenant vous connecter !");
        }
    }
    private function redirectWithMessage($url, $message)
    {
        $_SESSION['message'] = $message;
        header("Location: $url");
        exit();
    }
    public function checkEmailAndRedirect($email)
    {
        if ($this->userModel->emailExists($email)) {
            $_SESSION['userEmail'] = $email;
            header('Location: signIn.php');
        } else {
            $_SESSION['userEmail'] = $email;
            header('Location: signUp.php');
        }
        exit();
    }
}
