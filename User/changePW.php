<?php

    include("database.php");

    $userID = $_POST['userID'];
    $password = $_POST['password'];

    //$conn = mysqli_connect("localhost","root","","training");

    $updateQuery = "UPDATE logdetail SET Password = '$password' WHERE idUser = '$userID'";
    
    
    if ($conn->query($updateQuery) === TRUE) {
        $output = 'Succesfully updated..!';
        $data = array(
            'message'   => $output
        );
        echo    json_encode($data);
    }else{
        $output = 'Sorry..! Something went wrong..!';
        $data = array(
            'message'   => $output
        );
        echo    json_encode($data);
    }
?>