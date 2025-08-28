<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once __DIR__ . '/../../controllers/TaskController.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $status = $_GET['status'] ?? '';
    $due_date = $_GET['due_date'] ?? '';

    $taskController = new TaskController();
    $tasks = $taskController->getTasksByUser($status, $due_date);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $taskController = new TaskController();

    $taskId = $_POST['task_id'];
    $action = $_POST['action'];

    if ($action == 'delete') {
        $taskController->delete($taskId);
    } elseif ($action == 'mark_completed') {
        $taskController->markCompleted($taskId);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Tasks</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div style="display: flex; justify-content: center; height: 100vh">
        <div style="display: flex; flex-direction: column; width: 100%; padding:20px">
            <div style="display: flex; justify-content: space-between">
                <h2>Task List</h2>
                <div style="display: flex; align-items: center">
                    <p>Welcome, 
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                        | <a href="logout">Logout</a>
                        | <a href="profile">Profile</a>
                    </p>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end">
                <button
                    onclick="window.location.href='add';"
                    style="padding:6px 12px; border-radius:4px; margin-bottom:10px; cursor:pointer;"
                >
                    Add New Task
                </button>
                
            </div>
            <form method="GET" style="margin-bottom: 15px; display:flex; gap:10px; align-items:center;">
                <label>Status:
                    <select name="status">
                        <option value="" <?php if ($status == '') {
                            echo 'selected';
                        } ?>>All</option>
                        <option value="pending" <?php if ($status == 'pending') {
                            echo 'selected';
                        } ?>>Pending</option>
                        <option value="completed" <?php if ($status == 'completed') {
                            echo 'selected';
                        } ?>>Completed</option>
                    </select>
                </label>
                <label>Due Date:
                    <input type="date" name="due_date" value="<?php echo htmlspecialchars($due_date); ?>">
                </label>
                <button type="submit" style="cursor:pointer;">Filter</button>
            </form>

            <table border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php if (!empty($tasks)) : ?>
                    <?php foreach ($tasks as $task) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($task['title']); ?></td>
                            <td><?php echo htmlspecialchars($task['description']); ?></td>
                            <td><?php echo htmlspecialchars($task['due_date']); ?></td>
                            <td><?php echo htmlspecialchars($task['status']); ?></td>
                            <td>
                                <?php if ($task['status'] == 'pending') : ?>
                                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="action" value="mark_completed">
                                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                        <button 
                                            type="submit"
                                            style="padding: 6px 10px; border: none; color: black; border-radius: 4px; cursor: pointer;"  
                                            onclick="return confirm('Are you sure?');" 
                                            title='mark completed'>
                                            <i class="fas fa-check"></i>
                                        </button>
                                </form>
                                <?php endif; ?>


                                <button style="padding: 6px 10px; border: none; color: black; border-radius: 4px; cursor: pointer;"   onclick="window.location.href='edit?id=<?php echo $task['id']; ?>'">
                                    <i class="fas fa-edit"></i>
                                </button>


                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                    <button 
                                        type="submit" style="padding: 6px 10px; border: none; color: black; border-radius: 4px; cursor: pointer;"
                                        onclick="return confirm('Are you sure you want to delete this task?');"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            

                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">No tasks found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>
