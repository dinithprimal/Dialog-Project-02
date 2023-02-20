<?php
    //require_once 'database.php';
    include("database.php");
    /*$dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "1234";
    $dbName = "training";

    $conn = mysqli_connect("localhost","root","","training");*/
    $err = '';
        

    if(isset($_POST['submit'])){
        $email = $_POST['email'];

        if($email != ""){

            $query = "select count(*) as total from user WHERE email='".$email."'";
            $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
            $rw = mysqli_fetch_array($result);

            if($rw['total'] == 1){

                $querySelUID = "SELECT idUser, fName FROM user WHERE email = '".$email."'";
                $resultQuerySelUID = mysqli_query($conn,$querySelUID) or die(mysqli_error($conn));
                $idUser = mysqli_fetch_array($resultQuerySelUID);
                $fname = $idUser['fName'];

                $str = "qwertyuiopasdfghjklzxcvbnm1234567890";
                $str = str_shuffle($str);
                $pw = substr($str,0,6);

                $queryUpdatePW = "UPDATE logdetail SET Password = '$pw' WHERE idUser = '".$idUser['idUser']."'";

                if ($conn->query($queryUpdatePW) === TRUE) {
                    //unset($_POST['save_programTrasup']);                    
                
                    $queryLogDetails = "SELECT Username, Password FROM logdetail WHERE idUser = '".$idUser['idUser']."'";
                    $resultQueryLogDetails = mysqli_query($conn,$queryLogDetails) or die(mysqli_error($conn));
                    $logDetails = mysqli_fetch_array($resultQueryLogDetails);

                    $userUserName = $logDetails['Username'];
                    $userPassword = $logDetails['Password'];

                    require 'PHPMailerAutoload.php';
                    require 'credential.php';

                    $mail = new PHPMailer;

                    $mail->SMTPDebug = 4;                               // Enable verbose debug output

                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = 'smtp.gmail.com';//smtp.office365.com';  // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = EMAIL;                 // SMTP username
                    $mail->Password = PASS;                           // SMTP password
                    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 587;                                    // TCP port to connect to

                    $mail->setFrom(EMAIL, 'GT - Trainings');
                    $mail->addAddress($email);     // Add a recipient
                                // Name is optional
                    
                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = 'Password Recovery';
                    $mail->Body    = 'Dear '.$fname.',<br><br>';
                    $mail->Body    .= 'Your password has been recovered!<br><br>';
                    $mail->Body    .= '<table>';
                    $mail->Body    .=   '<tr>';
                    $mail->Body    .=       '<td width="200">Username:</td><td>'.$userUserName.'</td>';
                    $mail->Body    .=   '</tr>';
                    $mail->Body    .=   '<tr>';
                    $mail->Body    .=       '<td>Password:</td><td>'.$userPassword.'</td>';
                    $mail->Body    .=   '</tr>';
                    $mail->Body    .= '</table>';
                    $mail->Body    .= '<br><br>';
                    $mail->Body    .= '<a href="http://172.26.59.67:4200/">Training Portal</a>';
                    $mail->Body    .= '<br><br>';
                    $mail->Body    .= 'Thank You';

                    if(!$mail->send()){
                        $out = 'Message could not be sent.';
                        $out .= 'Mailer Error: ' . $mail->ErrorInfo;
                        $err = "<div class='alert alert-danger text-center text-danger' role='alert'>Somthing happened wrong..! '".$out."'</div>";
                    }else{
                        echo "<script>location.href='recoverPW.php'</script>";
                    }

                }else{
                    $err = "<div class='alert alert-danger text-center text-danger' role='alert'>Somthing happened wrong..! Please try again.</div>";
                }
                

            }else if($rw['total'] == 0){

                $err = "<div class='alert alert-danger text-center text-danger' role='alert'>Your email was not registered with this system. Please contact <b class='text-dark'>System Aministration</b> to create a account</div>";
                
            }else{
                echo "<script>location.href='manyUserForgetPassword.php?email=".$email."'</script>";
            }
        }else{
            $err = "<div class='alert alert-danger text-center text-danger' role='alert'>Please enter email first...</div>";
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
                    <form class="form" action="forgetPassword.php" method="POST">
                        <?= $err ; ?>
                        <h3>Forgot Password..?</h3>                        
                        <div class="form-group mt-3">
                            <label for="email">Please enter your email address here for recover password</label>
                            <br>
                            <label for="email" class="text-danger font-weight-bold">Please enter your email address only in simple letters..!</label>
                            <input type="email" class="form-control" name="email" id="email" aria-describedby="usernameHelp">
                            <!--<small id="usernameHelp" class="form-text text-muted">Given in email</small>-->
                        </div>
                        <br>
                        <input type="submit" name="submit" class="btn btn-success btn-block" value="Send"/>
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