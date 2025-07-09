<?php
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = $_POST['task'];
    $dueDate = $_POST['due_date'];

    $stmt = $pdo->prepare("INSERT INTO todos (task, due_date) VALUES (?, ?)");
    $stmt->execute([$task, $dueDate]);

    header("Location: index.php");
    exit;
}
