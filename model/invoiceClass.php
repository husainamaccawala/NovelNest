<?php
class InvoiceClass {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        // Ensure connection is established
        if (!$this->conn) {
            die("Database connection failed");
        }
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
                    ON i.user_id = u.id";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $invoices = [];
            while ($row = $result->fetch_assoc()) {
                $invoices[] = $row;
            }
            return $invoices;
        } else {
            return [];
        }
    }
}
?>
