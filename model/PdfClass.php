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
    public function updatePdf($id, $title, $description, $file, $book_id, $size)
    {
        $sql = "UPDATE pdfs SET title = ?, description = ?, file = ?, book_id = ?, size = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("sssiii", $title, $description, $file, $book_id, $size, $id);
        $exe_result = $stmt->execute();
        $stmt->close();

        return $exe_result; // Return true if update is successful, false otherwise
    }

    // Delete a PDF
    public function deletePdf($id)
    {
        $sql = "DELETE FROM pdfs WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $exe_result = $stmt->execute();
        $stmt->close();

        return $exe_result; // Return true if deletion is successful
    }

    // Get a specific PDF by ID
    public function getPdfById($id)
    {
        $sql = "SELECT * FROM pdfs WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close();
        return $result->fetch_assoc(); // Return data as an associative array
    }

    // Get all PDFs with book titles
    public function getPdfs()
    {
        $sql = "SELECT 
                    pdfs.id, 
                    pdfs.title, 
                    pdfs.book_id,
                    books.title AS book_title, 
                    pdfs.description, 
                    pdfs.file,
                    pdfs.size
                FROM pdfs 
                LEFT JOIN books ON pdfs.book_id = books.id";
    
        $result = $this->conn->query($sql);
    
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC); // Fetch all PDFs with book_id
        }
    
        return false;
    }
    
}
