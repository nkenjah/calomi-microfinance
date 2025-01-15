<?php
include("conn.php"); // Include the database connection

// Initialize message variables
$message = '';
$type = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $client_id = isset($_POST['client_id']) ? intval($_POST['client_id']) : 0;
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0.0;
    $staff_id = isset($_POST['staff_id']) ? intval($_POST['staff_id']) : 0;

    // Validate inputs
    $errors = [];
    if ($client_id <= 0) {
        $errors[] = "Invalid client selected.";
    }
    if ($type !== 'loan' && $type !== 'repayment') {
        $errors[] = "Invalid transaction type.";
    }
    if ($amount <= 0) {
        $errors[] = "Amount must be greater than zero.";
    }
    if ($staff_id <= 0) {
        $errors[] = "Invalid staff member selected.";
    }

    // If there are no errors, proceed to insert the transaction
    if (empty($errors)) {
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO transactions (client_name, type, amount, staff_username) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isdi", $client_id, $type, $amount, $staff_id);

        // Execute the statement
        if ($stmt->execute()) {
            $message = "Transaction recorded successfully.";
            $type = "success"; // Set alert type to success
        } else {
            $message = "Error recording transaction: " . $stmt->error;
            $type = "danger"; // Set alert type to danger
        }

        // Close the statement
        $stmt->close();
    } else {
        // If there are errors, concatenate them into a single message
        $message = implode("<br>", $errors);
        $type = "danger"; // Set alert type to danger
    }

    // Redirect to the same page with message and type
    header("Location: transaction_record.php?message=" . urlencode($message) . "&type=" . urlencode($type));
    exit();
}

// Close the database connection
$conn->close();

// Display alert message if available
?>