<?php

    include("database.php");

    $id = $_POST['id'];

    //$conn = mysqli_connect("localhost","root","","training");

    date_default_timezone_set("Asia/Colombo");

    $query = "SELECT * FROM programstatus WHERE idProgram = '$id'";
    $resultQuery = mysqli_query($conn,$query) or die(mysqli_error($conn));
    $progDetails = mysqli_fetch_array($resultQuery);

    $progName = $progDetails['progName'];
    $progType = $progDetails['progType'];

    $ccMails = array();
    $names = $progDetails['requestedBy'];

    if (preg_match( '/\//', $names)){
        $name = explode("/", $names);
        for($i = 0;$i<count($name);$i++){
            $Name = $name[$i];
            $query = "SELECT email FROM user WHERE fullName = '$Name'";
            $result_sql = mysqli_query($conn,$query) or die(mysqli_error($conn));
            $email = mysqli_fetch_array($result_sql);
            $ccMails[$i] = $email['email'];
        }
    }else{
        $Name = $names;
        $query = "SELECT email FROM user WHERE fullName = '$Name'";
        $result_sql = mysqli_query($conn,$query) or die(mysqli_error($conn));
        $email = mysqli_fetch_array($result_sql);
        $ccMails[0] = $email['email'];
    }

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

    $mail->addReplyTo(EMAIL);
    for($j=0;$j<count($ccMails);$j++){
        $mail->addAddress($ccMails[$j]);
    }

    $mail->setFrom(EMAIL);
    
    $queryAdmin = "SELECT * FROM user WHERE role = 'Admin'";
        $resultAdmin = mysqli_query($conn,$queryAdmin) or die(mysqli_error($conn));
        while($admin = mysqli_fetch_array($resultAdmin)){
            $adminMail = $admin['email'];
            $mail->addCC($adminMail);
        }

    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');
   
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'GTD Approval - Training Program : '.$progName.' '.$progType.' Training';
    $mail->Body    = 'Dear User,<br><br>';
    $mail->Body    .= 'Your "'.$progName.'" training has been rejected by GTD.';
    $mail->Body    .= '<br><br>Thank You';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()){
        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }else{
        
    }

?>