<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/model/BooksClass.php';

$BooksClass = new BooksClass();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        // Handle file upload
        $cover_image = '';
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/assets/images/book-cover/';
            $cover_image = basename($_FILES['cover_image']['name']);
            move_uploaded_file($_FILES['cover_image']['tmp_name'], $uploadDir . $cover_image);
        }

        // Validate input fields
        $title = $_POST['title'] ?? '';
        $genre_id = $_POST['genre_id'] ?? '';
        $author = $_POST['author'] ?? '';
        $description = $_POST['description'] ?? '';
        $published_date = $_POST['published_date'] ?? '';

        if (!empty($cover_image) && !empty($title) && !empty($genre_id) && !empty($author) && !empty($description) && !empty($published_date)) {
            $result = $BooksClass->addBook($cover_image, $title, $genre_id, $author, $description, $published_date);

            if ($result) {
                echo json_encode(["status" => "success", "message" => "Book added successfully!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to add book."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "All fields are required."]);
        }
    } elseif ($action === 'update') {
        $id = $_POST['id'] ?? '';

        // Handle file upload (optional update)
        $cover_image = $_POST['existing_cover_image'] ?? ''; // Default to existing cover image
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/assets/images/book-cover/';
            $cover_image = basename($_FILES['cover_image']['name']);
            move_uploaded_file($_FILES['cover_image']['tmp_name'], $uploadDir . $cover_image);
        }

        $title = $_POST['title'] ?? '';
        $genre_id = $_POST['genre_id'] ?? '';
        $author = $_POST['author'] ?? '';
        $description = $_POST['description'] ?? '';

        if (!empty($id) && !empty($cover_image) && !empty($title) && !empty($genre_id) && !empty($author) && !empty($description)) {
            $result = $BooksClass->updateBook($id, $cover_image, $title, $genre_id, $author, $description);

            if ($result) {
                echo json_encode(["status" => "success", "message" => "Book updated successfully!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to update book."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "All fields are required."]);
        }
    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        if (!empty($id)) {
            $result = $BooksClass->deleteBook($id);
            if ($result) {
                echo json_encode(["status" => "success", "message" => "Book deleted successfully!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to delete book."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid ID."]);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $book = $BooksClass->getBookById($_GET['id']);
        if ($book) {
            $book['cover_image'] = $baseUrl . '/assets/images/book-cover/' . $book['cover_image'];
            echo json_encode([
                "status" => "success",
                "data" => $book
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Book not found."
            ]);
        }
    } else {
        $books = $BooksClass->getAllBooks();
        if ($books) {
            foreach ($books as &$book) {
                $book['cover_image'] = $baseUrl . '/assets/images/book-cover/' . $book['cover_image'];
            }
            echo json_encode([
                "status" => "success",
                "data" => $books
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Failed to fetch books."
            ]);
        }
    }
}
