<?php
$pageTitle = "Mes Recettes";
require_once(__DIR__ . '/includes/head.php');
require_once(__DIR__ . '/includes/navbar.php');
?>
<body class="min-h-screen bg-[#f8f8f8] text-[#384d48] flex flex-col">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold text-[#384d48] mb-6">Mes Recettes</h1>
        <?php if (!empty($_SESSION['message'])): ?>
            <div class="w-full max-w-4xl mb-6 p-4 rounded-lg
        <?= $_SESSION['message_type'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>
        <?php if (!empty($userRecipes)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <?php foreach ($userRecipes as $recipe): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-4">
                            <h2 class="text-2xl font-bellota text-[#6e7271] mb-2">
                                <?= htmlspecialchars($recipe['title']); ?>
                            </h2>
                            <p class="text-xl text-[#acad94] mb-4 font-bellota">
                                <?= htmlspecialchars($recipe['recipe']); ?>
                            </p>
                            <div class="flex justify-between items-center">
                                <a href="<?= route('update_recipe', ['id' => $recipe['recipe_id']]) ?>"
                                    class="text-sm text-[#6e7271] hover:text-[#acad94] transition">
                                    Modifier
                                </a>

                                <form action="<?= route('delete_recipe') ?>" method="POST" class="inline-block">
                                    <input type="hidden" name="recipe_id" value="<?= htmlspecialchars($recipe['recipe_id']) ?>">
                                    <input type="hidden" name="csrf" value="<?= generateCsrfToken() ?>">
                                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 transition"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?');">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-lg text-[#6e7271]">
                Vous n'avez aucune recette enregistrée pour le moment.
            </p>
        <?php endif; ?>
    </div>

    <?php require_once(__DIR__ . '/includes/footer.php'); ?>
</body>
</html>