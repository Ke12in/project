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

// Get the current user's username (assuming it is stored in session)
$current_user = $_SESSION['username'];

// Get form data
$new_username = $_POST['username'];
$new_email = $_POST['email'];
$new_phone = $_POST['phone'];

// Validate input (simple validation for example purposes)
if (empty($new_username) || empty($new_email) || empty($new_phone)) {
    echo "All fields are required.";
    exit;
}

// Update the user's information
$sql = "UPDATE users SET username = ?, email = ?, phone = ? WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $new_username, $new_email, $new_phone, $current_user);

if ($stmt->execute()) {
    // Update session username if it was changed
    $_SESSION['username'] = $new_username;
    echo "Account information updated successfully.";
    // Redirect to the account page (optional)
    header("Location: account.php");
    exit;
} else {
    echo "Error updating record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
