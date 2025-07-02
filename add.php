<?php
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['task'])) {
    $task = $_POST['task'];
    $stmt = $pdo->prepare("INSERT INTO todos (task) VALUES (?)");
    $stmt->execute([$task]);
}

header("Location: index.php");
exit;
