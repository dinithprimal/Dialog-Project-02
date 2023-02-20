<?php

    include("database.php");

    $id = $_POST['id'];
    $CXOid = $_POST['GTDCXOid'];
    // foreach ($CXOid as $value) {
    //     echo $value, "\n";
    // }


    //$conn = mysqli_connect("localhost","root","","training");

    date_default_timezone_set("Asia/Colombo");

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
    $file = $progDetails['wordFile'];
    $progScheduleComment = $progDetails['scheduleComment'];

    $str = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890";

    $strGTD = str_shuffle($str);
    $cnfirmGTD = substr($strGTD,0,10);

    $strCXO = str_shuffle($str);
    $cnfirmCXO = substr($strCXO,0,10);

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

    $queryGTD = "SELECT * FROM user WHERE role = 'GTD'";
    $resultGTD = mysqli_query($conn,$queryGTD) or die(mysqli_error($conn));
    $GTD = mysqli_fetch_array($resultGTD);
    $GTDname = $GTD['fName'];
    $GTDmail = $GTD['email'];

    /* $queryCXO = "SELECT * FROM user WHERE role = 'CXO-1' AND unit = '$CXOid'";
    $resultCXO = mysqli_query($conn,$queryCXO) or die(mysqli_error($conn));
    $CXO = mysqli_fetch_array($resultCXO);
    $CXOname = $CXO['fName'];
    $CXOmail = $CXO['email']; */

    require 'PHPMailerAutoload.php';
    require 'credential.php';

    $mail = new PHPMailer;

    $mail->SMTPDebug = false;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = EMAIL;                 // SMTP username
    $mail->Password = PASS;                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom(EMAIL);
    $mail->addAddress($GTDmail);
    //$mail->addAddress($CXOmail);     // Add a recipient
                // Name is optional
    $mail->addReplyTo(EMAIL);

    $queryAdmin = "SELECT * FROM user WHERE role = 'Admin'";
    $resultAdmin = mysqli_query($conn,$queryAdmin) or die(mysqli_error($conn));
    while($admin = mysqli_fetch_array($resultAdmin)){
        $adminMail = $admin['email'];
        $mail->addCC($adminMail);
    }
    //$mail->addCC('sulochana.rathnayake@dialog.lk');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');
    if($progDetails['statusWord'] == 1){
        $file = $progDetails['wordFile'];
        $fileName = $progDetails['wordName'];
        $mail->addStringAttachment($file,''.$fileName.'.docx');        // Add attachments
    }
    //$mail->addStringAttachment($file,'Info.docx');
    //$mail->addAttachment($file);         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Training Program Recommendation: '.$progName.' '.$progType.' Training';
    $mail->Body    = 'Dear '.$GTDname.',<br><br>';
    $mail->Body    .= 'Please provide your <b>Recommendations</b> to proceed with the attached <b>'.$progType.'</b> training program on "'.$progName.'" ';
    $mail->Body    .= 'request by '.$progDivision.' team.<br>';
    if($progDetails['statusWord'] == 1){
        $mail->Body    .= 'Details of the Training Program and the cost are summarized in the attached document, FYI.<br>';
    }
    $mail->Body    .= '<br>';
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
    $mail->Body    .= '<br>You can provide your recommendation by using below buttons<br><br>';
    $mail->Body    .= '<a class="button" href="http://172.26.59.67:4200/Admin-Dashboard/GTDApproval.php?id='.$id.'&confirm='.$cnfirmGTD.'">Accept</a> &emsp; <a class="button" href="http://172.26.59.67:4200/Admin-Dashboard/GTDReject.php?id='.$id.'&confirm='.$cnfirmGTD.'">Reject</a>';
    $mail->Body    .= '<br>To view training details, please go through this link<br>';
    $mail->Body    .= '<a href="http://172.26.59.67:4200/Admin-Dashboard/Preview/previewDashboard.php">Group Technology - Trainings Dashboard</a>';
    $mail->Body    .= '<br><br>Thank You';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()){
        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }else{
        $mail->SmtpClose();
    }

    $Dt = new DateTime();
    $Dt = $Dt->format("Y-m-d");

    foreach ($CXOid as $value) {
    $queryCXO = "SELECT * FROM user WHERE role = 'CXO-1' AND unit = '$value'";
    $resultCXO = mysqli_query($conn,$queryCXO) or die(mysqli_error($conn));
    $CXO = mysqli_fetch_array($resultCXO);

        $CXOname = $CXO['fName'];
        $CXOmail = $CXO['email'];
        $CXOunit = $CXO['unit'];

        $mail2 = new PHPMailer;

        $mail2->SMTPDebug = false;                               // Enable verbose debug output

        $mail2->isSMTP();                                      // Set mailer to use SMTP
        $mail2->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
        $mail2->SMTPAuth = true;                               // Enable SMTP authentication
        $mail2->Username = EMAIL;                 // SMTP username
        $mail2->Password = PASS;                           // SMTP password
        $mail2->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail2->Port = 587;                                    // TCP port to connect to

        $mail2->setFrom(EMAIL);
        //$mail2->addAddress($GTDmail);
        $mail2->addAddress($CXOmail);     // Add a recipient
                    // Name is optional
        $mail2->addReplyTo(EMAIL);

        $queryAdmin = "SELECT * FROM user WHERE role = 'Admin'";
        $resultAdmin = mysqli_query($conn,$queryAdmin) or die(mysqli_error($conn));
        while($admin = mysqli_fetch_array($resultAdmin)){
            $adminMail = $admin['email'];
            $mail2->addCC($adminMail);
        }
        //$mail2->addCC('sulochana.rathnayake@dialog.lk');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        if($progDetails['statusWord'] == 1){
            $file = $progDetails['wordFile'];
            $fileName = $progDetails['wordName'];
            $mail2->addStringAttachment($file,''.$fileName.'.docx');        // Add attachments
        }
        //$mail->addStringAttachment($file,'Info.docx');
        //$mail->addAttachment($file);         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail2->isHTML(true);                                  // Set email format to HTML

        $mail2->Subject = 'Training Program Recommendation: '.$progName.' '.$progType.' Training';
        $mail2->Body    = 'Dear '.$CXOname.',<br><br>';
        $mail2->Body    .= 'Please provide your <b>Recommendations</b> to proceed with the attached <b>'.$progType.'</b> training program on "'.$progName.'" ';
        $mail2->Body    .= 'request by '.$progDivision.' team.<br>';
        if($progDetails['statusWord'] == 1){
            $mail2->Body    .= 'Details of the Training Program and the cost are summarized in the attached document, FYI.<br>';
        }
        $mail2->Body    .= '<br>';
        $mail2->Body    .= '<b>Summery</b><br>';
        $mail2->Body    .= '<table>';
        $mail2->Body    .=   '<tr>';
        $mail2->Body    .=       '<td width="200">Program Name:</td><td>'.$progName.'</td>';
        $mail2->Body    .=   '</tr>';
        $mail2->Body    .=   '<tr>';
        $mail2->Body    .=       '<td>Total Slot:</td><td>'.$progSlots.'</td>';
        $mail2->Body    .=   '</tr>';
        $mail2->Body    .=   '<tr>';
        $mail2->Body    .=       '<td>Course Fee:</td><td>'.$progCurrency.' '.$progFee.'</td>';
        $mail2->Body    .=   '</tr>';
        $mail2->Body    .=   '<tr>';
        $mail2->Body    .=       '<td>Estimated Other Cost:</td><td>'.$progCurrency.' '.$progOtherCost.'</td>';
        $mail2->Body    .=   '</tr>';
        if($progOtherCostComment != ''){
            $mail->Body    .=   '<tr>';
            $mail->Body    .=       '<td>Other Cost Comment:</td><td>'.$progOtherCostComment.'</td>';
            $mail->Body    .=   '</tr>';
        }
        if($progDuration != ''){
            $mail2->Body    .=   '<tr>';
            $mail2->Body    .=       '<td>Duration:</td><td>'.$progDuration.'</td>';
            $mail2->Body    .=   '</tr>';
        }
        if($progStDate != ''){
            $mail2->Body    .=   '<tr>';
            $mail2->Body    .=       '<td>Start Date:</td><td>'.$progStDate.'</td>';
            $mail2->Body    .=   '</tr>';
        }
        if($progEdDate != ''){
            $mail2->Body    .=   '<tr>';
            $mail2->Body    .=       '<td>End Date:</td><td>'.$progEdDate.'</td>';
            $mail2->Body    .=   '</tr>';
        }
        if($progScheduleComment != ''){
            $mail2->Body    .=   '<tr>';
            $mail2->Body    .=       '<td>Program Schedule Comment:</td><td>'.$progScheduleComment.'</td>';
            $mail2->Body    .=   '</tr>';
        }
        if($progBudgetSource != ''){
            $mail2->Body    .=   '<tr>';
            $mail2->Body    .=       '<td>Budget Source:</td><td>'.$progBudgetSource.'</td>';
            $mail2->Body    .=   '</tr>';
        }
        $mail2->Body    .= '</table>';
        $mail2->Body    .= '<br>';
        $mail2->Body    .= '<b>Nominees</b><br>';
        $mail2->Body    .= '<table>';

        $nomineeQuery = "SELECT nomineeName FROM nomineeprogramstatus WHERE idProgram = '$id'";
        $resultNomQuery = mysqli_query($conn,$nomineeQuery) or die(mysqli_error($conn));
        while($nominees = mysqli_fetch_array($resultNomQuery)){
            $nom = $nominees['nomineeName'];
            $mail2->Body    .=   '<tr>';
            $mail2->Body    .=       '<td>'.$nom.'</td>';
            $mail2->Body    .=   '</tr>';
        }

        $mail2->Body    .= '</table>';
        $mail2->Body    .= '<br>You can provide your recommendation by using below buttons<br><br>';
        $mail2->Body    .= '<a class="button" href="http://172.26.59.67:4200/Admin-Dashboard/CXOApproval.php?id='.$id.'&confirm='.$cnfirmCXO.'&unit='.$CXOunit.'">Accept</a> &emsp; <a class="button" href="http://172.26.59.67:4200/Admin-Dashboard/CXOReject.php?id='.$id.'&confirm='.$cnfirmCXO.'&unit='.$CXOunit.'">Reject</a>';
        $mail2->Body    .= '<br>To view training details, please go through this link<br>';
        $mail2->Body    .= '<a href="http://172.26.59.67:4200/Admin-Dashboard/Preview/previewDashboard.php">Group Technology - Trainings Dashboard</a>';
        $mail2->Body    .= '<br><br>Thank You';
        $mail2->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail2->send()){
            echo 'Message could not be sent. Mailer Error: ' . $mail2->ErrorInfo;
        }else{
            $insertQuery = "INSERT INTO cxoapproval (idProgram, CXOid, CXO1Confirm, reqDtApprCXO1, progApprCXO1) VALUES ('$id', '$CXOunit', '$cnfirmCXO', '$Dt', '1')";
            if ($conn->query($insertQuery) === TRUE) {
                //unset($_POST['save_programTrasup']);                    
            }
        }
    }

    
    $updateQuery = "";
    if($progType != 'Foriegn'){
        $updateQuery = "UPDATE programstatus SET progApprGTD= '1' , reqDtAprGTD = '$Dt', statusCXO1 = '1', GTDConfirm = '$cnfirmGTD', progApprGCEO = '4' WHERE idProgram = '$id'";
    }else{
        $updateQuery = "UPDATE programstatus SET progApprGTD= '1' , reqDtAprGTD = '$Dt', statusCXO1 = '1', GTDConfirm = '$cnfirmGTD', WHERE idProgram = '$id'";
    }
    
    if ($conn->query($updateQuery) === TRUE) {
        //unset($_POST['save_programTrasup']);                    
    }

?>