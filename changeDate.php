<?php

    include("database.php");

    date_default_timezone_set("Asia/Colombo");
    //$conn = mysqli_connect("localhost","root","","training");

    $datetime = $_POST['datetime'];
    $id = $_POST['id'];

    $Dt = new DateTime($datetime);
    $Dt = $Dt->format("Y-m-d H:i:s");
    //$dts = strlen($Dt);

    //$queryUpdate = "INSERT INTO test (test) VALUES ('$dts')";

    //if($conn->query($queryUpdate)=== TRUE){

    //}

    $queryUpdate = "UPDATE sheduleprogram SET enddate='$Dt' WHERE id = '$id'";

    
    if(mysqli_query($conn, $queryUpdate)){

    }else{
    //if(mysqli_query($conn, $queryUpdate)){

    //}else{

    }
?>