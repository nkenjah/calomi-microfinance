<?php
require_once 'conn.php';

// Query to retrieve profile image
$query = "SELECT profile_attachment FROM users WHERE id = ?";

// Prepare statement
$stmt = $conn->prepare($query);

// Bind parameters
$stmt->bind_param("i", $id);

// Set user ID
$id = 1; // Replace with the actual user ID

// Execute query
$stmt->execute();

// Get result
$result = $stmt->get_result();

// Fetch data
$data = $result->fetch_assoc();

// Close statement and connection
$stmt->close();
$conn->close();

// Check if image data exists
if ($data) {
    $profile_attachment = $data['profile_attachment'];
} else {
    $profile_attachment = null;
}
// Display profile image
if ($profile_attachment) {
    try {
        // Determine the image type
        $imageType = getimagesizefromstring($profile_attachment);
        if ($imageType === false) {
            throw new Exception('Unable to determine image type');
        }

        // Get the MIME type
        $mimeType = $imageType['mime'];

        // Encode the image data
        $encodedImage = base64_encode($profile_attachment);

        // Display the image
        echo '<img src="data:' . $mimeType . ';base64,' . $encodedImage . '" alt="Profile attachment" style="width: 35px; height: 35px; border-radius: 50%;">';
    } catch (Exception $e) {
        echo 'Error displaying profile image: ' . $e->getMessage();
    }
} else {
    echo 'No profile image found.';
}
?>