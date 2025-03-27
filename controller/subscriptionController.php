<?php
session_start();

// Ensure database connection is included
require_once $_SERVER['DOCUMENT_ROOT'] . "/NovelNest/config/db.php"; 
require_once $_SERVER['DOCUMENT_ROOT'] . "/NovelNest/model/SubscriptionClass.php";


$dbInstance = new DB();
$db = $dbInstance->connection(); //  Correctly get the database connection



class SubscriptionController {
    private $db;
    private $subscriptionModel;

    public function __construct($db) {
        $this->db = $db;
        $this->subscriptionModel = new SubscriptionClass($this->db);
    }

    public function getAllSubscriptions() {
        return $this->subscriptionModel->getAllSubscriptions();
    }


    //  Automatically fetch & display subscriptions when the admin opens the page
    public function handleSubscriptionPage() {
        //  Check if admin is logged in
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /NovelNest/view/admin/adminSigninForm.php');
            exit();
        }

        //  Fetch the latest subscriptions & invoices from Stripe
        $this->subscriptionModel->fetchSubscriptionsFromStripe();

        //  Get all subscription data from the database
        $userSubscriptions = $this->subscriptionModel->getAllSubscriptions();

        //  Load the subscription page (View)
        require_once $_SERVER['DOCUMENT_ROOT'] . '/NovelNest/view/subscription/subscription.php';
    }

    //  Handle AJAX requests (if needed in future)
    public function handleAjaxRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $action = $_POST['action'];

            if ($action === 'updateSubscription') {
                $userId = $_POST['user_id'];
                $subscriptionType = $_POST['subscription_type'];

                $result = $this->subscriptionModel->updateUserSubscription($userId, $subscriptionType);

                echo json_encode([
                    "success" => $result,
                    "message" => $result ? "Subscription updated successfully!" : "Failed to update subscription."
                ]);
            }
        }
    }
}

//  Create the controller and call the appropriate method
$controller = new SubscriptionController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller->handleAjaxRequest();
} else {
    $controller->handleSubscriptionPage();
}

$controller = new SubscriptionController($db);
?>
