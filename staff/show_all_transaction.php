<?php
include("session_manager.php");
include("conn.php"); // Include the database connection
include("link.php");
include("header.php");
include("sidebar.php");

// Check if the user is logged in and has the role of either admin or staff
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'staff')) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

// Fetch the username of the logged-in staff member
$sql = "SELECT username FROM users WHERE id = ? AND (role = 'staff' OR role = 'admin')";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($username);
    $stmt->fetch();
    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error);
}

// **Pagination Variables**
$limit = 20; // Number of transactions per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page number from URL
$offset = ($page - 1) * $limit; // Calculate offset for SQL query

// **Determine the Filter**
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// **Fetch Total Number of Transactions Based on Filter and Staff Member**
$totalSql = "SELECT COUNT(*) AS total FROM transactions WHERE created_by = ?"; 

if ($filter === 'today') {
    $totalSql .= " AND DATE(transaction_date) = CURDATE()";
} elseif ($filter === 'month') {
    $totalSql .= " AND MONTH(transaction_date) = MONTH(CURDATE()) AND YEAR(transaction_date) = YEAR(CURDATE())";
} elseif ($filter === 'year') {
    $totalSql .= " AND YEAR(transaction_date) = YEAR(CURDATE())";
}

$totalStmt = $conn->prepare($totalSql);
$totalStmt->bind_param("s", $username);
$totalStmt->execute();
$totalResult = $totalStmt->get_result();
$totalRow = $totalResult->fetch_assoc();
$totalTransactions = $totalRow['total']; // Total number of transactions
$totalPages = ceil($totalTransactions / $limit); // Calculate total pages for pagination
$totalStmt->close();

// **Fetch Transactions from Database for the Logged-in Staff Member**
$sql = "
    SELECT 
        c.name AS client_name,
        'loan' AS type,  -- Explicitly set type as 'loan'
        t.amount AS total_amount,
        (SELECT SUM(amount) FROM transactions WHERE client_name = c.id AND type = 'loan') AS total_loan,
        (SELECT SUM(amount) FROM transactions WHERE client_name = c.id AND type = 'repayment') AS total_repayment,
        (SELECT SUM(amount) FROM transactions WHERE client_name = c.id AND type = 'loan') - 
        (SELECT SUM(amount) FROM transactions WHERE client_name = c.id AND type = 'repayment') AS remaining_debt
    FROM 
        transactions t
    INNER JOIN 
        clients c ON t.client_name = c.id
    WHERE 
        t.created_by = ? AND t.type = 'loan'  -- Filter by loan transactions

    UNION ALL

    SELECT 
        c.name AS client_name,
        'repayment' AS type,  -- Explicitly set type as 'repayment'
        t.amount AS total_amount,
        (SELECT SUM(amount) FROM transactions WHERE client_name = c.id AND type = 'loan') AS total_loan,
        (SELECT SUM(amount) FROM transactions WHERE client_name = c.id AND type = 'repayment') AS total_repayment,
        (SELECT SUM(amount) FROM transactions WHERE client_name = c.id AND type = 'loan') - 
        (SELECT SUM(amount) FROM transactions WHERE client_name = c.id AND type = 'repayment') AS remaining_debt
    FROM 
        transactions t
    INNER JOIN 
        clients c ON t.client_name = c.id
    WHERE 
        t.created_by = ? AND t.type = 'repayment'  -- Filter by repayment transactions
";

if ($filter === 'today') {
    $sql .= " AND DATE(t.transaction_date) = CURDATE()";
} elseif ($filter === 'month') {
    $sql .= " AND MONTH(t.transaction_date) = MONTH(CURDATE()) AND YEAR(t.transaction_date) = YEAR(CURDATE())";
} elseif ($filter === 'year') {
    $sql .= " AND YEAR(t.transaction_date) = YEAR(CURDATE())";
}

$sql .= " GROUP BY c.id"; // Group by client only
$sql .= " LIMIT ? OFFSET ?"; // Use placeholders for limit and offset
$stmt = $conn->prepare($sql);
if ($stmt) {
    // Bind the username twice (once for each UNION ALL part) and then bind limit and offset
    $stmt->bind_param("ssii", $username, $username, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error);
}

$sql = "SELECT * FROM clients WHERE created_by = ?";
$clientStmt = $conn->prepare($sql);

if ($clientStmt) {
    $clientStmt->bind_param("s", $username);
    
    if ($clientStmt->execute()) {
        $resultClients = $clientStmt->get_result();
        $clients = $resultClients->fetch_all(MYSQLI_ASSOC);
    } else {
        // Handle execution error
        die("Error executing statement: " . $clientStmt->error);
    }
    
    $clientStmt->close();
} else {
    // Handle preparation error
    die("Error preparing statement: " . $conn->error);
}
?>
<!-- **Filter Buttons** -->
<h2>Transactions Registered by <?php echo htmlspecialchars($username); ?></h2>
<div class="filter-buttons">
    <a href="?filter=today&page=<?php echo $page; ?>" class ="btn btn-primary">Today</a>
    <a href="?filter=month&page=<?php echo $page; ?>" class="btn btn-primary">This Month</a>
    <a href="?filter=year&page=<?php echo $page; ?>" class="btn btn-primary">This Year</a>
</div><br>
<p><b>SEARCH HERE</b></p>
<div class="mb-1">
    <input type="text" id="searchTransaction" class="form-control" placeholder="Search by Name, type, or amount...">
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Client Name</th>
            <th scope="col">Transaction Type</th>
            <th scope="col">Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Initialize a counter for the row number
        $rowNumber = $offset + 1;

        if ($result->num_rows > 0) {
            // Fetch and Display Each Transaction
            while ($row = $result->fetch_assoc()) {
                // Determine the row class based on transaction type
                $rowClass = ($row['type'] === 'loan') ? 'table-danger' : 'table-success';
                
                echo "<tr class='{$rowClass}'>
                        <td>{$rowNumber}</td>
                        <td>" . htmlspecialchars($row['client_name']) . "</td>
                        <td>" . htmlspecialchars($row['type']) . "</td>
                        <td>" . htmlspecialchars($row['total_amount']) . "</td>
                      </tr>";
                // Increment the row number for the next iteration
                $rowNumber++;
            }
        } else {
            // Display a Contextual Message Based on the Filter
            $message = "No transactions recorded.";
            if ($filter === 'today') {
                $message = "No transactions recorded today.";
            } elseif ($filter === 'month') {
                $message = "No transactions recorded this month.";
            } elseif ($filter === 'year') {
                $message = "No transactions recorded this year.";
            }
            echo "<tr><td colspan='5'>{$message}</td></tr>";
        }
        ?>
    </tbody>
</table>
<!-- **Pagination Controls** -->
<?php if ($totalTransactions > 0): ?>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?filter=<?php echo $filter; ?>&page=<?php echo $page - 1; ?>">Previous</a> 
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?filter=<?php echo $filter; ?>&page=<?php echo $i; ?>" class="<?php echo ($i === $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
        
        <?php if ($page < $totalPages): ?>
            <a href="?filter=<?php echo $filter; ?>&page=<?php echo $page + 1; ?>">Next</a>
        <?php endif; ?>
    </div>
<?php endif; ?>
<script>
document.getElementById('searchTransaction').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.table tbody tr');

    rows.forEach(row => {
        const clientName = row.cells[1].textContent.toLowerCase();
        const transactionType = row.cells[2].textContent.toLowerCase();
        const amount = row.cells[3].textContent.toLowerCase();

        if (clientName.includes(searchTerm) || transactionType.includes(searchTerm) || amount.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
<?php
include("footer.php");
?>