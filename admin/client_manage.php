<?php
include("init.php");

$timeout = 120;
include("headernice.php");
include("sidebar.php");
include("linknice.php");
?>
           <?php
                    if(!empty($_GET['message']) && !empty($_GET['type'])){
                      $message = $_GET['message'];
                      $type = $_GET['type'];
                      echo "<div class='alert alert-$type' role='alert'>$message</div>";
                    }
                    ?>
<div>
</div>
<br>
<div class="mb-3">
    <input type="text" id="searchClient" class="form-control" placeholder="Search by Name, Phone, or Address...">
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Phone</th>
            <th scope="col">Address</th>
            <th scope="col">Loan Amount</th>
            <th scope="col">Interest Rate</th>
            <th scope="col">Loan Duration</th>
            <th scope="col">Collateral</th>
            <th scope="col">Image</th>
            <th scope="col">Actions</th> <!-- New column for actions -->
        </tr>
    </thead>

    <?php
    // Include database connection
    include("conn.php");
    
     
    // Prepare SQL statement to fetch data from the database
    $sql = "SELECT id, name, phone, address, loan_amount, interest_rate, loan_duration, collateral, client_image FROM clients"; // Include 'id' for actions
    $result = $conn->query($sql);

    // Initialize a counter for row numbers
    $rowNumber = 1;

    // Check if there are results and display them
    if ($result->num_rows > 0) {
        // Output data for each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $rowNumber . "</td>"; // Display the row number
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
            echo "<td>" . htmlspecialchars($row['address']) . "</td>";
            echo "<td>" . htmlspecialchars($row['loan_amount']) . "</td>";
            echo "<td>" . htmlspecialchars($row['interest_rate']) . "</td>";
            echo "<td>" . htmlspecialchars($row['loan_duration']) . "</td>";
            echo "<td>" . htmlspecialchars($row['collateral']) . "</td>";
            echo "<td><img src='" . htmlspecialchars($row['client_image']) . "' alt='Image' width='100'></td>";
            echo "<td>
                    <a href='edit_client.php?id=" . $row['id'] . "' class='btn btn-warning'>Edit</a>
                    <a href='delete_client.php?id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this client?\");'>Delete</a>
                  </td>"; // Edit and Delete buttons
            echo "</tr>";
            
            // Increment the row number for the next iteration
            $rowNumber++;
        }
    } else {
        echo "<tr><td colspan='7'>No clients found.</td></tr>"; // Adjusted colspan
    }
    

    // Close the database connection
    $conn->close();
    ?>
</table>
<script>
document.getElementById('searchClient').addEventListener('input', function() {
    // Get the search input value and convert it to lowercase for case-insensitive comparison
    var searchValue = this.value.toLowerCase();

    // Get all the rows in the table body
    var rows = document.querySelectorAll('table tbody tr');

    // Loop through each row
    rows.forEach(function(row) {
        // Get the text content of the row and convert it to lowercase
        var rowText = row.textContent.toLowerCase();

        // Check if the row text contains the search value
        if (rowText.includes(searchValue)) {
            // If it does, display the row
            row.style.display = '';
        } else {
            // If it doesn't, hide the row
            row.style.display = 'none';
        }
    });
});
</script>
<?php
include('autolog.php');
?>
<?php
include("footernice.php");
?>

