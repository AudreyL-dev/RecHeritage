<?php
require_once __DIR__ . '/../config/autoload.php';
use Controllers\UserController;

$userController = new UserController();
$userController->signOut();