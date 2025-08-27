<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../../controllers/TaskController.php';

    $taskController = new TaskController();
    $taskController->add($_POST);

    header("Location: tasks");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Task</title>
</head>
<body>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh">
        <div style="display: flex; flex-direction: column;border: 2px solid gray; padding: 20px; background-color: #f7f6f6;">
            <h2>Add New Task</h2>
            <p><a href="tasks">Back to Task List</a></p>

            <?php if (!empty($error)) : ?>
                <p style="color:red;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <p>
                    <label>Title:</label><br>
                    <input type="text" name="title" required>
                </p>
                <p>
                    <label>Description:</label><br>
                    <textarea name="description"></textarea>
                </p>
                <p>
                    <label>Due Date:</label><br>
                    <input type="date" name="due_date" required>
                </p>
                <p>
                    <button type="submit">Add Task</button>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
