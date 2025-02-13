<?php
require_once __DIR__ . "/config/DB.php";
require_once __DIR__ . "/view/layout/header.php";
var_dump(headers_list());
exit;
header('Content-Type: application/json');


// Fetch Total Users
// $user_query = "SELECT COUNT(*) as total_users FROM users";
// $user_result = mysqli_query($conn, $user_query);
// $user_data = mysqli_fetch_assoc($user_result);
// $total_users = $user_data['total_users'];

// Fetch Total Books
$book_query = "SELECT COUNT(*) as total_books FROM books";
$book_result = mysqli_query($conn, $book_query);
$book_data = mysqli_fetch_assoc($book_result);
$total_books = $book_data['total_books'];

// Fetch Total Subscriptions
// $sub_query = "SELECT COUNT(*) as total_subscriptions FROM subscriptions";
// $sub_result = mysqli_query($conn, $sub_query);
// $sub_data = mysqli_fetch_assoc($sub_result);
// $total_subscriptions = $sub_data['total_subscriptions'];

// Fetch Total Revenue
// $revenue_query = "SELECT SUM(amount) as total_revenue FROM invoices";
// $revenue_result = mysqli_query($conn, $revenue_query);
// $revenue_data = mysqli_fetch_assoc($revenue_result);
// $total_revenue = $revenue_data['total_revenue'] ?? 0; // Handle null values

// Return JSON Response
echo json_encode([
    // 'total_users' => $total_users,
    'total_books' => $total_books,
    // 'total_subscriptions' => $total_subscriptions,
    // 'total_revenue' => number_format($total_revenue, 2)
]);

?>


<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->

        <!-- Main Content -->
        <main role="main" class="col-md-10 ml-sm-auto px-4">
            <h2>Admin Dashboard</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <p class="card-text"><span id="totalUsers">Loading...</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Books</h5>
                            <p class="card-text"><span id="totalBooks">Loading...</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Subscriptions</h5>
                            <p class="card-text"><span id="totalSubscriptions">Loading...</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-danger mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Revenue</h5>
                            <p class="card-text">$<span id="totalRevenue">Loading...</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Include Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchDashboardData(); // Fetch numbers on page load

        function fetchDashboardData() {
            fetch('fetch_dashboard_data.php')
                .then(response => response.json())
                .then(data => {
                    // document.getElementById("totalUsers").innerText = data.total_users;
                    document.getElementById("totalBooks").innerText = data.total_books;
                    // document.getElementById("totalSubscriptions").innerText = data.total_subscriptions;
                    // document.getElementById("totalRevenue").innerText = data.total_revenue;
                })
                .catch(error => console.error('Error fetching dashboard data:', error));
        }
    });
</script>

<?php require_once __DIR__ . "/view/layout/footer.php";

?>