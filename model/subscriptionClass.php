<?php
class SubscriptionClass {
    private $conn;

    public function __construct() {
        $db = new DB();
        $this->conn = $db->connection();
    }

    public function getAllUserSubscriptions() {
        $query = "SELECT 
                      u.id AS user_id, 
                      u.name AS user_name, 
                      u.email AS user_email, 
                      s.subscription_type, 
                      s.start_date AS subscription_start_date, 
                      s.end_date AS subscription_end_date, 
                      p.name AS plan_name, 
                      p.price AS plan_price, 
                      p.features AS plan_features, 
                      p.tier AS plan_tier
                  FROM 
                      subscriptions s
                  INNER JOIN 
                      user u 
                      ON s.user_id = u.id
                  INNER JOIN 
                      plans p 
                      ON s.plan_id = p.id";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $subscriptions = [];
            while ($row = $result->fetch_assoc()) {
                $subscriptions[] = $row;
            }
            return $subscriptions;
        } else {
            return [];
        }
    }

    public function updateUserSubscription($userId, $subscriptionType) {
        $startDate = date("Y-m-d");
        $endDate = date("Y-m-d", strtotime("+1 month"));

        $query = "UPDATE subscriptions 
                  SET subscription_type = ?, 
                      start_date = ?, 
                      end_date = ? 
                  WHERE user_id = ?";

        $stmt = $this->conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("sssi", $subscriptionType, $startDate, $endDate, $userId);
            return $stmt->execute();
        } else {
            error_log("Error preparing statement: " . $this->conn->error);
            return false;
        }
    }
}
?>
