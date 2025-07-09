<?php

$host = 'localhost';
$dbname = 'todo_app';
$user = 'root';
$pass = '';
// $user = 'todo_app';
// $pass = 'W$0VPCXcj?t6kD"V';

$config = require_once 'config/constant.php';

$host     = $config['DB_HOST'];
$dbname   = $config['DB_NAME'];
$username = $config['DB_USERNAME'];
$password = $config['DB_PASSWORD'];
$charset  = $config['DB_CHARSET'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
?>
