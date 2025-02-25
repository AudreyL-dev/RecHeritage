<?php $pageTitle = "Site de recettes - Accueil"; // Définir le titre dynamique
require_once(__DIR__ . '/../Views/includes/head.php'); // Inclure le fichier d'en-tête
?>

<body class="flex flex-col min-h-screen bg-gray-50 text-gray-700">
    <div class="container mx-auto px-4">
        <?php require_once(__DIR__ . '/../Views/includes/navbar.php'); ?>

        <h1 class="text-3xl font-bold text-teal-700 text-center mt-8">
            Site de recettes
        </h1>

        <section class="mt-6 text-center">
            <p class="text-lg">
                <?php
                // Affichage d'un message succès s'il existe dans la session
                if (isset($_SESSION['message'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
                    unset($_SESSION['message']); // Supprime après affichage
                }
                ?>
                Bienvenu sur le site de partage de recettes en PHP basique
            </p>
        </section>
    </div>
    <!-- inclusion du bas de page du site -->
    <?php require_once(__DIR__ . '/../Views/includes/footer.php'); ?>
</body>
</html>