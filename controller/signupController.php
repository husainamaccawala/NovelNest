<?php
$baseUrl = '/NovelNest';
session_start();
require $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/config/DB.php';
require $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/model/SignupModel.php';

class SignupController {
    private $userModel;

    public function __construct() {
        $this->userModel = new SignupModel();
    }

    public function signup($name, $email, $gender, $password, $profile) {
        if (empty($name) || empty($email) || empty($gender) || empty($password) || empty($profile)) {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
            return;
        }

        // Validate email format
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
            return;
        }

        // Check if the email already exists
        if ($this->userModel->getUserByEmail($email)) {
            echo json_encode(['status' => 'error', 'message' => 'Email already exists.']);
            return;
        }

        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Handle file upload validation
        $validMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB

        if (!in_array($profile['type'], $validMimeTypes)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only JPEG, PNG, and GIF files are allowed.']);
            return;
        }

        if ($profile['size'] > $maxFileSize) {
            echo json_encode(['status' => 'error', 'message' => 'File size exceeds the maximum limit of 2MB.']);
            return;
        }

        // Insert new user into the database
        $result = $this->userModel->createUser($name, $email, $gender, $hashedPassword, $profile);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Signup successful!', 'redirect' => "/NovelNest/view/admin/adminSigninForm.php"]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Signup failed. Please try again.']);
        }
    }
}

// Handle signup request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'signup') {
    $controller = new SignupController();
    $controller->signup(
        trim($_POST['user-name']),
        trim($_POST['email']),
        trim($_POST['gender']),
        trim($_POST['password']),
        $_FILES['photo']
    );
}
?>
