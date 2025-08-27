<?php

require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function render($filePath)
    {
        return (new View($filePath))->render();
    }

    public function login($email, $password)
    {
        $user = $this->userModel->login($email, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: /todo/tasks");
            exit;
        } else {
            return "Invalid email or password!";
        }
    }

    public function register($username, $email, $password)
    {
        try {
            return $this->userModel->register($username, $email, $password);
        } catch (Exception $e) {
            return false;
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        header("Location: /todo/login");
        exit;
    }
}
