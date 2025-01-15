<?php
include("init.php");

$timeout = 120;
// Include necessary files for database connection and layout
include("linknice.php");
include("headernice.php");
include("sidebar.php");

// **Pagination Variables**
$limit = 20; // Number of transactions per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page number from URL
$offset = ($page - 1) * $limit; // Calculate offset for SQL query

// **Database Connection**
include("conn.php");

// **Fetch Total Number of Transactions**
$totalResult = $conn->query("SELECT COUNT(*) AS total FROM transactions");
if (!$totalResult) {
    die("Database query failed: " . $conn->error);
}
$totalRow = $totalResult->fetch_assoc();
$totalTransactions = $totalRow['total']; // Total number of transactions
$totalPages = ceil($totalTransactions / $limit); // Calculate total pages for pagination

// **Fetch Transactions from Database**
$result = $conn->query("
    SELECT 
        t.id, 
        c.name AS client_name, 
        t.type, 
        t.amount, 
        s.name AS staff_username 
    FROM 
        transactions t
    INNER JOIN 
        clients c ON t.client_name = c.id
    LEFT JOIN 
        staff s ON t.staff_username = s.id
    LIMIT $limit OFFSET $offset
");

if (!$result) {
    die("Database query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction List</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file here -->
</head>
<body>
<div class="mb-3">
    <input type="text" id="searchClient" class="form-control" placeholder="Search by Name, Phone, or Address...">
</div>
<table class="table" id="clientTable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Transaction ID</th>
            <th scope="col">Client Name</th>
            <th scope="col">Transaction Type</th>
            <th scope="col">Amount</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Initialize a counter for the row number
        $rowNumber = $offset + 1;

        // **Check if there are results**
        if ($result->num_rows > 0) {
            // **Fetch and Display Each Transaction**
            while ($row = $result->fetch_assoc()) {
                // Determine the row class based on transaction type
                $rowClass = ($row['type'] === 'loan') ? 'table-danger' : 'table-success';
                
                echo "<tr class='{$rowClass}'>
                        <td>{$rowNumber}</td>
                        <td>{$row['id']}</td>
                        <td>{$row['client_name']}</td>
                        <td>{$row['type']}</td>
                        <td>{$row['amount']}</td>
                        <td>
                           <a href='delete_transaction.php?id={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this transaction?\");'>
                               <i class='bi bi-trash' style='width:20px; height:20px;'>delete</i>
                           </a>
                        </td>
                      </tr>";
                // Increment the row number for the next iteration
                $rowNumber++;
            }
        } else {
            echo "<tr><td colspan='6'>No transactions found.</td></tr>"; // Updated colspan
        }

        // **Close the Database Connection**
        $conn->close();
        ?>
    </tbody>
</table>
<script>
document.getElementById('searchClient').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#clientTable tbody tr');

    rows.forEach(row => {
        const clientName = row.cells[2].textContent.toLowerCase(); // Only search Client Name (3rd column)
        const transactionId = row.cells[1].textContent.toLowerCase(); // Search Transaction ID (2nd column)
        const transactionType = row.cells[3].textContent.toLowerCase(); // Search Transaction Type (4th column)
        const amount = row.cells[4].textContent.toLowerCase(); // Search Amount (5th column)

        if (clientName.includes(searchTerm) || transactionId.includes(searchTerm) || transactionType.includes(searchTerm) || amount.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
<button class="btn btn-primary" onclick="window.open('generate_pdf.php', '_blank')">Print to PDF</button>

<!-- **Pagination Controls** -->
<div class="pagination">
    <?php if ($page > 1): ?>
       <a href="?page=<?php echo $page - 1; ?>">Previous</a> 
    <?php endif; ?>
    
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>" class="<?php echo ($i === $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
    
    <?php if ($page < $totalPages): ?>
        <a href="?page=<?php echo $page + 1; ?>">Next</a>
    <?php endif; ?>
</div>

<!-- **Show All Button** -->
<div>
<?php
include('autolog.php');
?>
    <?php
    include("footernice.php");
    ?>
</div>
</body>
</html>