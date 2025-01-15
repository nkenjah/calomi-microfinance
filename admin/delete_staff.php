<?php
// Include database connection
include ("conn.php");

$message = "";
$type = "";

// Check if ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete staff member from the database
    $deleteQuery = "DELETE FROM staff WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $id);
    
    if ($deleteStmt->execute()) {
        $message = "Staff member deleted successfully.";
        $type = "success";
    } else {
        $message = "Error deleting staff member.";
        $type = "danger";
    }
} else {
    $message = "ID not provided.";
    $type = "danger";
}
header("Location: view_all_staff.php?message=" . urlencode($message) . "&type=" . urlencode($type));
?>