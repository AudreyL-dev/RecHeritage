<?php

require_once __DIR__ . '/config/autoload.php';

use Controllers\UserController;
$userController = new UserController(); // Instanciation du contrôleur
use Controllers\RecipeController;
$RecipeController = new RecipeController(); // Instanciation du contrôleur

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formType = $_POST['form_type'] ?? ''; // Récupère form_type ou une chaîne vide si absent

    switch ($formType) {

        case 'sign_in':
            $userController->signIn($_POST);
            break;

        case 'sign_up':
            $userController->signUp($_POST);
            break;
        case 'sign_in_sign_up':
            $email = filter_input(INPUT_POST, 'signIn_signUp_email', FILTER_SANITIZE_EMAIL);
            if ($email) {
                $userController->checkEmailAndRedirect($email);
            }
            break;
        case 'add_recipe':
            $RecipeController->ajouterRecette($_POST, $_SESSION['user_id'], $_SESSION['userEmail']);
            break;
        case 'contact_form':
            handleFormSubmission($_POST, $_FILES);
            break;
            if ($email) {
                $userController->checkEmailAndRedirect($email);
            }
            break;

        case 'update_recipe':
            $RecipeController->updateRecipe($_POST);
            break;

        case 'delete_recipe':
            // Récupérer le jeton CSRF soumis dans le formulaire
            $csrfToken = $_POST['csrf'] ?? '';
            $recipeId = $postData['id'] ?? null;
            // Vérification du jeton CSRF
            if (!verifyCsrfToken($csrfToken)) {
                die('Jeton CSRF invalide ou manquant.');
            }

            // Si le jeton est valide, continuez le traitement
            handleDeleteRecipe($_POST);
            break;
        case 'password_reset_request':
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

            // Vérifiez si l'email existe dans la base
            $stmt = $mysqlClient->prepare('SELECT user_id FROM users WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Générer un token sécurisé
                $token = bin2hex(random_bytes(32));
                $expiresAt = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');

                // Enregistrez le token et sa date d'expiration en base
                $stmt = $mysqlClient->prepare('
                        INSERT INTO password_resets (user_id, token, expires_at)
                        VALUES (:user_id, :token, :expires_at)
                    ');
                $stmt->execute([
                    'user_id' => $user['user_id'],
                    'token' => $token,
                    'expires_at' => $expiresAt,
                ]);

                // Envoyez le lien par email
                $resetLink = "http://localhost/cookBook/password_reset.php?token=$token";
                mail($email, 'Réinitialisation de mot de passe', "Cliquez sur ce lien pour réinitialiser votre mot de passe : $resetLink");
                header('Location: password_reset_sent.php');
                exit();
            }

            // Redirige vers le formulaire avec un message d'erreur
            header("Location: password_reset_request.php?error=unknown_email");
            exit();

        case 'password_reset':
            $token = $_POST['token'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';

            // Recherchez le token dans la base
            $stmt = $mysqlClient->prepare('
                        SELECT user_id, expires_at FROM password_resets WHERE token = :token
                    ');
            $stmt->execute(['token' => $token]);
            $resetRequest = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$resetRequest || new DateTime() > new DateTime($resetRequest['expires_at'])) {
                echo "Le lien de réinitialisation est invalide ou expiré.";
                break;
            }

            // Mettre à jour le mot de passe
            $stmt = $mysqlClient->prepare('
                        UPDATE users SET password = :password WHERE user_id = :user_id
                    ');
            $stmt->execute([
                'password' => password_hash($newPassword, PASSWORD_DEFAULT),
                'user_id' => $resetRequest['user_id'],
            ]);

            // Supprimez le token utilisé
            $stmt = $mysqlClient->prepare('DELETE FROM password_resets WHERE token = :token');
            $stmt->execute(['token' => $token]);

            // Redirection vers une page de confirmation
            header('Location: password_reset_success.php');
            exit();
        default:
            echo 'Type de formulaire non valide.';
            break;
    }
} else { // Gérer les pages en GET
    $page = $_GET['page'] ?? 'home';

    switch ($page) {
        case 'recipes':
            $RecipeController->showRecipes();
            break;
        case 'home':
            require_once __DIR__ . '/Views/home.php';
            break;
        default:
            require_once __DIR__ . '/Views/errors/404.php'; // Page erreur si la page n'existe pas
            break;
        case 'user_recipes':
            $RecipeController->showUserRecipes();
            break;
        case 'update_recipe':
            $recipeId = $_GET['id'] ?? null; // ✅ On récupère l'ID avant d’appeler la fonction
            if ($recipeId) {
                $RecipeController->showUpdateRecipeForm($recipeId);
            } else {
                header("Location:" . BASE_URL . "/index.php?page=user_recipes");
                exit();
            }
            break;
    }
}
