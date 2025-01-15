<?php
// Include the TCPDF library
include("vendor/autoload.php");

// Create a new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Staff List');
$pdf->SetSubject('Staff Data');
$pdf->SetKeywords('TCPDF, PDF, staff, list');

// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Staff List', 'Generated PDF');

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Add a page
$pdf->AddPage();

// Include database connection
include("conn.php");

// Prepare SQL statement to fetch data from the database
$sql = "SELECT name, phone, address, email, image FROM staff";
$result = $conn->query($sql);

// Check if there are results and display them
if ($result->num_rows > 0) {
    // Create HTML content for the PDF
    $html = '<h1>Staff List</h1>';
    $html .= '<table border="1" cellpadding="4">';
    $html .= '<tr><th>Name</th><th>Phone</th><th>Address</th><th>Email</th><th>Image</th></tr>';

    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($row['name']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['phone']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['address']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['email']) . '</td>';
        $html .= '<td><img src="' . htmlspecialchars($row['image']) . '" width="50"></td>';
        $html .= '</tr>';
    }
    $html .= '</table>';
} else {
    $html = '<h2>No staff members found.</h2>';
}

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('staff_list.pdf', 'I');

// Close the database connection
$conn->close();
?>