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

    public function createUser($name, $email, $contact, $gender, $password, $profile) {
        $conn = $this->db->connection();

        // Handle file upload
        $uploadDir ='../assets/images/uploads/';
        $profilePath = $uploadDir . basename($profile['name']);

        if (!move_uploaded_file($profile['tmp_name'], $profilePath)) {
            return false;
        }

        // Store the relative path for database
        $profileUrl = '../assets/images/uploads/' . basename($profile['name']);

        $stmt = $conn->prepare("INSERT INTO user (name, email, contact, gender, password, profile) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $contact, $gender, $password, $profileUrl);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Database Insert Error: " . $stmt->error);
            return false;
        }
    }
}
?>
