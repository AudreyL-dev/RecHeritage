<?php
$pageTitle = 'Email envoyé - Site de recettes';
require_once(__DIR__ . '/../includes/head.php');
require_once(__DIR__ . '/../includes/navbar.php');
?>

<body class="bg-[#f8f8f8] text-[#384d48] font-sans min-h-screen flex flex-col">

    <div class="flex flex-col items-center justify-center flex-grow px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Vérifiez votre email</h1>

        <p class="text-center text-lg text-[#6e7271] max-w-md">
            Si votre adresse est enregistrée, un email contenant un lien de réinitialisation a été envoyé.
            <br><br>
            Pensez à vérifier également votre dossier spam.
        </p>
    </div>

    <?php require_once(__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>