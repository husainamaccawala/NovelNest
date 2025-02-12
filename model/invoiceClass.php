<?php
class InvoiceClass {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllInvoices() {
        $query = "SELECT 
                i.id AS invoice_id,
                i.invoice_number,
                u.name AS user_name,
                u.email AS user_email,
                i.subscription_plan,
                i.amount,
                i.status,
                i.payment_method,
                i.payment_transaction_id,
                i.invoice_date,
                i.due_date
            FROM 
                invoices i
            INNER JOIN 
                user u 
                ON i.user_id = u.id
        ";

        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
            
    }
}
?>
