<?php

// Check if admin session variables exist
$adminName = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Admin';
$adminProfileImage = isset($_SESSION['admin_profile_image']) && $_SESSION['admin_profile_image'] !== ''
    ? $_SESSION['admin_profile_image']
    : '/assets/images/default-profile.png';

// Include necessary files
require_once $_SERVER['DOCUMENT_ROOT'] . "/NovelNest/config/db.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/NovelNest/controller/SubscriptionController.php";

// Include the header
require_once $_SERVER['DOCUMENT_ROOT'] . "/NovelNest/view/layout/header.php";
?>

<!-- Page Content -->
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
                        <div class="custom-table-effect table-responsive custom-table-search">
                            <table id="subscriptionTable" class="mb-0 table table-bordered custom-datatable-border">
                                <thead>
                                    <tr class="bg-white">
                                        <th class="border-bottom bg-primary text-white">Sr. No.</th>
                                        <th class="border-bottom bg-primary text-white">User Name</th>
                                        <th class="border-bottom bg-primary text-white">Email</th>
                                        <th class="border-bottom bg-primary text-white">Subscription Type</th>
                                        <th class="border-bottom bg-primary text-white">Start Date</th>
                                        <th class="border-bottom bg-primary text-white">End Date</th>
                                        <th class="border-bottom bg-primary text-white">Subscription Status</th>
                                        <th class="border-bottom bg-primary text-white">Plan Name</th>
                                        <th class="border-bottom bg-primary text-white">Plan Price</th>
                                        <th class="border-bottom bg-primary text-white">Invoice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($userSubscriptions)): ?>
                                        <?php $srNo = 1; ?>
                                        <?php foreach ($userSubscriptions as $subscription): ?>
                                            <tr>
                                                <td><?= $srNo++; ?></td>
                                                <td><?= htmlspecialchars($subscription['name']); ?></td>
                                                <td><?= htmlspecialchars($subscription['email']); ?></td>
                                                <td><?= htmlspecialchars($subscription['subscription_type']); ?></td>
                                                <td><?= htmlspecialchars($subscription['start_date']); ?></td>
                                                <td><?= htmlspecialchars($subscription['end_date']); ?></td>
                                                <td><?= htmlspecialchars($subscription['subscription_status']); ?></td>
                                                <td><?= htmlspecialchars($subscription['plan_name']); ?></td>
                                                <td>₹<?= htmlspecialchars($subscription['plan_price']); ?></td>
                                                <td>
                                                    <a href="<?= htmlspecialchars($subscription['invoice_url']); ?>" target="_blank">📄</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="10">No subscriptions found.</td>
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

<!-- Include JavaScript -->
<script src="/NovelNest/assets/js/ajax/subscription.js"></script>

<?php
// Include the footer
require_once $_SERVER['DOCUMENT_ROOT'] . "/NovelNest/view/layout/footer.php";
?>