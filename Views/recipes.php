<?php
$pageTitle = "Site de recettes - Recettes"; // Définir le titre dynamique
require_once __DIR__ . '/includes/head.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<body class="min-h-screen bg-hero-pattern bg-cover bg-center bg-no-repeat bg-fixed text-[#384d48] flex flex-col">
    <div class="container mx-auto p-4">
        <?php if (!empty($_SESSION['message'])): ?>
            <div>
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>
        <h1 class="text-3xl font-semibold text-[#384d48] mb-6">Recettes</h1>

        <div class="p-4">
            <div class="grid grid-cols-3 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($recipes as $recipe): ?>
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden transition-transform transform hover:scale-105 p-4">
                        <h2 class="text-xl font-bold text-[#6e7271] mb-2"><?= htmlspecialchars($recipe['title']) ?></h2>
                        <p class="text-sm text-[#acad94] mb-4 line-clamp-3"><?= htmlspecialchars($recipe['recipe']) ?></p>

                        <p class="text-sm text-[#384d48]">
                            <?= htmlspecialchars($recipe['pseudo']) ?>
                            <?php if ($recipe['pseudo'] !== "Contributeur anonyme" && $recipe['age'] !== null): ?>
                                <?php
                                $dateNaissance = new DateTime($recipe['age']);
                                $aujourdhui = new DateTime();
                                $age = $dateNaissance->diff($aujourdhui)->y;
                                ?>
                                <span>(<?= htmlspecialchars($age) ?> ans)</span>
                            <?php endif; ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>
</body>
</html>