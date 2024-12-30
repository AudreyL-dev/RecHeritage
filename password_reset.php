<?php
$pageTitle = "Définir un nouveau mot de passe";
require_once 'head.php';
$token = $_GET['token'] ?? '';
?>
<body class="bg-[#f8f8f8] text-[#384d48] font-sans min-h-screen flex flex-col">
    <div class="flex flex-col items-center justify-center flex-grow px-4">
        <h1 class="text-3xl font-bold mb-6 text-[#384d48]">Définir un nouveau mot de passe</h1>
        <form action="traitement.php" method="POST" class="bg-white shadow-md rounded-lg p-6 max-w-md w-full space-y-6">
            <input type="hidden" name="form_type" value="password_reset">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

            <!-- Mot de passe -->
            <div class="relative">
                <input type="password" name="new_password" id="new_password"
                    class="peer w-full border border-[#acad94] rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-[#6e7271]"
                    placeholder=" " required>
                <label for="new_password"
                    class="absolute left-3 top-2 text-[#6e7271] text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-[#acad94] peer-focus:top-2 peer-focus:text-sm peer-focus:text-[#6e7271]">
                    Mot de passe
                </label>
                <button type="button" data-target="#new_password"
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
                    class="absolute left-3 top-2 text-[#6e7271] text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-placeholder-shown:text-[#acad94] peer-focus:top-2 peer-focus:text-sm peer-focus:text-[#6e7271]">
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

            <!-- Bouton Réinitialiser -->
            <button type="submit"
                class="w-full bg-[#6e7271] text-white py-2 rounded-lg hover:bg-[#384d48] transition duration-300">
                Réinitialiser le mot de passe
            </button>
        </form>
    </div>
</body>
</html>