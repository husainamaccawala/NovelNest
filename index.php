<?php
session_start();


if (isset($_SESSION['admin_id'])) {
    // Admin is logged in
    $adminName = $_SESSION['admin_name'] ?? 'Admin';
    $adminProfileImage = $_SESSION['admin_profile_image'] ?? 'assets/images/default-avatar.jpg';
} elseif (isset($_SESSION['user_id'])) {
    // User is logged in
} else {
    header("Location: /NovelNest/view/admin/adminSigninForm.php");

    exit;
}

require_once __DIR__ . "/view/layout/header.php";

require_once __DIR__ . "/view/admin/dashboard.php";

require_once __DIR__ . "/view/layout/footer.php";
?>
