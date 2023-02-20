<?php

    include("database.php");

    if(isset($_POST['insert'])){
        $div = $_POST['division'];

        $query = "INSERT INTO divisions (divitionName) VALUES ('$div')";
        if($conn->query($query)=== TRUE){
            
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
</head>
<body>
    <form action="insertDivision.php" method="post">
        <input type="text" name="division" />
        <input type="submit" name="insert" value="insert"/>
    </form>
</body>
</html>