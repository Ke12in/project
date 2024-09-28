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
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
$email = $_POST['email'];
$phone = $_POST['phone'];
$referral_code = $_POST['referral_code'];

// Check if the referral code is valid
$referred_by = null;
if (!empty($referral_code)) {
    $sql = "SELECT id FROM users WHERE referral_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $referral_code);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $referred_by = $row['id'];
    }
    $stmt->close();
}

// Insert the new user
$referral_code_user = uniqid(); // Generate a unique referral code for the new user
$sql = "INSERT INTO users (username, password, email, phone, referral_code, referred_by) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $username, $password, $email, $phone, $referral_code_user, $referred_by);

if ($stmt->execute()) {
    // If the user was referred by someone, log the referral
    if ($referred_by) {
        $sql_referral = "INSERT INTO referrals (referrer_id, referred_id) VALUES (?, ?)";
        $stmt_referral = $conn->prepare($sql_referral);
        $stmt_referral->bind_param("ii", $referred_by, $stmt->insert_id);
        $stmt_referral->execute();
        $stmt_referral->close();

        // Update earnings for the referrer
        $earnings_amount = 10; // Example amount earned for referral
        $description = "Referral Bonus";
        $sql_earnings = "INSERT INTO earnings (user_id, amount, description) VALUES (?, ?, ?)";
        $stmt_earnings = $conn->prepare($sql_earnings);
        $stmt_earnings->bind_param("ids", $referred_by, $earnings_amount, $description);
        $stmt_earnings->execute();
        $stmt_earnings->close();
    }

    echo "Registration successful!";
    // Redirect to login page (optional)
    header("Location: login.php");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
