<?php $pageTitle = "Grille tailwind"; // Définir le titre dynamique
require_once(__DIR__ . '/head.php'); // Inclure le fichier d'en-tête
require_once(__DIR__ . '/navbar.php');
?>

<body class="flex flex-col min-h-screen bg-gray-50 text-gray-700">
    <div class="container mx-auto px-4">

        <h1 class="text-3xl font-semibold text-[#384d48] mb-6">Recettes</h1>

        <div class="p-4">
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-red-500 p-4 text-white">
                    <h2>Title</h2>
                    <p>recette</p>
                </div>
                <div class="bg-green-500 p-4 text-white">Colonne 2</div>
                <div class="bg-blue-500 p-4 text-white">Colonne 3</div>
                <div class="bg-black p-4 text-white">Colonne 4</div>
                <div class="bg-yellow-500 p-4 border-8 border-[#B91C1C] text-white">Colonne 5</div>
            </div>
        </div>

        <div class="relative">
            <input type="password" id="password" class="form-input" />
            <button type="button" class="hs-toggle-password" data-hs-toggle-password='{"target": "#password"}'>
                <svg class="eye-icon hs-password-active:block shrink-0 size-3.5" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path class="hs-password-active:hidden" d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                    <path class="hs-password-active:hidden"
                        d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                    <path class="hs-password-active:hidden"
                        d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                    <line class="hs-password-active:hidden" x1="2" x2="22" y1="2" y2="22"></line>
                    <path class="hidden hs-password-active:block" d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z">
                    </path>
                    <circle class="hidden hs-password-active:block" cx="12" cy="12" r="3"></circle>
                </svg>
            </button>
        </div>

        <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>