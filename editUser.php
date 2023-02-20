<?php

    include("database.php");

    //$conn = mysqli_connect("localhost","root","","training");

    $uid = $_POST['uid'];
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $division = $_POST['division'];
    $unit = $_POST['unit'];
    $empID = $_POST['empID'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    

   
    $queryUpdateUser ="UPDATE user SET fName='$fName',lName='$lName',Department='$division',unit='$unit',email='$email',empID='$empID',role='$role' WHERE idUser = '$uid'";
    $queryUpdateLogDetails = "UPDATE logdetail SET role='$role' WHERE idUser='$uid'";


    if(mysqli_query($conn, $queryUpdateUser)&&mysqli_query($conn, $queryUpdateLogDetails)){
        sleep(1);  
        
        
    }

    
     
?>