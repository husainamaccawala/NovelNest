<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/config/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/vendor/autoload.php'; // Load Stripe PHP SDK

use Stripe\Stripe;

class SubscriptionClass {
    private $conn;

    public function __construct($db) {
        $this->conn = $db; // Use the connection passed from `subscriptionController.php`
        Stripe::setApiKey("sk_test_51QuctDKCx3klHNuFSDXGD1SADW5Qk2w6MTTQ0MEXvVCx1MrORs7Wul3PMn2MVGAZobN7N8wjlcAYREH6n8EGIcya00uPOkrDWr"); // Set Stripe Secret Key
    }

    // Fetch Subscriptions from Stripe and update the database
    public function fetchSubscriptionsFromStripe() {
        try {
            // Step 1: Get all customers from Stripe
            $customers = \Stripe\Customer::all(['limit' => 10]); // Fetch first 10 customers

            foreach ($customers->data as $customer) {
                $customerId = $customer->id;
                $userName = $customer->name;
                $userEmail = $customer->email;

                echo "Fetching customer: $userName ($userEmail) - Stripe ID: $customerId <br>"; // Debug

                // Step 2: Fetch active subscriptions for the user
                $subscriptions = \Stripe\Subscription::all(['customer' => $customerId]);
                foreach ($subscriptions->data as $subscription) {
                    $subscriptionId = $subscription->id;
                    $status = $subscription->status == 'active' ? 'Active' : 'Expired';
                    $startDate = date('Y-m-d H:i:s', $subscription->current_period_start);
                    $endDate = date('Y-m-d H:i:s', $subscription->current_period_end);
                    $planName = $subscription->items->data[0]->plan->nickname;
                    $planPrice = $subscription->items->data[0]->plan->amount / 100; // Convert paise to INR

                    echo "Saving Subscription: $planName - ₹$planPrice <br>"; // Debug

                    // Step 3: Insert or update subscription details
                    $stmt = $this->conn->prepare("INSERT INTO subscriptions (user_name, email, subscription_id, subscription_type, start_date, end_date, subscription_status, plan_name, plan_price)
                                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                                                  ON DUPLICATE KEY UPDATE subscription_status=?, end_date=?");
                    if (!$stmt) {
                        die("SQL Error (Insert Subscription): " . $this->conn->error);
                    }
                    $stmt->bind_param("sssssssssss", $userName, $userEmail, $subscriptionId, $status, $startDate, $endDate, $status, $planName, $planPrice, $status, $endDate);
                    $stmt->execute();
                }
            }
            return true;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Fetch all subscription data from the database to display
    public function getAllSubscriptions() {
        $sql = "SELECT user_name, email, subscription_type,
                       start_date, end_date, subscription_status,
                       plan_name, plan_price
                FROM subscriptions
                ORDER BY start_date DESC";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("SQL Error: " . $this->conn->error); // Debugging: Show SQL error
        }

        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Function to update subscription type in the database
    public function updateUserSubscription($subscriptionId, $subscriptionType) {
        try {
            $stmt = $this->conn->prepare("UPDATE subscriptions SET subscription_type = ? WHERE subscription_id = ?");
            $stmt->bind_param("ss", $subscriptionType, $subscriptionId);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }
}

// Usage example
$subscriptionClass = new SubscriptionClass($dbConnection);

// Step 1: Fetch data from Stripe and update the database
$subscriptionClass->fetchSubscriptionsFromStripe();

// Step 2: Retrieve data from the database and display
$subscriptions = $subscriptionClass->getAllSubscriptions();

// Display the subscriptions (example output)
foreach ($subscriptions as $subscription) {
    echo "User: {$subscription['user_name']}, Plan: {$subscription['plan_name']}, Status: {$subscription['subscription_status']}<br>";
}
?>
