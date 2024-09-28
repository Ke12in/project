<?php
session_start();

// Database connection details
$servername = "127.0.0.1:3307";
$username = "bank-rt";
$password = "Khristos@18";
$dbname = "project";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Assuming user is logged in and user ID or username is stored in session
if (!isset($_SESSION['username'])) {
    echo "User is not logged in.";
    exit;
}

$current_user = $_SESSION['username'];

// Get the deposit amount, phone number, and payment method from the form
$amount = $_POST['amount'];
$phone_number = $_POST['phone_number'];
$payment_method = $_POST['payment_method'];

// Validate the deposit amount
if (empty($amount) || $amount <= 0) {
    echo "Invalid deposit amount.";
    exit;
}

// Trigger MoMo payment (pseudo-code; replace with actual API call)
if ($payment_method == 'momo') {
    // Example using fictional API
    $api_url = 'https://api.momo-provider.com/charge';
    $api_key = 'YOUR_API_KEY';

    $data = array(
        'amount' => $amount,
        'phone_number' => $phone_number,
        'currency' => 'USD', // Or your local currency
        'description' => 'Deposit to your account'
    );

    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/json\r\n" .
                         "Authorization: Bearer $api_key\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ),
    );

    $context  = stream_context_create($options);
    $response = file_get_contents($api_url, false, $context);

    if ($response === FALSE) { 
        die('Error initiating payment.');
    }

    $responseData = json_decode($response, true);

    // Handle response
    if ($responseData['status'] == 'success') {
        // Update the user's balance and log the transaction in your database
        $sql = "UPDATE users SET balance = balance + ? WHERE username = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ds", $amount, $current_user);
        
        if ($stmt->execute()) {
            $sql_log = "INSERT INTO transactions (username, amount, transaction_type, payment_method, date) VALUES (?, ?, 'deposit', ?, NOW())";
            $stmt_log = $con->prepare($sql_log);
            $stmt_log->bind_param("sds", $current_user, $amount, $payment_method);
            $stmt_log->execute();
            echo "Deposit successful!";
            header("Location: account.php");
            exit;
        } else {
            echo "Error processing deposit: " . $con->error;
        }
    } else {
        echo "Payment failed: " . $responseData['message'];
    }
} else {
    echo "Invalid payment method.";
}

$stmt->close();
$con->close();
?>
