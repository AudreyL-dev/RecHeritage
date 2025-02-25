<?php
require_once __DIR__ . '/../config/autoload.php';

$page = $_GET['page'] ?? 'home'; // Par défaut, afficher la page d'accueil

require_once __DIR__ . '/../router.php';