<?php

include("conn.php"); // Include the database connection

$message = "";
$type = "";

if (isset($_GET['id'])) {
    $clientId = intval($_GET['id']); // Get the client ID from the URL and convert it to an integer

    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM clients WHERE id = ?");
    $stmt->bind_param("i", $clientId); // Bind the correct parameter

    if ($stmt->execute()) {
        // Redirect to the client management page with a success message
        $message = "Client deleted successfully";
        $type = "success";
        exit();
    } else {
        // Redirect to the client management page with an error message
         $message = "deleting client";
         $type = "error";
        exit();
    }

    $stmt->close();
} else {
    // Redirect to the client management page if no ID is provided
    $message = "message=No client ID provided";
    $type = "error";
    exit();
}

header("location: client_manage.php?message=" . urldecode($message) . "&type=" . urldecode($type));
 exit();
 exit();
$conn->close();
?>