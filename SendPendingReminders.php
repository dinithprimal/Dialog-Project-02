<?php

    include("database.php");

    date_default_timezone_set("Asia/Colombo");

    require 'PHPMailerAutoload.php';
    require 'credential.php';

    $queryID = "SELECT idProgram FROM programstatus WHERE (progNomStatus = 'Pending' OR progModuleStatus = 'Pending' OR statusWord = '0') AND (progApprGTD = '0' AND statusHR = '0') ORDER BY idProgram";
    $resultQueryID = mysqli_query($conn,$queryID) or die(mysqli_error($conn));
    while($progDetailsID = mysqli_fetch_array($resultQueryID)){
        $id = $progDetailsID['idProgram'];

        $query = "SELECT * FROM programstatus WHERE idProgram = '$id'";
        $resultQuery = mysqli_query($conn,$query) or die(mysqli_error($conn));
        $progDetails = mysqli_fetch_array($resultQuery);

        $progName = $progDetails['progName'];
        $progType = $progDetails['progType'];
        $progNomStatus = $progDetails['progNomStatus'];
        $progModuleStatus = $progDetails['progModuleStatus'];
        $wordStatus = $progDetails['statusWord'];

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

        $mail = new PHPMailer;

        $mail->SMTPDebug = false;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = EMAIL;                 // SMTP username
        $mail->Password = PASS;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom(EMAIL, 'Training Portal');
        /* $mail->addAddress('dinith.primal-intern@dialog.lk'); */
        for($j=0;$j<count($ccMails);$j++){
            $mail->addAddress($ccMails[$j]);
        }

        $mail->addReplyTo(EMAIL);
        
        $queryAdmin = "SELECT * FROM user WHERE role = 'Admin'";
        $resultAdmin = mysqli_query($conn,$queryAdmin) or die(mysqli_error($conn));
        while($admin = mysqli_fetch_array($resultAdmin)){
            $adminMail = $admin['email'];
            $mail->addCC($adminMail);
        }

        $mail->isHTML(true);                                  // Set email format to HTML

        if($progNomStatus == "Pending" & $progModuleStatus == "Pending" & $wordStatus == '0'){
            $mail->Subject = 'Pending Nominee, Module Details and Detailed Sheet for Training Program : '.$progName.' '.$progType.' Training';
        }else if($progNomStatus == "Pending" & $progModuleStatus == "Pending"){
            $mail->Subject = 'Pending Nominee and Module Details for Training Program : '.$progName.' '.$progType.' Training';
        }else if($progModuleStatus == "Pending" & $wordStatus == '0'){
            $mail->Subject = 'Pending Module Details and Detailed Sheet for Training Program : '.$progName.' '.$progType.' Training';
        }else if($progNomStatus == "Pending" & $wordStatus == '0'){
            $mail->Subject = 'Pending Nominee Details and Detailed Sheet for Training Program : '.$progName.' '.$progType.' Training';
        }else if($progNomStatus == "Pending"){
            $mail->Subject = 'Pending Nominee Detail for Training Program : '.$progName.' '.$progType.' Training';
        }else if($progModuleStatus == "Pending"){
            $mail->Subject = 'Pending Module Details for Training Program : '.$progName.' '.$progType.' Training';
        }else if($wordStatus == '0'){
            $mail->Subject = 'Pending Detailed Sheet for Training Program : '.$progName.' '.$progType.' Training';
        }
        $mail->Body    = 'Dear Team,<br><br>';
        $mail->Body    .= 'Please provide ';

        if($progNomStatus == "Pending" & $progModuleStatus == "Pending" & $wordStatus == '0'){
            $mail->Body .= 'pending nomine, module details and detailed sheet that include all training information asap in order to proceed the training program : <em>'.$progName.' '.$progType.' training</em>.';
        }else if($progNomStatus == "Pending" & $progModuleStatus == "Pending"){
            $mail->Body .= 'pending nominee and module details asap in order to proceed the training program : <em>'.$progName.' '.$progType.' training</em>.';
        }else if($progModuleStatus == "Pending" & $wordStatus == '0'){
            $mail->Body .= 'pending module details and detailed sheet that include all training information asap in order to proceed the training program : <em>'.$progName.' '.$progType.' training</em>.';
        }else if($progNomStatus == "Pending" & $wordStatus == '0'){
            $mail->Body .= 'pending nominee details and detailed sheet that include all training information asap in order to proceed the training program : <em>'.$progName.' '.$progType.' training</em>.';
        }else if($progNomStatus == "Pending"){
            $mail->Body .= 'pending nominee details asap in order to proceed the training program : <em>'.$progName.' '.$progType.' training</em>.';
        }else if($progModuleStatus == "Pending"){
            $mail->Body .= 'pending module details asap in order to proceed the training program : <em>'.$progName.' '.$progType.' training</em>.';
        }else if($wordStatus == '0'){
            $mail->Body .= 'pending detailed sheet that include all training information asap in order to proceed the training program : <em>'.$progName.' '.$progType.' training</em>.';
        }

        $mail->Body    .= '<br><br>Please contact Sulochana Rathnayake for more details.<br><br>';
        $mail->Body    .= '<br><br>Thank You';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()){
            echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }else{
            echo  'message sent';
        }

    }

?>