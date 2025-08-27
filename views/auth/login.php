<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../../controllers/AuthController.php';

    $auth = new AuthController();
    $message = $auth->login($_POST['email'], $_POST['password']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Todo App</title>
</head>
<body>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh">
        <div style="display: flex; flex-direction: column;border: 2px solid gray; padding: 20px; background-color: #f7f6f6;">
            <h2>Login</h2>
            <?php if (!empty($message)) {
                echo "<p style='color:red;'>$message</p>";
            } ?>

            <form method="POST">
                <label>Email:</label><br>
                <input type="email" name="email" required><br><br>

                <label>Password:</label><br>
                <input type="password" name="password" required><br><br>

                <button type="submit">Login</button>
            </form>

            <p>Don't have an account? <a href="register">Register here</a></p>
        </div>
    </div>
</body>
</html>
