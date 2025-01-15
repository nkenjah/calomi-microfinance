<!-- Modal for delete confirmation -->
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteConfirmModalLabel">Confirmation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this staff member from the system? Enter your password to confirm.</p>
          <input type="password" id="deleteAdminPassword" class="form-control" placeholder="Enter your password">
          <p id="deleteErrorMessage" class="text-danger mt-2" style="display: none;">Incorrect password. Please try again.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="deleteConfirmBtn">Delete</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <script src="del.js"></script>
 <?php
include("footernice.php"); 
?>
</body>
</html>