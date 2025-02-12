<?php
class DB
{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "novelnest";
    private $conn;



    public function connection()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        return $this->conn;
    }
}

