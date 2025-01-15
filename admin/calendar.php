<?php
include("linknice.php");
include("headernice.php");
include("sidebar.php");
?>
<div class="col-12" id="calendar"></div>
<div id="messageBox" style="display:none;"><br>
    <div id="error-message" style="color: red;"></div>
    <input type="text" class="form-control" id="usernameInput" placeholder="Enter your name..."><br>
    <textarea class="form-control" id="messageInput" placeholder="Type your message here..."></textarea><br>
    <button class="btn btn-success w-100" type="submit" onclick="saveMessage()">Save</button>
</div>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            dateClick: function(info) {
                document.getElementById('messageBox').style.display = 'block';
                selectedDate = info.dateStr;
            }
        });
        calendar.render();
    });

    function saveMessage() {
    var username = document.getElementById('usernameInput').value.trim();
    var message = document.getElementById('messageInput').value.trim();
    var date = selectedDate;
    var errorMessage = document.getElementById('error-message');

    // Check for input required
    if (username === '') {
        errorMessage.innerText = 'Please enter your name!';
        return;
    }
    if (message === '') {
        errorMessage.innerText = 'Please enter a message!';
        return;
    }

    // Send data to the server using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "save_message.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            alert("Message saved!");
            errorMessage.innerText = '';
            document.getElementById('usernameInput').value = '';
            document.getElementById('messageInput').value = '';
        }
    };
    xhr.send("date=" + date + "&message=" + message + "&username=" + username);
}
</script>
<?php include("footernice.php"); ?>