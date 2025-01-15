<?php
include("init.php");

$timeout = 120;
include("headernice.php");
include("sidebar.php");
include("conn.php");

// Assuming you have already established a database connection in $conn

// Query to fetch clients
$clients_query = "SELECT id, name FROM clients"; // Adjust the query as needed
$clients_result = $conn->query($clients_query);

// Check if the query was successful
if ($clients_result === false) {
    die("Error executing clients query: " . $conn->error);
}

// Query to fetch staff members from the users table where role is 'staff'
$staff_query = "SELECT id, username FROM users WHERE role = 'staff'"; // Adjust the query as needed
$staff_result = $conn->query($staff_query);

// Check if the query was successful
if ($staff_result === false) {
    die("Error executing staff query: " . $conn->error);
}
?>
<h1>Record Transaction</h1>
<?php
                    if(!empty($_GET['message']) && !empty($_GET['type'])){
                      $message = $_GET['message'];
                      $type = $_GET['type'];
                      echo "<div class='alert alert-$type' role='alert'>$message</div>";
                    }
                    ?>
<form method="POST" action="transaction.php">
    <div class="col-12">
    <label for="clients" class="form-label">Select Client:</label>
<select name="client_id" id="clients" class="form-control" required>
    <option value="">Select a client</option>
    <?php while ($client = $clients_result->fetch_assoc()): ?>
        <option value="<?php echo htmlspecialchars($client['id']); ?>">
            <?php echo htmlspecialchars($client['name']); ?>
        </option>
    <?php endwhile; ?>
</select>
<div class="invalid-feedback">Please select a client!</div>
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
        <select name="staff_id" id="staff_id" class="form-control" required>
            <option value="">Select a staff member</option>
            <?php while ($staff = $staff_result->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($staff['id']); ?>">
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
</body>
</html>
<?php include('autolog.php');?>
<?php
include("footernice.php");
?>