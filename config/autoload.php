<?php
session_start(); // Toujours démarrer la session

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
