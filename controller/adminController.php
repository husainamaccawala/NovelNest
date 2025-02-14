<?php
session_start();
require_once('../config/db.php');
require_once('../model/adminClass.php');
require_once('../model/userClass.php');
require_once('../model/mailHelper.php'); // Assuming PHPMailer is used

class adminController {
    private $adminModel;
    private $userModel;
    private $mailer;

    public function __construct() {
        $this->adminModel = new Admin();  // Admin model instance
        $this->userModel = new UserClass();  // User model instance
        $this->mailer = new MailHelper();  // PHPMailer instance
    }

    public function login($fullname, $password) {
        if (empty($fullname) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Both fields are required.']);
            return;
        }

        // Check in admin table using 'fullname'
        $admin = $this->adminModel->getAdminByFullname($fullname);
        if ($admin && $password == $admin['password']) { // No password hashing used
            $this->sendOtpToEmail($admin['email'], 'admin', $admin['id']);
            return;
        }

        // Check in user table using 'name'
        $user = $this->userModel->getUserByName($fullname);
        if ($user && $password == $user['password']) { // No password hashing used
            $this->sendOtpToEmail($user['email'], 'user', $user['id']);
            return;
        }

        // If no match found
        echo json_encode(['status' => 'error', 'message' => 'Invalid credentials.']);
    }

    private function sendOtpToEmail($email, $type, $userId) {
        if (!$email) {
            echo json_encode(['status' => 'error', 'message' => 'Email not found for this user.']);
            return;
        }

        $otp = rand(100000, 999999); // Generate a 6-digit OTP
        $otpExpiry = time() + 300; // OTP valid for 5 minutes

        // Store OTP in session
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expiry'] = $otpExpiry;
        $_SESSION['otp_user_id'] = $userId;
        $_SESSION['otp_type'] = $type; // 'admin' or 'user'

        // Email content
        $subject = "Your OTP for Two-Step Verification";
        $message = "Your OTP code is: <strong>$otp</strong>. It is valid for 5 minutes.";

        // Send OTP via email
        if ($this->mailer->sendMail($email, $subject, $message)) {
            echo json_encode(['status' => 'success', 'redirect' => '/novelnest/view/admin/verifyOtp.php']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send OTP. Please try again.']);
        }
    }
}

// Handle login request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $controller = new adminController();
    $controller->login(trim($_POST['fullname']), trim($_POST['password']));
}
?>
