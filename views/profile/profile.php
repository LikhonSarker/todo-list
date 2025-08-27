<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: /todo/login");
    exit;
}

require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Task.php';

$userModel = new User();
$taskModel = new Task();

$userId = $_SESSION['user_id'];
$user = $userModel->getUserById($userId);
$tasks = $taskModel->getTasksByUser($userId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';

    if (!empty($username) && !empty($email)) {
        $userModel->updateUser($userId, $username, $email);
        $user = $userModel->getUserById($userId);
        $_SESSION['username'] = $username;
    } else {
        $error = "Username and email cannot be empty!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
</head>
<body>
    <div style="display: flex; justify-content: center; align-items: center;">
        <div style="display: flex; flex-direction: column;border: 2px solid gray; padding: 20px; background-color: #f7f6f6;">
            <h1>Profile Page</h1>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> | <a href="logout">Logout</a></p>

            <h2>Update Profile</h2>

            <?php if (!empty($error)) : ?>
                <p style="color:red;"><?php echo $error; ?></p>
            <?php endif; ?>
            
            <form method="POST" action="">
                <p>
                    <label>Username:</label><br>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </p>
                <p>
                    <label>Email:</label><br>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </p>
                <p>
                    <button type="submit">Update Profile</button>
                </p>
            </form>

            <h2>My Tasks</h2>
            <p><a href="/todo/tasks">Manage Tasks</a></p>

            <table border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Status</th>
                </tr>
                <?php if (!empty($tasks)) : ?>
                    <?php foreach ($tasks as $task) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($task['title']); ?></td>
                            <td><?php echo htmlspecialchars($task['description']); ?></td>
                            <td><?php echo htmlspecialchars($task['due_date']); ?></td>
                            <td><?php echo htmlspecialchars($task['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4">No tasks found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>
