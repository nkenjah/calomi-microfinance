<?php
include("init.php");

$timeout = 120;

include("linknice.php");
include("sidebar.php");
include("headernice.php");
?>
            <div class="card mb-3">
                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4"> Register staff account</h5>
                    <p class="text-center small">Enter staff details to register</p>
                  </div>

                  <form class="row g-3 needs-validation" novalidate action="register_process.php" method="POST">

                  <?php
                    if(!empty($_GET['message']) && !empty($_GET['type'])){
                      $message = $_GET['message'];
                      $type = $_GET['type'];
                      echo "<div class='alert alert-$type' role='alert'>$message</div>";
                    }
                    ?>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter username</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter password!</div>
                    </div>
                    <div class="col-12">
                      <label for="userRole" class="form-label">Role</label>
                      <select name="role" class="form-select" id="userRole" required>
                        <option value="" disabled selected>Select role</option>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                      </select>
                      <div class="invalid-feedback">Please select role!</div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Register</button>
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
include('autolog.php');
?>
<?php
include("footernice.php");
?>