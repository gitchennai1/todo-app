<?php require_once 'config/db.php';

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $editId = $_POST['edit_id'];
    $newTask = $_POST['edit_task'];
    $newDueDate = $_POST['edit_due_date'];
    $update = $pdo->prepare("UPDATE todos SET task = ?, due_date = ? WHERE id = ?");
    $update->execute([$newTask, $newDueDate, $editId]);
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
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 25px;
            flex-flow: row;
        }
        input[type="date"] {
            flex: 1 1 20% !important;
        }

        input[type="text"],
        input[type="date"] {
            flex: 1 1 100%;
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

        .task-details {
            flex: 1;
        }

        .due-date {
            display: block;
            font-size: 13px;
            color: #888;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📝 Todo-Lists</h1>

        <!-- Add new task form -->
        <form method="POST" action="add.php">
            <input type="text" name="task" placeholder="Enter new task..." required />
            <input type="date" name="due_date" required />
            <button type="submit">Add</button>
        </form>

        <!-- Task list -->
        <ul>
            <?php foreach ($todos as $todo): ?>
                <li>
                    <?php if (isset($_GET['edit']) && $_GET['edit'] == $todo['id']): ?>
                        <form method="POST" style="width: 100%;">
                            <input type="hidden" name="edit_id" value="<?= $todo['id'] ?>">
                            <input type="text" name="edit_task" value="<?= htmlspecialchars($todo['task']) ?>" required>
                            <input type="date" name="edit_due_date" value="<?= $todo['due_date'] ?>" required>
                            <button type="submit">Update</button>
                            <a href="index.php">Cancel</a>
                        </form>
                    <?php else: ?>
                        <div class="task-details">
                            <span class="<?= $todo['status'] ? 'task-done' : '' ?>">
                                <?= htmlspecialchars($todo['task']) ?>
                            </span>
                            <span class="due-date">Due: <?= htmlspecialchars(date('d M Y', strtotime($todo['due_date']))) ?></span>
                        </div>
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
            <p style="text-align: center; font-weight: bold;">Updated By Developer - Siva</p>
            <p style="text-align: center; font-weight: bold;">Updated By Developer - Ambu</p>
            <p style="text-align: center; font-weight: bold;">Updated By Developer - Vicky</p>
            <p style="text-align: center; font-weight: bold;">Updated By Developer - Satheesh</p>
            <p style="text-align: center; font-weight: bold;">Updated By Developer - Tamil Aruvi</p>
        </div>
    </div>
</body>
</html>
