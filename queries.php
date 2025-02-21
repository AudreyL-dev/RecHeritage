<?php
require_once __DIR__ . '/Models/Database.php';

use Models\Database;

$pdo = Database::getInstance();


try {
    //Première requête
// Récupérer les recettes avec le pseudo et l'âge de l'utilisateur
//⚠️Jointure externe (left join) pour gérer les recettes sans utilisateurs enregistrés
    $getEnabledRecipes = ' SELECT 
        recipes.title, 
        recipes.recipe, 
        IFNULL(users.pseudo, "Contributeur anonyme") AS pseudo, 
        users.birthDate AS age
    FROM recipes
    LEFT JOIN users ON recipes.user_id = users.user_id
    WHERE recipes.is_enabled = true
';
    $statementEnabledRecipes = $pdo->query($getEnabledRecipes);
    $enabledRecipes = $statementEnabledRecipes->fetchAll(PDO::FETCH_ASSOC);

    //Deuxième requête
//Récupérer les recettes par utilisateur
    $getRecipesByUsers = ' SELECT recipes.title,
recipes.recipe,recipes.recipe_id
FROM recipes
WHERE recipes.author =:email AND recipes.is_enabled = true';
    $statementRecipesByUsers = $pdo->prepare($getRecipesByUsers);
    $statementRecipesByUsers->execute(['email' => $userEmail]);
    // Récupérer les recettes
    $userRecipes = $statementRecipesByUsers->fetchAll(PDO::FETCH_ASSOC);

    // Troisième requête
    //Récupérer les recettes par id


    if ($recipeId && is_numeric($recipeId)) {
        $getRecipesById = '
            SELECT 
                recipes.title,
                recipes.recipe
            FROM recipes
            WHERE recipes.recipe_id = :recipe_id
        ';
        $statementGetRecipesById = $pdo->prepare($getRecipesById);
        $statementGetRecipesById->execute(['recipe_id' => $recipeId]);
        $recipeById = $statementGetRecipesById->fetch(PDO::FETCH_ASSOC);
    } else {
        $recipeById = null; // Aucun ID valide
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
