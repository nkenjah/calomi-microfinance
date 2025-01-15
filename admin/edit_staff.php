<?php
include("init.php");

$timeout = 120;
// Include database connection
include ("conn.php");

$message = "";
$type = "";

// Check if ID is set
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure ID is an integer

    // Fetch staff member details from the database
    $query = "SELECT * FROM staff WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $staff = $result->fetch_assoc();
    } else {
        $message = "No staff member found.";
        $type = "danger";
    }
} else {
    $message = "ID not provided. Please provide a valid ID in the URL.";
    $type = "danger";
}

// Handle form submission for editing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    
    // Handle image upload
    $imagePath = $staff['image']; // Default to current image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "uploads/"; // Ensure this directory exists and is writable
        $imagePath = $targetDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
    }

    // Update staff member in the database
    $updateQuery = "UPDATE staff SET name = ?, phone = ?, address = ?, email = ?, image = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("sssssi", $name, $phone, $address, $email, $imagePath, $id);
    
    if ($updateStmt->execute()) {
        $message = "Staff member updated successfully.";
        $type = "success";
    } else {
        $message = "Error updating staff member: " . $conn->error;
        $type = "danger";
    }

    // Redirect to the same page with the message
    header("Location: edit_staff.php?id=$id&message=" . urlencode($message) . "&type=$type");
    exit;
}
?>

<?php
include ("linknice.php");
include ("headernice.php");
include ("sidebar.php");
?>

<!-- Display Message -->
<?php
if(!empty($_GET['message']) && !empty($_GET['type'])){
    $message = $_GET['message'];
    $type = $_GET['type'];
    echo "<div class='alert alert-$type' role='alert'>$message</div>";
}
?>
<div class="mb-3">
    <input type="text" id="searchClient" class="form-control" placeholder="Search by Name, Phone, or Address...">
</div>
<!-- HTML Form for Editing Staff -->
<form method="POST" class="staff-form" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($staff['name']); ?>" required>
    </div>
    
    <div class="form-group">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($staff['phone']); ?>" required>
    </div>
    
    <div class="form-group">
        <label for="address" class="form-label">Address</label>
        <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($staff['address']); ?>" required>
    </div>
    <div class="form-group">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($staff['email']); ?>" required>
    <div class="invalid-feedback">Please enter a valid email.</div>
</div>
    
    <div class="form-group">
        <label for="image" class="form-label">Current Image:</label>
        <div>
            <img src="<?php echo htmlspecialchars($staff['image']); ?>" alt="Current Image" style="max-width: 100px; max-height: 100px;">
        </div>
        <label for="image" class="form-label">Change Image:</label>
        <input type="file" id="image" name="image" class="form-control">
        <div class="invalid-feedback">Please change the image.</div>
    </div>
    <br>
    <div>
        <button type="submit" class="btn btn-primary">Update Staff</button>
    </div>
</form>
<?php
include('autolog.php');
?>
<?php
include ("footernice.php");
?>