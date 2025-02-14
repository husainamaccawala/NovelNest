<?php
require_once('../config/db.php');

class Admin {
    private $conn;

    public function __construct() {
        $db = new DB();
        $this->conn = $db->Connection();
    }

    public function getAdminByFullname($fullname) {
        $query = "SELECT * FROM admin WHERE fullname = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $fullname);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Return admin record as an associative array
    }
}
?>
