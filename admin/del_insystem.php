<?php
include("init.php");

$timeout = 120;
include("linknice.php");
include("headernice.php");
include("sidebar.php");
include("autolog.php");
include("conn.php");

// Query to fetch staff members from the users table where role is 'staff'
$staff_query = "SELECT id, username FROM users WHERE role = 'staff'"; // Adjust the query as needed
$staff_result = $conn->query($staff_query);

// Check if the query was successful
if ($staff_result === false) {
    die("Error executing staff query: " . $conn->error);
}
?>
<h1>Remove staff in system</h1>
<?php
if(!empty($_GET['message']) && !empty($_GET['type'])){
    $message = $_GET['message'];
    $type = $_GET['type'];
    echo "<div class='alert alert-$type' role='alert'>$message</div>";
}
?>
<form method="POST" action="remove_staff_system.php" id="deleteForm">
    <div class="col-12">
        <label for="staff_id" class="form-label">Staff:</label>
        <select name="staff_id" id="staff_id" class="form-control" required>
            <option value="">Select a staff member</option>
            <?php while ($staff = $staff_result->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($staff['id']); ?>">
                    <?php echo htmlspecialchars($staff['username']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <div class="invalid-feedback">Please select a staff member!</div>
    </div>
    <br>
    <div class="col-12">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmationModal">
            Submit
        </button>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this staff member from the system?
                <div class="form-group">
                    <label for="password">Enter your password to confirm:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div id="passwordError" class="text-danger" style="display: none;">Incorrect password!</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>

<?php
include('footernice.php');
?>

<!-- JavaScript to handle the modal confirmation -->
 <script>
document.getElementById('confirmDelete').addEventListener('click', function() {
    var password = document.getElementById('password').value;
    var passwordError = document.getElementById('passwordError');

    // Validate password via AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "validate_password.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.valid) {
                // Password is correct, submit the form
                document.getElementById('deleteForm').submit();
            } else {
                // Password is incorrect, show error message
                passwordError.style.display = 'block';
            }
        }
    };
    xhr.send("password=" + encodeURIComponent(password));
});
</script>