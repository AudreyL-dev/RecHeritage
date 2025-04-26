<?php
/**
 * On ne traite pas les super globales provenant de l'utilisateur directement,
 * ces données doivent être testées et vérifiées.
 */

/**
 * Vérifie si la requête POST a échoué à cause d'un fichier trop volumineux.
 */
function checkPostRequest()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST)) {

        return false;
    }
    return true;
}

/**
 * Valide les données du formulaire.
 * @param array $postData Données provenant du formulaire.
 * @return bool
 */
function validateFormData($postData)
{
    if (
        !isset($postData['email_contact'])
        || !filter_var($postData['email_contact'], FILTER_VALIDATE_EMAIL)
        || empty($postData['message_contact'])
        || trim($postData['message_contact']) === ''
    ) {

        return false;
    }
    return true;
}

/**
 * Valide le fichier uploadé.
 * @param array $fileData Données concernant le fichier uploadé.
 * @return array|bool|string Retourne le message d'erreur en cas d'échec, sinon true.
 */
function validateFileUpload($fileData)
{
    global $errors;
    if (!isset($fileData['screenshot']) || $fileData['screenshot']['error'] === UPLOAD_ERR_NO_FILE) {
        // Pas de fichier uploadé
        $errors = "Aucun fichier joint";
        return [
            'error' => $errors,
            'bool' => false
        ];
    }

    if ($fileData['screenshot']['error'] !== 0) {
        $errors = "Erreur lors de l'envoi du fichier.";
        return [
            'error' => $errors,
            'bool' => false
        ];
    }

    if ($fileData['screenshot']['size'] > 1000000) {
        $errors = "L'envoi n'a pas pu être effectué, l'image est supérieure à 1 Mo.";
        return [
            'error' => $errors,
            'bool' => false
        ];
    }

    $fileInfo = pathinfo($fileData['screenshot']['name']);
    $extension = strtolower($fileInfo['extension']);
    $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];

    if (!in_array($extension, $allowedExtensions) || !in_array($fileData['screenshot']['type'], $allowedMimeTypes)) {
        $errors = "L'envoi n'a pas pu être effectué, l'image doit être uniquement au format " . implode(',', $allowedExtensions);
        return [
            'error' => $errors,
            'bool' => false
        ];
    }

    return [
        'bool' => true
    ];
}

/**
 * Gère le stockage du fichier dans le dossier uploads.
 * @param array array $fileData Données concernant le fichier uploadé.
 * @param string $email Email de l'utilisateur pour la création d'un nom unique.
 * @return array|bool Nom du fichier si succès, sinon false.
 */
function storeUploadedFile($fileData, $email)
{
    $uploadsDir = __DIR__ . '/uploads';
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0755, true);
    }

    $originalFileName = strtolower($fileData['screenshot']['name']);  // Conserver le nom du fichier original
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
    } else {
        echo "Erreur lors de l'upload du fichier.";
        return false;
    }
}

/**
 * Fonction principale de traitement du formulaire.
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

    $uploadedFileName = storeUploadedFile($fileData, $postData['email_contact']);
    if (!$uploadedFileName) {
        return ['error' => 'Erreur lors de l\'upload du fichier.'];
    }

    return [
        'email' => $postData['email_contact'],
        'message_contact' => $postData['message_contact'],
        'screenshot_name' => $uploadedFileName['originalName'],
    ];
}