<?php
    include("database.php");

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $password = $_POST['password'];


    $sqlValidate = "UPDATE maildetails SET password = '$password' WHERE id = 1";
    if($conn->query($sqlValidate) === TRUE){
        $data = 'true';
    }else{
        $data = 'false';
    }

    echo $data;
?>