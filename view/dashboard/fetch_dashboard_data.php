<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/config/DB.php';

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db = new DB();
$conn = $db->connection();

$response = [];

if (!$conn) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Fetch Total Users
$user_query = "SELECT COUNT(*) as total_users FROM user";
$user_result = $conn->query($user_query);
if ($user_result) {
    $user_data = $user_result->fetch_assoc();
    $response['total_users'] = $user_data['total_users'] ?? 0;
}

// Fetch Total Books
$book_query = "SELECT COUNT(*) as total_books FROM books";
$book_result = $conn->query($book_query);
if ($book_result) {
    $book_data = $book_result->fetch_assoc();
    $total_books = $book_data['total_books'] ?? 0;
    $response['total_books'] = $total_books;
} else {
    $total_books = 0;
}

// Fetch Total PDF Books
$pdf_query = "SELECT COUNT(*) as total_pdfs FROM pdfs";
$pdf_result = $conn->query($pdf_query);
if ($pdf_result) {
    $pdf_data = $pdf_result->fetch_assoc();
    $total_pdfs = $pdf_data['total_pdfs'] ?? 0;
} else {
    $total_pdfs = 0;
}

// Fetch Total Audiobooks
$audiobook_query = "SELECT COUNT(*) as total_audiobooks FROM audiobooks";
$audiobook_result = $conn->query($audiobook_query);
if ($audiobook_result) {
    $audiobook_data = $audiobook_result->fetch_assoc();
    $total_audiobooks = $audiobook_data['total_audiobooks'] ?? 0;
} else {
    $total_audiobooks = 0;
}

// Calculate Percentages
$response['pdf_percentage'] = ($total_books > 0) ? round(($total_pdfs / $total_books) * 100, 2) : 0;
$response['audiobook_percentage'] = ($total_books > 0) ? round(($total_audiobooks / $total_books) * 100, 2) : 0;

// Fetch Total Subscriptions
$sub_query = "SELECT COUNT(*) as total_subscriptions FROM subscriptions";
$sub_result = $conn->query($sub_query);
if ($sub_result) {
    $sub_data = $sub_result->fetch_assoc();
    $response['total_subscriptions'] = $sub_data['total_subscriptions'] ?? 0;
}

// Fetch Total Revenue
$total_revenue_query = "SELECT SUM(amount) AS total_revenue FROM invoices";
$total_revenue_result = $conn->query($total_revenue_query);
if ($total_revenue_result) {
    $total_revenue_data = $total_revenue_result->fetch_assoc();
    $response['total_revenue'] = $total_revenue_data['total_revenue'] ?? 0;
}

// Fetch Monthly Revenue
$revenue_query = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, SUM(amount) AS revenue
                  FROM invoices 
                  GROUP BY month 
                  ORDER BY month DESC 
                  LIMIT 6";

$revenue_result = $conn->query($revenue_query);
if (!$revenue_result) {
    echo json_encode(["error" => "Query failed: " . mysqli_error($conn)]);
    exit;
}

$monthly_revenue = [];
while ($row = mysqli_fetch_assoc($revenue_result)) {
    $monthly_revenue[] = [
        'month' => $row['month'],
        'revenue' => $row['revenue'] ?? 0
    ];
}

// Add monthly revenue to the response
$response['monthly_revenue'] = $monthly_revenue;

// Close database connection
$conn->close();

// Send JSON response
echo json_encode($response);
exit;
