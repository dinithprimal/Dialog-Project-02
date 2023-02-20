<?php
    include("database.php");

    $divName = $_POST['divName'];

    $sql = "DELETE FROM divisions WHERE divitionName = '$divName'";

    if ($conn->query($sql) === TRUE) {
    } 
?>