<?php
// Configuration
include("conn.php");

// Debug: Check if database variables are defined
if (!isset($dbHost) || !isset($dbUser ) || !isset($dbPass) || !isset($dbName)) {
    die("Database connection variables are not defined in conn.php");
}

// Define backup directory
$backupDir = "backups";

// Create backup directory if it doesn't exist
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
}

// Backup database
$timestamp = date('Y-m-d_H-i-s');
$dbBackupFile = "$backupDir/db_backup_$timestamp.sql";
$command = "mysqldump --opt -h $dbHost -u $dbUser  -p$dbPass $dbName > $dbBackupFile";

// Debug: Print the command
echo "Command: $command\n";

// Execute the command
system($command, $output);

// Debug: Print the output
echo "Output: $output\n";

if ($output === 0) {
    echo "Backup of database completed: $dbBackupFile\n";
} else {
    echo "Failed to backup database. Check the command and permissions.\n";
}
?>
</body>
</html>
