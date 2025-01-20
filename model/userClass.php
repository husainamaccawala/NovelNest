<?php
require_once __DIR__.'/../config/DB.php';

class UserClass
{
    private $db;

    public function __construct()
    {
        $this->db = new DB();
        $this->db = $this->db->connect();
    }

    public function createUser($data)
    {
        $name = $this->db->real_escape_string($data['name']);
        $contact = $this->db->real_escape_string($data['contact']);
        $email = $this->db->real_escape_string($data['email']);
        $gender = $this->db->real_escape_string($data['gender']);
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        // Handle image upload
        $profilePath = $this->uploadImage($_FILES['photo']);

        $query = "INSERT INTO user (name, contact, email, gender, password, profile)
                  VALUES ('$name', '$contact', '$email', '$gender', '$password', '$profilePath')";

        return $this->db->query($query);
    }

    public function readUsers()
    {
        $query = "SELECT * FROM user";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function updateUser($data)
    {
        $id = $this->db->real_escape_string($data['id']);
        $name = $this->db->real_escape_string($data['name']);
        $contact = $this->db->real_escape_string($data['contact']);
        $email = $this->db->real_escape_string($data['email']);
        $gender = $this->db->real_escape_string($data['gender']);

        // Initialize query parts
        $updateFields = "name='$name', contact='$contact', email='$email', gender='$gender'";

        // Always hash password if provided
        if (!empty($data['password'])) {
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            $updateFields .= ", password='$password'";
        }

        // Check if new photo is uploaded
        if (!empty($_FILES['photo']['name'])) {
            $profilePath = $this->uploadImage($_FILES['photo']);
            $updateFields .= ", profile='$profilePath'";
        }

        $query = "UPDATE user SET $updateFields WHERE id='$id'";
        return $this->db->query($query);
    }

    public function deleteUser($id)
    {
        $id = $this->db->real_escape_string($id);

        // Delete user profile image
        $stmt = $this->db->prepare("SELECT profile FROM user WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (!empty($row['profile']) && file_exists(__DIR__.'/../'.$row['profile'])) {
                unlink(__DIR__.'/../'.$row['profile']);
            }
        }

        $query = "DELETE FROM user WHERE id='$id'";
        return $this->db->query($query);
    }

    private function uploadImage($file)
    {
        $uploadDir = 'assets/images/';
        $targetFile = $uploadDir . basename($file['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validate the image file type
        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $validExtensions)) {
            return ''; // Invalid file type
        }

        // Move uploaded file to the target directory
        if (move_uploaded_file($file['tmp_name'], __DIR__.'/../'.$targetFile)) {
            return $targetFile;  // Return relative path to store in DB
        }
        return '';
    }
}
?>
