<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/config/db.php';

class UserClass
{
    private $db;
    private $conn;
    private $table = "user";
    public function __construct()
    {
        $this->db = new DB();
        $this->db = $this->db->connection(); // Ensure connection is stored properly
    }

    public function createUser($data)
    {
        $name = $this->db->real_escape_string($data['name']);
        $email = $this->db->real_escape_string($data['email']);
        $gender = $this->db->real_escape_string($data['gender']);
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        // Handle image upload
        $profilePath = $this->uploadImage($_FILES['photo']);

        $query = "INSERT INTO user (name, email, gender, password, profile)
                  VALUES ('$name', '$email', '$gender', '$password', '$profilePath')";

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



    public function getUserByName($fullname)
    {
        $query = "SELECT * FROM user WHERE name = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            die('Error preparing statement: ' . $this->db->error);
        }

        $stmt->bind_param("s", $fullname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();  // Return user record if found
        } else {
            return null;  // No user found
        }
    }

    public function updateUser($data)
    {
        $id = $this->db->real_escape_string($data['id']);
        $name = $this->db->real_escape_string($data['name']);
        $email = $this->db->real_escape_string($data['email']);
        $gender = $this->db->real_escape_string($data['gender']);

        $updateFields = "name='$name', email='$email', gender='$gender'";

        if (!empty($data['password'])) {
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            $updateFields .= ", password='$password'";
        }

        if (!empty($_FILES['photo']['name'])) {
            // First, get the old image path from DB
            $stmt = $this->db->prepare("SELECT profile FROM user WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                if (!empty($row['profile']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $row['profile'])) {
                    unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $row['profile']);  // Delete old image
                }
            }

            // Upload new image
            $profilePath = $this->uploadImage($_FILES['photo']);
            if (!empty($profilePath)) {
                $updateFields .= ", profile='$profilePath'";
            }
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
            if (!empty($row['profile']) && file_exists(__DIR__ . '/../' . $row['profile'])) {
                unlink(__DIR__ . '/../' . $row['profile']);
            }
        }

        $query = "DELETE FROM user WHERE id='$id'";
        return $this->db->query($query);
    }

    private function uploadImage($file)
    {
        $uploadDir = '/NovelNest/assets/images/'; // Ensure path is inside NovelNest
        $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Validate the image file type
        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $validExtensions)) {
            return ''; // Invalid file type
        }

        // Generate a unique filename to prevent overwriting
        $newFileName = time() . '_' . uniqid() . '.' . $imageFileType;
        $targetFile = $uploadDir . $newFileName;

        // Move uploaded file to the target directory
        if (move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/' . $targetFile)) {
            return $targetFile;  // Return relative path to store in DB
        }
        return '';
    }
}
