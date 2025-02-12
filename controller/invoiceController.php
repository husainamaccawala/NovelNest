<?php
require_once __DIR__ . '../../config/db.php';
require_once __DIR__ . '../../model/invoiceClass.php';

class InvoiceController {
    public $db;
    public $invoiceModel;

    public function __construct($db) {
        $this->db = $db;
        $this->invoiceModel = new InvoiceClass($db);
    }

    public function handleInvoicePage() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /NovelNest/view/admin/adminSigninForm.php');
            exit();
        }

        $userInvoices = $this->invoiceModel->getAllInvoices();
        

        require_once __DIR__ . '/../view/invoice/invoice.php';
    }
}

$db = new PDO("mysql:host=localhost;dbname=novelnest", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$controller = new InvoiceController($db);
$controller->handleInvoicePage();
?>
