<?php
// Toujours démarrer la session
session_start();

// Charger la configuration globale
require_once __DIR__ . '/config.php';

// Charger les accès BDD
require_once __DIR__ . '/mysql.php';

// Sécurité : protection CSRF
require_once __DIR__ . '/csrf.php';

// Fonctions utilitaires globales
require_once __DIR__ . '/../helpers/url.php';

// Autoload des classes
spl_autoload_register(function ($class) {
    $class = str_replace('\\\\', DIRECTORY_SEPARATOR, $class);
    $folders = ['Models', 'Controllers'];

    foreach ($folders as $folder) {
        $file = __DIR__ . '/../' . $folder . '/' . basename($class) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
