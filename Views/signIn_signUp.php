<?php
$pageTitle = "Connexion / Inscription - Site de recettes";
require_once __DIR__ . '/../Views/includes/head.php';
require_once __DIR__ . '/../Views/includes/navbar.php';
?>

<body class="bg-[#f8f8f8] text-[#384d48] font-sans min-h-screen flex flex-col">

    <div class="flex flex-col items-center justify-center flex-grow px-4">
        <h1 class="text-3xl font-bold mb-6">Connexion / Inscription</h1>

        <?php if (isset($_SESSION['message'])): ?>
            <div
                class="w-full max-w-md mb-4 p-4 rounded-lg <?= $_SESSION['message_type'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>

        <form action="<?= route('sign_in_sign_up') ?>" method="POST"
            class="bg-white shadow-md rounded-lg p-6 max-w-sm w-full space-y-6">

            <div class="relative">
                <input type="email" name="signIn_signUp_email" id="signIn_signUp_email"
                    class="peer w-full border border-[#acad94] rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-[#6e7271] placeholder-transparent"
                    placeholder="Votre email" required>
                <label for="signIn_signUp_email"
                    class="absolute left-3 top-0 text-[#6e7271] text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-[#acad94] peer-focus:top-0 peer-focus:text-sm peer-focus:text-[#6e7271]">
                    Votre email
                </label>
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-[#6e7271] text-white py-2 rounded-lg hover:bg-[#384d48] transition duration-300">
                    Connexion / Inscription
                </button>
            </div>

        </form>

        <p class="text-sm text-gray-600 mt-2">
            <a href="<?= route('reset_request') ?>" class="text-[#6e7271] hover:underline">
                Mot de passe oublié ?
            </a>
        </p>
    </div>

    <?php require_once(__DIR__ . '/../Views/includes/footer.php'); ?>
</body>
</html>