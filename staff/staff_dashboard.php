<?php
// Include necessary files
include("session_manager.php"); 

$timeout = 120;

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $message = "Tafadhali ingia kwenye mfumo ili kufikia ukurasa huu.";
    $type = "warning";
    header("Location: index.php?message=" . urlencode($message) . "&type=" . urlencode($type));
    exit;
}
?>
    <?php
     include("link.php");
     include("header.php");
     include("sidebar.php"); 
     ?>
    <script>
    var timeout = <?php echo $timeout; ?>;
    var inactivityTimeout = setTimeout(function() {
        window.location.href = 'index.php';
    }, timeout * 1000);

    // Reset the timeout on user activity
    document.onmousemove = function() {
        clearTimeout(inactivityTimeout);
        inactivityTimeout = setTimeout(function() {
            window.location.href = 'index.php';
        }, timeout * 1000);
    };

    document.onkeydown = function() {
        clearTimeout(inactivityTimeout);
        inactivityTimeout = setTimeout(function() {
            window.location.href = 'index.php';
        }, timeout * 1000);
    };
</script>

    <?php 
    include("footer.php"); 
    ?>