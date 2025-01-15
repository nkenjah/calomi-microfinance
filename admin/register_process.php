<?php
// Include database connection file
include("conn.php");

$message = "";
$type = "";

// Function to validate password
function isValidPassword($password) {
    // Check length
    if (strlen($password) < 8) {
        return false;
    }
    
    // Check for numbers
    if (!preg_match('/[0-9]/', $password)) {
        return false;
    }
    
    // Check for symbols
    if (!preg_match('/[\W_]/', $password)) {
        return false;
    }
    
    // Check for alphabets
    if (!preg_match('/[a-zA-Z]/', $password)) {
        return false;
    }
    
    return true;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    // Validate input
    if (empty($username) || empty($password) || empty($role)) {
        echo "All fields are required.";
        exit;
    }

    // Validate password
    if (!isValidPassword($password)) {
        $message = "Password must be at least 8 characters long, contain numbers, symbols, and alphabets.";
        $type = "danger";
        $conn->close();
        header("Location: register.php?message=" . urlencode($message) . "&type=" . urlencode($type));
        exit;
    }

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = "Username already exists";
        $type = "danger";
        $stmt->close();
        $conn->close();
        // Redirect with message
        header("Location: register.php?message=" . urlencode($message) . "&type=" . urlencode($type));
        exit;
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashedPassword, $role);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful!";
        // Redirect to a login page or another page
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>