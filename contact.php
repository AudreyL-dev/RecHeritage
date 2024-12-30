<?php
$pageTitle = "Site de recettes - Contact"; // Définir le titre dynamique
require_once(__DIR__ . '/head.php'); // Inclure le fichier d'en-tête
?>

<body class="bg-[#f8f8f8] text-[#384d48] font-sans min-h-screen flex flex-col">
    <!-- Navbar -->
    <?php require_once(__DIR__ . '/navbar.php'); ?>

    <!-- Conteneur principal -->
    <div class="flex flex-col items-center justify-center flex-grow px-4 py-8">

        <!-- Titre principal -->
        <h1 class="text-3xl font-bold text-[#384d48] mb-6">Contactez-nous</h1>

        <!-- Formulaire de contact -->
        <form action="submitContact.php" method="POST" enctype="multipart/form-data" class="w-full max-w-lg space-y-6">
            <input type="hidden" name="form_type" value="contact_form">
            <!-- Champ Email -->
            <div class="space-y-2">
                <label for="email_contact" class="block text-lg font-medium text-[#6e7271]">Email</label>
                <div class="relative">
                    <input type="email"
                        class="form_control_contact w-full p-3 border border-[#ccc] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#384d48]"
                        id="email_contact" name="email_contact" required>
                    <button type="button" class="absolute top-2 right-2 text-xl text-gray-500">×</button>
                </div>
                <div class="text-sm text-gray-500 mt-1">Nous ne revendrons pas votre email.</div>
            </div>

            <!-- Champ Message -->
            <div class="space-y-2">
                <label for="message_contact" class="block text-lg font-medium text-[#6e7271]">Votre message</label>
                <div class="relative">
                    <textarea
                        class="form_control_contact w-full p-3 border border-[#ccc] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#384d48]"
                        placeholder="Exprimez-vous" id="message_contact" name="message_contact" required></textarea>
                    <button type="button" class="absolute top-2 right-2 text-xl text-gray-500">×</button>
                </div>
            </div>

            <!-- Champ Screenshot -->
            <div class="space-y-2">
                <label for="screenshot" class="block text-lg font-medium text-[#6e7271]">Votre capture d'écran</label>
                <div class="relative">
                    <input type="file"
                        class="form_control_contact w-full p-3 border border-[#ccc] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#384d48]"
                        id="screenshot" name="screenshot">
                    <button type="button" class="absolute top-2 right-2 text-xl text-gray-500">×</button>
                </div>
            </div>

            <!-- Boutons -->
            <div class="flex space-x-4 justify-center">
                <button type="submit"
                    class="px-6 py-3 bg-[#384d48] text-white rounded-lg hover:bg-[#6e7271] transition-all">Envoyer</button>
                <button type="reset"
                    class="px-6 py-3 bg-gray-300 text-black rounded-lg hover:bg-gray-400 transition-all">Annuler</button>
            </div>

        </form>
    </div>

    <!-- Footer -->
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>