<?php
// Include TCPDF library
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

// Include database connection
include("conn.php");

// **Check if a client name is selected**
if (isset($_POST['client_name'])) {
    $selectedClientName = $_POST['client_name'];

    // **Fetch Transactions from Database for the Selected Client**
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
        WHERE 
            c.name = '$selectedClientName'
    ");

    if (!$result) {
        die("Database query failed: " . $conn->error);
    }

    // **Create a new PDF document**
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // **Set document information**
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Transactions Report for ' . $selectedClientName);
    $pdf->SetSubject('Transactions Report');
    $pdf->SetKeywords('TCPDF, PDF, Transactions, Report');

    // **Set header and footer fonts**
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // **Set default monospaced font**
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // **Set margins**
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // **Set auto page breaks**
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // **Set image scale factor**
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // **Add a page**
    $pdf->AddPage();

    // **Set font**
    $pdf->SetFont('helvetica', '', 10);

    // **Create the table content**
    $html = '<h1>Transactions Report for ' . $selectedClientName . '</h1>';
    $html .= '<table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Transaction ID</th>
                        <th>Client Name</th>
                        <th>Transaction Type</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>';

    // **Initialize a counter for the row number**
    $rowNumber = 1;

    // **Check if there are results**
    if ($result->num_rows > 0) {
        // **Fetch and Display Each Transaction**
        while ($row = $result->fetch_assoc()) {
            $html .= "<tr>
                        <td>{$rowNumber}</td>
                        <td>{$row['id']}</td>
                        <td>{$row['client_name']}</td>
                        <td>{$row['type']}</td>
                        <td>{$row['amount']}</td>
                      </tr>";
            // Increment the row number for the next iteration
            $rowNumber++;
        }
    } else {
        $html .= "<tr><td colspan='5'> No transactions found for this client.</td></tr>";
    }

    $html .= '</tbody></table>';

    // **Output the HTML content**
    $pdf->writeHTML($html, true, false, true, false, '');

    // **Close the Database Connection**
    $conn->close();

    // **Close and output PDF document**
    $pdf->Output('transactions_report_' . $selectedClientName . '.pdf', 'I');
} else {
    // Include necessary files
    include "linknice.php";
    include "headernice.php";
    include "sidebar.php";
    
    // Query to fetch client names from the database
    $clientResult = $conn->query("SELECT name FROM clients");
    
    // Check if the query was successful
    if ($clientResult) {
        // Start the form
        echo '
        <form method="POST" action="" class="mt-4 p-4 border rounded bg-light">
            <div class="mb-3">
                <label for="client_name" class="form-label">Select Client:</label>
                <select name="client_name" id="client_name" class="form-select">';
    
        // Loop through the client results and populate the dropdown
        while ($clientRow = $clientResult->fetch_assoc()) {
            echo '<option value="' . $clientRow['name'] . '">' . $clientRow['name'] . '</option>';
        }
    
        // Close the select and form
        echo '
                </select>
            </div>
            <input type="submit" value="Generate Report" class="btn btn-primary">
        </form>';
    } else {
        // Handle query error
        echo "Error fetching client data.";
    }
}
include "footernice.php";
    ?>