<?php

    require 'PHPMailerAutoload.php';
    require 'credential.php';

    include("database.php");

    date_default_timezone_set("Asia/Colombo");
    //$conn = mysqli_connect("localhost", "root", "", "training");
    
    $query = '';
    if(isset($_POST["title"])){

        $title = $_POST["title"];
        $endDt = $_POST["endDt"];
        $mailSub = $_POST["mailSub"];
        $mes = $_POST["mes"];

        $edDt = new DateTime($endDt);
        $edDt = $edDt->format("Y-m-d H:i:s");

        $now = new DateTime();
        $now = $now->format("Y-m-d H:i:s");

        $query = "INSERT INTO sheduleprogram (remark, startdate, enddate, status, upStatus, active) VALUES ('$title','$now','$edDt','0', '0', '0')";

        if ($conn->query($query) === TRUE) {
            sleep(1);
            $querySelectUsers = "SELECT idUser, fName, email FROM user WHERE status = '1' AND role = 'User'";
            $resultSelectUsers = mysqli_query($conn,$querySelectUsers) or die(mysqli_error($conn));

            while($user = mysqli_fetch_array($resultSelectUsers)){
                sleep(1);

                $idUser = $user['idUser'];

                $querySelectUsersLog = "SELECT Username, Password FROM logdetail WHERE idUser = '$idUser'";
                $resultSelectUsersLog = mysqli_query($conn,$querySelectUsersLog) or die(mysqli_error($conn));
                $usersLog = mysqli_fetch_array($resultSelectUsersLog);

                $usernamelog = $usersLog['Username'];
                $userPassword = $usersLog['Password'];

                $fname = $user['fName'];
                $email = $user['email'];

                

                $mail = new PHPMailer;

                $mail->SMTPDebug = 4;                               // Enable verbose debug output

                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = EMAIL;                 // SMTP username
                $mail->Password = PASS;                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to

                $mail->setFrom(EMAIL);
                $mail->addAddress($email);     // Add a recipient
                            // Name is optional
                $mail->addReplyTo(EMAIL);
                
                $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = ''.$mailSub.'';
                $mail->Body    = 'Dear '.$fname.',<br><br>';
                $mail->Body    .= ''.$mes.'';
                $mail->Body    .= '<br>';
                $mail->Body    .= '<br>You can login to the portal bellow link<br><br>';
                $mail->Body    .= '<a href="http://172.26.59.67:4200/">Traing Portal</a>';
                $mail->Body    .= '<br>Your login details,';
                $mail->Body    .= '<br>Username = '.$usernamelog.'';
                $mail->Body    .= '<br>Password = '.$userPassword.'';
                $mail->Body    .= '<br><br>Thank You';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                if(!$mail->send()){
                    echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
                }else{
                    
                    continue;
                }
            }

            
        }
        
    }
    





?>