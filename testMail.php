
<?php

    include("database.php");

    //$conn = mysqli_connect("localhost","root","","training");

    $query = "SELECT * FROM programstatus WHERE idProgram = '1'";
    $resultQuery = mysqli_query($conn,$query) or die(mysqli_error($conn));
    $progDetails = mysqli_fetch_array($resultQuery);

    $ccMails = array();
    $names = $progDetails['requestedBy'];

    if (preg_match( '/\//', $names)){
        $name = explode("/", $names);
        for($i = 0;$i<count($name);$i++){
            list($fName,$lName) = explode(" ", $name[$i]);
            $query = "SELECT email FROM user WHERE fName = '$fName' AND lName = '$lName'";
            $result_sql = mysqli_query($conn,$query) or die(mysqli_error($conn));
            $email = mysqli_fetch_array($result_sql);
            $ccMails[$i] = $email['email'];
        }
    }else{
        $name = $names;
        list($fName,$lName) = explode(" ", $name);
        $query = "SELECT email FROM user WHERE fName = '$fName' AND lName = '$lName'";
        $result_sql = mysqli_query($conn,$query) or die(mysqli_error($conn));
        $email = mysqli_fetch_array($result_sql);
        $ccMails[0] = $email['email'];
    }

    for($j=0;$j<count($ccMails);$j++){
        echo    $ccMails[$j];
        echo    "<br>";
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

    $mail->setFrom(EMAIL, 'GT - Trainings');
    $mail->addAddress('dinith.primal-intern@dialog.lk', 'Dinith');     // Add a recipient
                // Name is optional
    $mail->addReplyTo(EMAIL);
    /*for($j=0;$j<count($ccMails);$j++){
        $mail->addCC($ccMails[$j]);
    }*/
    //$mail->addCC('niproban@gmail.com');
    //$mail->addBCC('bcc@example.com');

   // $file = $progDetails['wordFile'];

   // $mail->addStringAttachment($file,'wodr.docx');

    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b><br><br>';
    $mail->Body .= '<a href="http://www.domain.com/register/registration.php?token=$token&stud_id=stud_id">hello</a>';
    $mail->AltBody = 'Click to Register';

    if(!$mail->send()){
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }else{
        echo 'Message has been sent';
    }
?>
	