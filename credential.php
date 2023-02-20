<?php

    include("database.php");

    $sqlEmaiPW = "SELECT email, password FROM maildetails WHERE id = 1";
    $resultEmailPW = mysqli_query($conn,$sqlEmaiPW) or die(mysqli_error($conn));
    $emailPW = mysqli_fetch_array($resultEmailPW);
    $pw = $emailPW['password'];
    $email = $emailPW['email'];

    define('EMAIL', $email);
    define('PASS', $pw);
?>