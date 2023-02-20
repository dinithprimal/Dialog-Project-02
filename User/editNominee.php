<?php

    include("database.php");

    //$conn = mysqli_connect("localhost","root","","training");
    $nval = $_POST['valN'];
    $empID = $_POST['valEmpID'];
    $pID = $_POST['idProg'];
    

    $sql="DELETE FROM nominee WHERE Name = '$nval' AND empID = '$empID' AND idProgram = '$pID'";
    if(mysqli_query($conn, $sql)){  
        
    }
?>