<?php
header('Content-Type: application/json');
error_reporting(0); // Disable error reporting in production

require_once '../model/AudiobookClass.php';

$audiobook = new AudiobookClass();
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'create':
            // Handle file upload
            $audiobook_file = null;
            if (isset($_FILES['audiobook']) && $_FILES['audiobook']['error'] === UPLOAD_ERR_OK) {
                $audiobook_file = $_FILES['audiobook']['name'];
                $upload_path = '../uploads/' . $audiobook_file;
                move_uploaded_file($_FILES['audiobook']['tmp_name'], $upload_path);
            }

            $result = $audiobook->createAudiobook(
                $_POST['book'],
                $_POST['narrator'],
                $_POST['duration'],
                $_POST['language'],
                $audiobook_file
            );

            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Audiobook created successfully';
            } else {
                $response['success'] = false;
                $response['message'] = 'Failed to create audiobook';
            }
            break;

        case 'read':
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $audiobooks = $audiobook->readAudiobooksById($id);
            } else {
                $audiobooks = $audiobook->readAudiobooks();
            }
            echo json_encode($audiobooks);
            break;

        case 'update':
            $id = $_POST['id'];
            $book = $_POST['book'];
            $narrator = $_POST['narrator'];
            $duration = $_POST['duration'];
            $language = $_POST['language'];
            $audiobook = $_FILES['audiobook']['name'];
            $result = $audiobook->updateAudiobook($id, $book, $narrator, $duration, $language, $audiobook);
            echo json_encode(['success' => $result]);
            break;

        case 'delete':
            $id = $_POST['id'];
            $result = $audiobook->deleteAudiobook($id);
            echo json_encode(['success' => $result]);
            break;
    }
}

echo json_encode($response);
?>
