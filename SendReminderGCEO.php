<?php

    include("database.php");

    date_default_timezone_set("Asia/Colombo");

    require 'PHPMailerAutoload.php';
    require 'credential.php';

    $queryID = "SELECT idProgram FROM programstatus WHERE progApprGCEO = '1'";
    $resultQueryID = mysqli_query($conn,$queryID) or die(mysqli_error($conn));
    while($progDetailsID = mysqli_fetch_array($resultQueryID)){
        $id = $progDetailsID['idProgram'];

        $query = "SELECT * FROM programstatus WHERE idProgram = '$id'";
        $resultQuery = mysqli_query($conn,$query) or die(mysqli_error($conn));
        $progDetails = mysqli_fetch_array($resultQuery);

        $progName = $progDetails['progName'];
        $progType = $progDetails['progType'];
        $progDivision = $progDetails['division'];
        $progSlots = $progDetails['slots'];
        $progCurrency = $progDetails['currency'];
        $progFee = $progDetails['courseFee'];
        $progOtherCost = $progDetails['otherCost'];
        $progOtherCostComment = $progDetails['otherCostComment'];
        $progDuration = $progDetails['duration'];
        $progStDate = $progDetails['stDate'];
        $progEdDate = $progDetails['edDate'];
        $progBudgetSource = $progDetails['bSource'];
        $cnfirm = $progDetails['GCEOConfirm'];
        $progScheduleComment = $progDetails['scheduleComment'];


        $queryGCEO = "SELECT * FROM user WHERE role = 'GCEO'";
        $resultGCEO = mysqli_query($conn,$queryGCEO) or die(mysqli_error($conn));
        $GCEO = mysqli_fetch_array($resultGCEO);
        $GCEOname = $GCEO['fName'];
        $GCEOmail = $GCEO['email'];

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
        $mail->addAddress($GCEOmail);     // Add a recipient
                    // Name is optional
        $mail->addReplyTo(EMAIL);
        
        $queryAdmin = "SELECT * FROM user WHERE role = 'Admin'";
        $resultAdmin = mysqli_query($conn,$queryAdmin) or die(mysqli_error($conn));
        while($admin = mysqli_fetch_array($resultAdmin)){
            $adminMail = $admin['email'];
            $mail->addCC($adminMail);
        }

        if($progDetails['statusWord'] == 1){
            $file = $progDetails['wordFile'];
            $fileName = $progDetails['wordName'];
            $mail->addStringAttachment($file,''.$fileName.'.docx');        // Add attachments
        }

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Reminder: '.$progType.' Training Program Approval Request';
        $mail->Body    = 'Dear '.$GCEOname.',<br><br>';
        $mail->Body    .= 'Please grant your approval to proceed with the attached <b>'.$progType.'</b> training program for the nominated GT staff.';
        if($progDetails['statusWord'] == 1){
            $mail->Body    .= 'Details of the Training Program and the cost are summarized in the attached document, FYI.<br>';
        }
        $mail->Body    .= '<br>';
        $mail->Body    .= '';
        $mail->Body    .= '<b>Summery</b><br>';
        $mail->Body    .= '<table>';
        $mail->Body    .=   '<tr>';
        $mail->Body    .=       '<td width="200">Program Name:</td><td>'.$progName.'</td>';
        $mail->Body    .=   '</tr>';
        $mail->Body    .=   '<tr>';
        $mail->Body    .=       '<td>Total Slot:</td><td>'.$progSlots.'</td>';
        $mail->Body    .=   '</tr>';
        $mail->Body    .=   '<tr>';
        $mail->Body    .=       '<td>Course Fee:</td><td>'.$progCurrency.' '.$progFee.'</td>';
        $mail->Body    .=   '</tr>';
        $mail->Body    .=   '<tr>';
        $mail->Body    .=       '<td>Estimated Other Cost:</td><td>'.$progCurrency.' '.$progOtherCost.'</td>';
        $mail->Body    .=   '</tr>';
        if($progOtherCostComment != ''){
            $mail->Body    .=   '<tr>';
            $mail->Body    .=       '<td>Other Cost Comment:</td><td>'.$progOtherCostComment.'</td>';
            $mail->Body    .=   '</tr>';
        }
        if($progDuration != ''){
        $mail->Body    .=   '<tr>';
        $mail->Body    .=       '<td>Duration:</td><td>'.$progDuration.'</td>';
        $mail->Body    .=   '</tr>';
        }
        if($progStDate != ''){
        $mail->Body    .=   '<tr>';
        $mail->Body    .=       '<td>Start Date:</td><td>'.$progStDate.'</td>';
        $mail->Body    .=   '</tr>';
        }
        if($progEdDate != ''){
        $mail->Body    .=   '<tr>';
        $mail->Body    .=       '<td>End Date:</td><td>'.$progEdDate.'</td>';
        $mail->Body    .=   '</tr>';
        }
        if($progScheduleComment != ''){
            $mail->Body    .=   '<tr>';
            $mail->Body    .=       '<td>Program Schedule Comment:</td><td>'.$progScheduleComment.'</td>';
            $mail->Body    .=   '</tr>';
        }
        if($progBudgetSource != ''){
            $mail->Body    .=   '<tr>';
            $mail->Body    .=       '<td>Budget Source:</td><td>'.$progBudgetSource.'</td>';
            $mail->Body    .=   '</tr>';
        }
        $mail->Body    .= '</table>';
        $mail->Body    .= '<br>';
        $mail->Body    .= '<b>Nominees</b><br>';
        $mail->Body    .= '<table>';

        $nomineeQuery1 = "SELECT nomineeName FROM nomineeprogramstatus WHERE idProgram = '$id'";
        $resultNomQuery1 = mysqli_query($conn,$nomineeQuery1) or die(mysqli_error($conn));
        while($nominees1 = mysqli_fetch_array($resultNomQuery1)){
            $nom1 = $nominees1['nomineeName'];
            $mail->Body    .=   '<tr>';
            $mail->Body    .=       '<td>'.$nom1.'</td>';
            $mail->Body    .=   '</tr>';
        }

        $mail->Body    .= '</table>';
        $mail->Body    .= '<br>You can provide your recommendation by using bellow buttons<br><br>';
        $mail->Body    .= '<a href="http://172.26.59.67:4200/Admin-Dashboard/GCEOApproval.php?id='.$id.'&confirm='.$cnfirm.'">Accept</a> &emsp; <a href="http://172.26.59.67:4200/Admin-Dashboard/GCEOReject.php?id='.$id.'&confirm='.$cnfirm.'">Reject</a><br><br>';
        $mail->Body    .= '<br>To view training details, please go through this link<br>';
        $mail->Body    .= '<a href="http://172.26.59.67:4200/Admin-Dashboard/Preview/previewDashboard.php">Group Technology - Trainings Dashboard</a>';
        $mail->Body    .= '<br><br>Thank You';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()){
            echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }else{
            
        }

    }

?>