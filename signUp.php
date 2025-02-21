<?php
$pageTitle = "Site de recettes - Inscription"; // Définir le titre dynamique
require_once(__DIR__ . '/head.php'); // Inclure le fichier d'en-tête
?>
<body class="bg-[#f8f8f8] text-[#384d48] font-sans min-h-screen flex flex-col">
    <!-- Navbar -->
    <?php require_once(__DIR__ . '/navbar.php'); ?>

    <!-- Conteneur principal -->
    <div class="flex flex-col items-center justify-center flex-grow px-4">
        <!-- Titre -->
        <h1 class="text-3xl font-bold mb-6">Création de compte</h1>

        <!-- Formulaire -->
        <form action="" method="POST" class="bg-white shadow-md rounded-lg p-6 max-w-md w-full space-y-6">
            <input type="hidden" name="form_type" value="sign_up">
            <!-- Email (pré-rempli si existant) -->
            <div class="relative">
                <input type="email" name="email" id="email"
                    class="peer w-full border border-[#acad94] rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-[#6e7271]"
                    placeholder=" "
                    value="<?php echo isset($_SESSION['userEmail']) ? htmlspecialchars($_SESSION['userEmail']) : ''; ?>"
                    required>
                <label for="email"
                    class="absolute left-3 top-0 text-[#6e7271] text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-[#acad94] peer-focus:top-0 peer-focus:text-sm peer-focus:text-[#6e7271]">
                    E-mail
                </label>
            </div>

            <!-- Champ Pseudo -->
            <div class="relative">
                <input type="text" name="pseudo" id="pseudo"
                    class="peer w-full border border-[#acad94] rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-[#6e7271]"
                    placeholder=" " required>
                <label for="pseudo"
                    class="absolute left-3 top-0 text-[#6e7271] text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-[#acad94] peer-focus:top-0 peer-focus:text-sm peer-focus:text-[#6e7271]">
                    Pseudo
                </label>
            </div>

            <!-- Date de naissance -->
            <div class="relative">
                <input type="date" name="birthDate" id="birthDate"
                    class="peer w-full border border-[#acad94] rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-[#6e7271]"
                    placeholder=" " required>
                <label for="birthDate"
                    class="absolute left-3 top-0 text-[#6e7271] text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-[#acad94] peer-focus:top-0 peer-focus:text-sm peer-focus:text-[#6e7271]">
                    Date de naissance
                </label>
            </div>

            <!-- Mot de passe -->
            <div class="relative">
                <input type="password" name="password" id="password"
                    class="peer w-full border border-[#acad94] rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-[#6e7271]"
                    placeholder=" " required>
                <label for="password"
                    class="absolute left-3 top-0 text-[#6e7271] text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-[#acad94] peer-focus:top-0 peer-focus:text-sm peer-focus:text-[#6e7271]">
                    Mot de passe
                </label>
                <button type="button" data-target="#password"
                    class="toggle-password absolute right-3 top-3 text-gray-600">
                    <!-- Icône pour afficher ou masquer -->
                    <svg class="eye-closed w-5 h-5  " xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="#384D48" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-eye-closed">
                        <path d="m15 18-.722-3.25" />
                        <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                        <path d="m20 15-1.726-2.05" />
                        <path d="m4 15 1.726-2.05" />
                        <path d="m9 18 .722-3.25" />
                    </svg>
                    <svg class="eye-open w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="#6E7271" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-eye">
                        <path
                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>

                </button>
            </div>

            <!-- Confirmation du mot de passe -->
            <div class="relative">
                <input type="password" name="confirm_password" id="confirm_password"
                    class="peer w-full border border-[#acad94] rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-[#6e7271]"
                    placeholder=" " required>
                <label for="confirm_password"
                    class="absolute left-3 top-0 text-[#6e7271] text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-[#acad94] peer-focus:top-0 peer-focus:text-sm peer-focus:text-[#6e7271]">
                    Confirmez le mot de passe
                </label>
                <button type="button" data-target="#confirm_password"
                    class="toggle-password absolute right-3 top-3 text-gray-600">
                    <!-- Icône pour afficher ou masquer -->
                    <svg class="eye-closed w-5 h-5 " xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="#384D48" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-eye-closed">
                        <path d="m15 18-.722-3.25" />
                        <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                        <path d="m20 15-1.726-2.05" />
                        <path d="m4 15 1.726-2.05" />
                        <path d="m9 18 .722-3.25" />
                    </svg>
                    <svg class="eye-open w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="#6E7271" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-eye">
                        <path
                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>

                </button>
            </div>


            <!-- Bouton Créer un compte -->
            <div>
                <button type="submit"
                    class="w-full bg-[#6e7271] text-white py-2 rounded-lg hover:bg-[#384d48] transition duration-300">
                    Créer un compte
                </button>
            </div>
        </form>
    </div>
</body>
</html>