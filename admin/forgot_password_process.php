<?php
// Start the session
session_start();

// Include database connection file
include("conn.php");
include("linknice.php");

// Function to check if the password is strong
function isStrongPassword($password) {
    // Check for minimum length, at least one letter, one number, and one special character
    return preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input data
    $username = trim($_POST['username']);
    $newPassword = trim($_POST['password']);
    $repeatPassword = trim($_POST['repeat_password']);

    // Validate input
    if (empty($username) || empty($newPassword) || empty($repeatPassword)) {
        // Redirect with error message
        header("Location: forgot_password.php?message=All fields are required&type=danger");
        exit();
    }

    if ($newPassword !== $repeatPassword) {
        // Redirect with error message
        header("Location: forgot_password.php?message=Passwords do not match&type=danger");
        exit();
    }

    // Check if the new password is strong
    if (!isStrongPassword($newPassword)) {
        // Redirect with error message
        header("Location: forgot_password.php?message=Password must be at least 8 characters long and include at least one letter, one number, and one special character&type=danger");
        exit();
    }

    // Sanitize username
    $username = mysqli_real_escape_string($conn, $username);

    // Prepare SQL statement to check user role
    $stmt = $conn->prepare("SELECT role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows == 0) {
        // Redirect with error message
        header("Location: forgot_password.php?message=User  not found&type=danger");
        exit();
    }

    // Fetch the role
    $stmt->bind_result($role);
    $stmt->fetch();

    // Check user role (optional, based on your requirements)
    if ($role !== 'admin' && $role !== 'staff') {
        // Redirect with error message
        header("Location: forgot_password.php?message=Invalid user role&type=danger");
        exit();
    }

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Prepare SQL statement to update the password
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
    
    // Check if the statement was prepared successfully
    if ($stmt === false) {
        header("Location: forgot_password.php?message=Error preparing statement&type=danger");
        exit();
    }

    // Bind parameters
    $stmt->bind_param("ss", $hashedPassword, $username);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect with success message
        header("Location: office_login.php?message=Password updated successfully&type=success");
    } else {
        // Redirect with error message
        header("Location: forgot_password.php?message=Error updating password&type=danger");
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>