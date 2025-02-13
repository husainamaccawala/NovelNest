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

    public function signup($name, $email, $contact, $gender, $password, $profile) {
        if (empty($name) || empty($email) || empty($contact) || empty($gender) || empty($password) || empty($profile)) {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
            return;
        }

        // Check if the email already exists
        if ($this->userModel->getUserByEmail($email)) {
            echo json_encode(['status' => 'error', 'message' => 'Email already exists.']);
            return;
        }

        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $result = $this->userModel->createUser($name, $email, $contact, $gender, $hashedPassword, $profile);

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
        trim($_POST['contact']),
        trim($_POST['gender']),
        trim($_POST['password']),
        $_FILES['photo']
    );
}
?>
