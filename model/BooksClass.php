<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/config/DB.php';

class BooksClass
{
    private $conn;

    public function __construct()
    {
        $db = new DB();
        $this->conn = $db->connection();
    }

    // Add a new book
    public function addBook($cover_image, $title, $genre_id, $author, $description )
    {
        $sql = "INSERT INTO books (cover_image, title, genre_id, author, description) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("ssiss", $cover_image, $title, $genre_id,  $author, $description);
        $exe_result = $stmt->execute();

        if (!$exe_result) {
            error_log("Execute failed: " . $stmt->error);
        }

        $stmt->close();

        return $exe_result; // Return true if insertion is successful
    }

    // Update an existing book
    public function updateBook($id, $cover_image, $title, $genre_id, $author, $description)
    {
        $sql = "UPDATE books SET cover_image = ?, title = ?, genre_id = ?, author = ?,description = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("ssissi", $cover_image, $title, $genre_id, $author, $description,$id);
        $exe_result = $stmt->execute();

        if (!$exe_result) {
            error_log("Execute failed: " . $stmt->error);
        }

        $stmt->close();

        return $exe_result; // Return true if update is successful
    }

    // Delete a book
    public function deleteBook($id)
    {
        $sql = "DELETE FROM books WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $exe_result = $stmt->execute();

        if (!$exe_result) {
            error_log("Execute failed: " . $stmt->error);
        }

        $stmt->close();

        return $exe_result; // Return true if deletion is successful
    }

    // Get a single book by ID
    public function getBookById($id)
    {
        $sql = "SELECT * FROM books WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $book = $result->fetch_assoc();

        $stmt->close();

        return $book; // Return the book as an associative array
    }

    // Get all books

    public function getAllBooks()
    {
        $sql = "SELECT 
                books.id, 
                books.cover_image, 
                books.title, 
                genre.name AS genre_name, 
                books.author, 
                books.description
            FROM books 
            JOIN genre ON books.genre_id = genre.id";
        $result = $this->conn->query($sql);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC); // Fetch all books with genre names and cover images as associative array
        }

        return false;
    }
}
