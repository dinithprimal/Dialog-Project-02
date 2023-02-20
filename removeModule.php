<?php

    include("database.php");

    //$conn = mysqli_connect("localhost","root","","training");
    $mid = $_POST['idModule'];
    $id = $_POST['idProgram'];

    $sql2="DELETE FROM moduleprogramstatus WHERE idModule = '$mid' AND idprogram = '$id'";
    
    if(mysqli_query($conn, $sql2)) {
         
    }

    
     
?>