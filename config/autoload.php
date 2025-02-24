<?php
// Toujours démarrer la session
session_start();
// Charger la configuration (BASE_URL)
require_once __DIR__ . '/config.php';
spl_autoload_register(function ($class) {
    // Remplace les antislashs par des slashs pour compatibilité avec les namespaces
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    // Construit le chemin du fichier à inclure
    $file = __DIR__ . '/../' . $class . '.php';

    // Vérifie si le fichier existe avant de l'inclure
    if (file_exists($file)) {
        require_once $file;
    }
});
