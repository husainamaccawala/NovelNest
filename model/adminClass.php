<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl .'/config/db.php';

class Admin {
    private $conn;

    public function __construct() {
        $db = new DB();
        $this->conn = $db->Connection();
    }

    public function getAdminByFullname($fullname) {
        $query = "SELECT * FROM admin WHERE fullname = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $fullname);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getAdminById($admin_id) {
        $query = "SELECT fullname, image FROM admin WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
    
