<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../../controllers/AuthController.php';

    $auth = new AuthController();

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($auth->register($username, $email, $password)) {
        header("Location: login");
        exit;
    } else {
        $message = "Registration failed. Email may already exist.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Todo App</title>
</head>
<body>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh">
        <div style="display: flex; flex-direction: column;border: 2px solid gray; padding: 20px; background-color: #f7f6f6;">
            <h2>Register</h2>
            <?php if (!empty($message)) {
                echo "<p style='color:red;'>$message</p>";
            } ?>

            <form method="POST">
                <label>Username:</label><br>
                <input type="text" name="username" required><br><br>

                <label>Email:</label><br>
                <input type="email" name="email" required><br><br>

                <label>Password:</label><br>
                <input type="password" name="password" required><br><br>

                <button type="submit">Register</button>
            </form>

            <p>Already have an account? <a href="login">Login here</a></p>
        </div>
    </div>
</body>
</html>
