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

                // Create upload directory if it doesn't exist
                if (!file_exists($UPLOAD_DIR)) {
                    mkdir($UPLOAD_DIR, 0777, true);
                }

                $fileName = time() . '_' . basename($audioFile['name']);
                $uploadPath = $UPLOAD_DIR . $fileName;
                
                if (!move_uploaded_file($audioFile['tmp_name'], $uploadPath)) {
                    error_log("Failed to move file from {$audioFile['tmp_name']} to {$uploadPath}");
                    die(json_encode([
                        "status" => "error",
                        "message" => "Failed to upload audio file"
                    ]));
                }

                // Add the audiobook to database
                $result = $AudiobookClass->addAudiobook([
                    'book_id' => $_POST['book_id'],
                    'description' => $_POST['description'],
                    'narrator' => $_POST['narrator'],
                    'file' => $fileName  // Store just the filename
                ]);

                if ($result) {
                    echo json_encode([
                        "status" => "success",
                        "message" => "Audiobook added successfully"
                    ]);
                } else {
                    // If database insert fails, remove the uploaded file
                    unlink($uploadPath);
                    echo json_encode([
                        "status" => "error",
                        "message" => "Failed to save audiobook details"
                    ]);
                }
                break;

            case 'update':
                $data = [
                    'id' => $_POST['id'],
                    'book_id' => $_POST['book_id'],
                    'description' => $_POST['description'],
                    'narrator' => $_POST['narrator'],
                    'file' => null
                ];

                if (isset($_FILES['audio_file']) && $_FILES['audio_file']['error'] === UPLOAD_ERR_OK) {
                    $fileName = time() . '_' . basename($_FILES['audio_file']['name']);
                    $uploadPath = $UPLOAD_DIR . $fileName;
                    
                    if (move_uploaded_file($_FILES['audio_file']['tmp_name'], $uploadPath)) {
                        $data['file'] = $fileName;
                    }
                }

                $result = $AudiobookClass->updateAudiobook($data);
                die(json_encode([
                    "status" => $result ? "success" : "error",
                    "message" => $result ? "Audiobook updated successfully" : "Failed to update audiobook"
                ]));
                break;

            case 'delete':
                $result = $AudiobookClass->deleteAudiobook($_POST['id']);
                die(json_encode([
                    "status" => $result ? "success" : "error",
                    "message" => $result ? "Audiobook deleted successfully" : "Failed to delete audiobook"
                ]));
                break;

            default:
                die(json_encode([
                    "status" => "error",
                    "message" => "Invalid action"
                ]));
        }
        break;

    case 'GET':
        if (isset($_GET['id'])) {
            $audiobook = $AudiobookClass->getAudiobookById($_GET['id']);
            die(json_encode([
                "status" => $audiobook ? "success" : "error",
                "data" => $audiobook,
                "message" => $audiobook ? null : "Audiobook not found"
            ]));
        } else {
            $audiobooks = $AudiobookClass->getAllAudiobooks();
            die(json_encode([
                "status" => $audiobooks ? "success" : "error",
                "data" => $audiobooks,
                "message" => $audiobooks ? null : "No audiobooks found"
            ]));
        }
        break;

    default:
        die(json_encode([
            "status" => "error",
            "message" => "Invalid request method"
        ]));
}
?>
