<?php
$pageTitle = "Site de recettes - Recette Ajouté";
require_once(__DIR__ . '/head.php');
?>
<body>
    <div class="container">


        <?php require_once(__DIR__ . '/navbar.php'); ?>
        <!-- MESSAGE DE SUCCÈS -->
        <h1>Recette ajoutée avec succès !</h1>
        <div class="card">

            <div class="card-body">
                <h5 class="card-title"><?php echo $title; ?></h5>
                <p class="card-text"><b>Email</b> : <?php echo $userEmail; ?></p>
                <p class="card-text"><b>Recette</b> : <?php echo $recipe; ?></p>
            </div>
        </div>
    </div>
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>