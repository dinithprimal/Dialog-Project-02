<?php

    include("database.php");

    //$conn = mysqli_connect("localhost","root","","training");
    $mval = $_POST['valM'];
    $sel = "SELECT idModule FROM module WHERE moduleName = '$mval'";
    $result_sql = mysqli_query($conn,$sel) or die(mysqli_error($conn));
    $moduleId = mysqli_fetch_array($result_sql);
    $mid = $moduleId['idModule'];

    $sql2="DELETE FROM user_program_module WHERE idModule = '$mid'";
    
    if(mysqli_query($conn, $sql2)) {
        $sql="DELETE FROM module WHERE moduleName = '$mval'";
        if(mysqli_query($conn, $sql)){  
            
        }  
    }

    
     
?>