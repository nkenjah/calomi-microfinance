<?php
include("init.php");

$timeout = 120;
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include necessary files
include("linknice.php");
include("headernice.php");
include("sidebar.php");

// Define pagination variables
$limit = 10;
$page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT);
$page = max(1, $page);
$offset = ($page - 1) * $limit;

// Include database connection
include("conn.php");

try {
    // Fetch total number of transactions for pagination
    $totalResult = $conn->query("SELECT COUNT(*) AS total FROM transactions");
    if (!$totalResult) {
        throw new Exception("Database query failed: " . $conn->error);
    }
    $totalRow = $totalResult->fetch_assoc();
    $totalTransactions = $totalRow['total'];
    $totalPages = ceil($totalTransactions / $limit);

    // Fetch transactions from the database with limit and offset
    $stmt = $conn->prepare("
        SELECT 
            t.id, 
            c.name AS client_name, 
            t.type, 
            t.amount, 
            s.name AS staff_username,
            t.transaction_date,
            t.status
        FROM 
            transactions t
        INNER JOIN 
            clients c ON t.client_name = c.id
        LEFT JOIN 
            staff s ON t.staff_username = s.id
        ORDER BY t.transaction_date DESC
        LIMIT ? OFFSET ?
    ");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
    exit;
}

// Display messages
if (!empty($_GET['message']) && !empty($_GET['type'])) {
    $message = htmlspecialchars($_GET['message']);
    $type = htmlspecialchars($_GET['type']);
    echo "<div class='alert alert-$type' role='alert'>$message</div>";
}
?>

<div class="container mt-4">
    <h2 class="mb-4">Transaction Management</h2>
    <div class="table-responsive">
        <div class="mb-3">
            <input type="text" id="searchClient" class="form-control" placeholder="Search by Name, Phone, or Address...">
        </div>
        <table id="clientTable" class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Client Name</th>
                    <th scope="col">Transaction Type</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Staff Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rowNumber = $offset + 1;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $rowClass = ($row['type'] === 'loan') ? 'table-danger' : 'table-success';
                        $formattedAmount = number_format($row['amount'], 2);
                        $formattedDate = date("d-m-Y", strtotime($row['transaction_date']));

                        echo "<tr class='{$rowClass}'>
                                <td>{$rowNumber}</td>
                                <td>{$row['client_name']}</td>
                                <td>" . ucfirst($row['type']) . "</td>
                                <td>Tsh " . $formattedAmount . "</td>
                                <td>{$row['staff_username']}</td>
                                <td>{$formattedDate}</td>
                                <td>{$row['status']}</td>
                                <td>";

                        if ($row['type'] === 'loan' && $row['status'] !== 'approved') {
                            echo "<a href='approve_loan.php?id={$row['id']}' class='btn btn-sm btn-primary mr-2' onclick='return confirm(\"Are you sure you want to send an approval request for this loan?\");'>
                                    <i class='bi bi-check-circle'></i> Approve Loan
                                  </a>";
                        }

                        if ($row['type'] === 'repayment' && $row['status'] !== 'approved') {
                            echo "<a href='approve_repayment.php?id={$row['id']}' class='btn btn-sm btn-success mr-2' onclick='return confirm(\"Are you sure you want to approve this repayment?\");'>
                                    <i class='bi bi-check-circle'></i> Approve Repayment
                                  </a>";
                        }
                        
                        echo "<a href='delete_transaction.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this transaction?\");'>
                                <i class='bi bi-trash'></i> Delete
                            </a>
                                </td>
                              </tr>";
                        $rowNumber++;
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>No transactions found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<script>
    document.getElementById('searchClient').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#clientTable tbody tr');

        rows.forEach(row => {
            const columns = row.querySelectorAll('td');
            const name = columns[1].textContent.toLowerCase();
            const amount = columns[3].textContent.toLowerCase();
            const staffName = columns[4].textContent.toLowerCase();
            const date = columns[5].textContent.toLowerCase();
            const status = columns[6].textContent.toLowerCase();

            if (name.includes(searchTerm) || staffName.includes(searchTerm) || date.includes(searchTerm) || status.includes(searchTerm) || amount.includes(searchTerm)) {
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
include("footernice.php");
?>