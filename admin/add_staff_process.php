<?php
include("init.php");

$timeout = 120;
// Include database connection
include("conn.php");

$message = "";
$type = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = isset($_POST['name']) ? trim($_POST['name']) : null;
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : null;
    $address = isset($_POST['address']) ? trim($_POST['address']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;

    // Validate required fields
    if (empty($name) || empty($phone) || empty($address) || empty($email)) {
        $message = "All fields are required.";
        $type = "danger";
    } else {
        // Check if the email already exists
        $checkEmailSql = "SELECT * FROM staff WHERE email = ?";
        $checkEmailStmt = $conn->prepare($checkEmailSql);
        $checkEmailStmt->bind_param("s", $email);
        $checkEmailStmt->execute();
        $result = $checkEmailStmt->get_result();

        if ($result->num_rows > 0) {
            $message = "Email already exists. Please use a different email.";
            $type = "danger";
        } else {
            // Check if the image file is uploaded
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
                // Handle file upload
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check === false) {
                    $message = "File is not an image.";
                    $uploadOk = 0;
                }

                // Check file size (limit to 2MB)
                if ($_FILES["image"]["size"] > 2000000) {
                    $message = "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                    $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    $message = "Sorry, your file was not uploaded.";
                    $type = "danger";
                } else {
                    // Try to upload file
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        // Prepare SQL statement to insert data into the database
                        $sql = "INSERT INTO staff (name, phone, address, email, image) VALUES (?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("sssss", $name, $phone, $address, $email, $target_file);

                        // Execute the statement
                        if ($stmt->execute()) {
                            $message = "New staff member added successfully";
                            $type = "success"; 
                        } else {
                            $message = "Error: " . $stmt->error;
                            $type = "danger";
                        }

                        // Close the statement
                        $stmt->close();
                    } else {
                        $message = "Sorry, there was an error uploading your file.";
                        $type = "danger";
                    }
                }
            } else {
                $message = "No file uploaded or there was an upload error.";
                $type = "danger";
            }
        }

        // Close the email check statement
        $checkEmailStmt->close();
    }
}

// Display message to the user
if (!empty($message)) {
    header("Location: add_staff_member.php?message=" . urlencode($message) . "&type=" . urlencode($type));
}
?>
<?php
include('autolog.php');
?>
</body>
</html>
<?php include('footernice.php'); ?> 
