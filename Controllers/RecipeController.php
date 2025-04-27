<?php
namespace Controllers;

use Models\Recipe;

class RecipeController
{
    private $recipeModel;

    public function __construct()
    {
        $this->recipeModel = new Recipe();
    }

    public function showRecipes()
    {
        $recipes = $this->recipeModel->getPublicRecipes();
        require_once __DIR__ . '/../Views/recipes.php';
    }

    public function showUserRecipes()
    {
        if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
            header('Location: ' . route('sign_in_sign_up'));
            exit();
        }
        $email = $_SESSION['userEmail'] ?? null;
        if ($email === null) {
            header('Location: ' . route('sign_in_sign_up'));
            exit();
        }
        // Récupérer toutes les recettes de l'utilisateur, pas une seule recette !
        $userRecipes = $this->recipeModel->getRecipesByUser($email);

        require_once __DIR__ . '/../Views/user_recipes.php';
    }
    public function showUpdateRecipeForm($recipeId)
    {
        if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
            header('Location: ' . route('sign_in_sign_up'));
            exit();
        }

        if (!$recipeId) {
            $this->redirectWithMessage(route('user_recipes'), 'Recette non valide.', 'danger');
        }

        $recipe = $this->recipeModel->getRecipeById($recipeId);
        $email = $_SESSION['userEmail'] ?? '';
        if (!$recipe || $recipe['author'] !== $email) {
            $this->redirectWithMessage(route('user_recipes'), 'Recette non trouvée.', 'danger');
        }


        require_once __DIR__ . '/../Views/recipe_update.php';
    }

    public function addRecipe($postData, $userId, $email)
    {
        if (empty($postData['title']) || empty($postData['recipe'])) {
            $this->redirectWithMessage(BASE_URL . "/views/recipes_create.php", "Titre et contenu requis.", "danger");
        }
        // Nettoyage des données
        $title = trim(strip_tags($postData['title']));
        $recipe = trim(strip_tags($postData['recipe']));


        $success = $this->recipeModel->addRecipeInDb($title, $recipe, $userId, $email);


        if ($success) {
            $this->redirectWithMessage(route('recipes'), 'Recette ajoutée avec succès.', 'success');
        } else {
            $this->redirectWithMessage(route('recipes_create'), 'Erreur lors de l\'ajout.', 'danger');
        }
    }

    public function updateRecipe($postData)
    {
        $csrfToken = $postData['csrf'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            die('Jeton CSRF invalide ou manquant.');
        }

        if (empty($postData['title']) || empty($postData['recipe']) || empty($postData['recipe_id'])) {
            $this->redirectWithMessage(route('update_recipe', ['id' => $postData['recipe_id']]), 'Tous les champs sont requis.', 'danger');
        }

        $recipeId = intval($postData['recipe_id']);
        $title = sanitizeRecipeTitle($postData['title']);
        $recipe = sanitizeRecipeContent($postData['recipe']);
        $email = $_SESSION['userEmail'] ?? '';

        $recipeOwner = $this->recipeModel->getRecipeById($recipeId);
        if (!$recipeOwner || $recipeOwner['author'] !== $email) {
            $this->redirectWithMessage(route('user_recipes'), 'Vous ne pouvez pas modifier cette recette.', 'danger');
        }

        $success = $this->recipeModel->updateRecipeInDb($recipeId, $title, $recipe, $email);

        if ($success) {
            $this->redirectWithMessage(route('user_recipes'), 'Recette modifiée avec succès.', type: 'success');
        } else {
            $this->redirectWithMessage(route('update_recipe', ['id' => $recipeId]), 'Erreur lors de la modification.', 'danger');
        }
    }

    public function deleteRecipe($recipeId, $email)
    {
        $success = $this->recipeModel->deleteRecipeInDb($recipeId, $email);

        if ($success) {
            $this->redirectWithMessage(route('recipes'), 'Recette supprimée.', 'success');
        } else {
            $this->redirectWithMessage(route('recipes'), 'Erreur lors de la suppression.', 'danger');
        }
    }

    public function getRecipes()
    {
        return $this->recipeModel->getPublicRecipes();
    }

    private function redirectWithMessage($url, $message, $type = 'success')
    {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type;
        header("Location: $url");
        exit();
    }
}