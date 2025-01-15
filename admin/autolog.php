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