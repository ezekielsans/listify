<?php
require_once '../../controllers/productController.php';
require_once '../../controllers/usersController.php';
require_once '../../controllers/ordersController.php';


$orders = $orders->showOrders();
$counter = 1;

?>

<main class="col-md-10 main-content">


    Dashboard Header
    <h3>Dashboard</h3>
    <!-- Tabs -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#">Overview</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Analytics</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Reports</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Notifications</a>
        </li>
    </ul>

    <!-- Top Info Cards -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="info-card">
                <h5>Total Revenue</h5>
                <p>$45,231.89</p>
                <small>+20.1% from last month</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-card">
                <h5>Subscriptions</h5>
                <p>+2350</p>
                <small>+180.1% from last month</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-card">
                <h5>Sales</h5>
                <p>+12,234</p>
                <small>+19% from last month</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-card">
                <h5>Active Now</h5>
                <p>+573</p>
                <small>+201 since last hour</small>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Sales Chart with "Overview" title -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Overview</h5>
                    <canvas id="salesChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Sales -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Recent Sales</h5>
                    <p class="text-muted">You made 265 sales this month.</p>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div><strong>O</strong> Olivia Martin<br><small>Glimmer Lamps</small></div>
                            <span>$79.00</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div><strong>A</strong> Ava Johnson<br><small>Aqua Filters</small></div>
                            <span>$39.00</span>
                        </li>
                        <!-- More list items as needed -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Orders -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Orders</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order) { ?>
                            <tr>
                                    <td><?=$counter++?></td>
                                    <td><?= $order['product_name'] ?></td>
                                    <td><?= $order['first_name'] ?>     <?= $order['last_name'] ?></td>
                                    <td><?= '₱' . number_format($order['total_price'], 2) ?></td>
                                    <td><?= $order['order_status'] ?></td>
                                </tr>
                                <?php } ?>
                            <!-- More rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Top Products</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Sales</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Glimmer Lamps</td>
                                <td>230</td>
                                <td>$18,400</td>
                            </tr>
                            <!-- More rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Example data for Chart.js
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Sales',
                data: [6000, 4500, 3000, 4000, 2000, 3500, 6000, 5000, 2500, 4500, 4000, 3000],
                backgroundColor: '#7FFF00'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });




</script>