<?php

/*-----------------------------------------------------------------------------------*/
/*------------------------------Contact--------------------------------------------- */
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
function handleFormSubmission($postData, $fileData)
{
    global $message; // Utiliser la variable globale pour stocker le message
    global $champRequis; // Utiliser la variable globale pour stocker le message

    if (!checkPostRequest()) {
        header('Location:ErreurRequest.php');
        exit();

    }

    if (!validateFormData($postData)) {
        $champRequis = 'Il faut un email et un message valides pour soumettre le formulaire.';
        return;
    }

    $fileValidationResult = validateFileUpload($fileData);
    if ($fileValidationResult['bool'] === false) {
        $message = $fileValidationResult['error'];
        return;
    }

    $uploadedFileName = storeUploadedFile($fileData, $postData['email_contact']);
    if ($uploadedFileName) {
        $message = $uploadedFileName['originalName'];
    }
}
// Appel de la fonction principale pour gérer la soumission
//handleFormSubmission($_POST, $_FILES);
/*-----------------------------------------------------------------------------------*/
/*------------------------------Sécurité--------------------------------------------- */

// Générer un jeton CSRF
function generateCsrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Vérifier un jeton CSRF
function verifyCsrfToken(string $token): bool
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/*-----------------------------------------------------------------------------------*/
/*------------------------------Traitement des formulaire--------------------------------------------- */


function handleUpdateRecipe($postData, $userEmail)
{
    global $mysqlClient;

    // Modification des recettes
// Vérifier le formulaire POST
    if (
        empty($postData['title']) ||
        empty($postData['recipe']) ||
        trim($postData['title']) === '' ||
        trim($postData['recipe']) === ''
    ) {
        echo 'Il faut un titre et une recette pour soumettre le formulaire.';
        return;
    }

    try {
        $stmt = $mysqlClient->prepare("UPDATE recipes SET title = :title, recipe = :recipe WHERE recipe_id = :id AND author = :email");
        $stmt->execute([
            'title' => $postData['title'],
            'recipe' => $postData['recipe'],
            'id' => $postData['recipe_id'],
            'email' => $userEmail
        ]);
        header('Location: userRecipes.php');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function handleDeleteRecipe($postData)
{
    global $mysqlClient;
    try {
        // Requête pour supprimer la recette
        $deleteQuery = 'DELETE FROM recipes WHERE recipe_id = :recipe_id';
        $deleteStatement = $mysqlClient->prepare($deleteQuery);
        $deleteStatement->execute(['recipe_id' => $postData['recipe_id']]);

        header('Location: userRecipes.php'); // Redirection après suppression
        exit();
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

