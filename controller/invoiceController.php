<?php
require_once __DIR__ . '../../config/db.php';
require_once __DIR__ . '../../model/invoiceClass.php';

class InvoiceController {
    private $conn;
    public $invoiceModel;

    public function __construct() {
        $db = new DB();
        $this->conn = $db->connection();
        $this->invoiceModel = new InvoiceClass($this->conn);
    }

    public function handleInvoicePage() {
        // session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /NovelNest/view/admin/adminSigninForm.php');
            exit();
        }

        $userInvoices = $this->invoiceModel->getAllInvoices();

        require_once __DIR__ . '/../view/invoice/invoice.php';
    }
}

$controller = new InvoiceController();
$controller->handleInvoicePage();
?>
