<?php
// Toujours démarrer la session
session_start();

// Charger la configuration globale
require_once __DIR__ . '/config.php';

// Sécurité : protection CSRF
require_once __DIR__ . '/csrf.php';

// Fonctions utilitaires globales (route, etc.)
require_once __DIR__ . '/../helpers/url.php';

// Autoload des classes (MVC : Models, Controllers)
spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $folders = ['Models', 'Controllers'];

    foreach ($folders as $folder) {
        $file = __DIR__ . '/../' . $folder . '/' . basename($class) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

