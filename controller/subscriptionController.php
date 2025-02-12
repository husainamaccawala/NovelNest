<?php
require_once __DIR__ . '../../config/db.php';
require_once __DIR__ . '../../model/subscriptionClass.php';


class SubscriptionController {
    public $db;  // Database connection
    public $subscriptionModel; // Make this public if you need direct access

    public function __construct($db) {
        $this->db = $db;
        $this->subscriptionModel = new SubscriptionClass($db);
    }

    public function handleSubscriptionPage() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /NovelNest/view/admin/adminSigninForm.php');
            exit();
        }
    
        $userSubscriptions = $this->subscriptionModel->getAllUserSubscriptions();
    
        require_once __DIR__.'/../view/subscription/subscription.php';
    }

    public function handleAjaxRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $action = $_POST['action'];
            if ($action === 'updateSubscription') {
                $userId = $_POST['user_id'];
                $subscriptionType = $_POST['subscription_type'];
                $result = $this->subscriptionModel->updateUserSubscription($userId, $subscriptionType); // Correctly calling the method
                echo json_encode([
                    "success" => $result,
                    "message" => $result ? "Subscription updated successfully!" : "Failed to update subscription."
                ]);
            }
        }
    }
}


$db = new PDO("mysql:host=localhost;dbname=novelnest", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$controller = new SubscriptionController($db);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller->handleAjaxRequest();
} else {
    $controller->handleSubscriptionPage();
}


?>
