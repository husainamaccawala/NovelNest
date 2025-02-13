<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/model/PdfClass.php';

$PdfClass = new PdfClass();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        if (isset($_FILES['pdf_file'])) {
            $file = $_FILES['pdf_file'];
            $fileName = time() . '_' . $file['name'];
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/assets/pdfs/' . $fileName;
            $size = $file['size'];

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $title = $_POST['title'] ?? '';
                $description = $_POST['description'] ?? '';
                $book_id = $_POST['book_id'] ?? 0;

                $result = $PdfClass->addPdf($title, $description, $fileName, $book_id, $size);

                echo json_encode(
                    $result
                        ? ['status' => 'success', 'message' => 'PDF added successfully']
                        : ['status' => 'error', 'message' => 'Failed to add PDF']
                );
            } else {
                echo json_encode(['status' => 'error', 'message' => 'File upload failed']);
            }
        }
    } elseif ($action === 'update') {
        $id = $_POST['id'] ?? 0;
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $book_id = $_POST['book_id'] ?? 0;
        $size = 0;

        $oldPdf = $PdfClass->getPdfById($id);
        if (!$oldPdf) {
            echo json_encode(['status' => 'error', 'message' => 'PDF not found']);
            exit;
        }

        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === 0) {
            $file = $_FILES['pdf_file'];
            $fileName = time() . '_' . $file['name'];
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/assets/pdfs/' . $fileName;
            $size = $file['size'];

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $oldFilePath = $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/assets/pdfs/' . $oldPdf['file'];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'File upload failed']);
                exit;
            }
        } else {
            $fileName = $oldPdf['file'];
            $size = $oldPdf['size']; // Preserve old file size
        }

        $result = $PdfClass->updatePdf($id, $title, $description, $fileName, $book_id, $size);

        echo json_encode(
            $result
                ? ['status' => 'success', 'message' => 'PDF updated successfully']
                : ['status' => 'error', 'message' => 'Failed to update PDF']
        );
    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? 0;
        $pdf = $PdfClass->getPdfById($id);

        if ($pdf) {
            $filePath = $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/assets/pdfs/' . $pdf['file'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $result = $PdfClass->deletePdf($id);

            echo json_encode(
                $result
                    ? ['status' => 'success', 'message' => 'PDF deleted successfully']
                    : ['status' => 'error', 'message' => 'Failed to delete PDF']
            );
        } else {
            echo json_encode(['status' => 'error', 'message' => 'PDF not found']);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'] ?? null;

    if ($id) {
        $pdf = $PdfClass->getPdfById($id);
        echo json_encode(
            $pdf
                ? ['status' => 'success', 'data' => $pdf]
                : ['status' => 'error', 'message' => 'PDF not found']
        );
    } else {
        $pdfs = $PdfClass->getPdfs();
        echo json_encode(['status' => 'success', 'data' => $pdfs ?: []]);
    }
}
