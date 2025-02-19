<?php
require_once __DIR__.'/../model/AudiobookClass.php';

$baseUrl = '/NovelNest';
$AudiobookClass = new Audiobook();

// Define upload directory constant
$UPLOAD_DIR = $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/assets/audiobooks/';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'add':
                $audioFile = $_FILES['audio_file'] ?? null;

                if (!$audioFile || $audioFile['error'] !== UPLOAD_ERR_OK) {
                    die(json_encode([
                        "status" => "error",
                        "message" => "No audio file uploaded or invalid file"
                    ]));
                }

                // Ensure upload directory exists
                if (!file_exists($UPLOAD_DIR)) {
                    mkdir($UPLOAD_DIR, 0777, true);
                }

                // Generate unique filename
                $fileName = time() . '_' . basename($audioFile['name']);
                $uploadPath = $UPLOAD_DIR . $fileName;

                // Move uploaded file
                if (!move_uploaded_file($audioFile['tmp_name'], $uploadPath)) {
                    die(json_encode([
                        "status" => "error",
                        "message" => "Failed to upload audio file"
                    ]));
                }

                // Add to database
                $result = $AudiobookClass->addAudiobook([
                    'book_id' => $_POST['book_id'],
                    'description' => $_POST['description'],
                    'narrator' => $_POST['narrator'],
                    'file' => $fileName,
                    'name' => $_POST['name']  // Include the name field
                ]);

                if ($result) {
                    echo json_encode(["status" => "success", "message" => "Audiobook added successfully"]);
                } else {
                    unlink($uploadPath); // Remove file if DB insert fails
                    echo json_encode(["status" => "error", "message" => "Failed to save audiobook details"]);
                }
                break;

            case 'update':
                $id = $_POST['id'];
                $data = [
                    'id' => $id,
                    'book_id' => $_POST['book_id'],
                    'description' => $_POST['description'],
                    'narrator' => $_POST['narrator'],
                    'file' => null,
                    'name' => $_POST['name']  // Include the name field
                ];

                // Fetch existing file name from database
                $existingAudiobook = $AudiobookClass->getAudiobookById($id);
                $existingFile = $existingAudiobook['file'] ?? '';

                if (isset($_FILES['audio_file']) && $_FILES['audio_file']['error'] === UPLOAD_ERR_OK) {
                    // Generate new filename
                    $newFileName = time() . '_' . basename($_FILES['audio_file']['name']);
                    $uploadPath = $UPLOAD_DIR . $newFileName;

                    // Move new file
                    if (move_uploaded_file($_FILES['audio_file']['tmp_name'], $uploadPath)) {
                        $data['file'] = $newFileName;

                        // Delete the old file if it exists
                        if (!empty($existingFile) && file_exists($UPLOAD_DIR . $existingFile)) {
                            unlink($UPLOAD_DIR . $existingFile);
                        }
                    }
                } else {
                    // Keep existing file if no new file is uploaded
                    $data['file'] = $existingFile;
                }

                $result = $AudiobookClass->updateAudiobook($data);
                echo json_encode(["status" => $result ? "success" : "error", "message" => $result ? "Audiobook updated successfully" : "Failed to update audiobook"]);
                break;

            case 'delete':
                $id = $_POST['id'];
                $audiobook = $AudiobookClass->getAudiobookById($id);

                if ($audiobook) {
                    $fileToDelete = $audiobook['file'];

                    // Delete from database
                    $result = $AudiobookClass->deleteAudiobook($id);

                    if ($result && !empty($fileToDelete) && file_exists($UPLOAD_DIR . $fileToDelete)) {
                        unlink($UPLOAD_DIR . $fileToDelete); // Delete the file
                    }

                    echo json_encode(["status" => $result ? "success" : "error", "message" => $result ? "Audiobook deleted successfully" : "Failed to delete audiobook"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Audiobook not found"]);
                }
                break;

            default:
                echo json_encode(["status" => "error", "message" => "Invalid action"]);
        }
        break;

    case 'GET':
        if (isset($_GET['id'])) {
            $audiobook = $AudiobookClass->getAudiobookById($_GET['id']);
            echo json_encode([
                "status" => $audiobook ? "success" : "error",
                "data" => $audiobook,
                "message" => $audiobook ? null : "Audiobook not found"
            ]);
        } else {
            $audiobooks = $AudiobookClass->getAllAudiobooks();
            echo json_encode([
                "status" => $audiobooks ? "success" : "error",
                "data" => $audiobooks,
                "message" => $audiobooks ? null : "No audiobooks found"
            ]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>

