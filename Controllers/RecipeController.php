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
            header("Location: index.php?page=signIn_signUp");
            exit();
        }
        $email = $_SESSION['userEmail'] ?? null;
        if ($email === null) {
            header("Location: index.php?page=signIn_signUp");
            exit();
        }
        // Récupérer toutes les recettes de l'utilisateur, pas une seule recette !
        $userRecipes = $this->recipeModel->getRecipesByUser($email);

        require_once __DIR__ . '/../Views/user_recipes.php';
    }
    public function showUpdateRecipeForm($recipeId)
    {
        if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
            header("Location: " . BASE_URL . "/index.php?page=signIn_signUp");
            exit();
        }

        if (!$recipeId) {
            $this->redirectWithMessage(BASE_URL . "/index.php?page=user_recipes", "Recette non valide.", "danger");
        }

        $recipe = $this->recipeModel->getRecipeById($recipeId);
        if (!$recipe) {
            $this->redirectWithMessage(BASE_URL . "/index.php?page=user_recipes", "Recette non trouvée.", "danger");
        }


        require_once __DIR__ . '/../Views/update_recipe.php';
    }

    public function ajouterRecette($postData, $userId, $email)
    {
        if (empty($postData['title']) || empty($postData['recipe'])) {
            $this->redirectWithMessage(BASE_URL . "/views/recipes_create.php", "Titre et contenu requis.", "danger");
        }
        // Nettoyage des données
        $title = trim(strip_tags($postData['title']));
        $recipe = trim(strip_tags($postData['recipe']));

        $success = $this->recipeModel->addRecipeInDb($postData['title'], $postData['recipe'], $userId, $email);

        if ($success) {
            $this->redirectWithMessage(BASE_URL . "/views/recipes.php", "Recette ajoutée avec succès.", "success");
        } else {
            $this->redirectWithMessage(BASE_URL . "/views/recipes_create.php", "Erreur lors de l'ajout.", "danger");
        }
    }

    public function updateRecipe($postData)
    {
        // Vérifier le jeton CSRF
        $csrfToken = $postData['csrf'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            die('Jeton CSRF invalide ou manquant.');
        }

        // Vérifier que les champs sont remplis
        if (empty($postData['title']) || empty($postData['recipe']) || empty($postData['recipe_id'])) {
            $this->redirectWithMessage(BASE_URL . "/index.php?page=update_recipe&id=" . $postData['recipe_id'], "Tous les champs sont requis.", "danger");
        }

        // Mise à jour de la recette
        $success = $this->recipeModel->updateRecipeInDb($postData['recipe_id'], $postData['title'], $postData['recipe'], $_SESSION['userEmail']);

        if ($success) {
            $this->redirectWithMessage(BASE_URL . "/index.php?page=user_recipes", "Recette modifiée avec succès.", "success");
        } else {
            $this->redirectWithMessage(BASE_URL . "/index.php?page=update_recipe&id=" . $postData['recipe_id'], "Erreur lors de la modification.", "danger");
        }
    }

    public function supprimerRecette($recipeId, $email)
    {
        $success = $this->recipeModel->deleteRecipeInDb($recipeId, $email);

        if ($success) {
            $this->redirectWithMessage(BASE_URL . "/views/recipes.php", "Recette supprimée.", "success");
        } else {
            $this->redirectWithMessage(BASE_URL . "/views/recipes.php", "Erreur lors de la suppression.", "danger");
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