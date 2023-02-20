<?php
    //require_once 'database.php';
    include("database.php");
    /*$dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "1234";
    $dbName = "training";

    $conn = mysqli_connect("localhost","root","","training");*/
    $err = '';
    
    session_start();

    if(isset($_SESSION['username'])){

        $userU = $_SESSION['username'];

        $queryUser = "select count(*) as total from logdetail WHERE Username='".$userU."'";
        $resultUser = mysqli_query($conn,$queryUser) or die(mysqli_error($conn));

        $rolequeryUser = "select role from logdetail WHERE Username='".$userU."'";
        $roleUser = mysqli_query($conn,$rolequeryUser) or die(mysqli_error($conn));

        $rw = mysqli_fetch_array($resultUser);
        $rolerw = mysqli_fetch_array($roleUser);

        if($rw['total'] > 0){            

            if($rolerw['role'] == 'Admin'){
                
                //session_start();
                //$_SESSION["username"] = $user;
                header("location: Dashboard.php");

            }else if($rolerw['role'] == 'User'){
                //session_start();
                //$_SESSION["username"] = $user;
                header("location: User/DashboardUser.php");
            }
            

        }else{

            $err = "<div class='alert alert-danger text-center text-danger' role='alert'>Username is Invalied!, Please Try Again..</div>";
            
        }
    }
        

    if(isset($_POST['submit'])){
        $user = $_POST['username'];
        $pass = $_POST['password'];

        $query = "select count(*) as total from logdetail WHERE Username='".$user."' AND Password='".$pass."'";
        $result = mysqli_query($conn,$query) or die(mysqli_error($conn));

        $rolequery = "select role from logdetail WHERE Username='".$user."' AND Password='".$pass."'";
        $role = mysqli_query($conn,$rolequery) or die(mysqli_error($conn));

        $rw = mysqli_fetch_array($result);
        $rolerw = mysqli_fetch_array($role);

        if($rw['total'] > 0){            

            if($rolerw['role'] == 'Admin'){
                
                //session_start();
                $_SESSION["username"] = $user;
                header("location: Dashboard.php");

            }else if($rolerw['role'] == 'User'){
                //session_start();
                $_SESSION["username"] = $user;
                header("location: User/DashboardUser.php");
            }
            

        }else{

            $err = "<div class='alert alert-danger text-center text-danger' role='alert'>Username or Password is Invalied!, Please Try Again..</div>";
            
        }
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
            <div class="row">            
                <div class="col-xl-4 col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
                <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-xs-12">                    
                    <form class="form" action="Login.php" method="POST">
                        <?= $err ; ?>
                        <h3>Login Here</h3>                        
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="username" class="form-control" name="username" id="username" aria-describedby="usernameHelp">
                            <!--<small id="usernameHelp" class="form-text text-muted">Given in email</small>-->
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="form-group">
                            <a href="forgetPassword.php" class="text-danger"><small class="text-danger">Forgot password..?</label></small></a>
                        </div>
                        <input type="submit" name="submit" class="btn btn-success btn-block" value="Login" />
                        <!--<small id="Help" class="form-text text-muted mt-4">*Username and Password are given in email</small>
                        <small id="Help" class="form-text text-muted">*Change the Username and Password once login</small>-->
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