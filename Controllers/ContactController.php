<?php
namespace Controllers;

class ContactController
{
    public function submitForm($postData, $fileData)
    {
        require_once __DIR__ . '/../helpers/contact_helpers.php';

        $result = handleFormSubmission($postData, $fileData);

        if (isset($result['error'])) {
            $_SESSION['message'] = $result['error'];
            $_SESSION['message_type'] = 'danger';
            header('Location: ' . route('contact'));
            exit();
        }

        // Enregistrement en base de données avec le nom du fichier stocké
        saveContactToDatabase($result['email'], $result['message_contact'], $result['screenshot_name']);

        // Variables pour la vue
        $email = $result['email'];
        $message_contact = $result['message_contact'];
        $original_name = $result['original_name'];

        require __DIR__ . '/../Views/contact_success.php';

        /*    // Envoi de l'email de notification
           $to = 'admin@example.com'; // Mets ton vrai email ici
           $subject = 'Nouveau message de contact';
           $messageEmail = "Vous avez reçu un nouveau message :\n\n"
               . "Email: " . $email . "\n"
               . "Message: " . $message_contact . "\n"
               . "Fichier: " . ($storedFileName ?? 'Pas de fichier joint');

           $headers = 'From: noreply@example.com' . "\r\n" .
               'Reply-To: ' . $email . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

           mail($to, $subject, $messageEmail, $headers); */
    }
}
