<?php
require_once __DIR__.'/../model/UserClass.php';

$userClass = new UserClass();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'create':
            $userClass->createUser($_POST);
            break;
        case 'update':
            $userClass->updateUser($_POST);
            break;
        case 'delete':
            if (isset($_POST['id'])) {
                $userClass->deleteUser($_POST['id']);
            }
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'fetch' && isset($_GET['id'])) {
        // Fetch a specific user by ID for editing
        $user = $userClass->getUserById($_GET['id']);
        if ($user) {
            echo json_encode($user);
        } else {
            echo json_encode(['error' => 'User not found']);
        }
    } else {
        // Read all users
        $users = $userClass->readUsers();
        echo json_encode($users);
    }
}
?>
