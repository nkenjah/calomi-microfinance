<?php
session_start(); // Start the session
include("session_manager.php");
include("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($password)) {
        header("Location: index.php?message=Username and password are required.&type=danger");
        exit();
    }

    // Prepare a SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    if (!$stmt) {
        header("Location: index.php?message=Database error. Please try again later.&type=danger");
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, log the user in
            $_SESSION['user_id'] = $user['id']; // Store user ID in session
            $_SESSION['username'] = $user['username']; // Store username in session
            $_SESSION['role'] = $user['role']; // Store user role in session
            $_SESSION['loggedin'] = true; // Mark user as logged in

            // Redirect based on role
            if ($user['role'] === 'admin' || $user['role'] === 'staff') {
                header("Location: staff_dashboard.php"); // Redirect to staff dashboard
                exit();
            } else {
                header("Location: index.php?message=Unknown role.&type=danger");
                exit();
            }
        } else {
            // Invalid password
            header("Location: index.php?message=Invalid password.&type=danger");
            exit();
        }
    } else {
        // No user found
        header("Location: index.php?message=No user found with that username.&type=danger");
        exit();
    }
}
?>