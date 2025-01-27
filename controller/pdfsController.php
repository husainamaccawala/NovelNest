<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/model/PdfsClass.php';

$PdfClass = new PdfClass();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        if (isset($_FILES['pdf_file'])) {
            $file = $_FILES['pdf_file'];
            $fileName = time() . '_' . $file['name'];
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/uploads/pdfs/' . $fileName;

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $title = $_POST['title'] ?? '';
                $description = $_POST['description'] ?? '';
                $book_id = $_POST['book_id'] ?? 0;
                $size = $file['size'];

                $result = $PdfClass->addPdf($title, $description, $fileName, $book_id, $size);

                if ($result) {
                    echo json_encode(['status' => 'success', 'message' => 'PDF added successfully']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to add PDF']);
                }
            }
        }
    } elseif ($action === 'update') {
        $id = $_POST['id'] ?? 0;
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $book_id = $_POST['book_id'] ?? 0;

        if (isset($_FILES['pdf_file'])) {
            $file = $_FILES['pdf_file'];
            $fileName = time() . '_' . $file['name'];
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/uploads/pdfs/' . $fileName;

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $oldPdf = $PdfClass->getPdfById($id);
                if ($oldPdf && file_exists($_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/uploads/pdfs/' . $oldPdf['file'])) {
                    unlink($_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/uploads/pdfs/' . $oldPdf['file']);
                }
            }
        } else {
            $oldPdf = $PdfClass->getPdfById($id);
            $fileName = $oldPdf['file'];
        }

        $result = $PdfClass->updatePdf($id, $title, $description, $fileName, $book_id);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'PDF updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update PDF']);
        }
    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? 0;
        $pdf = $PdfClass->getPdfById($id);

        if ($pdf) {
            $filePath = $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/uploads/pdfs/' . $pdf['file'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $result = $PdfClass->deletePdf($id);

            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'PDF deleted successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete PDF']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'PDF not found']);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'] ?? null;

    if ($id) {
        $pdf = $PdfClass->getPdfById($id);
        echo json_encode($pdf ? ['status' => 'success', 'data' => $pdf] : ['status' => 'error', 'message' => 'PDF not found']);
    } else {
        $pdfs = $PdfClass->getPdfs();
        echo json_encode(['status' => 'success', 'data' => $pdfs ?: []]);
    }
}
