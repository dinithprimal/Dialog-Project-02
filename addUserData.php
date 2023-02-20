<?php
    $mes = '';

    include("database.php");
    //$conn = mysqli_connect("localhost","root","","training");

    require 'PHPMailerAutoload.php';
    require 'credential.php';

    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $fullName = ''.$fName.' '.$lName.'';
    $division = $_POST['division'];
    $unit = $_POST['unit'];
    $empID = $_POST['empID'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    
    function userName($fname,$empid){
        $username = ''.$fname.'_'.$empid.'';
        return $username;
    }

    $queryCheck = "SELECT COUNT(*) AS tot FROM user WHERE empID = '$empID'";
    $check = mysqli_query($conn,$queryCheck) or die(mysqli_error($conn));
    $count = mysqli_fetch_array($check);
    $tot = $count['tot'];

    if($tot == 0){

        $queryAddUser ="INSERT INTO user (fName, lName, fullName, Department, unit, email, empID, role, status) VALUES ('$fName','$lName','$fullName','$division','$unit','$email','$empID','$role', '1')";

        if($conn->query($queryAddUser)=== TRUE){
            sleep(1);

            if($role == 'Admin' || $role == 'User'){
                $str = "qwertyuiopasdfghjklzxcvbnm1234567890";
                $str = str_shuffle($str);
                $pw = substr($str,0,6);

                $querySelectUserID = "SELECT idUser FROM user WHERE empID = '$empID'";
                $userIDArray = mysqli_query($conn,$querySelectUserID) or die(mysqli_error($conn));
                $userID = mysqli_fetch_array($userIDArray);
                $userID = $userID['idUser'];
                $username = userName($fName,$empID);

                $queryAddLogDetails = "INSERT INTO logdetail (idUser, Username, Password, role) VALUES ('$userID','$username','$pw','$role')";
                
                if($conn->query($queryAddLogDetails)=== TRUE){

                    if($role == 'Admin' || $role == 'User'){

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
                        $mail->addAddress($email);     // Add a recipient
                                    // Name is optional
                        
                        $mail->isHTML(true);                                  // Set email format to HTML

                        $mail->Subject = 'GT-Training Portal Login';
                        $mail->Body    = 'Dear '.$fName.',<br><br>';
                        $mail->Body    .= 'You have been registered to the GT-Training Portal. Your username and password are herewith.<br><br>';
                        $mail->Body    .= '<table>';
                        $mail->Body    .=   '<tr>';
                        $mail->Body    .=       '<td width="200">Username:</td><td>'.$username.'</td>';
                        $mail->Body    .=   '</tr>';
                        $mail->Body    .=   '<tr>';
                        $mail->Body    .=       '<td>Password:</td><td>'.$pw.'</td>';
                        $mail->Body    .=   '</tr>';
                        $mail->Body    .= '</table>';
                        $mail->Body    .= '<br><br>';
                        $mail->Body    .= '<a href="http://172.26.59.67:4200/">GT-Training Portal</a>';
                        $mail->Body    .= '<br><br>';
                        $mail->Body    .= 'Thank You';


                        if(!$mail->send()){
                            
                        }else{
                            
                        }
                    }
                }else{
                    $mes = 'not';
                }
            }
        }else{
            $mes = 'not';
        }

    }else{
        $mes = 'duplicate';
    }


    echo    $mes;
     
?>