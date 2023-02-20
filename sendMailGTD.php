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

    $queryGTD = "SELECT * FROM user WHERE role = 'GTD'";
    $resultGTD = mysqli_query($conn,$queryGTD) or die(mysqli_error($conn));
    $GTD = mysqli_fetch_array($resultGTD);
    $GTDname = $GTD['fName'];
    $GTDmail = $GTD['email'];

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

    $mail->setFrom(EMAIL);
    $mail->addAddress($GTDmail);     // Add a recipient
                // Name is optional
    $mail->addReplyTo(EMAIL);
    $queryAdmin = "SELECT * FROM user WHERE role = 'Admin'";
    $resultAdmin = mysqli_query($conn,$queryAdmin) or die(mysqli_error($conn));
    while($admin = mysqli_fetch_array($resultAdmin)){
        $adminMail = $admin['email'];
        $mail->addCC($adminMail);
    }
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');
    if($progDetails['statusWord'] == 1){
        $file = $progDetails['wordFile'];
        $fileName = $progDetails['wordName'];
        $mail->addStringAttachment($file,''.$fileName.'.docx');        // Add attachments
    }
   
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
    $mail->Body    .= '<br>You can provide your recommendation by using bellow buttons<br><br>';
    $mail->Body    .= '<a href="http://172.26.59.67:4200/Admin-Dashboard/GTDApproval.php?id='.$id.'&confirm='.$cnfirm.'">Accept</a> &emsp; <a href="http://172.26.59.67:4200/Admin-Dashboard/GTDReject.php?id='.$id.'&confirm='.$cnfirm.'">Reject</a><br><br>';
    $mail->Body    .= '<br>To view training details, please go through this link<br>';
    $mail->Body    .= '<a href="http://172.26.59.67:4200/Admin-Dashboard/Preview/previewDashboard.php">Group Technology - Trainings Dashboard</a>';
    $mail->Body    .= '<br><br>Thank You';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()){
        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }else{
        $updateQuery = "";
        $Dt = new DateTime();
        $Dt = $Dt->format("Y-m-d");
        if($progType != 'Foriegn'){
            $updateQuery = "UPDATE programstatus SET progApprGTD= '1' , reqDtAprGTD = '$Dt', GTDConfirm = '$cnfirm', progApprGCEO = '4' WHERE idProgram = '$id'";
        }else{
            $updateQuery = "UPDATE programstatus SET progApprGTD= '1' , reqDtAprGTD = '$Dt', GTDConfirm = '$cnfirm' WHERE idProgram = '$id'";
        }
        if ($conn->query($updateQuery) === TRUE) {
            //unset($_POST['save_programTrasup']);                    
        }
        
    }

?>