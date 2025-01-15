<?php
// Include necessary files
include("init.php");
include("conn.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the staff ID from the form
    $staff_id = $_POST['staff_id'];

    // Validate the staff ID
    if (empty($staff_id)) {
        header("Location: del_insystem.php?message=Please select a staff member!&type=danger");
        exit();
    }

    // Query to delete the staff member from the database
    $delete_query = "DELETE FROM users WHERE id = ? AND role = 'staff'";
    $stmt = $conn->prepare($delete_query);

    // Check if the query preparation was successful
    if ($stmt === false) {
        die("Error preparing delete query: " . $conn->error);
    }

    // Bind the staff ID parameter
    $stmt->bind_param("i", $staff_id);

    // Execute the query with error handling
    try {
        if ($stmt->execute()) {
            header("Location: del_insystem.php?message=Staff member deleted successfully!&type=success");
        } else {
            header("Location: del_insystem.php?message=Error deleting staff member!&type=danger");
        }
    } catch (mysqli_sql_exception $e) {
        error_log("Error: " . $e->getMessage());
        header("Location: del_insystem.php?message=An error occurred while deleting the staff member.&type=danger");
    }

    // Close the statement
    $stmt->close();
} else {
    // Redirect if the form is not submitted
    header("Location: del_insystem.php");
}

// Close the database connection
$conn->close();
?>