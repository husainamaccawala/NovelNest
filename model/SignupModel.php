	
<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/config/DB.php';

class SignupModel {
    private $db;

public function __construct() {
    $this->db = new DB();
}

public function getUserByEmail($email) {
    $conn = $this->db->connection();
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

public function createUser($name, $email, $gender, $password, $profile) {
    $conn = $this->db->connection();

    // Define the server-side upload directory
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/NovelNest/assets/images/';

    // Define the client-side URL path
    $profileUrl = '/NovelNest/assets/images/' . basename($profile['name']);

    // Handle file upload
    $profilePath = $uploadDir . basename($profile['name']);

    if (!move_uploaded_file($profile['tmp_name'], $profilePath)) {
        return false;
    }

    $stmt = $conn->prepare("INSERT INTO user (name, email, gender, password, profile) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $gender, $password, $profileUrl);

    if ($stmt->execute()) {
        return true;
    } else {
        error_log("Database Insert Error: " . $stmt->error);
        return false;
    }
}
}
?>