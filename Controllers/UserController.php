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
            return "Tous les champs sont obligatoires.";
        }

        if ($postData['password'] !== $postData['confirm_password']) {
            return "Les mots de passe ne correspondent pas.";
        }

        return $this->userModel->createUser(
            $postData['pseudo'],
            $postData['email'],
            $postData['password'],
            $postData['birthDate']
        );
    }
}
