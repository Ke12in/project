<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION["username"]; ?>!</h1>
    <p>You have successfully logged in.</p>
    <a href="account.php">View Account</a>
    <a href="logout.php">Logout</a>
</body>
</html>