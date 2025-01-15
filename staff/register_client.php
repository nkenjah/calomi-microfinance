<?php
include("session_manager.php"); // Start the session to access session variables
include("link.php");
include("header.php");
include("sidebar.php");
?>
<?php
// Display messages if any
if (!empty($_GET['message']) && !empty($_GET['type'])) {
    $message = htmlspecialchars($_GET['message']);
    $type = htmlspecialchars($_GET['type']);
    echo "<div class='alert alert-$type' role='alert'>$message</div>";
}
?>

<h1>Add Client</h1>
<form action="add_client.php" method="post" enctype="multipart/form-data">
    <div class="col-12">
        <label for="name" class="form-label">Client Name:</label>
        <input type="text" id="name" name="name" class="form-control" required>
        <div class="invalid-feedback">Please enter the client's name.</div>
    </div>

    <div class="col-12">
        <label for="phone" class="form-label">Phone:</label>
        <input type="text" id="phone" name="phone" class="form-control" pattern="[0-9]{10}" required>
        <div class="invalid-feedback">Please enter a valid 10-digit phone number.</div>
    </div>

    <div class="col-12">
        <label for="address" class="form-label">Address:</label>
        <textarea id="address" name="address" class="form-control" required></textarea>
        <div class="invalid-feedback">Please enter the address.</div>
    </div>

    <div class="col-12">
        <label for="loan_amount" class="form-label">Loan Amount:</label>
        <input type="number" id="loan_amount" name="loan_amount" class="form-control" step="0.01" min="0" required>
        <div class="invalid-feedback">Please enter a valid loan amount.</div>
    </div>

    <div class="col-12">
        <label for="interest_rate" class="form-label">Interest Rate (%):</label>
        <input type="number" id="interest_rate" name="interest_rate" class="form-control" step="0.01" min="0" max="100" required>
        <div class="invalid-feedback">Please enter a valid interest rate (0-100%).</div>
    </div>

    <br>

    <div class="col-12">
        <div class="form-group">
            <label for="client_image">Upload Client Image:</label>
            <input type="file" name="client_image" id="client_image" class="form-control" accept="image/*" required>
        </div>
    </div>

    <br>

    <div class="col-12">
        <label for="loan_duration" class="form-label">Loan Duration (months):</label>
        <input type="number" id="loan_duration" name="loan_duration" class="form-control" min="1" required>
        <div class="invalid-feedback">Please enter a valid loan duration (minimum 1 month).</div>
    </div>

    <br>

    <div class="col-12">
        <label for="collateral" class="form-label">Collateral:</label>
        <textarea id="collateral" name="collateral" class="form-control"></textarea>
    </div>

    <input type="hidden" name="created_by" value="<?php echo htmlspecialchars($_SESSION['username']); ?>">
<br>
    <div class="col-12">
        <input type="submit" value="Add Client" class="btn btn-primary">
    </div>
</form>

<?php
include("footer.php");
?>