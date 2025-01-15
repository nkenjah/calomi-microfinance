// Initialize the Bootstrap modal
const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));

// Add click event listener to the delete button
document.getElementById('deleteStaffBtn').addEventListener('click', function () {
  const staffId = document.getElementById('staffSelect').value; // Get the selected staff ID
  if (!staffId) {
    alert("Please select a staff member to delete.");
    return;
  }
  deleteConfirmModal.show(); // Show the delete confirmation modal

  // Store the staff ID in a hidden input or variable for use in deletion
  document.getElementById('deleteConfirmBtn').setAttribute('data-staff-id', staffId);
});

// Handle the Delete button click
document.getElementById('deleteConfirmBtn').addEventListener('click', function () {
  const enteredPassword = document.getElementById('deleteAdminPassword').value;
  const staffId = this.getAttribute('data-staff-id'); // Retrieve the staff ID

  // Validate the password (replace with your actual validation logic)
  if (validatePassword(enteredPassword)) {
    window.location.href = "admin_dashboard.php?staff_id=" + staffId; // Redirect with staff ID
  } else {
    document.getElementById('deleteErrorMessage').style.display = 'block'; // Show error message
  }
});