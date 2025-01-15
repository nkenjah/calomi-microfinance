<?php
session_start();
include("conn.php"); // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_name = $_POST['client_name'] ?? null;
    $type = $_POST['type'] ?? null;
    $amount = $_POST['amount'] ?? null;
    $staff_username = $_POST['staff_username'] ?? null;

    // Assuming you have a session or some way to identify the logged-in user
    if (!isset($_SESSION['user_id'])) {
        die("User  not logged in.");
    }
    $user_id = $_SESSION['user_id']; // Assuming the user ID is stored in the session

    // Fetch the username of the logged-in user from the database
    $sql = "SELECT username FROM users WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->fetch();
        $stmt->close();
    } else {
        die("Error fetching user data: " . $conn->error);
    }

    // Validate input
    if (empty($client_name) || empty($type) || empty($amount) || empty($staff_username)) {
        $message = "All fields are required!";
        $message_type = "danger";
    } elseif (!is_numeric($amount) || $amount <= 0) {
        $message = "Amount must be a number greater than zero!";
        $message_type = "danger";
    } else {
        // Check if the client already has a transaction
        $sql = "SELECT remaining_debt FROM transactions WHERE client_name = ? ORDER BY transaction_date DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $client_name);
        $stmt->execute();
        $stmt->bind_result($remaining_debt);
        $stmt->fetch();
        $stmt->close();

        // Calculate the new remaining debt
        if ($type === 'loan') {
            $new_remaining_debt = ($remaining_debt ?? 0) + $amount;
        } elseif ($type === 'repayment') {
            $new_remaining_debt = ($remaining_debt ?? 0) - $amount;
        } else {
            die("Invalid transaction type.");
        }

        // Insert the new transaction
        $sql = "INSERT INTO transactions (client_name, type, amount, remaining_debt, staff_username, created_by, transaction_date) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        // Bind parameters and execute the query
        $stmt->bind_param("ssddss", $client_name, $type, $amount, $new_remaining_debt, $staff_username, $username);
        if ($stmt->execute()) {
            $message = "Transaction recorded successfully!";
            $message_type = "success";
        } else {
            $message = "Error recording transaction: " . $stmt->error;
            $message_type = "danger";
        }

 // Close the statement
        $stmt->close();
    }

    // Redirect back to the form with a message
    header("Location: transaction_record.php?message=" . urlencode($message) . "&type=" . urlencode($message_type));
    exit();
} else {
    // If the form is not submitted, redirect back to the form
    header("Location: transaction_record.php");
    exit();
}

// Fetch transactions (this should only run if not handling a POST request)
$sql = "SELECT id AS transaction_id, client_name, type, amount, remaining_debt, staff_username, created_by, transaction_date 
        FROM transactions";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Transaction ID: " . $row["transaction_id"] . "<br>";
        echo "Client Name: " . $row["client_name"] . "<br>";
        echo "Type: " . $row["type"] . "<br>";
        echo "Amount: " . $row["amount"] . "<br>";
        echo "Remaining Debt: " . $row["remaining_debt"] . "<br>";
        echo "Staff Username: " . $row["staff_username"] . "<br>";
        echo "Created By: " . $row["created_by"] . "<br>";
        echo "Transaction Date: " . $row["transaction_date"] . "<br><br>";
    }
} else {
    echo "No transactions found.";
}

$conn->close();
?>