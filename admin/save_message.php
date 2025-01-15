<?php
include("conn.php");

// Get the data from the AJAX request
$date = $_POST['date'];
$message = $_POST['message'];
$username = $_POST['username'];

// Prepare the SQL query
$stmt = $conn->prepare("INSERT INTO messages (date, message, username) VALUES (?, ?, ?)");

// Bind the parameters
$stmt->bind_param("sss", $date, $message, $username);

// Execute the query
if ($stmt->execute()) {
    // Return a success message
    echo "Message saved!";
} else {
    // Return an error message
    echo "Error saving message: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>