<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['otp'])) {
    $otp = trim($_POST['otp']);

    if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_expiry'])) {
        echo json_encode(['status' => 'error', 'message' => 'Session expired. Please log in again.']);
        exit;
    }

    if ($otp == $_SESSION['otp'] && time() < $_SESSION['otp_expiry']) {
        // OTP is valid
        if ($_SESSION['otp_type'] == 'admin') {
            $_SESSION['admin_id'] = $_SESSION['otp_user_id']; // Store admin session
            unset($_SESSION['otp'], $_SESSION['otp_expiry'], $_SESSION['otp_user_id'], $_SESSION['otp_type']);
            echo json_encode(['status' => 'success', 'redirect' => '/novelnest/index.php']);
        } else if ($_SESSION['otp_type'] == 'user') {
            $_SESSION['user_id'] = $_SESSION['otp_user_id']; // Store user session
            unset($_SESSION['otp'], $_SESSION['otp_expiry'], $_SESSION['otp_user_id'], $_SESSION['otp_type']);
            echo json_encode(['status' => 'success', 'redirect' => '/client-site']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid session type.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid or expired OTP.']);
    }
}
?>
