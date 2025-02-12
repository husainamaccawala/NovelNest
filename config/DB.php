<?php
class DB {
    private $host = "localhost";
    private $db_name = "novelnest";
    private $username = "root";
    private $password = "";
    public $conn;

    public function Connection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
    
}
// config.php
define('BASE_URL', 'http://localhost/NovelNest/');

?>
