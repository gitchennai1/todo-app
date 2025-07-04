<?php require_once 'config/db.php';

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $editId = $_POST['edit_id'];
    $newTask = $_POST['edit_task'];
    $update = $pdo->prepare("UPDATE todos SET task = ? WHERE id = ?");
    $update->execute([$newTask, $editId]);
    header("Location: index.php");
    exit;
}

// Fetch all todos
$stmt = $pdo->query("SELECT * FROM todos ORDER BY created_at DESC");
$todos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple ToDo</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f8;
            padding: 40px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }

        form {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
        }

        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            padding: 10px 20px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #219150;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background: #f9f9f9;
            border: 1px solid #ddd;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .task-done {
            text-decoration: line-through;
            color: #888;
        }

        .actions a {
            margin-left: 10px;
            text-decoration: none;
            font-weight: bold;
        }

        .mark {
            color: #2980b9;
        }

        .delete {
            color: #e74c3c;
        }

        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container" style="background:rgb(110, 129, 150)">
        <h1>📝 Todo-Lists</h1>
        <form method="POST" action="add.php">
            <input type="text" name="task" placeholder="Enter new task..." required />
            <button type="submit">Add</button>
        </form>

        <ul>
            <?php foreach ($todos as $todo): ?>
                <li>
                    <?php if (isset($_GET['edit']) && $_GET['edit'] == $todo['id']): ?>
                        <form method="POST" style="width: 100%;align-items: center;">
                            <input type="hidden" name="edit_id" value="<?= $todo['id'] ?>">
                            <input type="text" name="edit_task" value="<?= htmlspecialchars($todo['task']) ?>" required>
                            <button type="submit">Update</button>
                            <a href="index.php">Cancel</a>
                        </form>
                    <?php else: ?>
                        <span class="<?= $todo['status'] ? 'task-done' : '' ?>">
                            <?= htmlspecialchars($todo['task']) ?>
                        </span>
                        <div class="actions">
                            <?php if (!$todo['status']): ?>
                                <a class="mark" href="done.php?id=<?= $todo['id'] ?>">Mark as Done</a>
                            <?php endif; ?>
                            <a href="index.php?edit=<?= $todo['id'] ?>">Edit</a>
                            <a class="delete" href="delete.php?id=<?= $todo['id'] ?>">Delete</a>
                        </div>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="footer">
            <p style="text-align: center;font-weight: bold">Updated By Developer - Siva</p>
        </div>
    </div>
</body>
</html>
git 
