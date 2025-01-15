<?php
// linknice.php should contain your database connection code
include("conn.php");

session_start(); // Start a session to store user information

$message = "";
$type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($password)) {
        echo "Username and password are required.";
        exit;
    }

    // Prepare a SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the password (assuming passwords are hashed)
        if (password_verify($password, $user['password'])) {
            // Password is correct, log the user in
            $_SESSION['user_id'] = $user['id']; // Store user ID in session
            $_SESSION['username'] = $user['username']; // Store username in session
            $_SESSION['role'] = $user['role']; // Store user role in session

            //login successful
            $_SESSION['loggedin'] = true;
            
            // Redirect based on user role
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php"); // Redirect to admin dashboard
                exit;
            } else {
                // For any other role, redirect to a default page or show an error message
                $message = "Access denied. You do not have the required permissions.";
                $type = "danger";
            }
        } else {
            $message = "Invalid password";
            $type = "danger";
        }
    } else {
        $message = "No user found with that username";
        $type = "danger";
    }

    // Redirect with message
    header("Location: index.php?message=" . urlencode($message) . "&type=" . urlencode($type));
    exit();

    $stmt->close();
}
?>