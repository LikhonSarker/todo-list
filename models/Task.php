<?php

require_once __DIR__ . '/../config/database.php';

class Task
{
    private $conn;

    public function __construct()
    {
        $database = Database::getInstance();
        $this->conn = $database->getConnection();
    }

    public function getTasksByUser($userId, $status = null, $due_date = null)
    {
        $query = "SELECT * FROM tasks WHERE user_id = :user_id";

        if ($status) {
            $query .= " AND status = :status";
        }

        if ($due_date) {
            $query .= " AND due_date = :due_date";
        }


        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        if ($status) {
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        }

        if ($due_date) {
            $stmt->bindParam(':due_date', $due_date, PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addTask($userId, $title, $description, $due_date)
    {
        $stmt = "INSERT INTO tasks (user_id, title, description, due_date)
                VALUES (:user_id, :title, :description, :due_date)";
        $stmt = $this->conn->prepare($stmt);

        return $stmt->execute([
            ':user_id' => $userId,
            ':title' => $title,
            ':description' =>  $description,
            ':due_date' =>  $due_date,
        ]);
    }

    public function deleteTask($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM tasks WHERE id = :id");

        return $stmt->execute([':id' => $id]);
    }

    public function getTaskById($id)
    {
        $stmt = "SELECT * FROM tasks WHERE id = :id";
        $stmt = $this->conn->prepare($stmt);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTask($id, $title, $description, $due_date, $status)
    {
        $stmt = "UPDATE tasks
                SET title = :title, 
                description = :description,
                due_date = :due_date,
                status = :status
                WHERE id = :id";
        $stmt = $this->conn->prepare($stmt);

        return $stmt->execute([
            ':title' => $title,
            ':description' =>  $description,
            ':due_date' =>  $due_date,
            ':status' =>  $status,
            ':id' =>  $id,
        ]);
    }

    public function markCompleted($id)
    {
        $stmt = "UPDATE tasks SET status = 'completed' WHERE id = :id";
        $stmt = $this->conn->prepare($stmt);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}
