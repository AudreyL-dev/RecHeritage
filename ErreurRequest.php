<?php

$pageTitle = "Site de recettes - Erreur"; // Définir le titre dynamique
require_once(__DIR__ . '/head.php'); // Inclure le fichier d'en-tête
?>

<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <?php require_once(__DIR__ . '/navbar.php'); ?>
        <h1>Site de recettes</h1>
        <section>
            Le fichier est trop volumineux, la taille maximale autorisée par le serveur est de 40M.
        </section>
    </div>
    <!-- inclusion du bas de page du site -->
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>