<?php
require_once 'Controllers/UserController.php';
use Controllers\UserController;

$userController = new UserController();
$userController->signOut();