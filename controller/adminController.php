<?php
session_start();
require_once('../config/db.php');
require_once('../model/adminClass.php');

class AdminController {
    private $adminModel;

    public function __construct($db) {
        $this->adminModel = new Admin($db);
    }

    public function adminLogin($fullname, $password) {
        // Validate input
        if (empty($fullname) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Both fields are required.']);
            return;
        }

        // Fetch admin by fullname
        $admin = $this->adminModel->getAdminByFullname($fullname);

        if ($admin) {
            // Compare plain text passwords
            if ($password === $admin['password']) {
                $this->adminModel->updateLastLogin($admin['id']);
            
                // Set session variables
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['fullname'];
                $_SESSION['admin_profile_image'] = $admin['image']; // Store profile image in session
            
                echo json_encode(['status' => 'success', 'message' => 'Sign-in successful.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid password.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Admin not found.']);
        }
    }
}

// Handle login request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'admin_login') {
    $database = new DB();
    $db = $database->Connection();
    $controller = new AdminController($db);

    // Pass the posted data to the controller method
    $controller->adminLogin(trim($_POST['fullname']), trim($_POST['password']));
}
?>