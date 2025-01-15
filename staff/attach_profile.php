<?php
// Start the session
include("session_manager.php");

// Configuration
define('UPLOAD_DIR', 'uploads/'); // Directory to store uploaded files
define('ALLOWED_EXTENSIONS', array('jpg', 'jpeg', 'png', 'gif')); // Allowed file extensions

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the uploaded file information
    $file = $_FILES['profile_attachment'];

    // Check if the file has been uploaded
    if ($file['error'] == 0) {
        // Get the file extension
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

        // Check if the file extension is allowed
        if (in_array($extension, ALLOWED_EXTENSIONS)) {
            // Generate a unique filename
            $filename = uniqid() . '.' . $extension;

            // Move the uploaded file to the upload directory
            if (move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $filename)) {
                // Update the user's profile with the attached file
                updateProfileAttachment($filename);
                echo 'Profile attachment successful!';
            } else {
                echo 'Error moving the uploaded file.';
            }
        } else {
            echo 'Invalid file extension. Only ' . implode(', ', ALLOWED_EXTENSIONS) . ' are allowed.';
        }
    } else {
        echo 'Error uploading the file.';
    }
}

// Function to update the user's profile with the attached file
function updateProfileAttachment($filename) {
    // Assuming a database connection has been established
    include('conn.php');

    // Get the user's ID
    $userId = $_SESSION['user_id'];

    // Update the user's profile with the attached file
    $query = "UPDATE users SET profile_attachment = '$filename' WHERE id = '$userId'";
    $conn->query($query);

    // Close the database connection
    $conn->close();
}