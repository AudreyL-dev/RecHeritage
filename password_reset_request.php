<?php
$pageTitle = "Mot de passe oublié";
require_once 'head.php';
// Vérifiez si un message d'erreur est passé
$errorMessage = '';
if (isset($_GET['error']) && $_GET['error'] === 'unknown_email') {
    $errorMessage = "Aucun utilisateur n'existe avec cette adresse email. Veuillez créer un compte.";
}
?>
<body class="bg-[#f8f8f8] text-[#384d48] font-sans min-h-screen flex flex-col">
    <!-- Navbar -->
    <?php require_once(__DIR__ . '/navbar.php'); ?>
    <div class="flex flex-col items-center justify-center flex-grow px-4">
        <h1 class="text-3xl font-bold mb-6 text-[#384d48]">Réinitialisation de mot de passe</h1>
        <form action="traitement.php" method="POST" class="bg-white shadow-md rounded-lg p-6 max-w-md w-full space-y-6">
            <input type="hidden" name="form_type" value="password_reset_request">

            <!-- Champ Email -->
            <div class="relative">
                <input type="email" name="email" id="email"
                    class="peer w-full border border-[#acad94] rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-[#6e7271]"
                    placeholder=" " required>
                <label for="email"
                    class="absolute left-3 top-2 text-[#6e7271] text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-[#acad94] peer-focus:top-2 peer-focus:text-sm peer-focus:text-[#6e7271]">
                    Adresse email
                </label>
            </div>
            <!-- Message d'erreur -->
            <?php if ($errorMessage): ?>
                <span class="text-red-500 text-sm"><?php echo htmlspecialchars($errorMessage); ?></span>
            <?php endif; ?>
            <!-- Bouton Envoyer -->
            <button type="submit"
                class="w-full bg-[#6e7271] text-white py-2 rounded-lg hover:bg-[#384d48] transition duration-300">
                Envoyer le lien de réinitialisation
            </button>
        </form>
    </div>
</body>
</html>