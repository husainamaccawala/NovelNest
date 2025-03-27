<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/config/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/vendor/autoload.php'; // Load Stripe PHP SDK

use Stripe\Stripe;

class SubscriptionClass {
    private $conn;

    public function __construct($db) {
        $this->conn = $db; //  Use the connection passed from `subscriptionController.php`
        Stripe::setApiKey("sk_test_51QuctDKCx3klHNuFSDXGD1SADW5Qk2w6MTTQ0MEXvVCx1MrORs7Wul3PMn2MVGAZobN7N8wjlcAYREH6n8EGIcya00uPOkrDWr"); //   Set Stripe Secret Key
    }

    // Fetch Subscriptions & Invoices from Stripe
    public function fetchSubscriptionsFromStripe() {
        try {
            // ✅ Step 1: Get all customers from Stripe
            $customers = \Stripe\Customer::all(['limit' => 10]); // Fetch first 10 customers
    
            foreach ($customers->data as $customer) {
                $customerId = $customer->id;
                $userName = $customer->name;
                $userEmail = $customer->email;
    
                echo "Fetching customer: $userName ($userEmail) - Stripe ID: $customerId <br>"; // ✅ Debug
    
                // ✅ Step 2: Check if the user already exists in the database
                $stmt = $this->conn->prepare("SELECT id FROM user WHERE stripe_customer_id = ?");
                if (!$stmt) {
                    die("SQL Error (Check User): " . $this->conn->error);
                }
    
                $stmt->bind_param("s", $customerId);
                $stmt->execute();
                $result = $stmt->get_result();
    
                if ($result->num_rows == 0) {
                    // ✅ Step 3: Insert new user if not exists
                    echo "Inserting user: $userName ($userEmail) <br>"; // ✅ Debug
    
                    $stmt = $this->conn->prepare("INSERT INTO user (stripe_customer_id, name, email) VALUES (?, ?, ?)");
                    if (!$stmt) {
                        die("SQL Error (Insert User): " . $this->conn->error);
                    }
                    $stmt->bind_param("sss", $customerId, $userName, $userEmail);
                    $stmt->execute();
                    $userId = $stmt->insert_id;
                } else {
                    $user = $result->fetch_assoc();
                    $userId = $user['id'];
                }
    
                // ✅ Step 4: Fetch active subscriptions for the user
                $subscriptions = \Stripe\Subscription::all(['customer' => $customerId]);
                foreach ($subscriptions->data as $subscription) {
                    $subscriptionId = $subscription->id;
                    $status = $subscription->status == 'active' ? 'Active' : 'Expired';
                    $startDate = date('Y-m-d H:i:s', $subscription->current_period_start);
                    $endDate = date('Y-m-d H:i:s', $subscription->current_period_end);
                    $planName = $subscription->items->data[0]->plan->nickname;
                    $planPrice = $subscription->items->data[0]->plan->amount / 100; // Convert paise to INR
    
                    echo "Saving Subscription: $planName - ₹$planPrice <br>"; // ✅ Debug
    
                    // ✅ Step 5: Insert or update subscription details
                    $stmt = $this->conn->prepare("INSERT INTO subscriptions (user_id, subscription_id, subscription_type, start_date, end_date, subscription_status, plan_name, plan_price)
                                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                                                  ON DUPLICATE KEY UPDATE subscription_status=?, end_date=?");
                    if (!$stmt) {
                        die("SQL Error (Insert Subscription): " . $this->conn->error);
                    }
                    $stmt->bind_param("isssssssss", $userId, $subscriptionId, $status, $startDate, $endDate, $status, $planName, $planPrice, $status, $endDate);
                    $stmt->execute();
                }
            }
            return true;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
    

    // Fetch all subscription data to display in admin panel
    public function getAllSubscriptions() {
        $sql = "SELECT user.name, user.email, subscriptions.subscription_type, 
                       subscriptions.start_date, subscriptions.end_date, subscriptions.subscription_status, 
                       subscriptions.plan_name, subscriptions.plan_price, invoices.invoice_url 
                FROM user 
                LEFT JOIN subscriptions ON user.id = subscriptions.user_id 
                LEFT JOIN invoices ON user.id = invoices.user_id 
                ORDER BY subscriptions.start_date DESC";
    
        $stmt = $this->conn->prepare($sql);
    
        if (!$stmt) {
            die("SQL Error: " . $this->conn->error); // ✅ Debugging: Show SQL error
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    

    // Function to update subscription type in the database
    public function updateUserSubscription($userId, $subscriptionType) {
        try {
            $stmt = $this->conn->prepare("UPDATE subscriptions SET subscription_type = ? WHERE user_id = ?");
            $stmt->bind_param("si", $subscriptionType, $userId);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
