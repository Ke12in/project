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

// Fetch referred users
$sql = "SELECT username, date FROM users u INNER JOIN referrals r ON u.id = r.referred_id WHERE r.referrer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$result = $stmt->get_result();

$team_members = [];
while ($row = $result->fetch_assoc()) {
    $team_members[] = $row;
}

$stmt->close();
$conn->close();
?>

<!-- teams.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Teams</title>
</head>
<body>
    <div class="container">
        <h2>Your Team</h2>
        <table>
            <tr>
                <th>Member Username</th>
                <th>Join Date</th>
            </tr>
            <?php foreach ($team_members as $member): ?>
            <tr>
                <td><?php echo $member['username']; ?></td>
                <td><?php echo $member['date']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
