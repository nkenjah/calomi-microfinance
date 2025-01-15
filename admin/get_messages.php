<?php
include("conn.php");

$sql = "SELECT date, message FROM messages";
$result = $conn->query($sql);

$events = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $events[] = array(
            'title' => $row['message'],
            'start' => $row['date']
        );
    }
}

header('Content-Type: application/json');
echo json_encode($events);

$conn->close();
?>