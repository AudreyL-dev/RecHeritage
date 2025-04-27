<?php

require_once __DIR__ . '/config/autoload.php';

use Controllers\UserController;
use Controllers\RecipeController;

$userController = new UserController();
$RecipeController = new RecipeController();

// Traitement POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $page = $_GET['page'] ?? basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $page = $page === '' ? 'home' : $page;

    switch ($page) {
        case 'sign_in':
            $userController->signIn($_POST);
            break;

        case 'sign_up':
            $userController->signUp($_POST);
            break;

        case 'sign_in_sign_up':
            $email = filter_input(INPUT_POST, 'signIn_signUp_email', FILTER_SANITIZE_EMAIL);
            $userController->checkEmailAndRedirect($email);
            break;

        case 'add_recipe':
            if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
                header('Location: ' . route('sign_in_sign_up'));
                exit();
            }
            $RecipeController->addRecipe($_POST, $_SESSION['user_id'], $_SESSION['userEmail']);
            break;

        case 'update_recipe':
            $RecipeController->updateRecipe($_POST);
            break;

        case 'delete_recipe':
            $RecipeController->deleteRecipe($_POST['recipe_id'], $_SESSION['userEmail']);
            break;

        case 'contact_form':
            (new Controllers\ContactController())->submitForm($_POST, $_FILES);
            break;

        default:
            echo 'Formulaire inconnu.';
            break;
    }

} else {
    // Traitement GET
    $page = $_GET['page'] ?? basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $page = $page === '' ? 'home' : $page;

    switch ($page) {
        case 'home':
            require_once __DIR__ . '/Views/home.php';
            break;

        case 'sign_in_sign_up':
            require_once __DIR__ . '/Views/signIn_signUp.php';
            break;

        case 'sign_in':
            require_once __DIR__ . '/Views/sign_in.php';
            break;

        case 'sign_up':
            require_once __DIR__ . '/Views/sign_up.php';
            break;

        case 'contact':
            require_once __DIR__ . '/Views/contact.php';
            break;

        case 'recipes':
            $RecipeController->showRecipes();
            break;

        case 'recipes_create':
            require_once __DIR__ . '/Views/recipe_create.php';
            break;

        case 'user_recipes':
            $RecipeController->showUserRecipes();
            break;

        case 'update_recipe':
            $recipeId = $_GET['id'] ?? null;
            if ($recipeId) {
                $RecipeController->showUpdateRecipeForm($recipeId);
            } else {
                header('Location: ' . route('user_recipes'));
                exit();
            }
            break;

        default:
            require_once __DIR__ . '/Views/errors/404.php';
            break;
    }
}
