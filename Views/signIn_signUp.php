<?php
$pageTitle = "Connexion / Inscription - Site de recettes"; // Définir le titre dynamique
require_once __DIR__ . '/../Views/includes/head.php'; // Inclure le fichier d'en-tête
?>
<body class="bg-[#f8f8f8] text-[#384d48] font-sans min-h-screen flex flex-col">
    <!-- Navbar -->
    <?php require_once(__DIR__ . '/../Views/includes/navbar.php'); ?>

    <!-- Conteneur principal -->
    <div class="flex flex-col items-center justify-center flex-grow px-4">
        <!-- Titre -->
        <h1 class="text-3xl font-bold mb-6">Connexion / Inscription</h1>

        <!-- Formulaire -->
        <form action="<?= BASE_URL ?>/index.php?page=sign_in_sign_up" method="POST"
            class="bg-white shadow-md rounded-lg p-6 max-w-sm w-full space-y-6">
            <input type="hidden" name="form_type" value="sign_in_sign_up">
            <!-- Champ E-mail -->
            <div class="relative">
                <input type="email" name="signIn_signUp_email" id="signIn_signUp_email"
                    class="peer w-full border border-[#acad94] rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-[#6e7271] placeholder-transparent"
                    placeholder=" E-mail" required>
                <label for="signIn_signUp_email"
                    class=" peer absolute left-3 top-0 text-[#6e7271] text-sm transition-all peer-placeholder-shown:top-2 peer-placeholder-shown:text-base peer-placeholder-shown:text-[#acad94] peer-focus:top-0 peer-focus:text-sm peer-focus:text-[#6e7271]">
                    E-mail
                </label>
            </div>

            <!-- Bouton Connexion / Inscription -->
            <div>
                <button type="submit"
                    class="w-full bg-[#6e7271] text-white py-2 rounded-lg hover:bg-[#384d48] transition duration-300">
                    Connexion / Inscription
                </button>
            </div>
        </form>
        <p class="text-sm text-gray-600 mt-2">
            <a href="password_reset_request.php" class="text-[#6e7271] hover:underline">
                Mot de passe oublié ?
            </a>
        </p>
    </div>
</body>
</html>