<?php
    include("database.php");

    require 'PHPMailerAutoload.php';

    require 'credential.php';

    date_default_timezone_set("Asia/Colombo");

    $data = '';

    $email = $_POST['email'];
    $firstName = $_POST['fName'];



        $mail = new PHPMailer;
        //$mail->SMTPDebug = 4; 
        $mail->SMTPDebug = false;                                // Disable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = EMAIL;                 // SMTP username
        $mail->Password = PASS;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom(EMAIL, 'GT - Trainings');
        $mail->addAddress($email);     // Add a recipient
                    
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'GT - Trainings : Test Mail';
        $mail->Body   = '<small>Dear '.$firstName.',</small><br><br>';
        $mail->Body   .= '<small>This is a <b>Test Mail</b> sent by your acount.</small><br>';
        $mail->Body   .= '<br><small>Thank You and Best Regard,<br>GTD Team.</small>';

        if(!$mail->send()){
            $data = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }else{
            $data = "true";
        }

    echo $data;
?>