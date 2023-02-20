<?php

    include("database.php");

    //$conn = mysqli_connect("localhost","root","","training");
    $err = '';

    $status_query = "SELECT * FROM notify WHERE nt_status=0";
    $result_query = mysqli_query($conn,$status_query);
    $count = mysqli_num_rows($result_query);

    if($count==0){
        $count = '';
    }
    echo $count;
?>