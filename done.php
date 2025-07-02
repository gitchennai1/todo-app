<?php
require_once 'config/db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("UPDATE todos SET status = 1 WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: index.php");
exit;
