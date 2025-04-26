<?php
use Models\Database;

/**
 * Vérifie si la requête POST a échoué à cause d'un fichier trop volumineux.
 */
function checkPostRequest()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST);
}

/**
 * Valide les données du formulaire.
 */
function validateFormData($postData)
{
    return isset($postData['email_contact']) &&
        filter_var($postData['email_contact'], FILTER_VALIDATE_EMAIL) &&
        !empty(trim($postData['message_contact']));
}

/**
 * Valide l'upload du fichier facultatif avec contrôle du mime type réel.
 */
function validateFileUpload($fileData): array
{
    if (!isset($fileData['screenshot']) || $fileData['screenshot']['error'] === UPLOAD_ERR_NO_FILE) {
        return ['bool' => true];
    }

    if ($fileData['screenshot']['error'] !== 0) {
        return ['error' => "Erreur lors de l'envoi du fichier.", 'bool' => false];
    }

    $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

    $fileInfo = pathinfo($fileData['screenshot']['name']);
    $extension = strtolower($fileInfo['extension']);

    if (!in_array($extension, $allowedExtensions)) {
        return ['error' => 'Le fichier doit être une image au format : ' . implode(', ', $allowedExtensions), 'bool' => false];
    }

    $realMimeType = mime_content_type($fileData['screenshot']['tmp_name']);
    if (!in_array($realMimeType, $allowedMimeTypes)) {
        return ['error' => 'Type de fichier non autorisé.', 'bool' => false];
    }

    return ['bool' => true];
}

/**
 * Stocke le fichier uploadé.
 */
function storeUploadedFile($fileData, $email)
{
    $uploadsDir = __DIR__ . '/../uploads';
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0755, true);
    }

    $originalFileName = strtolower($fileData['screenshot']['name']);
    $safeEmail = str_replace('@', '_at_', $email);
    $timestamp = time();
    $fileInfo = pathinfo($fileData['screenshot']['name']);
    $extension = strtolower($fileInfo['extension']);
    $newFileName = 'upload_' . $timestamp . '_' . $safeEmail . '.' . $extension;
    $destination = $uploadsDir . '/' . $newFileName;

    if (move_uploaded_file($fileData['screenshot']['tmp_name'], $destination)) {
        return [
            'storedName' => $newFileName,
            'originalName' => $originalFileName
        ];
    }
    return false;
}

/**
 * Gère le traitement complet du formulaire de contact.
 */
function handleFormSubmission(array $postData, array $fileData): array
{
    if (!checkPostRequest()) {
        header('Location: ' . route('error_request'));
        exit();
    }

    if (!validateFormData($postData)) {
        return ['error' => 'Il faut un email et un message valides pour soumettre le formulaire.'];
    }

    $fileValidationResult = validateFileUpload($fileData);
    if ($fileValidationResult['bool'] === false) {
        return ['error' => $fileValidationResult['error']];
    }

    $storedFileName = null;
    $originalFileName = null;
    if (isset($fileData['screenshot']) && $fileData['screenshot']['error'] !== UPLOAD_ERR_NO_FILE) {
        $uploadResult = storeUploadedFile($fileData, $postData['email_contact']);
        if ($uploadResult) {
            $storedFileName = $uploadResult['storedName'];
            $originalFileName = $uploadResult['originalName'];
        } else {
            return ['error' => "Erreur lors de l'upload du fichier."];
        }
    }

    return [
        'email' => $postData['email_contact'],
        'message_contact' => $postData['message_contact'],
        'screenshot_name' => $storedFileName,
        'original_name' => $originalFileName
    ];
}

/**
 * Sauvegarde le contact en base de données.
 */
function saveContactToDatabase(string $email, string $message, ?string $screenshot = null): bool
{
    $pdo = Database::getInstance();

    try {
        $query = '
            INSERT INTO contacts (email, message, screenshot, created_at)
            VALUES (:email, :message, :screenshot, NOW())
        ';

        $stmt = $pdo->prepare($query);

        return $stmt->execute([
            'email' => $email,
            'message' => $message,
            'screenshot' => $screenshot
        ]);
    } catch (PDOException $e) {
        error_log('Erreur insertion contact : ' . $e->getMessage());
        return false;
    }
}
