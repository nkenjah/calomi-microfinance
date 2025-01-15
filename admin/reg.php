<?php
include("init.php");

$timeout = 120;
include("linknice.php");
include("headernice.php");
include("sidebar.php") ;
?>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!-- Navbar Link -->
  <ul class="nav">
    <li class="nav-item">
      <button class="nav-link" id="regStaffBtn" data-bs-toggle="modal" data-bs-target="#confirmModal">
        <i class="bi bi-person-fill-add"></i>
        <span>Reg staff in system</span>
      </button>
    </li>
  </ul>

  <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to add a staff member to the system? Enter your password to confirm.</p>
        <input type="password" id="adminPassword" class="form-control" placeholder="Enter your password">
        <p id="errorMessage" class="text-danger mt-2" style="display: none;">Incorrect password. Please try again.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="confirmBtn">OK</button>
      </div>
    </div>
  </div>
</div>

  <!-- Bootstrap JS (with Popper.js) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 <script>
document.getElementById('confirmBtn').addEventListener('click', function() {
    var password = document.getElementById('adminPassword').value;
    var errorMessage = document.getElementById('errorMessage');

    // Validate password via AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "validate_password.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.valid) {
                // Password is correct, redirect to register.php
                window.location.href = "register.php";
            } else {
                // Password is incorrect, show error message
                errorMessage.style.display = 'block';
            }
        }
    };
    xhr.send("password=" + encodeURIComponent(password));
});
</script>
<?php
include('autolog.php');
?>
<?php
include("footernice.php") ;
?>