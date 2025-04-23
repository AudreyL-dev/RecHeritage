<!-- navbar.php -->
<nav class='bg-gray-100/0 backdrop-blur-sm shadow-md h-20 flex items-center'>
    <div class='w-full px-4 flex justify-between items-center h-full'>
        <!-- Logo intégré -->
        <a href='<?= route('home') ?>' class='flex items-center space-x-2 justify-start'>
            <img src='<?= BASE_URL ?>/assets/img/logo-rec-heritage.svg' alt='Logo Site de recettes'
                class='h-full max-h-[80px]'>
        </a>

        <!-- Bouton hamburger (mobile) -->
        <button id='menu-toggle' class='lg:hidden flex items-center text-gray-600 focus:outline-none'>
            <svg class='h-6 w-6' fill='none' stroke='currentColor' viewBox='0 0 24 24'
                xmlns='http://www.w3.org/2000/svg'>
                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 6h16M4 12h16m-7 6h7'></path>
            </svg>
        </button>

        <!-- Liens de navigation -->
        <div id='menu' class='hidden lg:flex flex-col lg:flex-row items-center space-y-4 lg:space-y-0 lg:space-x-6'>
            <a href='<?= route('home') ?>'
                class='font-bellota text-gray-300 hover:text-white text-2xl transition'>Accueil</a>
            <a href='<?= route('contact') ?>'
                class='font-bellota text-gray-300 hover:text-white text-2xl transition'>Contact</a>
            <a href='<?= route('recipes') ?>'
                class='font-bellota text-gray-300 hover:text-white text-2xl transition'>Recettes</a>

            <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true): ?>
                <!-- Menu utilisateur connecté -->
                <div class='relative' id='user-menu'>
                    <button class='flex items-center font-bellota text-gray-300 hover:text-white text-2xl transition'>
                        <?= htmlspecialchars($_SESSION['pseudo']) ?>
                        <svg class='ml-2 h-4 w-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'
                            xmlns='http://www.w3.org/2000/svg'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'></path>
                        </svg>
                    </button>
                    <ul id='user-dropdown'
                        class='absolute hidden bg-white/90 shadow-md rounded-md mt-2 w-48 transition-all duration-300 ease-in-out opacity-0'>
                        <li><a href='<?= route('recipes_create') ?>'
                                class='block px-4 py-2 text-gray-700 hover:bg-gray-100'>Ajouter une recette</a></li>
                        <li><a href='<?= route('user_recipes') ?>'
                                class='block px-4 py-2 text-gray-700 hover:bg-gray-100'>Mes recettes</a></li>
                    </ul>
                </div>
                <a href='<?= BASE_URL ?>/sign_out.php'
                    class='font-bellota text-gray-300 hover:text-white text-2xl transition'>Déconnexion</a>
            <?php else: ?>
                <!-- Lien de connexion si déconnecté -->
                <a href='<?= route('sign_in_sign_up') ?>'
                    class='font-bellota text-gray-300 hover:text-white text-2xl transition'>Me connecter</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
    const userMenu = document.getElementById('user-menu');
    const userDropdown = document.getElementById('user-dropdown');

    userMenu.addEventListener('mouseenter', () => {
        userDropdown.classList.remove('hidden');
        userDropdown.classList.add('opacity-100', 'scale-100');
    });

    userMenu.addEventListener('mouseleave', () => {
        setTimeout(() => {
            if (!userMenu.matches(':hover')) {
                userDropdown.classList.add('hidden');
                userDropdown.classList.remove('opacity-100', 'scale-100');
            }
        }, 500);
    });

    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('menu');
    menuToggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>