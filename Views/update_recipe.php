<?php
$pageTitle = "Mettre à jour ma Recette";

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: signIn_signUp.php');
    exit();
} else {
    require_once __DIR__ . '/includes/head.php';
    require_once __DIR__ . '/includes/navbar.php';
    $csrfToken = generateCsrfToken(); // Générer le jeton
}
?>

<body class="bg-[#f8f8f8] text-[#384d48] font-sans min-h-screen flex flex-col">
    <div class="container mx-auto p-4">
        <!-- Titre principal -->
        <h1 class="text-3xl font-bold mb-6 text-center">
            Modifier "<?php echo htmlspecialchars($recipe['title']); ?>"
        </h1>

        <!-- Formulaire de mise à jour -->
        <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
            <form action="../router.php" method="POST" class="space-y-6">
                <!-- Inputs cachés -->
                <div class="hidden">
                    <input type="hidden" name="form_type" value="update_recipe">
                    <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrfToken); ?>">
                </div>

                <!-- Champ pour le titre -->
                <div>
                    <label for="title" class="block text-lg font-medium mb-2">Titre de la recette</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($recipe['title']); ?>"
                        class="w-full border border-[#acad94] rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-[#6e7271]"
                        placeholder="Entrez le titre de la recette" required>
                </div>

                <!-- Champ pour la description -->
                <div>
                    <label for="recipe" class="block text-lg font-medium mb-2">Description de la recette</label>
                    <textarea id="recipe" name="recipe"
                        class="w-full border border-[#acad94] rounded-lg p-3 h-48 resize-none focus:outline-none focus:ring-2 focus:ring-[#6e7271]"
                        placeholder="Décrivez votre recette ici"
                        required><?php echo htmlspecialchars($recipe['recipe']); ?></textarea>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-4">
                    <a href="index.php?page=user_recipes"
                        class="bg-[#d8d4d5] text-[#384d48] px-4 py-2 rounded-lg hover:bg-[#e2e2e2] transition duration-300">
                        Annuler
                    </a>
                    <button type="submit"
                        class="bg-[#6e7271] text-white px-4 py-2 rounded-lg hover:bg-[#384d48] transition duration-300">
                        Modifier
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once __DIR__ . '/includes/footer.php'; ?>
</body>
</html>