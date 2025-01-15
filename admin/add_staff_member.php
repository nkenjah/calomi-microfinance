<?php
include("init.php");

$timeout = 120;
include("linknice.php");
include("sidebar.php");
include("headernice.php");
?>
        <?php
                    if(!empty($_GET['message']) && !empty($_GET['type'])){
                      $message = $_GET['message'];
                      $type = $_GET['type'];
                      echo "<div class='alert alert-$type' role='alert'>$message</div>";
                    }
                    ?>
                    
            <form action="add_staff_process.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="image">Profile Image:</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div><br>
            <button type="submit" class="btn btn-primary">Add Staff Member</button>
        </form>
    </div>
    <?php
    include("footernice.php");
    ?>
