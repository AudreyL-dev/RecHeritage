<?php
namespace Models;
use PDO;
use PDOException;

class Recipe
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    // Méthode pour exécuter les requêtes et gérer les erreurs
    private function executeQuery($sql, $params = [], $fetchMode = PDO::FETCH_ASSOC, $fetchAll = false)
    {
        try {
            $query = $this->pdo->prepare($sql);
            $query->execute($params);

            if ($fetchAll) {
                return $query->fetchAll($fetchMode);
            }
            return $query->fetch($fetchMode);
        } catch (PDOException $e) {
            error_log("Erreur SQL : " . $e->getMessage());
            return false;
        }
    }
    // Récupérer toutes les recettes publiques
    public function getPublicRecettes()
    {
        $sql = "SELECT recipes.recipe_id, recipes.title, recipes.recipe, 
                       IFNULL(users.pseudo, 'Contributeur anonyme') AS pseudo, 
                       users.birthDate AS age
                FROM recipes
                LEFT JOIN users ON recipes.user_id = users.user_id
                WHERE recipes.is_enabled = true";
        return $this->executeQuery($sql, [], PDO::FETCH_ASSOC, true);
    }

    // Récupérer les recettes d'un utilisateur
    public function getRecipesByUser($email)
    {
        $sql = "SELECT recipes.recipe_id, recipes.title, recipes.recipe 
                FROM recipes
                WHERE recipes.author = :email AND recipes.is_enabled = true";
        return $this->executeQuery($sql, ['email' => $email], PDO::FETCH_ASSOC, true);
    }

    // Récupérer une recette par ID
    public function getRecipeById($recipeId)
    {
        $sql = "SELECT title, recipe FROM recipes WHERE recipe_id = :recipe_id";
        return $this->executeQuery($sql, ['recipe_id' => $recipeId]);
    }

    // Ajouter une recette
    public function addRecipeInDb($title, $recipe, $userId, $email)
    {
        $sql = "INSERT INTO recipes (title, recipe, is_enabled, user_id, author, created_at) 
                VALUES (:title, :recipe, 1, :user_id, :author, NOW())";
        return $this->executeQuery($sql, [
            'title' => $title,
            'recipe' => $recipe,
            'user_id' => $userId,
            'author' => $email
        ]);
    }

    // Modifier une recette
    public function updateRecipeInDb($recipeId, $title, $recipe, $email)
    {
        $sql = "UPDATE recipes SET title = :title, recipe = :recipe 
                WHERE recipe_id = :recipe_id AND author = :email";
        return $this->executeQuery($sql, [
            'title' => $title,
            'recipe' => $recipe,
            'recipe_id' => $recipeId,
            'email' => $email
        ]);
    }

    // Supprimer une recette
    public function deleteRecipeInDb($recipeId, $email)
    {
        $sql = "DELETE FROM recipes WHERE recipe_id = :recipe_id AND author = :email";
        return $this->executeQuery($sql, [
            'recipe_id' => $recipeId,
            'email' => $email
        ]);
    }
}
