<?php
$pageTitle = "Créer une Recette"; // Titre dynamique
require_once(__DIR__ . '/includes/head.php');
require_once(__DIR__ . '/includes/navbar.php');
?>
<body class="bg-[#f8f8f8] text-[#384d48] font-sans min-h-screen flex flex-col">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6 text-center">Créer une nouvelle recette</h1>
        <?php if (!empty($_SESSION['message'])): ?>
            <div class="w-full max-w-3xl mx-auto mb-6 p-4 rounded-lg
        <?= $_SESSION['message_type'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>
        <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
            <form action="<?= route('add_recipe') ?>" method="POST" class="space-y-6">
                <?= csrfInput() ?>
                <div>
                    <label for="title" class="block text-lg font-medium mb-2">Titre de la recette</label>
                    <input type="text" name="title" id="title"
                        class="w-full border border-[#acad94] rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-[#6e7271]"
                        placeholder="Titre de votre recette" required>
                </div>

                <div>
                    <label for="recipe" class="block text-lg font-medium mb-2">Description</label>
                    <textarea name="recipe" id="recipe"
                        class="w-full border border-[#acad94] rounded-lg p-3 h-32 resize-none focus:outline-none focus:ring-2 focus:ring-[#6e7271]"
                        placeholder="Décrivez votre recette" required></textarea>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="reset"
                        class="bg-[#d8d4d5] text-[#384d48] px-4 py-2 rounded-lg hover:bg-[#e2e2e2] transition duration-300">
                        Réinitialiser
                    </button>
                    <button type="submit"
                        class="bg-[#6e7271] text-white px-4 py-2 rounded-lg hover:bg-[#384d48] transition duration-300">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php require_once(__DIR__ . '/includes/footer.php'); ?>
</body>
</html>