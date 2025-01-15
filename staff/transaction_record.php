<?php
session_start(); // Start the session at the beginning

include("session_manager.php");
include("link.php");
include("header.php");
include("sidebar.php");
include("conn.php");

// Query to fetch clients with their names
$clients_query = "SELECT id, name FROM clients"; // Adjust the query as needed
$clients_result = $conn->query($clients_query);

// Check if the query was successful
if ($clients_result === false) {
    die("Error executing clients query: " . $conn->error);
}

// Query to fetch staff members with their usernames
$staff_query = "SELECT id, username FROM users WHERE role = 'staff'"; // Adjust the query as needed
$staff_result = $conn->query($staff_query);

// Check if the query was successful
if ($staff_result === false) {
    die("Error executing staff query: " . $conn->error);
}
?>


<?php
if (!empty($_GET['message']) && !empty($_GET['type'])) {
    $message = htmlspecialchars($_GET['message']);
    $type = htmlspecialchars($_GET['type']);
    echo "<div class='alert alert-$type' role='alert'>$message</div>";
}
?>

<h1>Record Transaction</h1>
<form method="POST" action="transaction.php" onsubmit="return validateForm()">
    <div class="col-12">
        <label for="clients" class="form-label">Select Client:</label>
        <select name="client_name" id="clients" class="form-control" required>
            <option value="">Select a client</option>
            <?php while ($client = $clients_result->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($client['id']); ?>">
                    <?php echo htmlspecialchars($client['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <div class="invalid-feedback">Please select a client!</div>
    </div>

    <div class="col-12">
        <label for="type" class="form-label">Transaction Type:</label>
        <select name="type" id="type" class="form-control" required>
            <option value="loan">Loan</option>
            <option value="repayment">Repayment</option>
        </select>
        <div class="invalid-feedback">Please select a transaction type!</div>
    </div>

    <div class="col-12">
        <label for="amount" class="form-label">Amount:</label>
        <input type="number" name="amount" id="amount" class="form-control" required>
        <div class="invalid-feedback">Please enter an amount!</div>
    </div>

    <div class="col-12">
        <label for="staff_id" class="form-label">Staff:</label>
        <select name="staff_username" id="staff_id" class="form-control" required>
            <option value="">Select a staff member</option>
            <?php 
            // Assuming $logged_in_user contains the username of the logged-in staff member
            $logged_in_user = $_SESSION['username']; // Adjust this based on your session variable

            while ($staff = $staff_result->fetch_assoc()): 
                $selected = ($staff['username'] === $logged_in_user) ? 'selected' : '';
            ?>
                <option value="<?php echo htmlspecialchars($staff['id']); ?>" <?php echo $selected; ?>>
                    <?php echo htmlspecialchars($staff['username']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <div class="invalid-feedback">Please select a staff member!</div>
    </div>

    <div class="col-12">
        <input type="submit" value="Submit" class="btn btn-primary">
    </div>
</form>
<?php
include("footer.php");
?>