<?php
// Include database connection
include("conn.php"); // Make sure to create this file for database connection

$message = "";
$type = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $loan_amount = $_POST['loan_amount'];
    $interest_rate = $_POST['interest_rate'];
    $loan_duration = $_POST['loan_duration'];
    $collateral = $_POST['collateral'];
    $created_by = $_POST['created_by'];

   // Assuming you have a session or some way to identify the logged-in user
   include("session_manager.php");
   $user_id = $_SESSION['user_id']; // Assuming the user ID is stored in the session
   
   // Fetch the username from the database
   $sql = "SELECT username FROM users WHERE id = ? AND role = 'staff'";
   if ($stmt = $conn->prepare($sql)) {
       $stmt->bind_param("i", $user_id);
       $stmt->execute();
       $stmt->bind_result($username);
       $stmt->fetch();
       $stmt->close();
   }
 
    // Handle file upload for client image
    $target_dir = "uploads/"; // Directory to save uploaded images
    $target_file = $target_dir . basename($_FILES["client_image"]["name"]);

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file input exists and is not empty
    if (isset($_FILES["client_image"]) && $_FILES["client_image"]["error"] == UPLOAD_ERR_OK) {
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["client_image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $message = "File is not an image.";
            $type = "danger";
            $uploadOk = 0;
        }

        // Check file size (limit to 2MB)
        if ($_FILES["client_image"]["size"] > 2000000) {
            $message = "Sorry, your file is too large.";
            $type = "danger";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $type = "danger";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $message = "Sorry, your file was not uploaded.";
            $type = "danger";
        } else {
            // If everything is ok, try to upload file
            if (move_uploaded_file($_FILES["client_image"]["tmp_name"], $target_file)) {
                // Prepare SQL statement to insert client data
                $sql = "INSERT INTO clients (name, phone, address, loan_amount, interest_rate, loan_duration, collateral, client_image, created_by) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

                // Prepare and bind
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("sssdiddss", $name, $phone, $address, $loan_amount, $interest_rate, $loan_duration, $collateral, $target_file, $created_by);

                    // Execute the statement
                    if ($stmt->execute()) {
                        $message = "New client added successfully.";
                        $type = "success";
                    } else {
                        echo "Error: " . $stmt->error;
                    }

                   

                    // Close statement
                    $stmt->close();
                } else {
                    $message = "Error preparing statement: " . $conn->error;
                    $type = "error";
                }
            } else {
                $message = "Sorry, there was an error uploading your file.";
                $type = "error";
            }
        }
    } else {
        $message = "No file uploaded or there was an upload error.";
        $type = "error";
    }

    // Header for message
    header("location: register_client.php?message=" . urldecode($message) . "&type=" . urldecode($type));
    
    // Close database connection
    $conn->close();
}
?>