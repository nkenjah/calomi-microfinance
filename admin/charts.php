<?php
include("conn.php");

// Fetch loan and repayment data separately
$sql = "SELECT amount, transaction_date, type FROM transactions WHERE type IN ('loan', 'repayment')";
$result = $conn->query($sql);

$loanData = [];
$repaymentData = [];
$dates = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row['type'] == 'loan') {
            $loanData[] = $row['amount'];
        } elseif ($row['type'] == 'repayment') {
            $repaymentData[] = $row['amount'];
        }
        $dates[] = $row['transaction_date'];
    }
} else {
    echo "0 results";
}
$conn->close();
?>
   <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
    <div id="reportsChart"></div>

    <script>
        var loanData = <?php echo json_encode($loanData); ?>;
        var repaymentData = <?php echo json_encode($repaymentData); ?>;
        var dates = <?php echo json_encode($dates); ?>;

        document.addEventListener("DOMContentLoaded", () => {
            new ApexCharts(document.querySelector("#reportsChart"), {
                series: [{
                    name: 'Loan',
                    data: loanData,
                }, {
                    name: 'Repayment',
                    data: repaymentData
                }],
                chart: {
                    height: 350,
                    type: 'area',
                    toolbar: {
                        show: false
                    },
                },
                markers: {
                    size: 4
                },
                colors: ['#4154f1', '#2eca6a'],
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        opacityTo: 0.4,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                xaxis: {
                    type: 'datetime',
                    categories: dates
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy HH:mm'
                    },
                }
            }).render();
        });
    </script>
</body>
</html>