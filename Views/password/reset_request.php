<?php
$pageTitle = 'Mot de passe oublié - Site de recettes';
require_once(__DIR__ . '/../includes/head.php');
require_once(__DIR__ . '/../includes/navbar.php');
?>

<body class="bg-[#f8f8f8] text-[#384d48] font-sans min-h-screen flex flex-col">

    <div class="flex flex-col items-center justify-center flex-grow px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Mot de passe oublié</h1>

        <?php if (isset($_SESSION['message'])): ?>
            <div
                class="w-full max-w-md mb-4 p-4 rounded-lg <?= $_SESSION['message_type'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>

        <form action="<?= route('reset_request') ?>" method="post"
            class="bg-white shadow-md rounded-lg p-6 max-w-md w-full space-y-6">
            <div class="relative">
                <input type="email" name="email" id="email"
                    class="peer w-full border border-[#acad94] rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-[#384d48] placeholder-transparent"
                    placeholder="Adresse email" required>
                <label for="email"
                    class="absolute left-3 top-0 text-[#6e7271] text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-[#acad94] peer-focus:top-0 peer-focus:text-sm peer-focus:text-[#6e7271]">
                    Adresse email
                </label>
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-[#6e7271] text-white py-2 rounded-lg hover:bg-[#384d48] transition duration-300">
                    Envoyer le lien
                </button>
            </div>
        </form>
    </div>

    <?php require_once(__DIR__ . '/../includes/footer.php'); ?>
</body>
</html>