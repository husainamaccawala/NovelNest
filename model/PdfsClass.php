<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/config/DB.php';

class PdfClass
{
    private $conn;

    public function __construct()
    {
        $db = new DB();
        $this->conn = $db->connection();
    }

    // Add a new PDF
    public function addPdf($title, $description, $file, $book_id, $size)
    {
        $sql = "INSERT INTO pdfs (title, description, file, book_id, size) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("sssii", $title, $description, $file, $book_id, $size);
        $exe_result = $stmt->execute();

        if (!$exe_result) {
            error_log("Execute failed: " . $stmt->error);
        }

        $stmt->close();

        return $exe_result; // Return true if insertion is successful
    }

    // Update an existing PDF
    public function updatePdf($id, $title, $description, $file, $book_id,)
    {
        $sql = "UPDATE pdfs SET title = ?, description = ?, file = ?, book_id = ?, WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("sssii", $title, $description, $file, $book_id, $id); // Bind parameters: title, description, file, book_id, size are strings, id is an integer
        $exe_result = $stmt->execute();
        $stmt->close();

        return $exe_result; // Return true if update is successful, false otherwise
    }

    // Delete a PDF
    public function deletePdf($id)
    {
        $sql = "DELETE FROM pdfs WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);
        $exe_result = $stmt->execute();
        $stmt->close();

        return $exe_result; // Return true if deletion is successful
    }

    // Get all PDFs
    public function getPdfs()
    {
        $sql = "SELECT * FROM pdfs";
        $result = $this->conn->query($sql); // Execute query directly

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC); // Return data as an associative array
        }
        return false;
    }

    // Get a specific PDF by ID
    public function getPdfById($id)
    {
        $sql = "SELECT * FROM pdfs WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close();

        return $result->fetch_assoc(); // Return data as an associative array
    }
}
