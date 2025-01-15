<?php
// Include necessary files for database connection
include("conn.php");

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $transactionId = (int)$_GET['id'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM transactions WHERE id = ?");
    $stmt->bind_param("i", $transactionId);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect back to the transactions page with a success message
        header("Location: transaction_manage.php?message=Transaction deleted successfully&type=success");
    } else {
        // Redirect back with an error message
        header("Location: transaction_manage.php?message=Error deleting transaction&type=danger");
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>