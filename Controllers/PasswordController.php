<?php
namespace Controllers;

use Models\User;

class PasswordController
{
    public function showResetRequestForm()
    {
        require_once __DIR__ . '/../Views/password/reset_request.php';
    }

    public function handleResetRequest(array $postData)
    {
        $email = $postData['email'] ?? '';

        if (empty($email)) {
            $_SESSION['message'] = 'Veuillez saisir une adresse e-mail.';
            $_SESSION['message_type'] = 'danger';
            header('Location: ' . route('reset_request'));
            exit();
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $userModel->saveResetToken($user['user_id'], $token);

            $resetLink = 'http://' . $_SERVER['HTTP_HOST'] . BASE_URL . '/index.php?page=reset&token=' . $token;

            $subject = 'Réinitialisation de votre mot de passe';
            $message = 'Cliquez sur ce lien pour réinitialiser votre mot de passe : ' . $resetLink;
            $headers = 'From: no-reply@votresite.com' . "\r\n" .
                'Reply-To: ' . $email . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($email, $subject, $message, $headers);
        }

        // Toujours rediriger pour ne pas révéler si l'email existe ou non
        header('Location: ' . route('reset_sent'));
        exit();
    }

    public function showResetForm()
    {
        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            $_SESSION['message'] = 'Lien de réinitialisation invalide.';
            $_SESSION['message_type'] = 'danger';
            header('Location: ' . route('reset_request'));
            exit();
        }

        require_once __DIR__ . '/../Views/password/reset.php';
    }

    public function handleReset(array $postData)
    {
        $token = $postData['token'] ?? '';
        $password = $postData['password'] ?? '';
        $confirmPassword = $postData['confirm_password'] ?? '';

        if (empty($token) || empty($password) || empty($confirmPassword)) {
            $_SESSION['message'] = 'Tous les champs sont requis.';
            $_SESSION['message_type'] = 'danger';
            header('Location: ' . route('reset'));
            exit();
        }

        if ($password !== $confirmPassword) {
            $_SESSION['message'] = 'Les mots de passe ne correspondent pas.';
            $_SESSION['message_type'] = 'danger';
            header('Location: ' . route('reset') . '&token=' . urlencode($token));
            exit();
        }

        $userModel = new User();
        $user = $userModel->findByResetToken($token);

        if (!$user) {
            $_SESSION['message'] = 'Lien invalide ou expiré.';
            $_SESSION['message_type'] = 'danger';
            header('Location: ' . route('reset_request'));
            exit();
        }

        // Mise à jour du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $userModel->updatePassword($user['user_id'], $hashedPassword);
        $userModel->clearResetToken($user['user_id']);

        header('Location: ' . route('reset_success'));
        exit();
    }
}