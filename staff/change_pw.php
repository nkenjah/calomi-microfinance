<?php
include("session_manager.php");

// Check if the user is logged in and has the role of either admin or staff
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'staff')) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

$user_id = $_SESSION['user_id'];
?>
<?php
include("link.php");
include("header.php");
include("sidebar.php");
?>
<div class="card mb-3">
<div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">CHANGE YOUR PASSWORD</h5>
                  </div>

                  <?php
                    if(!empty($_GET['message']) && !empty($_GET['type'])){
                      $message = $_GET['message'];
                      $type = $_GET['type'];
                      echo "<div class='alert alert-$type' role='alert'>$message</div>";
                    }
                    ?>

                  <form class="row g-3 needs-validation" method="POST" action="change_pw_process.php" novalidate>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Old Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your old password!</div>
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Enter new Password</label>
                      <input type="password" name="repeat_password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please your new password!</div>
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Repeat new Password</label>
                      <input type="password" name="repeat_password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please repeat new password!</div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Submit</button>
                    </div>
                    <div class="col-12">
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

<?php
include("footer.php");
?>