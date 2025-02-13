<?php
require_once('../config/db.php');

class Admin {
    private $conn;

    public function __construct() {
        $db = new DB();
        $this->conn = $db->connection();
    }

    public function getAdminByFullname($fullname) {
        $fullname = mysqli_real_escape_string($this->conn, $fullname);
        $query = "SELECT * FROM admin WHERE fullname = '$fullname' LIMIT 1";
        $result = mysqli_query($this->conn, $query);
        return mysqli_fetch_assoc($result);
    }

    public function updateLastLogin($id) {
        $query = "UPDATE admin SET last_login = NOW() WHERE id = '$id'";
        mysqli_query($this->conn, $query);
    }
}
?>
