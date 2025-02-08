<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name'])) {
    header('Location: /novelnest/view/admin/adminSigninForm.php');
    exit;
}

// Retrieve admin data from session
$adminName = $_SESSION['admin_name'];
$adminProfileImage = $_SESSION['admin_profile_image'] ?? 'assets/images/default-avatar.jpg'; // Default image if none set
// Default image if none set


require_once __DIR__ . "/view/layout/header.php";

require_once __DIR__."/view/admin/dashboard.php";

// Include the footer
require_once __DIR__ . "/view/layout/footer.php";
?>


