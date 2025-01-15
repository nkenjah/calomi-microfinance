<?php
include("init.php");

$timeout = 120;
include("conn.php"); // Include the database connection

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
        header("Location: client_manage.php?message=Client not found");
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
            header("Location: client_manage.php?message=Client updated successfully");
            exit();
        } else {
            // Redirect to the client management page with an error message
            header("Location: client_manage.php?message=Error updating client");
            exit();
        }

        $updateStmt->close();
    }
} else {
    // Redirect if no ID is provided
    header("Location: client_manage.php?message=No client ID provided");
    exit();
}

$conn->close();
?>

<?php
include("linknice.php");
include("headernice.php");
include("sidebar.php");
?>

<!-- HTML Form for Editing Client -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Client</title>
</head>
<body>
<div class="mb-3">
    <input type="text" id="searchClient" class="form-control" placeholder="Search by Name, Phone, or Address...">
</div>
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
            <input type ```php
="number" id="loan_duration" name="loan_duration" class="form-control" value="<?php echo htmlspecialchars($client['loan_duration']); ?>" required>
            <div class="invalid-feedback">Please enter the loan duration.</div>
        </div>

        <div class="col-12">
            <label for="collateral" class="form-label">Collateral:</label>
            <textarea id="collateral" name="collateral" class="form-control"><?php echo htmlspecialchars($client['collateral']); ?></textarea>
        </div>        

        <div class="col-12">
            <input type="submit" value="Update" class="btn btn-danger">
        </div>
    </form>
    <?php
include('autolog.php');
?>
    <?php
    include("footernice.php");
    ?>
</body>
</html>