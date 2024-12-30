<?php


$fileData = $_FILES;
// Initialisation des variables vides
$message = "";
$champRequis = "";
$userEmail = $_SESSION['userEmail'] ?? '';

$errorMessage = "";



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = $_POST;
    $recipeId = $_POST['recipe_id'] ?? null;
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $getData = $_GET;
    $recipeId = $getData['id'] ?? null;
}
