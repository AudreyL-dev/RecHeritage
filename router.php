<?php

require_once __DIR__ . '/config/autoload.php';

use Controllers\UserController;
use Controllers\RecipeController;
use Controllers\ContactController;
use Controllers\PasswordController;

// Instanciation des contrôleurs
$userController = new UserController();
$recipeController = new RecipeController();
$contactController = new ContactController();
$passwordController = new PasswordController();

$page = $_GET['page'] ?? basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$page = $page === '' ? 'home' : $page;

// Traitement POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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
            $recipeController->addRecipe($_POST, $_SESSION['user_id'], $_SESSION['userEmail']);
            break;

        case 'update_recipe':
            $recipeController->updateRecipe($_POST);
            break;

        case 'delete_recipe':
            $recipeController->deleteRecipe($_POST['recipe_id'], $_SESSION['userEmail']);
            break;

        case 'contact_form':
            (new Controllers\ContactController())->submitForm($_POST, $_FILES);
            break;

        case 'reset_request':
            $passwordController->handleResetRequest($_POST);
            break;

        case 'reset':
            $passwordController->handleReset($_POST);
            break;

        default:
            require_once __DIR__ . '/Views/errors/404.php';
            break;
    }

} else {
    // Traitement GET

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

        case 'recipes':
            $recipeController->showRecipes();
            break;

        case 'recipes_create':
            require_once __DIR__ . '/Views/recipe_create.php';
            break;

        case 'user_recipes':
            $recipeController->showUserRecipes();
            break;

        case 'update_recipe':
            $recipeId = $_GET['id'] ?? null;
            if ($recipeId) {
                $recipeController->showUpdateRecipeForm($recipeId);
            } else {
                header('Location: ' . route('user_recipes'));
                exit();
            }
            break;

        case 'contact':
            require_once __DIR__ . '/Views/contact.php';
            break;

        case 'reset_request':
            $passwordController->showResetRequestForm();
            break;

        case 'reset_sent':
            require_once __DIR__ . '/Views/password/reset_sent.php';
            break;

        case 'reset':
            $passwordController->showResetForm();
            break;

        case 'reset_success':
            require_once __DIR__ . '/Views/password/reset_success.php';
            break;

        default:
            require_once __DIR__ . '/Views/errors/404.php';
            break;
    }
}
