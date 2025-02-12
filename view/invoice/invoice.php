<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: /NovelNest/view/admin/adminSigninForm.php');
    exit();
}
$baseUrl = '/novelnest';

$adminName = $_SESSION['admin_name'];
$adminProfileImage = $_SESSION['admin_profile_image'] ?? 'assets/images/default-avatar.jpg'; 

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controller/invoiceController.php';

$controller = new InvoiceController($db);
$userInvoices = $controller->invoiceModel->getAllInvoices();

require_once __DIR__ . '/../../view/layout/header.php';
?>
<!-- This is correct, no need to echo the path outside the image tag -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <style>
        table {
            width: 100%;
            /* border-collapse: collapse; */
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            /* border: 1px solid #ddd; */
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>

    <div class="content-inner container-fluid pb-0" id="page_layout">
        <div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Invoice List</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="custom-table-effect table-responsive custom-table-search user-table">
                                <table class="mb-0 table" id="user-table" data-toggle="data-table1">
                                    <thead class="">


                                        <tr class="bg-white">
                                            <!-- <th scope="col" class="border-bottom bg-primary text-white">Sr No</th> -->
                                            <th scope="col" class="border-bottom bg-primary text-white">Invoice No.</th>
                                            <th scope="col" class="border-bottom bg-primary text-white">User</th>
                                            <th scope="col" class="border-bottom bg-primary text-white">Plan</th>
                                            <th scope="col" class="border-bottom bg-primary text-white">Amount</th>
                                            <th scope="col" class="border-bottom bg-primary text-white description-column">Status</th>
                                            <th scope="col" class="border-bottom bg-primary text-white">Payment Method</th>
                                            <th scope="col" class="border-bottom bg-primary text-white">Transaction Id</th>
                                            <th scope="col" class="border-bottom bg-primary text-white">Invoice Date</th>
                                            <th scope="col" class="border-bottom bg-primary text-white">Due Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($userInvoices)): ?>
                                        <?php foreach ($userInvoices as $invoice): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($invoice['invoice_number']); ?></td> <!-- ADD THIS -->
                                                    <td><?= htmlspecialchars($invoice['user_name']); ?></td>
                                                    <td><?= htmlspecialchars($invoice['subscription_plan']); ?></td>
                                                    <td><?= htmlspecialchars($invoice['amount']); ?></td>
                                                    <td><?= htmlspecialchars($invoice['status']); ?></td>
                                                    <td><?= htmlspecialchars($invoice['payment_method']); ?></td>
                                                    <td><?= htmlspecialchars($invoice['payment_transaction_id']); ?></td>
                                                    <td><?= htmlspecialchars($invoice['invoice_date']); ?></td>
                                                    <td><?= htmlspecialchars($invoice['due_date']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="9">No invoices found.</td>
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