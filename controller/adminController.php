<?php
// Start the session only if it is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl .'/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl .'/model/adminClass.php';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl .'/model/userClass.php';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl .'/model/mailHelper.php';


class AdminController {
    private $adminModel;
    private $userModel;
    private $mailer;

    public function __construct() {
        $this->adminModel = new Admin();
        $this->userModel = new UserClass();
        $this->mailer = new MailHelper();
    }

    public function login($fullname, $password) {
        if (empty($fullname) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Both fields are required.']);
            return;
        }

        // Check in admin table using 'fullname'
        $admin = $this->adminModel->getAdminByFullname($fullname);
        if ($admin && $password == $admin['password']) { // No password hashing used
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['fullname'];
            $_SESSION['admin_profile_image'] = $admin['image'] ?? 'assets/images/avatars/09.jpg';
            
            $this->sendOtpToEmail($admin['email'], 'admin', $admin['id']);
            return;
        }

        // Check in user table using 'name'
        $user = $this->userModel->getUserByName($fullname);
        if ($user && password_verify($password, $user['password'])) { 
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_profile_image'] = $user['profile'] ?? 'assets/images/avatars/09.jpg';

            $this->sendOtpToEmail($user['email'], 'user', $user['id']);
            return;
        }

        echo json_encode(['status' => 'error', 'message' => 'Invalid credentials.']);
    }

    public function getAdminProfile($admin_id) {
        return $this->adminModel->getAdminById($admin_id);
    }

    private function sendOtpToEmail($email, $type, $userId) {
        if (!$email) {
            echo json_encode(['status' => 'error', 'message' => 'Email not found for this user.']);
            return;
        }

        $otp = rand(100000, 999999);
        $otpExpiry = time() + 300;

        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expiry'] = $otpExpiry;
        $_SESSION['otp_user_id'] = $userId;
        $_SESSION['otp_type'] = $type;

        $subject = "Your OTP for Two-Step Verification";
        $message = "Your OTP code is: <strong>$otp</strong>. It is valid for 5 minutes.";

        if ($this->mailer->sendMail($email, $subject, $message)) {
            echo json_encode(['status' => 'success', 'redirect' => '/novelnest/view/admin/verifyOtp.php']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send OTP. Please try again.']);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $controller = new AdminController();
    $controller->login(trim($_POST['fullname']), trim($_POST['password']));
}
?>