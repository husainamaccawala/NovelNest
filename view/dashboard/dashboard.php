<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/view/layout/header.php';
?>
<div class="content-inner container-fluid pb-0" id="page_layout">
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-lg-3 iq-counter">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle p-1 bg-primary d-flex align-items-center justify-content-center"
                                    style="width:66px; height:66px; font-size: 22px;"><i class="fa fa-users text-white"></i>
                                </div>
                                <div class="text-left ms-3 mt-3">
                                    <h3 class="card-title">Total Users</h3>
                                    <h4 class="card-text"><span id="totalUsers">Loading...</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 iq-counter">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle p-1 bg-danger d-flex align-items-center justify-content-center"
                                    style="width:66px; height:66px; font-size: 22px;"><i class="fa fa-book text-white"></i>
                                </div>
                                <div class="text-left ms-3 mt-3">
                                    <h3 class="card-title">Total Books</h3>
                                    <h4 class="card-text"><span id="totalBooks">Loading...</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 iq-counter">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle p-1 bg-warning d-flex align-items-center justify-content-center"
                                    style="width:66px; height:66px; font-size: 22px;"><i class="ion-pricetag text-white"></i>
                                </div>
                                <div class="text-left ms-3 mt-3">
                                    <h3 class="card-title">Subscriptions</h3>
                                    <h4 class="card-text"><span id="totalSubscriptions">Loading...</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 iq-counter">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle p-1 bg-info d-flex align-items-center justify-content-center"
                                    style="width:66px; height:66px; font-size: 22px;"><i class="fa fa-envelope-open text-white"></i>
                                </div>
                                <div class="text-left ms-3 mt-3">
                                    <h3 class="card-title">Revenue</h3>
                                    <h4 class="card-text">₹<span id="totalRevenue">Loading...</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Monthly Revenue</h3>
                            <div style="width: 100%; height: 300px;">
                                <canvas id="revenueChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-header d-flex justify-content-between align-items-center mb-0">
                            <div class="header-title">
                                <h4 class="card-title mb-0">Book Summary</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-inline p-0 mb-0">
                                <li>
                                    <div class="details mb-3">
                                        <span class="title">Total Books</span>
                                        <div class="percentage float-right text-dark" id="total_books">Loading...</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="details mb-4">
                                        <span class="title">PDF Percentage</span>
                                        <div class="percentage float-right text-primary" id="pdf_percentage">Loading...</div>
                                        <div class="progress bg-primary-subtle shadow-none w-100" style="height: 6px">
                                            <div class="progress-bar bg-primary" id="pdf_progress" role="progressbar" style="width: 0%;"></div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="details mb-4">
                                        <span class="title">Audiobook Percentage</span>
                                        <div class="percentage float-right text-info" id="audiobook_percentage">Loading...</div>
                                        <div class="progress bg-info-subtle shadow-none w-100" style="height: 6px">
                                            <div class="progress-bar bg-info" id="audiobook_progress" role="progressbar" style="width: 0%;"></div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchDashboardData();

        function fetchDashboardData() {
            fetch('/NovelNest/view/dashboard/fetch_dashboard_data.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById("totalUsers").innerText = data.total_users;
                    document.getElementById("totalBooks").innerText = data.total_books;
                    document.getElementById("total_books").innerText = data.total_books; // FIX for book summary
                    document.getElementById("totalSubscriptions").innerText = data.total_subscriptions;
                    document.getElementById("totalRevenue").innerText = data.total_revenue;

                    const ctx = document.getElementById('revenueChart').getContext('2d');

                    if (window.revenueChart instanceof Chart) {
                        window.revenueChart.destroy();
                    }

                    window.revenueChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.monthly_revenue.map(item => item.month).reverse(),
                            datasets: [{
                                label: 'Revenue (in ₹)',
                                data: data.monthly_revenue.map(item => item.revenue).reverse(),
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 2,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // Update Progress Bars
                    document.getElementById("pdf_percentage").innerText = data.pdf_percentage + "%";
                    document.getElementById("pdf_progress").style.width = data.pdf_percentage + "%";
                    document.getElementById("audiobook_percentage").innerText = data.audiobook_percentage + "%";
                    document.getElementById("audiobook_progress").style.width = data.audiobook_percentage + "%";
                })

        }
    });
</script>


<?php
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/view/layout/footer.php';
?>