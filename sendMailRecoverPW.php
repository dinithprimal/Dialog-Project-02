<?php
    include("database.php");

    $fName = $_POST['fName'];
    $userUserName = $_POST['uName'];
    $userPassword = $_POST['pw'];

    require 'PHPMailerAutoload.php';
    require 'credential.php';

    $mail = new PHPMailer;

    $mail->SMTPDebug = 4;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = EMAIL;                 // SMTP username
    $mail->Password = PASS;                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom(EMAIL, 'GT - Trainings');
    $mail->addAddress('dinith.primal-intern@dialog.lk', 'Dinith');     // Add a recipient
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
    $mail->Body    .= '<a href="http://www.domain.com/register/registration.php?token=$token&stud_id=stud_id">Training Portal</a>';
    $mail->Body    .= '<br><br>';
    $mail->Body    .= 'Thank You';

    if(!$mail->send()){
        $out = 'Message could not be sent.';
        $out .= 'Mailer Error: ' . $mail->ErrorInfo;
        $err = "<div class='alert alert-danger text-center text-danger' role='alert'>Somthing happened wrong..! '".$out."'</div>";
    }else{
        //$err = "<div class='alert alert-success text-center text-success' role='alert'>Passwor recovered email successfully sent..!</div>";
    }
?>