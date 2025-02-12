<?php
class SubscriptionClass
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
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
    
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUserSubscription($userId, $subscriptionType)
    {
        $startDate = date("Y-m-d");
        $endDate = date("Y-m-d", strtotime("+1 month"));

        $query = "
            UPDATE subscriptions
            SET 
                subscription_type = :subscription_type, 
                subscription_start_date = :start_date, 
                subscription_end_date = :end_date
            WHERE user_id = :user_id
        ";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':subscription_type', $subscriptionType);
            $stmt->bindParam(':start_date', $startDate);
            $stmt->bindParam(':end_date', $endDate);
            $stmt->bindParam(':user_id', $userId);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating subscription: " . $e->getMessage());
            return false;
        }
    }
}
?>