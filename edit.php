<?php
    require_once("connection.php"); 

    $UserID = $_GET['GetID'];

    $query = "SELECT * FROM signup WHERE user_id = '".$UserID."'";
    $results = mysqli_query($con, $query); 

    while($row = mysqli_fetch_assoc($results))
        {
            $UserID = $row['user_id'];
            $FirstName = $row['Username'];
            $LastName = $row['Email'];
            $Email = $row['Phone number'];
            $password = $row['Password']; 
        }        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Registration Form</title>
    <link rel="stylesheet" href="./signup.css">
</head>
<body>
    <div class="main">
        <h2>Reset your credentials</h2>
        <form action="update.php?GetID=<?php echo $UserID; ?>" method="post">
            <input type="hidden" name="user_id" value="<?php echo $UserID ?>">

            <div class="row">
                <div class="column">
                    <label for="first">Username:</label>
                    <input type="text" id="Username" name="Username" value="<?php echo $Username ?>" required>
                </div>
                <div class="column">
                    <label for="last">Email:</label>
                    <input type="text" id="Email" name="Email" value="<?php echo $Email ?>" required>
                </div>
            </div>
                <div class="column">
                    <label for="email">Phone number:</label>
                    <input type="tel" id="Phone number" name="Phone number" value="<?php echo $Phone number ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="column">
                    <label for="password">Password:</label>
                    <input type="password" id="Password" name="Password" pattern="^(?=.*\d)(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9])\S{8,}$" title="Password must contain at least one number, one alphabet, one symbol, and be at least 8 characters long" required>
                </div>
                <div class="column">
                    <label for="repassword">Re-type Password:</label>
                    <input type="password" id="Confirm Password" name="Confirm Password" required>
                </div>
            </div>
            <button type="submit" name="update">Reset</button>
        </form>
    </div>
</body>
</html>
