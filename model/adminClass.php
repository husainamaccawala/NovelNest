
<?php
class Admin {
    private $conn;
    private $table = "admin";

    public function __construct() {
        $db = new DB();
        $this->conn = $db->connection();
    }

    public function getAdminByFullname($fullname) {
        $query = "SELECT * FROM " . $this->table . " WHERE fullname = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $fullname);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); 
    }

    public function updateLastLogin($id) {
        $query = "UPDATE " . $this->table . " SET last_login = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>

