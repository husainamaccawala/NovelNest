<?php
require_once "config/db.php"; 
require_once "model/subscriptionClass.php";

$dbInstance = new DB();
$db = $dbInstance->connection();

$subscriptionClass = new SubscriptionClass($db);
$result = $subscriptionClass->fetchSubscriptionsFromStripe();

if ($result === true) {
    echo "✅ Data fetched and stored successfully!";
} else {
    echo "❌ Error: " . $result;
}
?>
