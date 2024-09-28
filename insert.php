<?php
require_once("connection.php"); 

if (isset($_POST['Signup'])) 
{
    if (empty($_POST['Username']) || empty($_POST['Email']) || empty($_POST['Phone number']) || empty($_POST['Password'])  || empty($_POST['Confirm Password'])) 
    {
        echo "PLEASE FILL OUT ALL FIELDS";
    } 
    else 
    {

        $first = mysqli_real_escape_string($con, $_POST['Username']); 
        $last = mysqli_real_escape_string($con, $_POST['Email']);
        $email = mysqli_real_escape_string($con, $_POST['Phone number']);
        $password = mysqli_real_escape_string($con, $_POST['Password']);
        $repassword = mysqli_real_escape_string($con, $_POST['Confirm Password']);
     
        if ($password !== $Confirm password) 
        {
            echo "Passwords do not match!";
        } 
        else 
        {

            $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO signup (Username, Email, Phone number, Password) VALUES ('$Username', '$Email', '$Phone number', '$hashedpassword')";
            $results = mysqli_query($con, $query);

            if ($results) 
            {

                header("Location: view.php");
                exit();
            } 
            else 
            {
                echo "There was an error: " . mysqli_error($con);
            }
        }
    }
} 
else 
{
    header("location: signup(main).html");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    // Generate a random 6-digit verification code
    $verificationCode = rand(100000, 999999);

    // Set up the email
    $subject = "Your Verification Code";
    $message = "Your verification code is: " . $verificationCode;
    $headers = "From: your-email@example.com"; // Replace with your own email

    // Send the email
    if (mail($email, $subject, $message, $headers)) {
        echo "Registration successful! Please check your email for the verification code.";
    } else {
        echo "Error sending email. Please try again.";
    }
}

?>
