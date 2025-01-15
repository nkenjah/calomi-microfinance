<?php
//database connection
$backupDir = 'backups'; // Directory where backups will be stored
$sourceDir = 'path/to/your/directory'; // Directory to back up
$dbHost = "localhost"; // Replace with your database host
$dbUser  = "root";      // Replace with your database username
$dbPass = "";  // Replace with your database password
$dbName = "micro_finance";    // Replace with your database name

$conn = new mysqli($dbHost, $dbUser, $dbPass,$dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
