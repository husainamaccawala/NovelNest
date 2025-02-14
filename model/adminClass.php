<?php
require_once('../config/db.php');

class Admin {
    private $conn;

    public function __construct() {
        $db = new DB();
        $this->conn = $db->Connection();
    }

    public function getAdminByFullname($fullname) {
        $query = "SELECT * FROM admin WHERE fullname = '$fullname' LIMIT 1";
        $result = mysqli_query($this->conn, $query);
        return mysqli_fetch_assoc($result);
    }
    
}
?>
