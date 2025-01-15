<?php
//database connection
$backupDir = 'backups'; // Directory where backups will be stored
$sourceDir = 'path/to/your/directory'; // Directory to back up
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "micro_finance";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
