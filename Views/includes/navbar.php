<!-- navbar.php -->
<nav class="bg-gray-100 shadow-md">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <!-- Logo intégré -->
        <a href="<?= BASE_URL ?>/index.php" class="flex items-center space-x-2">
            <img src="<?= BASE_URL ?>/assets/img/DALL_E_logo.png" alt="Logo Site de recettes" class="h-10 w-10">
            <span class="text-lg font-bold text-gray-800">Site de recettes</span>
        </a>

        <!-- Bouton hamburger (mobile) -->
        <button id="menu-toggle" class="lg:hidden flex items-center text-gray-600 focus:outline-none">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>

        <!-- Liens de navigation -->
        <div id="menu" class="hidden lg:flex flex-col lg:flex-row items-center space-y-4 lg:space-y-0 lg:space-x-6">
            <a href="<?= BASE_URL ?>/index.php?page=home"
                class="text-gray-700 hover:text-gray-900 transition">Accueil</a>
            <a href="<?= BASE_URL ?>/views/contact.php" class="text-gray-700 hover:text-gray-900 transition">Contact</a>
            <a href="<?= BASE_URL ?>/index.php?page=recettes"
                class="text-gray-700 hover:text-gray-900 transition">Recettes</a>

            <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true): ?>
                <!-- Menu utilisateur connecté -->
                <div class="relative" id="user-menu">
                    <button class="flex items-center text-gray-700 hover:text-gray-900 transition">
                        <?php echo htmlspecialchars($_SESSION['pseudo']); ?>
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <ul id="user-dropdown"
                        class="absolute hidden bg-white shadow-md rounded-md mt-2 w-48 transition-all duration-300 ease-in-out opacity-0">
                        <li><a href="<?= BASE_URL ?>/views/recipes_create.php"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Ajouter une
                                recette</a></li>
                        <li><a href="<?= BASE_URL ?>/index.php?page=user_recipes"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Mes
                                recettes</a></li>
                    </ul>
                </div>
                <a href="<?= BASE_URL ?>/signOut.php" class="text-gray-700 hover:text-gray-900 transition">Déconnexion</a>
            <?php else: ?>
                <!-- Lien de connexion si déconnecté -->
                <a href="<?= BASE_URL ?>/../views/signIn_signUp.php" class="text-gray-700 hover:text-gray-900 transition">Me
                    connecter</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
    // Script pour gérer le survol du menu utilisateur connecté
    const userMenu = document.getElementById('user-menu');
    const userDropdown = document.getElementById('user-dropdown');

    userMenu.addEventListener('mouseenter', () => {
        userDropdown.classList.remove('hidden'); // Affiche le menu
        userDropdown.classList.add('opacity-100', 'scale-100'); // Ajoute les effets de visibilité
    });

    userMenu.addEventListener('mouseleave', () => {
        setTimeout(() => {
            if (!userMenu.matches(':hover')) {
                userDropdown.classList.add('hidden'); // Cache le menu
                userDropdown.classList.remove('opacity-100', 'scale-100'); // Retire les effets de visibilité
            }
        }, 500); // Retarde la fermeture du menu de 300ms
    });

    // Script pour le menu mobile
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('menu');
    menuToggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>