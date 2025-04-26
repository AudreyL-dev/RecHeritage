<?php
namespace Controllers;

class ContactController
{
    public function submitForm($postData, $fileData)
    {
        require_once __DIR__ . '/../helpers/contact_helpers.php';

        $result = handleFormSubmission($postData, $fileData);

        if (isset($result['error'])) {
            // Si erreur, tu peux rediriger ou afficher un message d'erreur
            $_SESSION['message'] = $result['error'];
            $_SESSION['message_type'] = 'danger';
            header('Location: ' . route('contact'));
            exit();
        }

        // Variables pour la vue
        $email = $result['email'];
        $message_contact = $result['message_contact'];
        $screenshot_name = $result['screenshot_name'];

        require __DIR__ . '/../Views/contact_success.php';
    }
}