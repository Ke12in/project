<?php
session_start();

// Database connection details
$servername = "127.0.0.1:3307";
$username = "bank-rt";
$password = "Khristos@18";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data

$amount = $_POST['amount'];
$method = $_POST['method'];
$account = $_POST['account'];

// Fetch user's current balance
$sql_balance = "SELECT balance FROM users WHERE id = ?";
$stmt_balance = $conn->prepare($sql_balance);
$stmt_balance->bind_param("i", $user_id);
$stmt_balance->execute();
$result = $stmt_balance->get_result();
$row = $result->fetch_assoc();
$current_balance = $row['balance'];
$stmt_balance->close();

// Check if user has sufficient balance
if ($amount > $current_balance) {
    echo "Insufficient balance!";
    exit;
}

// Deduct the amount from user's balance
$new_balance = $current_balance - $amount;
$sql_update = "UPDATE users SET balance = ? WHERE id = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("di", $new_balance, $user_id);
$stmt_update->execute();
$stmt_update->close();

// Insert withdrawal record (optional, if you want to track withdrawals)
$sql_withdraw = "INSERT INTO withdrawals (user_id, amount, method, account) VALUES (?, ?, ?, ?)";
$stmt_withdraw = $conn->prepare($sql_withdraw);
$stmt_withdraw->bind_param("idss", $user_id, $amount, $method, $account);
$stmt_withdraw->execute();
$stmt_withdraw->close();

$conn->close();

echo "Withdrawal successful!";
?>
