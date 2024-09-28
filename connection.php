<?php
    $con = new mysqli("127.0.0.1:3307", "kel-rt", "Khristos@18", "project");
    
    if(!$con){
        die("Connection Error").mysqli_error();
    }
?>

