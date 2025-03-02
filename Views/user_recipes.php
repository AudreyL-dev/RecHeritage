<?php
$pageTitle = "Mes Recettes";
require_once(__DIR__ . '/includes/head.php');
require_once(__DIR__ . '/includes/navbar.php');

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {

    header('Location: index.php?page=signIn_signUp');
    exit();
}


?>

<body class="min-h-screen bg-[#f8f8f8] text-[#384d48] flex flex-col">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold text-[#384d48] mb-6">Mes Recettes</h1>

        <?php if (!empty($userRecipes)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <?php foreach ($userRecipes as $recipe): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-4">
                            <h2 class="text-xl font-bold text-[#6e7271] mb-2"><?php echo htmlspecialchars($recipe['title']); ?>
                            </h2>
                            <p class="text-sm text-[#acad94] mb-4"><?php echo htmlspecialchars($recipe['recipe']); ?></p>
                            <div class="flex justify-between">
                                <a href="index.php?page=recipe_view.php?id=<?php echo $recipe['recipe_id']; ?>"
                                    class="text-sm text-[#384d48] hover:text-[#acad94] transition">
                                    Voir la recette
                                </a>
                                <div class="flex space-x-2">
                                    <a href="<?= BASE_URL ?>/index.php?page=update_recipe&id=<?= $recipe['recipe_id']; ?>"
                                        class="text-sm text-[#6e7271] hover:text-[#acad94] transition">
                                        Modifier
                                    </a>
                                    <a href="index.php?page=recipe_delete.php?id=<?php echo $recipe['recipe_id']; ?>"
                                        class="text-sm text-red-500 hover:text-red-700 transition">
                                        Supprimer
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-lg text-[#6e7271]">Vous n'avez aucune recette enregistrée pour le moment.</p>
        <?php endif; ?>
    </div>
    <?php require_once(__DIR__ . '/includes/footer.php'); ?>
</body>
</html>