<?php
$pageTitle = "Site de recettes - Contact Reçu"; // Définir le titre dynamique
require_once(__DIR__ . '/head.php'); // Inclure le fichier d'en-tête
?>
<body class="bg-[#f8f8f8] text-[#384d48] font-sans min-h-screen flex flex-col">
    <!-- Navbar -->
    <?php require_once(__DIR__ . '/navbar.php'); ?>

    <!-- Conteneur principal -->
    <div class="flex flex-col items-center justify-center flex-grow px-4 py-8">

        <!-- Titre principal -->
        <h1 class="text-3xl font-bold text-[#384d48] mb-6">Nous avons bien reçu votre message.</h1>

        <!-- Carte avec les informations du contact -->
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-xl">

            <div class="mb-4">
                <h5 class="text-xl font-semibold text-[#6e7271]">Rappel de vos informations</h5>
            </div>

            <div class="space-y-3">
                <p class="text-lg"><b>Email:</b> <?php echo htmlspecialchars($postData['email_contact']); ?></p>
                <p class="text-lg"><b>Message:</b>
                    <?php echo nl2br(htmlspecialchars(strip_tags($postData['message_contact']))); ?></p>
                <p class="text-lg"><b>Votre capture d'écran:</b> <?php echo $message; ?></p>
            </div>

        </div>

    </div>
</body>
</html>