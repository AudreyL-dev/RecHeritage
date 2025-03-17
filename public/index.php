<?php
require_once __DIR__ . '/../config/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Gestion des formulaires (ex: add, update, login, signup...)
    require_once __DIR__ . '/../router.php';
} else {
    // Gestion des pages (ex: afficher page recettes, home, update_recipe en GET)
    $page = $_GET['page'] ?? 'home';
    require_once __DIR__ . '/../router.php';
}

require_once __DIR__ . '/../router.php';