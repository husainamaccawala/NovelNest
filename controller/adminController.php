<?php
session_start();
header('Content-Type: application/json'); // Ensures JSON response

require_once('../config/db.php');
require_once('../model/adminClass.php');
require_once('../model/userClass.php');
require_once('../model/mailHelper.php'); // Assuming mail helper is here

// The rest of your PHP code...


class adminController {
    private $adminModel;
    private $userModel;
    private $mailer;

    public function __construct() {
        $this->adminModel = new Admin();
        $this->userModel = new UserClass();
        $this->mailer = new MailHelper(); // Mail helper object for sending OTP
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
                // Fetch email and send OTP
                $this->sendOtpToEmail($admin['email'], 'admin', $admin['id']);
                return;
            }
        }
    
        // Check in user table (using 'name')
        $user = $this->userModel->getUserByName($fullname);
        if ($user) {
            if ($password == $user['password']) { // No password hashing used
                // Fetch email and send OTP
                $this->sendOtpToEmail($user['email'], 'user', $user['id']);
                return;
            }
        }
    
        // If no match found
        echo json_encode(['status' => 'error', 'message' => 'Invalid credentials.']);
    }
    

    private function sendOtpToEmail($email, $type, $userId) {
        $otp = rand(100000, 999999); // 6-digit OTP
        $otpExpiry = time() + 300; // OTP valid for 5 minutes
        
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expiry'] = $otpExpiry;
        $_SESSION['otp_user_id'] = $userId;
        $_SESSION['otp_type'] = $type; // 'admin' or 'user'
        
        $subject = "Your OTP for Two-Step Verification";
        $message = "Your OTP code is: $otp. It is valid for 5 minutes.";
    
        // Send OTP email
        if ($this->mailer->sendMail($email, $subject, $message)) {
            echo json_encode(['status' => 'success', 'redirect' => '/novelnest/view/admin/verifyOtp.php']);
            exit(); // Stop further execution after sending response
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send OTP. Please try again.']);
            exit(); // Stop further execution after sending response
        }
    }
    
}

// Handle login request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $controller = new adminController();
    $controller->login(trim($_POST['fullname']), trim($_POST['password']));
}
?>
