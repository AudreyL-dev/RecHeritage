<?php
$pageTitle = "Site de recettes - Accueil";
require_once __DIR__ . '/includes/head.php';
require_once __DIR__ . '/includes/navbar.php';
?>


<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold text-teal-700 text-center mt-8">
        Site de recettes
    </h1>

    <section class="mt-6 text-center">
        <p class="text-lg">
            <?php
            if (isset($_SESSION['message'])) {
                echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
                unset($_SESSION['message']);
            }
            ?>
            Bienvenue sur le site de partage de recettes en PHP basique
        </p>
    </section>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
</>
</html>