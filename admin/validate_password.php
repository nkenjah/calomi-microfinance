<?php
session_start();
include("conn.php");

$password = $_POST['password'];
$user_id = $_SESSION['user_id']; // Assuming you store the logged-in user's ID in the session

// Query to fetch the user's password hash from the database
$query = "SELECT password FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($password_hash);
$stmt->fetch();
$stmt->close();

// Verify the password
if (password_verify($password, $password_hash)) {
    echo json_encode(['valid' => true]);
} else {
    echo json_encode(['valid' => false]);
}
?>