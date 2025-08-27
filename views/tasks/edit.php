<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit;
}


if ($_SERVER['QUERY_STRING']) {
    parse_str($_SERVER['QUERY_STRING'], $queryParams);
    $id = $queryParams['id'] ?? null;
    $taskId = $id;

    if (!$id) {
        die("Task not found.");
    }

    require_once __DIR__ . '/../../controllers/TaskController.php';

    $taskController = new TaskController();
    $task = $taskController->getTaskById($id);

    if (!$task) {
        die("Task not found.");
    }


} else {
    die("Task not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../../controllers/TaskController.php';

    $taskController = new TaskController();
    $taskController->edit($id, $_POST);

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
</head>
<body>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh">
        <div style="display: flex; flex-direction: column;border: 2px solid gray; padding: 20px; background-color: #f7f6f6;">
            <h1>Edit Task</h1>
            <p><a href="tasks">Back to Task List</a></p>

            <?php if (!empty($error)) : ?>
                <p style="color:red;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <p>
                    <label>Title:</label><br>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
                </p>
                <p>
                    <label>Description:</label><br>
                    <textarea name="description"><?php echo htmlspecialchars($task['description']); ?></textarea>
                </p>
                <p>
                    <label>Due Date:</label><br>
                    <input type="date" name="due_date" value="<?php echo htmlspecialchars($task['due_date']); ?>">
                </p>
                <p>
                    <label>Status:</label><br>
                    <select name="status">
                        <option value="pending" <?php echo $task['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="completed" <?php echo $task['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                    </select>
                </p>
                <p>
                    <button type="submit">Update Task</button>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
