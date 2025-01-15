<?php
include("init.php");

$timeout = 600;
// Include necessary files
include("linknice.php");
include("headernice.php");
include("sidebar.php");
include("conn.php"); // Include database connection once

// Query to count total staff by combining users and staff tables
$sql = "
    SELECT COUNT(*) AS total_staff
    FROM (
        SELECT id FROM users WHERE role = 'staff'
        UNION
        SELECT id FROM staff
    ) AS combined_staff
";
$result = $conn->query($sql);

$totalStaff = 0;
if ($result->num_rows > 0) {
    // Fetch the result
    $row = $result->fetch_assoc();
    $totalStaff = $row['total_staff'];
}

// Close the connection
$conn->close();
?>
        <section class="section dashboard">
            <div class="row">
                <!-- Left side columns -->
                <div class="col-lg-8">
                    <div class="row">
                        <!-- Staff Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Today</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Staff <span>| Total</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?php echo $totalStaff . " staff"; ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Staff Card -->

                        <?php
                        // Database connection
                        include("conn.php");

                        // Fetch clients from the database
                        $sql = "SELECT * FROM clients";
                        $result = $conn->query($sql);

                        $totalClient = 0; // Initialize the total client count
                        if ($result->num_rows > 0) {
                            $totalClient = $result->num_rows; // Get the total number of clients
                        }

                        $conn->close();
                        ?>

                        <!-- Client Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card revenue-card">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Today</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Client <span>| This Month</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?php echo $totalClient . " clients"; ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Client Card -->

                        <!-- Reports -->
                        <div class="col-12">
                            <div class="card">
                                <div class ="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Today</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Reports <span>/Today</span></h5>
                                    <!-- Line Chart -->
                                    <div id="reportsChart"></div>
                                    <?php include("charts.php"); ?>
                                    <!-- End Line Chart -->
                                </div>
                            </div><!-- End Reports -->
                        </div>
                    </div>
                </div><!-- End Left side columns -->

                <!-- Right side columns -->
                <div class="col-lg-4">
<?php
include("conn.php");
// Fetch activities created in the last 2 hours
$query = "
    SELECT 'client' AS type, name AS message, created_at 
    FROM clients 
    WHERE created_at >= NOW() - INTERVAL 2 HOUR
    UNION ALL
    SELECT type, CONCAT('Transaction: ', amount, ' for client ID ', client_name) AS message, date AS created_at 
    FROM transactions 
    WHERE date >= NOW() - INTERVAL 2 HOUR
    ORDER BY created_at DESC
";

$result = $conn->query($query);
$activities = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }
}
?>

<!-- Recent Activity -->
<div class="card">
    <div class="filter">
        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
                <h6>Filter</h6>
            </li>
            <li><a class="dropdown-item" href="#">Today</a></li>
            <li><a class="dropdown-item" href="#">This Month</a></li>
            <li><a class="dropdown-item" href="#">This Year</a></li>
        </ul>
    </div>
    <div class="card-body">
        <h5 class="card-title">Recent Activity <span>| Today</span></h5>
        <div class="activity">
            <?php if (empty($activities)): ?>
                <div class="activity-item d-flex">
                    <div class="activity-content">No recent activities.</div>
                </div>
            <?php else: ?>
                <?php foreach ($activities as $activity): ?>
                    <div class="activity-item d-flex">
                        <div class="activite-label">
                            <?php
                            // Calculate time difference
                            $createdAt = new DateTime($activity['created_at']);
                            $now = new DateTime();
                            $interval = $now->diff($createdAt);
                            echo $interval->format('%h hours %i minutes ago');
                            ?>
                        </div>
                        <i class='bi bi-circle-fill activity-badge 
                            <?php
                            // Set badge color based on activity type
                            switch ($activity['type']) {
                                case 'client':
                                    echo 'text-success';
                                    break;
                                case 'loan':
                                    echo 'text-primary';
                                    break;
                                case 'repayment':
                                    echo 'text-info';
                                    break;
                                default:
                                    echo 'text-muted';
                            }
                            ?> align-self-start'></i>
                        <div class="activity-content">
                            <?php echo $activity['message']; ?>
                        </div>
                    </div><!-- End activity item-->
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div><!-- End Recent Activity -->
                </div><!-- End Right side columns -->
            </div>
        </section>
    </main>
    <?php
include('autolog.php');
?>
<?php include("footernice.php"); ?>