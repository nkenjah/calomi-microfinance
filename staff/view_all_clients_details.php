<?php
include("session_manager.php");

// Check if the user is logged in and has the role of either admin or staff
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'staff')) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

$user_id = $_SESSION['user_id'];
// Include database connection
include("conn.php");
include("link.php");
include("header.php");
include("sidebar.php");

// Fetch the username of the logged-in staff member
$sql = "SELECT username FROM users WHERE id = ? AND role = 'staff'";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username);
    $stmt->fetch();
    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error);
}

// Fetch clients created by the logged-in staff member
$sql = "SELECT * FROM clients WHERE created_by = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $clients = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error);
}

// Close database connection
$conn->close();
?>

<h2>Clients Registered by <?php echo htmlspecialchars($username); ?></h2>

<!-- Search Client Section -->
<div class="mb-3">
    <input type="text" id="searchClient" class="form-control" placeholder="Search by Name, Phone, or Address...">
</div>

<div class="card">
    <div class="card-body">
        <!-- Table with hoverable rows -->
        <table class="table table-hover" id="clientTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Loan Amount</th>
                    <th>Interest Rate</th>
                    <th>Loan Duration</th>
                    <th>Collateral</th>
                    <th>Client Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($client['name']); ?></td>
                        <td><?php echo htmlspecialchars($client['phone']); ?></td>
                        <td><?php echo htmlspecialchars($client['address']); ?></td>
                        <td><?php echo htmlspecialchars($client['loan_amount']); ?></td>
                        <td><?php echo htmlspecialchars($client['interest_rate']); ?></td>
                        <td><?php echo htmlspecialchars($client['loan_duration']); ?></td>
                        <td><?php echo htmlspecialchars($client['collateral']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($client['client_image']); ?>" alt="Client Image" width="100"></td>
                        <td>
                            <a href='edit_client.php?id=<?php echo $client['id']; ?>' class='btn btn-warning'>Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- JavaScript for Search Functionality -->
<script src="javascript.js"></script>

<?php include('footer.php');?>