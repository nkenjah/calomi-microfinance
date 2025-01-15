<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to login page
    header("Location: office_login.php?message=" . urlencode("Please log in to access this page.") . "&type=" . urlencode("warning"));
    exit();
}
?>
