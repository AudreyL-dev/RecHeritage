<?php

$pageTitle = "Site de recettes - Recettes"; // Définir le titre dynamique
require_once(__DIR__ . '/Views/includes/head.php'); // Inclure le fichier d'en-tête
require_once(__DIR__ . '/Views/includes/navbar.php');
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: signIn_signUp.php');
    exit();
}

?>
<body class="min-h-screen bg-[#f8f8f8] text-[#384d48] flex flex-col"">
    <div class=" container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-[#384d48] mb-6">Recettes</h1>
    <div class="p-4">
        <div class="grid grid-cols-3 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!--Boucle sur les recettes-->
            <?php foreach ($enabledRecipes as $recipe): ?>
                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden transition-transform transform hover:scale-105 p-4">

                    <h2 class="text-xl font-bold text-[#6e7271] mb-2"><?php echo htmlspecialchars($recipe['title']) ?>
                    </h2>
                    <p class="text-sm text-[#acad94] mb-4 line-clamp-3 "><?php echo htmlspecialchars($recipe['recipe']) ?>
                    </p>

                    <p class="text-sm text-[#384d48]"><span><?php echo htmlspecialchars($recipe['pseudo']) ?></span>
                        <?php if ($recipe['pseudo'] !== "Contributeur anonyme" && $recipe['age'] !== null): ?>
                            <?php
                            // Calculer l'âge à partir de la date de naissance
                            $dateNaissance = new DateTime($recipe['age']);
                            $aujourdhui = new DateTime();
                            $age = $dateNaissance->diff($aujourdhui)->y; // Différence en années
                            ?>
                            <span> (<?php echo htmlspecialchars($age); ?> ans)</span>
                        <?php endif; ?>
                    </p>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    </div>
    <!-- inclusion du bas de page du site -->
    <?php require_once(__DIR__ . '/Views/includes/footer.php'); ?>
</body>
</html>