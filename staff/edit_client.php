<?php
include("session_manager.php");

// Check if the user is logged in and has the role of either admin or staff
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'staff')) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

$user_id = $_SESSION['user_id'];
include("conn.php"); // Include the database connection

$message = "";
$type = "";

if (isset($_GET['id'])) {
    $clientId = intval($_GET['id']); // Get the client ID from the URL

    // Fetch the client data
    $stmt = $conn->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->bind_param("i", $clientId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();
    } else {
        // Redirect if client not found
        $message = "Client not found";
        $type = "danger";
        header("Location: view_all_clients_details.php?message=" . urlencode($message) . "&type=" . urlencode($type));
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Update client information
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $loan_amount = $_POST['loan_amount'];
        $interest_rate = $_POST['interest_rate'];
        $loan_duration = $_POST['loan_duration'];
        $collateral = $_POST['collateral'];

        $updateStmt = $conn->prepare("UPDATE clients SET name=?, phone=?, address=?, loan_amount=?, interest_rate=?, loan_duration=?, collateral=? WHERE id=?");
        $updateStmt->bind_param("sssdissi", $name, $phone, $address, $loan_amount, $interest_rate, $loan_duration, $collateral, $clientId);

        if ($updateStmt->execute()) {
            // Redirect to the client management page with a success message
            $message = "Client updated successfully";
            $type = "success";
        } else {
            // Redirect to the client management page with an error message
            $message = "Error updating client";
            $type = "danger";
        }

        $updateStmt->close();
        header("Location: view_all_clients_details.php?message=" . urlencode($message) . "&type=" . urlencode($type));
        exit();
    }
} else {
    // Redirect if no ID is provided
    $message = "No client ID provided";
    $type = "danger";
    header("Location: view_all_clients_details.php?message=" . urlencode($message) . "&type=" . urlencode($type));
    exit();
}

$conn->close();
?>

<?php
include("link.php");
include("header.php");
include("sidebar.php");
?>

<!-- HTML Form for Editing Client -->
<?php
if (!empty($_GET['message']) && !empty($_GET['type'])) {
    $message = htmlspecialchars($_GET['message']);
    $type = htmlspecialchars($_GET['type']);
    echo "<div class='alert alert-$type' role='alert'>$message</div>";
}
?>
<body>
    <form action="" method="POST" class="row g-3">
        <div class="col-12">
            <label for="name" class="form-label">Client Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($client['name']); ?>" required>
            <div class="invalid-feedback">Please enter the client's name.</div>
        </div>

        <div class="col-12">
            <label for="phone" class="form-label">Phone:</label>
            <input type="text" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($client['phone']); ?>" required>
            <div class="invalid-feedback">Please enter the phone number.</div>
        </div>

        <div class="col-12">
            <label for="address" class="form-label">Address:</label>
            <textarea id="address" name="address" class="form-control" required><?php echo htmlspecialchars($client['address']); ?></textarea>
            <div class="invalid-feedback">Please enter the address.</div>
        </div>

        <div class="col-12">
            <label for="loan_amount" class="form-label">Loan Amount:</label>
            <input type="number" id="loan_amount" name="loan_amount" class="form-control" step="0.01" value="<?php echo htmlspecialchars($client['loan_amount']); ?>" required>
            <div class="invalid-feedback">Please enter the loan amount.</div>
        </div>

        <div class="col-12">
            <label for="interest_rate" class="form-label">Interest Rate (%):</label>
            <input type="number" id="interest_rate" name="interest_rate" class="form-control" step="0.01" value="<?php echo htmlspecialchars($client['interest_rate']); ?>" required>
            <div class="invalid-feedback">Please enter the interest rate.</div>
        </div>

        <div class="col-12">
            <label for="loan_duration" class="form-label">Loan Duration (months):</label>
            <input type="number" id="loan_duration" name="loan_duration" class="form-control" value="<?php echo htmlspecialchars($client['loan_duration']); ?>" required>
            <div class="invalid-feedback">Please enter the loan duration.</div>
        </div>

        <div class="col-12">
            <label for="collateral" class="form-label">Collateral:</label>
            <textarea id="collateral" name="collateral" class="form-control"><?php echo htmlspecialchars($client['collateral']); ?></textarea>
        </div>        

        <div class="col-12">
            <input type="submit" value="Update" class="btn btn-primary">
        </div>
    </form>
    <?php
    include("footer.php");
    ?>
</body>
</html>