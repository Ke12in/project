<?php
    require_once("connection.php"); 
    $query = "SELECT * FROM signup";
    $result = mysqli_query($con, $query); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Registration Page</title>
    <link rel="stylesheet" href="./signup.css">
</head>
<body>
    <div class="main">
        <div class="header">
            <h2>View Page</h2>
            <button type="button" name="submit" onclick="window.location.href='view.php'">+ Add New Record</button>
        </div>
        <P></p>
        <div class="table-container">
            <table>
                <tr>
                    <th>id</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone number</th>
                    <th>Action</th>
                </tr>  
                <?php
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $UserID = $row['id'];
                        $FirstName = $row['Username'];
                        $LastName = $row['Email'];
                        $Email = $row['Phone number'];
                        ?>

                        <tr>
                            <td><?php echo $id ?></td>
                            <td><?php echo $Username ?></td>
                            <td><?php echo $Email ?></td>
                            <td><?php echo $Phone number ?></td>
                            <td>
                            <button class="action-btn"><a href="edit.php?GetID=<?php echo $UserID?>">Edit</a></button>
                            </td>
                        </tr>
                        <?php
                    }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
