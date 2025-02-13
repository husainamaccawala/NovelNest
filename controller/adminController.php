<?php

session_start();
require_once('../config/db.php');
require_once('../model/adminClass.php');
require_once('../model/userClass.php');

class AuthController {
    private $adminModel;
    private $userModel;

    public function __construct() {
        $this->adminModel = new Admin();
        $this->userModel = new UserClass();
    }

    public function login($fullname, $password) {
        if (empty($fullname) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Both fields are required.']);
            return;
        }

        // Check in admin table (using 'fullname')
        $admin = $this->adminModel->getAdminByFullname($fullname);
        if ($admin) {
            if ($password == $admin['password']) { // No password hashing used
                // Update last login timestamp
                $this->adminModel->updateLastLogin($admin['id']);

                // Store admin session
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['fullname'];
                $_SESSION['admin_email'] = $admin['email'];
                $_SESSION['admin_profile_image'] = $admin['image'];

                echo json_encode(['status' => 'success', 'redirect' => '/novelnest/index.php']);
                return;
            }
        }

        // Check in user table (using 'name')
        $user = $this->userModel->getUserByName($fullname);
        if ($user) {
            if ($password == $user['password']) { // No password hashing used
                // Store user session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_contact'] = $user['contact'];
                $_SESSION['user_gender'] = $user['gender'];
                $_SESSION['user_profile'] = $user['profile'];

                echo json_encode(['status' => 'success', 'redirect' => '/client-site']);
                return;
            }
        }

        // If no match found
        echo json_encode(['status' => 'error', 'message' => 'Invalid credentials.']);
    }
}

// Handle login request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $controller = new AuthController();
    $controller->login(trim($_POST['fullname']), trim($_POST['password']));
}
?>
