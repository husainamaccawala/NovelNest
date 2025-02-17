<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/model/GenreClass.php';

$GenreClass = new GenreClass();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'add') {
        // Validate input fields
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';

        if (!empty($name) && !empty($description)) {
            $result = $GenreClass->addGenre($name, $description);

            if ($result) {
                echo json_encode(["status" => "success", "message" => "Genre added successfully!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to add genre."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "All fields are required."]);
        }
    } elseif ($action === 'update') {
        $id = $_POST['id'] ?? '';
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';

        if (!empty($id) && !empty($name) && !empty($description)) {
            $result = $GenreClass->updateGenre($id, $name, $description); // Update only name and description

            if ($result) {
                echo json_encode(["status" => "success", "message" => "Genre updated successfully!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to update Genre."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "All fields are required."]);
        }
    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        if (!empty($id)) {
            $result = $GenreClass->deleteGenre($id); // Assuming deleteGenre is implemented
            if ($result) {
                echo json_encode(["status" => "success", "message" => "Genre deleted successfully!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to delete genre."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid ID."]);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch all genres (not paginated)
    $genres = $GenreClass->getGenre(); // Make sure this returns an array

    echo json_encode([
        "status" => "success",
        "data" => $genres // DataTables will handle pagination itself
    ]);
}
?>
