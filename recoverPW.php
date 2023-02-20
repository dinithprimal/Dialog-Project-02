<?php
    //require_once 'database.php';
    /*$dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "1234";
    $dbName = "training";

    $conn = mysqli_connect("localhost","root","","training");*/
    if(isset($_POST['loginhere'])){

        header("location: Login.php");

    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="title icon" href="images/title-img2.jpg">
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" 
        integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">-->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" 
        integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>

        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link rel="stylesheet" href="loginstyle.css">
        <title>Dashboard-Login</title>
    </head>
    <body>
        <div class="container-fluid bg">
            <h2 class="text-center pt-5">Training Programs Portal</h2>                
            <div class="row mt-5 pt-5">            
                <div class="col-xl-4 col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
                <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-xs-12" align="center">                    
                    <small>Your recovered password was sent to your email..!</small>
                </div>
                <div class="col-xl-4 col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
            </div>
            <div class="row mt-5 pt-5">            
                <div class="col-xl-4 col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
                <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-xs-12" align="center">
                    <form action="recoverPW.php" method="POST">
                        <button type="submit" class="btn btn-info" name="loginhere">Login Here</button>
                    </form>
                </div>
                <div class="col-xl-4 col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" 
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" 
        integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
        <!--<script src="script.js"></script>-->
    </body>
</html>