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
    $progDuration = $progDetails['duration'];
    $progStDate = $progDetails['stDate'];
    $progEdDate = $progDetails['edDate'];
    $progBudgetSource = $progDetails['bSource'];
    $progGTD = $progDetails['progApprGTD'];
    $progCXO = $progDetails['statusCXO1'];
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

    $queryHR = "SELECT * FROM user WHERE role = 'Training HR'";
    $resultHR = mysqli_query($conn,$queryHR) or die(mysqli_error($conn));
    $HR = mysqli_fetch_array($resultHR);
    $HRname = $HR['fName'];
    $HRmail = $HR['email'];

    $queryHRSP = "SELECT * FROM user WHERE role = 'HR Supervisor'";
    $resultHRSP = mysqli_query($conn,$queryHRSP) or die(mysqli_error($conn));
    $HRSP = mysqli_fetch_array($resultHRSP);
    $HRSPmail = $HRSP['email'];

    $queryHRP = "SELECT * FROM user WHERE role = 'HR Partner'";
    $resultHRP = mysqli_query($conn,$queryHRP) or die(mysqli_error($conn));
    //$HRP = mysqli_fetch_array($resultHRP);
    //$HRPmail = $HRP['email'];

    $queryGTD = "SELECT * FROM user WHERE role = 'GTD'";
    $resultGTD = mysqli_query($conn,$queryGTD) or die(mysqli_error($conn));
    $GTD = mysqli_fetch_array($resultGTD);
    $GTDmail = $GTD['email'];

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

    $mail->setFrom(EMAIL, 'Training Portal');
    $mail->addAddress($HRmail);     // Add a recipient
                // Name is optional
    $mail->addReplyTo(EMAIL);

    $queryAdmin = "SELECT * FROM user WHERE role = 'Admin'";
    $resultAdmin = mysqli_query($conn,$queryAdmin) or die(mysqli_error($conn));
    while($admin = mysqli_fetch_array($resultAdmin)){
        $adminMail = $admin['email'];
        $mail->addCC($adminMail);
    }

    $mail->addCC($HRSPmail);
    while($HRP = mysqli_fetch_array($resultHRP)){
        $HRPmail = $HRP['email'];
        $mail->addCC($HRPmail);
    }
    $mail->addCC($GTDmail);
    for($k=0;$k<count($ccMails);$k++){
        $mail->addAddress($ccMails[$k]);
    }
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');
    if($progDetails['statusPDF'] == 1){
        $file = $progDetails['PDFFile'];
        $fileName = $progDetails['PDFName'];
        $mail->addStringAttachment($file,''.$fileName.'.pdf');        // Add attachments
    }
    //$mail->addStringAttachment($file,'info.docx');        // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = ''.$progType.' Training Program Delivery Request : '.$progName.' Training - GT Common Program';
    $mail->Body    = 'Dear '.$HRname.',<br><br>';
    $mail->Body    .= 'Please do the needful to arrange the attached <b>'.$progType.'</b> training program on "'.$progName.'" for the nominated GT staff.';
    if($progDetails['statusWord'] == 1){
        $mail->Body    .= 'Details of the Training Program, cost and nominees are given in the attached document, FYI.<br><br>';
    }
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
    $mail->Body    .= '<br><br>For schedule details and further clarifications, please contact '.$names.' from GT';
    $mail->Body    .= '<br><br>Thank You';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()){
        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }else{

        $Dt = new DateTime();
        $Dt = $Dt->format("Y-m-d");

        $updateQuery = "";
        if($progGTD == 0 & $progCXO == 0){
            $updateQuery = "UPDATE programstatus SET statusHR= '1' , dateHR = '$Dt', progApprGTD = '4', statusCXO1 = '4', progApprGCTO = '4', progApprGCEO = '4' WHERE idProgram = '$id'";
        }else{
            $updateQuery = "UPDATE programstatus SET statusHR= '1' , dateHR = '$Dt' WHERE idProgram = '$id'";
        }
        if ($conn->query($updateQuery) === TRUE) {
            //unset($_POST['save_programTrasup']);                    
        }
        
    }

    $mail2 = new PHPMailer;

    $mail2->SMTPDebug = false;                               // Enable verbose debug output

    $mail2->isSMTP();                                      // Set mailer to use SMTP
    $mail2->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
    $mail2->SMTPAuth = true;                               // Enable SMTP authentication
    $mail2->Username = EMAIL;                 // SMTP username
    $mail2->Password = PASS;                           // SMTP password
    $mail2->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail2->Port = 587;                                    // TCP port to connect to

    $mail2->setFrom(EMAIL, 'Training Portal');

    $mail2->addReplyTo(EMAIL);
    for($j=0;$j<count($ccMails);$j++){
        $mail2->addAddress($ccMails[$j]);
    }

    $queryAdmin = "SELECT * FROM user WHERE role = 'Admin'";
    $resultAdmin = mysqli_query($conn,$queryAdmin) or die(mysqli_error($conn));
    while($admin = mysqli_fetch_array($resultAdmin)){
        $adminMail = $admin['email'];
        $mail2->addCC($adminMail);
    }
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //$mail->addStringAttachment($file,'info.docx');        // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail2->isHTML(true);                                  // Set email format to HTML

    $mail2->Subject = ''.$progType.' Training Program Delivery : '.$progName.' Training';
    $mail2->Body    = 'Dear User,<br><br>';
    $mail2->Body    .= 'Your "'.$progName.'" training has been sent to HR for delivery. Please apply the same via HCM in order to proceed.';
    $mail2->Body    .= '<br><br>Thank You';
    $mail2->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail2->send()){
        echo 'Message could not be sent. Mailer Error: ' . $mail2->ErrorInfo;
    }else{

    }

?>