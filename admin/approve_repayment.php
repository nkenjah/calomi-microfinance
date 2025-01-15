<?php
include("conn.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Update the transaction status to 'approved'
    $stmt = $conn->prepare("UPDATE transactions SET status = 'approved' WHERE id = ? AND type = 'repayment'");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Redirect back to the transaction management page with a success message
header("Location: transaction_manage.php?message=Repayment approved successfully&type=success");
    } else {
        // Redirect back to the transaction management page with an error message
header("Location: transaction_manage.php?error=Failed to approve repayment&type=error");
    }
    
    $stmt->close();
} else {
    // Redirect back to the transaction management page if no ID was provided
    header("Location: transaction_manage.php?error=No transaction ID provided");
}

$conn->close();
?>
</body>
</html>
