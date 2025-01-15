<?php
include("session_manager.php"); // Assuming this file contains the database connection

// Check if the user is logged in and has the role of either admin or staff
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'staff')) {
    header("Location: index.php"); // Redirect to login page
    exit();
}

include("conn.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $old_password = $_POST['password'];
    $new_password = $_POST['repeat_password'];
    $repeat_new_password = $_POST['repeat_password'];

    // Validate input
    if (empty($old_password) || empty($new_password) || empty($repeat_new_password)) {
        header("Location: change_pw.php?message=All fields are required&type=danger");
        exit();
    }

    if ($new_password !== $repeat_new_password) {
        header("Location: change_pw.php?message=New passwords do not match&type=danger");
        exit();
    }

    // Validate password strength
    $password_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    if (!preg_match($password_regex, $new_password)) {
        header("Location: change_pw.php?message=Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character&type=danger");
        exit();
    }

    // Fetch the currently logged-in user's details
    $logged_in_user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE id = ?");
    $stmt->bind_param("i", $logged_in_user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows == 0) {
        header("Location: change_pw.php?message=User  not found&type=danger");
        exit();
    }

    // Verify the old password
    if (!password_verify($old_password, $hashed_password)) {
        header("Location: change_pw.php?message=Old password is incorrect&type=danger");
        exit();
    }

    // Hash the new password
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database for the currently logged-in user
    $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $update_stmt->bind_param("si", $new_hashed_password, $logged_in_user_id);
    $update_stmt->execute();

    if ($update_stmt->affected_rows > 0) {
        header("Location: change_pw.php?message=Password updated successfully&type=success");
        exit();
    } else {
        header("Location: change_pw.php?message=Failed to update password&type=danger");
        exit();
    }

    $stmt->close();
    $update_stmt->close();
    $conn->close();
} else {
    header("Location: change_pw.php");
    exit();
}
?>