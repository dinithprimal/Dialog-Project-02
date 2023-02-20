<?php

    include("database.php");

    require 'PHPMailerAutoload.php';
    require 'credential.php';

    $id = $_POST['id'];
    $CXOid = $_POST['CXOid'];

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
    $progScheduleComment = $progDetails['scheduleComment'];

    $str = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890";
    $str = str_shuffle($str);
    $cnfirm = substr($str,0,10);
    

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

    $Dt = new DateTime();
    $Dt = $Dt->format("Y-m-d");


    $queryCXO = "SELECT * FROM user WHERE role = 'CXO-1' AND unit = '$CXOid'";
    $resultCXO = mysqli_query($conn,$queryCXO) or die(mysqli_error($conn));
    $CXO = mysqli_fetch_array($resultCXO);

    $CXOname = $CXO['fName'];
    $CXOmail = $CXO['email'];
    $CXOunit = $CXO['unit'];

    

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
    $mail->addAddress($CXOmail);     // Add a recipient
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
    //$mail->addStringAttachment($file,'info.docx');        // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Training Program Recommendation: '.$progName.' '.$progType.' Training';
    $mail->Body    = 'Dear '.$CXOname.',<br><br>';
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
    $mail->Body    .= '<a href="http://172.26.59.67:4200/Admin-Dashboard/CXOApproval.php?id='.$id.'&confirm='.$cnfirm.'&unit='.$CXOunit.'">Accept</a> &emsp; <a href="http://172.26.59.67:4200/Admin-Dashboard/CXOReject.php?id='.$id.'&confirm='.$cnfirm.'&unit='.$CXOunit.'">Reject</a><br><br>';
    $mail->Body    .= '<br>To view training details, please go through this link<br>';
    $mail->Body    .= '<a href="http://172.26.59.67:4200/Admin-Dashboard/Preview/previewDashboard.php">Group Technology - Trainings Dashboard</a>';
    $mail->Body    .= '<br><br>Thank You';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()){
        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }else{
        $insertQuery = "UPDATE cxoapproval SET  CXO1Confirm = '$cnfirm', reqDtApprCXO1 = '$Dt', progApprCXO1 = '1' WHERE idProgram = '$id' AND CXOid = '$CXOunit'";
        if ($conn->query($insertQuery) === TRUE) {
            //unset($_POST['save_programTrasup']);                    
        }
    }

    $allCnf = 'true';
    
    $querySelCXO = "SELECT * FROM cxoapproval WHERE idProgram = '$id'";
    $cnfrmIdSelCXO = mysqli_query($conn,$querySelCXO) or die(mysqli_error($conn));
    while($CXOconfirm = mysqli_fetch_array($cnfrmIdSelCXO)){
        if($CXOconfirm['progApprCXO1'] == '3'){
            $allCnf = 'false';
        }
    }

    if($allCnf == 'true'){

        $updateQuery = "";
        $updateQuery = "UPDATE programstatus SET statusCXO1 = '1' WHERE idProgram = '$id'";
        
        if ($conn->query($updateQuery) === TRUE) {
            //unset($_POST['save_programTrasup']);                    
        }
    }

?>