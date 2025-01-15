<?php
 // Ensure this is the very first line
// Redirect if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php?message=" . urlencode("Please log in to access this page.") . "&type=" . urlencode("warning"));
    exit();
}
require_once("fetch.php");
?>

    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
            <img src="Artboard 1@720x-8-2.png" alt="Logo" style="width: 280px; max-height: 120px;">  
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->
        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar -->
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle" href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <?php
include("conn.php");

// Fetch messages from database
$sql = "SELECT username, date, message FROM messages WHERE date >= DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 24 HOUR) ORDER BY date DESC LIMIT 8";
$result = mysqli_query($conn, $sql);

// Check if there are any messages
if (mysqli_num_rows($result) > 0) {
    // Display messages
    $messageCount = mysqli_num_rows($result);
    echo "
    <li class='nav-item dropdown'>
        <a class='nav-link nav-icon' href='#' data-bs-toggle='dropdown'>
            <i class='bi bi-chat-left-text'></i>
            <span class='badge bg-success badge-number'>$messageCount</span>
        </a><!-- End Messages Icon -->
        <ul class='dropdown-menu dropdown-menu-end dropdown-menu-arrow messages'>
            <li class='dropdown-header'>
              You have $messageCount new messages
              <a href='#'><span class='badge rounded-pill bg-primary p-2 ms-2'>View all</span></a>
            </li>
            <li>
              <hr class='dropdown-divider'>
            </li>
    ";

    while($row = mysqli_fetch_assoc($result)) {
        $username = $row["username"];
        $date = $row["date"];
        $message = $row["message"];

        // Display message
        echo "
        <li class='message-item'>
            <a href='#'>
                <i class='fas fa-envelope'></i>
                <div>
                  <h4>$username</h4>
                  <p>$message</p>
                  <p>$date</p>
                </div>
            </a>
        </li>
        <li>
            <hr class='dropdown-divider'>
        </li>
        ";
    }

    echo "
    <li class='dropdown-footer'>
      <a href='#'>Show all messages</a>
    </li>
    </ul><!-- End Messages Dropdown Items -->
    </li><!-- End Messages Nav -->
    ";
} else {
    echo "No messages found.";
}

// Close database connection
mysqli_close($conn);
?>

<!-- Add this JavaScript code to your HTML file -->
<script>
$(document).ready(function() {
    // Remove badge when dropdown toggle is clicked
    $('.nav-icon').on('click', function() {
        console.log('Dropdown toggle clicked');
        var badge = $(this).find('.badge-number');
        console.log('Badge element:', badge);
        badge.remove();
    });

    // Remove badge when a message is clicked
    $('.message-item').on('click', function() {
        console.log('Message item clicked');
        var badge = $('.nav-icon').find('.badge-number');
        console.log('Badge element:', badge);
        badge.remove();
    });
});
</script>
<li class="nav-item dropdown pe-3">
    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <?php echo '<img src="data:image/jpeg,jpg,png;base64,'.base64_encode($profile_attachment).'" alt="Profile attachment" style="width: 35px; height: 35px; border-radius: 50%;">'; ?>
        <span class="d-none d-md-block dropdown-toggle ps-2">
            <?php echo $_SESSION['username']; ?>
        </span>
    </a>
</li>
    </a><!-- End Profile Image Icon -->
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo $_SESSION['username']; ?></h6>
                            <span><?php echo $_SESSION['role']; ?></span> <!-- Display user role -->
                        </li>
                        <script type="application/json"></script>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="attach_profile.php">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                        <form action="attach_profile.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="profile_attachment">
                        <button type="submit">Attach Profile</button>
                        </form>
                     </li>
                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->
            </ul>
        </nav><!-- End Icons Navigation -->
    </header><!-- End Header -->
    <main id="main" class="main">

<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div><!-- End Page Title -->