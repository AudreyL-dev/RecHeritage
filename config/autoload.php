<?php
// Toujours démarrer la session
session_start();

// Charger la configuration (BASE_URL)
require_once __DIR__ . '/config.php';

// Charger les fonctions de sécurité CSRF
require_once __DIR__ . '/csrf.php';

// Charger les fonctions utilitaires (route, etc.)
require_once __DIR__ . '/../helpers/url.php';

// Auto-chargement des classes avec gestion des namespaces
spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . '/../' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

