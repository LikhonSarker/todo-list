<?php

class Database
{
    private static ?Database $instance = null;
    private $host = "localhost";
    private $db_name = "todo_list";
    private $username = "root";
    private $password = "root";
    private $port = "3307";
    public $conn;

    private function __construct()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host .";port=" . $this->port .";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage(). $exception->getCode();
        }

    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
