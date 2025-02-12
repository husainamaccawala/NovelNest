<?php
// session_start();

// Check if the admin is logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if admin session variables exist
$adminName = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Admin';
$adminProfileImage = isset($_SESSION['admin_profile_image']) && $_SESSION['admin_profile_image'] !== '' 
                     ? $_SESSION['admin_profile_image'] 
                     : '/assets/images/default-profile.png';
// Default image if none set

// Include necessary files
require_once __DIR__ . "/../../config/db.php";
require_once __DIR__ . "/../../controller/subscriptionController.php";


// Create SubscriptionController object
$controller = new SubscriptionController($db);

// Fetch user subscriptions
$userSubscriptions = $controller->subscriptionModel->getAllUserSubscriptions();

// Include the header
require_once __DIR__ . "/../../view/layout/header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Subscriptions</title>
    <link rel="stylesheet" href="/assets/css/style.css">

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
    <script src="../../assets/js/ajax/subscription.js"></script>  
</head>

<body>
    <!-- Admin Profile -->
    <!-- <div class="admin-profile">
        <img src="<?php echo htmlspecialchars($adminProfileImage); ?>" alt="Admin Profile" />
        <h6 class="mb-0 line-height"><?= htmlspecialchars($adminName); ?></h6>
    </div> -->

    <!-- <h2>User Subscription Details</h2> -->

    <div class="content-inner container-fluid pb-0" id="page_layout">
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Subscription List</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="custom-table-effect table-responsive custom-table-search user-table">
                            <table class="mb-0 table table-bordered" id="user-table" data-toggle="data-table1">
                                <thead class="">

            <tr class="bg-white">
                <th scope="col" class="border-bottom bg-primary text-white">User Name</th>
                <th scope="col" class="border-bottom bg-primary text-white">Email</th>
                <th scope="col" class="border-bottom bg-primary text-white">Subscription Type</th>
                <th scope="col" class="border-bottom bg-primary text-white">Start Date</th>
                <th scope="col" class="border-bottom bg-primary text-white">End Date</th>
                <th scope="col" class="border-bottom bg-primary text-white description-column">Plan Name</th>
                <th scope="col" class="border-bottom bg-primary text-white">Plan Price</th>
                <th scope="col" class="border-bottom bg-primary text-white">Plan Features</th>
                <th scope="col" class="border-bottom bg-primary text-white">Plan Tier</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($userSubscriptions)): ?>
                <?php foreach ($userSubscriptions as $subscription): ?>
                    <tr>
                        <td><?= htmlspecialchars($subscription['user_name']); ?></td>
                        <td><?= htmlspecialchars($subscription['user_email']); ?></td>
                        <td><?= htmlspecialchars($subscription['subscription_type']); ?></td>
                        <td><?= htmlspecialchars($subscription['subscription_start_date']); ?></td>
                        <td><?= htmlspecialchars($subscription['subscription_end_date']); ?></td>
                        <td><?= htmlspecialchars($subscription['plan_name']); ?></td>
                        <td><?= htmlspecialchars($subscription['plan_price']); ?></td>
                        <td><?= htmlspecialchars($subscription['plan_features']); ?></td>
                        <td><?= htmlspecialchars($subscription['plan_tier']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No subscriptions found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php
// Include the footer
require_once __DIR__ . "/../../view/layout/footer.php";
?>