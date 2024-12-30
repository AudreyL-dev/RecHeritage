<?php
$pageTitle = "Lien envoyé";
require_once 'head.php';
?>
<body class="bg-[#f8f8f8] text-[#384d48] font-sans min-h-screen flex flex-col">
    <meta http-equiv="refresh" content="10;url=signIn_signUp.php">
    <!-- Navbar -->
    <?php require_once(__DIR__ . '/navbar.php'); ?>
    <div class="flex flex-col items-center justify-center flex-grow px-4">
        <h1 class="text-3xl font-bold mb-6 text-[#384d48]">Merci</h1>
        <p class="text-center text-[#6e7271] mb-6">
            Nous allons vous envoyer un email avec un lien pour réinitialiser votre mot de passe, merci de vérifier dans
            les différents dossier de votre boite mail si vous ne le voyez pas.
            Nous allons vous rediriger dans quelques instants vers la page d'accueil.
        </p>
        <a href="signIn_signUp.php"
            class="w-96 max-w-xs bg-[#6e7271] text-white py-2 rounded-lg text-center hover:bg-[#384d48] transition duration-300">
            Retour à la page de connexion
        </a>
    </div>
    <!-- Footer -->
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>