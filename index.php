<?php

session_start();

require_once __DIR__.'/router/router.php';
require_once __DIR__.'/controllers/TaskController.php';
require_once __DIR__ .'/controllers/AuthController.php';
require_once __DIR__ .'/controllers/UserController.php';

define('VIEW_PATH', __DIR__.'/views');

$taskController = new TaskController();
$authController = new AuthController();
$userController = new UserController();

$basePath = '/todo';
$path = $_SERVER['REQUEST_URI'];
$route = preg_replace('#^' . preg_quote($basePath, '#') . '#', '', $path);

$router  = new Router();

$router->register("/", function () use ($taskController) {
    $taskController->render('tasks/index');
});

$router->register("/add", function () use ($taskController) {
    $taskController->render('tasks/add');
});

$router->register("/edit", function () use ($taskController) {
    $taskController->render('tasks/edit');
});

$router->register("/tasks", function () use ($taskController) {
    $taskController->render('tasks/index');
});

$router->register("/profile", function () use ($userController) {
    $userController->render('profile/profile');
});

$router->register("/login", function () use ($authController) {
    $authController-> render('auth/login');
});

$router->register("/register", function () use ($authController) {
    $authController-> render('auth/register');
});

$router->register("/logout", function () use ($authController) {
    $authController->logout();
});

try {
    $router->resolve($route);
} catch (RouteNotFoundException $e) {
    echo "404 not found";
}
