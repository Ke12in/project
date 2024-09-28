<?php
session_start();
$servername = "127.0.0.1:3307";
$username = "bank-rt";
$password = "Khristos@18";
$dbname = "project";
$user = $_SESSION['username'];

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch user data
$sql = "SELECT username, balance, phone, email FROM users WHERE username='$user'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $email = $row['balance'];
    $phone = $row['phone'];
    $balance = $row['email'];
} else {
    echo "No user found!";
}

$con->close();
?>

<!-- Add the HTML part from the earlier account.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Account Information</title>
</head>
<body>
    <div class="container">
        <h2>Account Information</h2>
        <div class="account-info">
            <p><strong>Username:</strong> <?php echo $username; ?></p>
            <p><strong>Balance:</strong> <?php echo number_format($balance, 2); ?></p>
            <p><strong>Phone Number:</strong> <?php echo $phone; ?></p>
            <p><strong>Email:</strong> $<?php echo $email; ?></p>
        </div>
        <a href="edit_account.html" class="button">Edit Account</a>
    </div>
</body>
</html>
