<?php
include("init.php");
$timeout = 120;

include("linknice.php");
include("sidebar.php");
include("headernice.php");
include("conn.php");

// Correct SQL query to fetch all client data
$sql = "SELECT name, phone, address, client_image FROM clients";
$result = mysqli_query($conn, $sql);

// Start the table
echo '<table id="clientTable" class="table table-striped">
    <div class="mb-3">
        <input type="text" id="searchClient" class="form-control" placeholder="Search by Name, Phone, or Address...">
    </div>
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Client Name</th>
            <th scope="col">Phone</th>
            <th scope="col">Address</th>
            <th scope="col">Image</th>
        </tr>
    </thead>
    <tbody>';

// Loop through the results and display each row
$count = 1;
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>
            <th scope="row">' . $count . '</th>
            <td>' . htmlspecialchars($row['name']) . '</td>
            <td>' . htmlspecialchars($row['phone']) . '</td>
            <td>' . htmlspecialchars($row['address']) . '</td>
            <td><img src="' . htmlspecialchars($row['client_image']) . '" alt="Client Image" style="width:100px; height:auto;"></td>
          </tr>';
    $count++;
}

// Close the table
echo '</tbody></table>';

?>

<script>
    document.getElementById('searchClient').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#clientTable tbody tr');

        rows.forEach(row => {
            const name = row.cells[1].textContent.toLowerCase();
            const phone = row.cells[2].textContent.toLowerCase();
            const address = row.cells[3].textContent.toLowerCase();

            if (name.includes(searchTerm) || phone.includes(searchTerm) || address.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
<?php
include('autolog.php');
?>
<?php
include('footernice.php');
?>