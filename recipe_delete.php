<?php
$pageTitle = "Supprimer ma Recette"; // Définir le titre dynamique
require_once(__DIR__ . '/head.php'); // Inclure le fichier d'en-tête
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: signIn_signUp.php');
    exit();
} else {
    $csrfToken = generateCsrfToken(); // Générer le jeton
}
?>

<body class="bg-[#f8f8f8] text-[#384d48] font-sans min-h-screen flex flex-col">
    <div class="container mx-auto p-4">
        <!-- Navbar -->
        <?php require_once(__DIR__ . '/navbar.php'); ?>

        <!-- Titre principal -->
        <h1 class="text-3xl font-bold mb-6 text-center">
            Supprimer "<?php echo htmlspecialchars($recipeById['title']); ?>"
        </h1>

        <!-- Formulaire de mise à jour -->
        <div class="flex space-x-4 justify-center">
            <form action="user_recipes.php" method="POST" class="space-y-6">
                <!-- Inputs cachés -->
                <div class="hidden">
                    <input type="hidden" name="form_type" value="delete_recipe">
                    <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($recipeId); ?>">
                    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrfToken); ?>">
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-4">
                    <button type="submit"
                        class="appearance-none px-6 py-3 bg-danger text-white rounded-lg hover:bg-dangerHover  transition-all">Supprimer</button>
                    <a href="user_recipes.php"
                        class=" px-6 py-3 bg-[#384d48] text-white rounded-lg hover:bg-[#6e7271] transition-all">
                        Annuler
                    </a>
                </div>
            </form>

        </div>
    </div>

    <!-- Footer -->
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>