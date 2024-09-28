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

// Get current user ID (assuming it is stored in session)
$current_user_id = $_SESSION['user_id'];

// Fetch earnings for the current user
$sql = "SELECT amount, description, date FROM earnings WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$result = $stmt->get_result();

$earnings = [];
while ($row = $result->fetch_assoc()) {
    $earnings[] = $row;
}

$stmt->close();
$conn->close();
?>

<!-- earnings.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Earnings</title>
</head>
<body>
    <div class="container">
        <h2>Your Earnings</h2>
        <table>
            <tr>
                <th>Amount</th>
                <th>Description</th>
                <th>Date</th>
            </tr>
            <?php foreach ($earnings as $earning): ?>
            <tr>
                <td><?php echo $earning['amount']; ?></td>
                <td><?php echo $earning['description']; ?></td>
                <td><?php echo $earning['date']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
