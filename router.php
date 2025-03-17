<?php

require_once __DIR__ . '/config/autoload.php';

use Controllers\UserController;
use Controllers\RecipeController;

$userController = new UserController(); // Instanciation du contrôleur
$RecipeController = new RecipeController(); // Instanciation du contrôleur

// Traitement POST (Formulaires)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $page = $_GET['page'] ?? ''; //  On utilise "page" pour tout unifier

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
            $RecipeController->ajouterRecette($_POST, $_SESSION['user_id'], $_SESSION['userEmail']);
            break;

        case 'update_recipe':
            $RecipeController->updateRecipe($_POST);
            break;

        case 'delete_recipe':
            $RecipeController->supprimerRecette($_POST['recipe_id'], $_SESSION['userEmail']);
            break;

        case 'contact_form':
            handleFormSubmission($_POST, $_FILES);
            break;

        case 'password_reset_request':
            //  A REVOIR : ce code devrait aller dans un UserController plus tard
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $stmt = $mysqlClient->prepare('SELECT user_id FROM users WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $token = bin2hex(random_bytes(32));
                $expiresAt = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');

                $stmt = $mysqlClient->prepare('
                    INSERT INTO password_resets (user_id, token, expires_at)
                    VALUES (:user_id, :token, :expires_at)
                ');
                $stmt->execute([
                    'user_id' => $user['user_id'],
                    'token' => $token,
                    'expires_at' => $expiresAt,
                ]);

                $resetLink = "http://localhost/cookBook/password_reset.php?token=$token";
                mail($email, 'Réinitialisation de mot de passe', "Cliquez ici pour réinitialiser : $resetLink");

                header('Location: password_reset_sent.php');
                exit();
            }

            header("Location: password_reset_request.php?error=unknown_email");
            exit();

        case 'password_reset':
            $token = $_POST['token'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $stmt = $mysqlClient->prepare('SELECT user_id, expires_at FROM password_resets WHERE token = :token');
            $stmt->execute(['token' => $token]);
            $resetRequest = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$resetRequest || new DateTime() > new DateTime($resetRequest['expires_at'])) {
                echo "Le lien est invalide ou expiré.";
                break;
            }

            $stmt = $mysqlClient->prepare('UPDATE users SET password = :password WHERE user_id = :user_id');
            $stmt->execute([
                'password' => password_hash($newPassword, PASSWORD_DEFAULT),
                'user_id' => $resetRequest['user_id'],
            ]);
            $stmt = $mysqlClient->prepare('DELETE FROM password_resets WHERE token = :token');
            $stmt->execute(['token' => $token]);

            header('Location: password_reset_success.php');
            exit();

        default:
            echo 'Formulaire inconnu.';
            break;
    }

} else {
    // Traitement GET (Pages)
    $page = $_GET['page'] ?? 'home';

    switch ($page) {
        case 'recipes':
            $RecipeController->showRecipes();
            break;

        case 'home':
            require_once __DIR__ . '/Views/home.php';
            break;

        case 'user_recipes':
            $RecipeController->showUserRecipes();
            break;

        case 'update_recipe':
            $recipeId = $_GET['id'] ?? null;
            if ($recipeId) {
                $RecipeController->showUpdateRecipeForm($recipeId);
            } else {
                header("Location: " . BASE_URL . "/index.php?page=user_recipes");
                exit();
            }
            break;

        default:
            require_once __DIR__ . '/Views/errors/404.php'; // Page d'erreur
            break;
    }
}