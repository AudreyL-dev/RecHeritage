<?php
$pageTitle = 'Mot de passe modifié - Site de recettes';
require_once(__DIR__ . '/../includes/head.php');
require_once(__DIR__ . '/../includes/navbar.php');
?>

<body class="bg-[#f8f8f8] text-[#384d48] font-sans min-h-screen flex flex-col">

    <div class="flex flex-col items-center justify-center flex-grow px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Mot de passe modifié avec succès</h1>

        <p class="text-center text-lg text-[#6e7271] max-w-md mb-6">
            Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.
        </p>

        <a href="<?= route('sign_in_sign_up') ?>"
            class="bg-[#384d48] text-white px-6 py-2 rounded-lg hover:bg-[#6e7271] transition">
            Se connecter
        </a>
    </div>

    <?php require_once(__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>