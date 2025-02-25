<?php
namespace Controllers;

use Models\Recette;

class RecetteController
{
    private $recetteModel;

    public function __construct()
    {
        $this->recetteModel = new Recette();
    }

    public function afficherRecettes()
    {
        $recettes = $this->recetteModel->getPublicRecettes();
        require_once __DIR__ . '/../Views/recettes.php';
    }

    public function ajouterRecette($postData, $userId, $email)
    {
        if (empty($postData['title']) || empty($postData['recipe'])) {
            $this->redirectWithMessage(BASE_URL . "/views/recipes_create.php", "Titre et contenu requis.", "danger");
        }
        // Nettoyage des données
        $title = trim(strip_tags($postData['title']));
        $recipe = trim(strip_tags($postData['recipe']));

        $success = $this->recetteModel->addRecette($postData['title'], $postData['recipe'], $userId, $email);

        if ($success) {
            $this->redirectWithMessage(BASE_URL . "/views/recettes.php", "Recette ajoutée avec succès.", "success");
        } else {
            $this->redirectWithMessage(BASE_URL . "/views/recipes_create.php", "Erreur lors de l'ajout.", "danger");
        }
    }

    public function modifierRecette($postData, $email)
    {
        if (empty($postData['title']) || empty($postData['recipe']) || empty($postData['recipe_id'])) {
            $this->redirectWithMessage(BASE_URL . "/views/recipes_edit.php", "Tous les champs sont requis.", "danger");
        }

        $success = $this->recetteModel->updateRecette($postData['recipe_id'], $postData['title'], $postData['recipe'], $email);

        if ($success) {
            $this->redirectWithMessage(BASE_URL . "/views/recettes.php", "Recette modifiée avec succès.", "success");
        } else {
            $this->redirectWithMessage(BASE_URL . "/views/recipes_edit.php", "Erreur lors de la modification.", "danger");
        }
    }

    public function supprimerRecette($recipeId, $email)
    {
        $success = $this->recetteModel->deleteRecette($recipeId, $email);

        if ($success) {
            $this->redirectWithMessage(BASE_URL . "/views/recettes.php", "Recette supprimée.", "success");
        } else {
            $this->redirectWithMessage(BASE_URL . "/views/recettes.php", "Erreur lors de la suppression.", "danger");
        }
    }
    public function getRecettes()
    {
        return $this->recetteModel->getPublicRecettes();
    }
    private function redirectWithMessage($url, $message, $type = 'success')
    {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type;
        header("Location: $url");
        exit();
    }
}