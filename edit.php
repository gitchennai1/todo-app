<?php
include 'config/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("No ID provided.");
}

// Fetch existing record
$stmt = $pdo->prepare("SELECT * FROM todos WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    die("Todo not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newTask = $_POST['title'];
    $update = $pdo->prepare("UPDATE todos SET task = ? WHERE id = ?");
    $update->execute([$newTask, $id]);
    header("Location: index.php");
    exit;
}
?>

<form method="POST">
    <label for="title">Edit Todo:</label>
    <input type="text" name="title" value="<?php echo isset($row['task']) ? htmlspecialchars($row['task']) : ''; ?>" required />
    <button type="submit">Update</button>
</form>