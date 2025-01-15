<?php
require 'vendor/autoload.php'; // Include Composer's autoloader
include("conn.php"); // Include the database connection

// Fetch clients from the database
$result = $conn->query("SELECT * FROM clients");

$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Client Information', 0, 1, 'C');

// Add table
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(10, 10, '#', 1);
$pdf->Cell(40, 10, 'Name', 1);
$pdf->Cell(30, 10, 'Phone', 1);
$pdf->Cell(50, 10, 'Address', 1);
$pdf->Cell(30, 10, 'Loan Amount', 1);
$pdf->Cell(30, 10, 'Interest Rate', 1);
$pdf->Cell(30, 10, 'Loan Duration', 1);
$pdf->Cell(30, 10, 'Collateral', 1);
$pdf->Ln();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(10, 10, $row['id'], 1);
        $pdf->Cell(40, 10, $row['name'], 1);
        $pdf->Cell(30, 10, $row['phone'], 1);
        $pdf->Cell(50, 10, $row['address'], 1);
        $pdf->Cell(30, 10, $row['loan_amount'], 1);
        $pdf->Cell(30, 10, $row['interest_rate'], 1);
        $pdf->Cell(30, 10, $row['loan_duration'], 1);
        $pdf->Cell(30, 10, $row['collateral'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No clients found.', 1, 1, 'C');
}

// Output the PDF
$pdf->Output('Client_Information.pdf', 'D');
exit;
?>