<?php

require_once __DIR__ . '/../models/Task.php';
require_once __DIR__.'/../views/index.php';

class TaskController
{
    private $taskModel;

    public function __construct()
    {
        $this->taskModel = new Task();
    }

    public function render($filePath)
    {
        if (!isset($_SESSION['user_id'])) {

            header("Location: /todo/login");
            exit;
        }

        return (new View($filePath))->render();
    }

    public function add($data)
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $title = $data['title'] ?? '';
        $description = $data['description'] ?? '';
        $due_date = $data['due_date'] ?? '';

        $this->taskModel->addTask($userId, $title, $description, $due_date);
    }

    public function getTasksByUser($status = null)
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login");
            exit;
        }

        $userId = $_SESSION['user_id'];

        return $this->taskModel->getTasksByUser($userId, $status);

    }

    public function getTaskById($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login");
            exit;
        }

        return $this->taskModel->getTaskById($id);
    }

    public function edit($id, $data)
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login");
            exit;
        }

        $title = $data['title'] ?? '';
        $description = $data['description'] ?? '';
        $due_date = $data['due_date'] ?? '';
        $status = $data['status'] ?? 'pending';

        $this->taskModel->updateTask($id, $title, $description, $due_date, $status);

        header("Location: tasks");
        exit;
    }

    public function delete($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login");
            exit;
        }

        $this->taskModel->deleteTask($id);
        header("Location: tasks");
        exit;
    }

    public function markCompleted($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login");
            exit;
        }

        $this->taskModel->markCompleted($id);

        header("Location: tasks");
        exit;
    }

}
