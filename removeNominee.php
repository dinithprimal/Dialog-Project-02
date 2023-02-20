<?php

    include("database.php");

    //$conn = mysqli_connect("localhost","root","","training");
    $nid = $_POST['idNominee'];
    $id = $_POST['idProgram'];

    $sql2="DELETE FROM nomineeprogramstatus WHERE idNominee = '$nid' AND idprogram = '$id'";
    
    if(mysqli_query($conn, $sql2)) {
         
    }

    
     
?>