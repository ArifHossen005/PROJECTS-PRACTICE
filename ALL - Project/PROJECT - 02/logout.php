<?php
session_start();

require_once 'config/database.php';
require_once 'models/User.php';
require_once 'controllers/AuthController.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$auth = new AuthController($db, $user);

$auth->logout();

header("Location: login.php");
exit();
