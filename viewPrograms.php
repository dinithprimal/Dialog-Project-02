<?php

    include("database.php");

    $id = $_GET['id'];

    $err = '';
    $user = '';
    $userId = '';
    $ct = '';

    $output = '';

    session_start();
    if(isset($_SESSION['username'])){

        $user = $_SESSION['username'];

        //$conn = mysqli_connect("localhost","root","","training");
        $sql = "SELECT idUser, role FROM logdetail WHERE Username = '$user'";
        $result_sql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
        $userId = mysqli_fetch_array($result_sql);


        if($userId['role']!="Admin"){
            session_destroy();
            unset($_SESSION["username"]);
            echo "<script>location.href='Login.php'</script>";
        }

        $queryUserDetail = "SELECT * FROM user WHERE idUser = '".$userId['idUser']."'";
        $result_query = mysqli_query($conn,$queryUserDetail) or die(mysqli_error($conn));
        $userDetails = mysqli_fetch_array($result_query);

       


        //session_destroy();

    }else{

        session_destroy();
        unset($_SESSION["username"]);
        echo "<script>location.href='Login.php'</script>";

    }

    


    if(isset($_POST['Logout'])){

        session_destroy();
        unset($_SESSION["username"]);
        header("location: Login.php");

    }

    if(isset($_POST['save_programDate'])){
        $stDate = $_POST['programStartDate'];
        $edDate = $_POST['programEndDate'];

        if($stDate == "" && $edDate == ""){

        }else{
            $stDt = new DateTime($stDate);
            $edDt = new DateTime($edDate);

            $stDt = $stDt->format("Y-m-d");
            $edDt = $edDt->format("Y-m-d");
            $queryUpdateDate = "UPDATE programstatus SET stDate= '$stDt' , edDate = '$edDt' WHERE idProgram = '$id'";
            
            if ($conn->query($queryUpdateDate) === TRUE) {
                //unset($_POST['save_programTrasup']);                    
            }else{
                echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
            }
        }
    }

    
    if(isset($_POST['save_programScheduleComment'])){
        $scheduleComment = $_POST['programScheduleComment'];

        $queryUpdateScheduleComment = "UPDATE programstatus SET scheduleComment= '$scheduleComment' WHERE idProgram = '$id'";

        if ($conn->query($queryUpdateScheduleComment) === TRUE) {
            //unset($_POST['save_programTrasup']);                    
        }else{
            echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
        }
    }

    if(isset($_POST['save_programPaymentMethod'])){
        $paymentMethod = $_POST['programPaymentMethod'];

        $queryUpdatePaymentMethod = "UPDATE programstatus SET paymentMeth= '$paymentMethod' WHERE idProgram = '$id'";

        if ($conn->query($queryUpdatePaymentMethod) === TRUE) {
            //unset($_POST['save_programTrasup']);                    
        }else{
            echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
        }
    }
    
    if(isset($_POST['save_programOtherCostComment'])){
        $otherCostComment= $_POST['programOtherCostComment'];

        $queryUpdateOtherCostComment= "UPDATE programstatus SET otherCostComment= '$otherCostComment' WHERE idProgram = '$id'";

        if ($conn->query($queryUpdateOtherCostComment) === TRUE) {
            //unset($_POST['save_programTrasup']);                    
        }else{
            echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
        }
    }

    if(isset($_POST['save_programDuration'])){
        $duration = $_POST['programDuration'];

        $queryUpdateDuration = "UPDATE programstatus SET duration= '$duration' WHERE idProgram = '$id'";

        if ($conn->query($queryUpdateDuration) === TRUE) {
            //unset($_POST['save_programTrasup']);                    
        }else{
            echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
        }
    }

    if(isset($_POST['save_programBudgetSource'])){
        $paymentBudgetSource = $_POST['programBudgetSource'];

        $queryUpdatePaymentBudgetSource = "UPDATE programstatus SET bSource= '$paymentBudgetSource' WHERE idProgram = '$id'";

        if ($conn->query($queryUpdatePaymentBudgetSource) === TRUE) {
            //unset($_POST['save_programTrasup']);                    
        }else{
            echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
        }
    }

    if(isset($_POST['save_programCost'])){
        $courseFee = $_POST['programCourseFee'];
        $otherCost = $_POST['programOtherCost'];
        $totalCost = $_POST['programTotalCost'];

        $queryUpdateCost = "UPDATE programstatus SET courseFee= '$courseFee' , otherCost = '$otherCost', totalCost = '$totalCost' WHERE idProgram = '$id'";

        if ($conn->query($queryUpdateCost) === TRUE) {
            //unset($_POST['save_programTrasup']);                    
        }else{
            echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
        }
    }

    if(isset($_POST['uploadWordFile'])){

        if($_FILES['wordFile']['tmp_name'] != "" & $_FILES['wordFile']['type'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"){

            if($_FILES['wordFile']['error'] == 0) {
                $name = $_FILES['wordFile']['name'];
                $data =  $conn->real_escape_string(file_get_contents($_FILES['wordFile']['tmp_name']));
                
                $queryUploadWordFile = "UPDATE programstatus SET statusWord = 1 , wordFile = '$data', wordName = '$name' WHERE idProgram = '$id'";

                if ($conn->query($queryUploadWordFile) === TRUE) {
                    echo '<script type="text/javascript">alert("Successfully Uploaded !");</script>';                  
                }else{
                    echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
                }
            }else{
                echo '<script type="text/javascript">alert("An error accured while the file was being uploaded Error code: '.intval($_FILES['wordFile']['error']).'");</script>';
                
            }
        }else{
            echo '<script type="text/javascript">alert("Please select a word file !");</script>';
        }
        
    }

    if(isset($_POST['uploadPDFFile'])){

        if($_FILES['PDFFile']['tmp_name'] != "" & $_FILES['PDFFile']['type'] == "application/pdf"){

            if($_FILES['PDFFile']['error'] == 0) {
                $name = $_FILES['PDFFile']['name'];
                $data =  $conn->real_escape_string(file_get_contents($_FILES['PDFFile']['tmp_name']));
                
                $queryUploadPDFFile = "UPDATE programstatus SET statusPDF = 1 , PDFFile = '$data', PDFName = '$name' WHERE idProgram = '$id'";

                if ($conn->query($queryUploadPDFFile) === TRUE) {
                    echo '<script type="text/javascript">alert("Successfully Uploaded !");</script>';                  
                }else{
                    echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
                }
            }else{
                echo '<script type="text/javascript">alert("An error accured while the file was being uploaded ! Error code: '.intval($_FILES['wordFile']['error']).'");</script>';
                
            }
        }else{
            echo '<script type="text/javascript">alert("Please select a PDF file !");</script>';
        }
        
    }

    if(isset($_POST['progModulePending'])){
        $queryPending = "UPDATE programstatus SET progModuleStatus = 'Pending' WHERE idProgram = '$id'";
        if($conn->query($queryPending) === TRUE){
            echo '<script type="text/javascript">alert("Successfully updated..!");</script>';
        }else{
            echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
        }
    }
    if(isset($_POST['progModuleReceived'])){
        $queryPending = "UPDATE programstatus SET progModuleStatus = 'Received' WHERE idProgram = '$id'";
        if($conn->query($queryPending) === TRUE){
            echo '<script type="text/javascript">alert("Successfully updated..!");</script>';
        }else{
            echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
        }
    }

    if(isset($_POST['progNomineePending'])){
        $queryPending = "UPDATE programstatus SET progNomStatus = 'Pending' WHERE idProgram = '$id'";
        if($conn->query($queryPending) === TRUE){
            echo '<script type="text/javascript">alert("Successfully updated..!");</script>';
        }else{
            echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
        }
    }
    if(isset($_POST['progNomineeReceived'])){
        $queryPending = "UPDATE programstatus SET progNomStatus = 'Received' WHERE idProgram = '$id'";
        if($conn->query($queryPending) === TRUE){
            echo '<script type="text/javascript">alert("Successfully updated..!");</script>';
        }else{
            echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
        }
    }

    if(isset($_POST['progDeliverPending'])){
        $queryPending = "UPDATE programstatus SET deliveryStatus = '0' WHERE idProgram = '$id'";
        if($conn->query($queryPending) === TRUE){
            echo '<script type="text/javascript">alert("Successfully updated..!");</script>';
        }else{
            echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
        }
    }
    if(isset($_POST['progDeliverReceived'])){
        $queryPending = "UPDATE programstatus SET deliveryStatus = '1' WHERE idProgram = '$id'";
        if($conn->query($queryPending) === TRUE){
            echo '<script type="text/javascript">alert("Successfully updated..!");</script>';
        }else{
            echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
        }
    }

    if(isset($_POST['add_programModule'])){
        $module = $_POST['programAddModule'];
        if($module != ""){
            $queryAddModule = "INSERT INTO moduleprogramstatus ( idProgram, moduleName) VALUES ('$id','$module')";
            if ($conn->query($queryAddModule) === TRUE) {

            }else{
                echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
            }
        }else{
            echo '<script type="text/javascript">alert("Please inset module name for add !");</script>';
        }
    }
    if(isset($_POST['add_programNominee'])){
        $nominee = $_POST['programAddNominee'];
        $nomineeID = $_POST['programAddNomin'];
        if($nominee != "" & $nomineeID != ""){
            $queryAddNominee = "INSERT INTO nomineeprogramstatus ( idProgram, nomineeName, empID) VALUES ('$id','$nominee','$nomineeID')";
            if ($conn->query($queryAddNominee) === TRUE) {

            }else{
                echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
            }
        }else{
            echo '<script type="text/javascript">alert("Please inset nominee name and employee ID name for add !");</script>';
        }
    }

    date_default_timezone_set("Asia/Colombo");


?>

<!Doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="title icon" href="images/title-img2.jpg">
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <!--<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>-->

        <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" 
        integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">-->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" 
        integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="styleAccordian.css">
        <title>Admin Dashboard</title>
    </head>
    <body>
        
        <!-- navbar -->
        <nav class="navbar navbar-expand-md navbar-light">
            <button class="navbar-toggler ml-auto mb-2 bg-light" type="button"
            data-toggle="collapse" data-target="#myNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="myNavbar">
                <div class="container-fluid">
                    <div class="row">
                        <!--sidebar-->
                        <div class="col-xl-2 col-lg-3 col-md-3 sidebar fixed-top">
                            <a href="Dashboard.php" class="navbar-brand
                            text-white d-block mx-auto text-center py-3
                            mb-4 bottom-border">Portal</a>
                            <div class="bottom-border pb-3" align="center">
                                <a href="myProfile.php" class="text-white">
                                    <?php
                                        echo    ''.$userDetails['fName'].' '.$userDetails['lName'].'';
                                    ?>
                                </a>
                            </div>
                            <ul class="navbar-nav flex-column mt-4">

                                <li class="nav-item"><a href="trainingDashboard.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-tachometer-alt text-light 
                                fa-lg fa-fw mr-3"></i>Dashboard</a></li>

                                <li class="nav-item"><a href="Dashboard.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-home text-light 
                                fa-lg fa-fw mr-3"></i>Home</a></li>

                                <li class="nav-item"><a href="Programs.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-tasks text-light 
                                fa-lg fa-fw mr-3"></i>Programs</a></li>

                                <li class="nav-item"><a href="History.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-history text-light 
                                fa-lg fa-fw mr-3"></i>History</a></li>

                                <li class="nav-item"><a href="Calender.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-calendar text-light 
                                fa-lg fa-fw mr-3"></i>Calendar</a></li>

                                <li class="nav-item"><a href="Users.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-users text-light 
                                fa-lg fa-fw mr-3"></i>Users</a></li>

                                <li class="nav-item"><a href="settings.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-cog text-light 
                                fa-lg fa-fw mr-3"></i>Settings</a></li>
                                
                            </ul>
                        </div>
                        <!--end of sidebar-->

                        <!--TopNav-->
                        <div class="col-xl-10 col-lg-9 col-md-9 ml-auto bg-dark fixed-top py-2 top-navbar">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h4 class="text-light 
                                    text-uppercase mb-0">View Programs</h4>
                                </div>
                                <div class="col-md-5">
                                    
                                </div>
                                <div class="col-md-3">
                                    <ul class="navbar-nav">                            

                                        <li class="nav-item ml-md-auto dropdown">
                                            <a href="#" class="nav-link dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown"><i class="fas fa-bell text-muted fa-lg"></i>
                                                <span class="badge badge-danger" id="count"></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-notify" aria-labelledby="navbarDropdown">
                                                
                                            </div>
                                        </li>

                                        <li class="nav-item dropdown ml-md-auto">
                                            <a href="#" 
                                            class="nav-link dropdown-toggle" id="navbarDropdown" 
                                            role="button" data-toggle="dropdown">
                                                <i class="fas fa-user-circle
                                                    text-muted fa-lg">
                                                </i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                <h1 class="dropdown-header"><i class="fas fa-user text-dark 
                                                    fa-lg mr-3"></i>
                                                    <?php
                                                        echo    ''.$userDetails['fName'].' '.$userDetails['lName'].'';
                                                    ?>
                                                </h1>
                                                <div class="dropdown-divider"></div>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="Dashboard.php"><i class="fas fa-home text-dark 
                                                    fa-lg fa-fw mr-3"></i>Home</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="myProfile.php"><i class="fas fa-user text-dark 
                                                    fa-lg fa-fw mr-3"></i>My Profile</a>
                                                <div class="dropdown-divider"></div>                                                
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#sign-out"><i class="fas fa-sign-out-alt text-danger 
                                                    fa-lg fa-fw mr-3"></i>Logout</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--end of TopNav-->
                    </div>
                </div>
            </div>
        </nav>

        <!-- end of navbar -->

        <!-- Modal -->

        <div class="modal fade" id="sign-out">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Want to leave?</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        Press logout to leave
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Stay Here</button>
                        <form action="Dashboard.php" method="POST">
                            
                            <button type="submit" name="Logout" class="btn btn-danger btn-block">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- end of Modal -->

        <!-- model send emails -->
        <?php
             $validationQuery = "SELECT * FROM programstatus WHERE idProgram = '$id'";
             $validateResult = mysqli_query($conn,$validationQuery) or die(mysqli_error($conn));
             $validateTot = mysqli_num_rows($validateResult);
     
             
     
             if($validateTot == 0){
                 echo '<script type="text/javascript">alert("Wrong Entry !");</script>';
                 echo "<script>location.href='Dashboard.php'</script>";
             }
            $progDetails = mysqli_fetch_array($validateResult);
        ?>
        <div class="modal fade" id="sendMails">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Send Approval Email - GTD/CXO-1</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row px-4">
                            <h5><small>Please select persons to send</small></h5>
                        </div>
                        <div class="row mt-1 px-4">
                            <div class="col-10">
                                <small>GTD</small>
                            </div>
                            <div class="col-2">
                                <input type="checkbox" id="GTD" onclick=" Selection(this);" value="GTD" checked>
                            </div>
                        </div>
                        <?php
                            $queryCXOAll = "SELECT * FROM user WHERE role = 'CXO-1' ORDER BY unit";
                            $resultCXOAll = mysqli_query($conn,$queryCXOAll) or die(mysqli_error($conn));
                            while($CXOAll = mysqli_fetch_array($resultCXOAll)){
                        ?>
                        <div class="row mt-1 px-4">
                            <div class="col-10">
                                <small>
                                    CXO-1 (
                                    <?php
                                        $unit = $CXOAll['unit'];
                                        $sel = "SELECT fName FROM user WHERE role = 'CXO-1' and unit = '$unit'";
                                        $CXO1 = mysqli_query($conn,$sel) or die(mysqli_error($conn));
                                        $CXO11 = mysqli_fetch_array($CXO1);
                                        echo    $CXO11['fName'];
                                    ?>
                                    )
                                </small>
                            </div>
                            <div class="col-2">
                                <input type="checkbox" id="checkCXO" onclick=" Selection(this);" value="<?php   echo    $unit;  ?>">
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <form action="" id="send" method="POST">
                            <button type="button" class="btn btn-success" id="sendFirst">Send</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="resendMailGTD">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Resend Approval Email - GTD</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row mt-1 px-4">
                            <div class="col-10">
                                <small>Resend approval email to GTD</small>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="" id="send" method="POST">
                            <button type="button" class="btn btn-success" id="resendGTD">Send</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="sendMailCXO1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Send Approval Email - CXO-1</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row px-4">
                            <h5><small>Please select person to send</small></h5>
                        </div>
                        <?php
                            $queryCXOAll = "SELECT * FROM user WHERE role = 'CXO-1' ORDER BY unit";
                            $resultCXOAll = mysqli_query($conn,$queryCXOAll) or die(mysqli_error($conn));
                            while($CXOAll = mysqli_fetch_array($resultCXOAll)){
                        ?>
                        <div class="row mt-1 px-4">
                            <div class="col-10">
                                <small>
                                    CXO-1 (
                                    <?php
                                        $unit = $CXOAll['unit'];
                                        $sel = "SELECT fName FROM user WHERE role = 'CXO-1' and unit = '$unit'";
                                        $CXO1 = mysqli_query($conn,$sel) or die(mysqli_error($conn));
                                        $CXO11 = mysqli_fetch_array($CXO1);
                                        echo    $CXO11['fName'];
                                    ?>
                                    )
                                </small>
                            </div>
                            <div class="col-2">
                                <input type="checkbox" id="checkCXO1" onclick=" SelectionCXO(this);" value="<?php   echo    $unit;  ?>">
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <form action="" id="send" method="POST">
                            <button type="button" class="btn btn-success" id="sendCXO" disabled>Send</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
            $queryCXOAll = "SELECT * FROM user WHERE role = 'CXO-1' ORDER BY unit";
            $resultCXOAll = mysqli_query($conn,$queryCXOAll) or die(mysqli_error($conn));
            while($CXOAll = mysqli_fetch_array($resultCXOAll)){
                $cxoUnit = $CXOAll['unit'];
        ?>

        <div class="modal fade" id="resendMailXCO1<?php echo  $cxoUnit;  ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Resend Approval Email - CXO-1</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row mt-1 px-4">
                            <div class="col-10">
                                <small>Resend approval email to CXO-1 (
                                    <?php
                                        echo    $CXOAll['fName'];
                                    ?>
                                )</small>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="" id="send" method="POST">
                            <button type="button" class="btn btn-success" id="resendCXO<?php   echo   $cxoUnit; ?>">Send</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
            }
        ?>

        <div class="modal fade" id="sendMailGCTO">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Send Approval Email - GCTO</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row mt-1 px-4">
                            <div class="col-10">
                                <small>Send approval email to GCTO</small>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="" id="send" method="POST">
                            <button type="button" class="btn btn-success" id="sendGCTO">Send</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="resendMailGCTO">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Resend Approval Email - GCTO</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row mt-1 px-4">
                            <div class="col-10">
                                <small>Resend approval email to GCTO</small>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="" id="send" method="POST">
                            <button type="button" class="btn btn-success" id="resendGCTO">Send</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="sendMailGCEO">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Send Approval Email - GCEO</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row mt-1 px-4">
                            <div class="col-10">
                                <small>Send approval email to GCEO</small>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="" id="send" method="POST">
                            <button type="button" class="btn btn-success" id="sendGCEO">Send</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="resendMailGCEO">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Resend Approval Email - GCEO</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row mt-1 px-4">
                            <div class="col-10">
                                <small>Resend approval email to GCEO</small>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="" id="send" method="POST">
                            <button type="button" class="btn btn-success" id="resendGCEO">Send</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="sendMailHR">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Send Email - HR</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row mt-1 px-4">
                            <div class="col-10">
                                <small>Send program details to HR</small>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="" id="send" method="POST">
                            <button type="button" class="btn btn-success" id="sendHR">Send</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- end of model send emails -->

        <!-- model editGTDAppr -->

        <div class="modal fade" id="editGTDAppr">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit GTD Approval</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row mt-1 px-4">
                            <div class="col-6">
                                <small>Request Sent Date</small>
                            </div>
                            <div class="col-6">
                                <small><input type="date" style="text-align: right" name="GTDSentDate" id="GTDSentDate" class="form-control"/></small>
                            </div>
                        </div>
                        <div class="row mt-3 px-4">
                            <div class="col-6">
                                <small>Status</small>
                            </div>
                            <div class="col-6">
                                <select class="form-control"  name="GTDStatus" id="GTDStatus" >
                                    <option>Select Status</option>
                                    <option>Pending</option>
                                    <option>Approved</option>
                                    <option>Rejected</option>
                                    <option>N/A</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3 px-4">
                            <div class="col-6">
                                <small>Delivered Date</small>
                            </div>
                            <div class="col-6">
                                <small><input type="date" style="text-align: right" name="GTDDeliveredDate" id="GTDDeliveredDate" class="form-control"/></small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="" id="SaveAppr" method="POST">
                            <button type="button" class="btn btn-info" id="editGTDApproval">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- end of model editGTDAppr -->

        
        <!-- model editXCOAppr -->

        <div class="modal fade" id="editXCOAppr">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit CXO-1 Approval</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row mt-1 px-4">
                            <div class="col-6">
                                <small>Request Sent Date</small>
                            </div>
                            <div class="col-6">
                                <small><input type="date" style="text-align: right" name="CXOSentDate" id="CXOSentDate" class="form-control"/></small>
                            </div>
                        </div>
                        <div class="row mt-3 px-4">
                            <div class="col-6">
                                <small>Status</small>
                            </div>
                            <div class="col-6">
                                <select class="form-control"  name="CXOStatus" id="CXOStatus" >
                                    <option>Select Status</option>
                                    <option>Pending</option>
                                    <option>Approved</option>
                                    <option>Rejected</option>
                                    <option>N/A</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3 px-4">
                            <div class="col-6">
                                <small>Delivered Date</small>
                            </div>
                            <div class="col-6">
                                <small><input type="date" style="text-align: right" name="CXODeliveredDate" id="CXODeliveredDate" class="form-control"/></small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="" id="SaveAppr" method="POST">
                            <button type="button" class="btn btn-info" id="editCXOApproval">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- end of model editXCOAppr -->

        <!-- model editGCTOAppr -->

        <div class="modal fade" id="editGCTOAppr">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit GCTO Approval</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row mt-1 px-4">
                            <div class="col-6">
                                <small>Request Sent Date</small>
                            </div>
                            <div class="col-6">
                                <small><input type="date" style="text-align: right" name="GCTOSentDate" id="GCTOSentDate" class="form-control"/></small>
                            </div>
                        </div>
                        <div class="row mt-3 px-4">
                            <div class="col-6">
                                <small>Status</small>
                            </div>
                            <div class="col-6">
                                <select class="form-control"  name="GCTOStatus" id="GCTOStatus" >
                                    <option>Select Status</option>
                                    <option>Pending</option>
                                    <option>Approved</option>
                                    <option>Rejected</option>
                                    <option>N/A</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3 px-4">
                            <div class="col-6">
                                <small>Delivered Date</small>
                            </div>
                            <div class="col-6">
                                <small><input type="date" style="text-align: right" name="GCTODeliveredDate" id="GCTODeliveredDate" class="form-control"/></small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="" id="SaveAppr" method="POST">
                            <button type="button" class="btn btn-info" id="editGCTOApproval">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- end of model editGCTOAppr -->

        <!-- model editGCEOAppr -->

        <div class="modal fade" id="editGCEOAppr">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit GCEO Approval</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row mt-1 px-4">
                            <div class="col-6">
                                <small>Request Sent Date</small>
                            </div>
                            <div class="col-6">
                                <small><input type="date" style="text-align: right" name="GCEOSentDate" id="GCEOSentDate" class="form-control"/></small>
                            </div>
                        </div>
                        <div class="row mt-3 px-4">
                            <div class="col-6">
                                <small>Status</small>
                            </div>
                            <div class="col-6">
                                <select class="form-control"  name="GCEOStatus" id="GCEOStatus" >
                                    <option>Select Status</option>
                                    <option>Pending</option>
                                    <option>Approved</option>
                                    <option>Rejected</option>
                                    <option>N/A</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3 px-4">
                            <div class="col-6">
                                <small>Delivered Date</small>
                            </div>
                            <div class="col-6">
                                <small><input type="date" style="text-align: right" name="GCEODeliveredDate" id="GCEODeliveredDate" class="form-control"/></small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="" id="SaveAppr" method="POST">
                            <button type="button" class="btn btn-info" id="editGCEOApproval">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- end of model editXCOAppr -->

        <!-- cards -->

       
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                        <div class="row pt-md-3 mt-md-5 mb-auto">
                            <div class="col-1">
                            </div>
                            <div class="col-10">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <div align="center" class="panel-title"><?php   echo    $progDetails['progName'];   ?></div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Trainer / Supplier</small>
                                            </div>
                                            <div class="col-9">
                                                <small><?php   echo    $progDetails['trainrSupp'];   ?></small>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Type</small>
                                            </div>
                                            <div class="col-9">
                                                <small><?php   echo    $progDetails['progType'];   ?></small>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Priority</small>
                                            </div>
                                            <div class="col-9">
                                                <small><?php   echo    $progDetails['priority'];   ?></small>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Slots</small>
                                            </div>
                                            <div class="col-9">
                                                <small><?php   echo    $progDetails['slots'];   ?></small>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Requested By</small>
                                            </div>
                                            <div class="col-9">
                                                <small><?php   echo    $progDetails['requestedBy'];   ?></small>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Division</small>
                                            </div>
                                            <div class="col-9">
                                                <small><?php   echo    $progDetails['division'];   ?></small>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Unit</small>
                                            </div>
                                            <div class="col-9">
                                                <small><?php   echo    $progDetails['unit'];   ?></small>
                                            </div>
                                        </div>
                                        <form action="" method="POST">
                                        <div class="row mt-3">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Program Start Date</small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>
                                                    <?php
                                                        if($progDetails['stDate'] == ""){
                                                            echo '<span class="text-danger">Not given</span>';
                                                        }else{
                                                            echo    $progDetails['stDate'];
                                                        }
                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <input type="hidden" style="text-align: right" name="programStartDate" id="programStartDate" class="form-control"/>
                                            </div>
                                            <div class="col-3">
                                                <button type="button" name="edit_programDate" id="edit_programDate" style="display:inline-block;" class="btn btn-info btn-sm">Edit</button>
                                                <button type="submit" name="save_programDate" id="save_programDate" style="display:none;" class="btn btn-info btn-sm">Save</button>
                                                <button type="button" name="cancel_programDate" id="cancel_programDate" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Program End Date</small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>
                                                    <?php
                                                        if($progDetails['edDate'] == ""){
                                                            echo '<span class="text-danger">Not given</span>';
                                                        }else{
                                                            echo    $progDetails['edDate'];
                                                        }
                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <input type="hidden" style="text-align: right" name="programEndDate" id="programEndDate" class="form-control"/>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Program Schedule Comment</small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>
                                                    <?php
                                                        if($progDetails['scheduleComment'] == ""){
                                                            echo '<span class="text-danger">Not given</span>';
                                                        }else{
                                                            echo    $progDetails['scheduleComment'];
                                                        }
                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <input type="hidden" style="text-align: right" name="programScheduleComment" id="programScheduleComment" class="form-control"/>
                                            </div>
                                            <div class="col-3">
                                                <button type="button" name="edit_programScheduleComment" id="edit_programScheduleComment" style="display:inline-block;" class="btn btn-info btn-sm">Edit</button>
                                                <button type="submit" name="save_programScheduleComment" id="save_programScheduleComment" style="display:none;" class="btn btn-info btn-sm">Save</button>
                                                <button type="button" name="cancel_programScheduleComment" id="cancel_programScheduleComment" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Program Duration</small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>
                                                    <?php
                                                        if($progDetails['duration'] == ""){
                                                            echo '<span class="text-danger">Not given</span>';
                                                        }else{
                                                            echo    $progDetails['duration'];
                                                        }
                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <input type="hidden" style="text-align: right" name="programDuration" id="programDuration" class="form-control"/>
                                            </div>
                                            <div class="col-3">
                                                <button type="button" name="edit_programDuration" id="edit_programDuration" style="display:inline-block;" class="btn btn-info btn-sm">Edit</button>
                                                <button type="submit" name="save_programDuration" id="save_programDuration" style="display:none;" class="btn btn-info btn-sm">Save</button>
                                                <button type="button" name="cancel_programDuration" id="cancel_programDuration" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                            </div>
                                        </div>
                                        </form>
                                        <hr>
                                        <form action="" method="POST">
                                        <div class="row">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Payment Method</small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small><?php    if($progDetails['paymentMeth']==""){    echo    '<label class="text-danger">Not given</label>'; }else{  echo    $progDetails['paymentMeth'];   }   ?></small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <input type="hidden" name="programPaymentMethod" id="programPaymentMethod" class="form-control"/>
                                            </div>
                                            <div class="col-3">
                                                <button type="button" name="edit_programPaymentMethod" id="edit_programPaymentMethod" style="display:inline-block;" class="btn btn-info btn-sm">Edit</button>
                                                <button type="submit" name="save_programPaymentMethod" id="save_programPaymentMethod" style="display:none;" class="btn btn-info btn-sm">Save</button>
                                                <button type="button" name="cancel_programPaymentMethod" id="cancel_programPaymentMethod" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Other Cost Comment</small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small><?php    if($progDetails['otherCostComment']==""){    echo    '<label class="text-danger">Not given</label>'; }else{  echo    $progDetails['otherCostComment'];   }   ?></small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <input type="hidden" name="programOtherCostComment" id="programOtherCostComment" class="form-control"/>
                                            </div>
                                            <div class="col-3">
                                                <button type="button" name="edit_programOtherCostComment" id="edit_programOtherCostComment" style="display:inline-block;" class="btn btn-info btn-sm">Edit</button>
                                                <button type="submit" name="save_programOtherCostComment" id="save_programOtherCostComment" style="display:none;" class="btn btn-info btn-sm">Save</button>
                                                <button type="button" name="cancel_programOtherCostComment" id="cancel_programOtherCostComment" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Budget Source</small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center9">
                                                <small><?php   echo    $progDetails['bSource'];   ?></small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <input type="hidden" name="programBudgetSource" id="programBudgetSource" class="form-control"/>
                                            </div>
                                            <div class="col-3">
                                                <button type="button" name="edit_programBudgetSource" id="edit_programBudgetSource" style="display:inline-block;" class="btn btn-info btn-sm">Edit</button>
                                                <button type="submit" name="save_programBudgetSource" id="save_programBudgetSource" style="display:none;" class="btn btn-info btn-sm">Save</button>
                                                <button type="button" name="cancel_programBudgetSource" id="cancel_programBudgetSource" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Course Fee</small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small><?php   echo     "".$progDetails['currency']."  ".$progDetails['courseFee']."";   ?></small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <input type="hidden" min="0" style="width:100%; text-align: right;" name="programCourseFee" id="programCourseFee" onclick="setTotal();" onkeyup="setTotal();" onfocusout="setVal(this)" value="<?php   echo     $progDetails['courseFee'];   ?>" class="form-control"/>
                                            </div>
                                            <div class="col-3">
                                                <button type="button" name="edit_programCost" id="edit_programCost" style="display:inline-block;" class="btn btn-info btn-sm">Edit</button>
                                                <button type="submit" name="save_programCost" id="save_programCost" style="display:none;" class="btn btn-info btn-sm">Save</button>
                                                <button type="button" name="cancel_programCost" id="cancel_programCost" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Other Cost</small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small><?php   echo     "".$progDetails['currency']."  ".$progDetails['otherCost']."";   ?></small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <input type="hidden" min="0" style="width:100%; text-align: right;" name="programOtherCost" id="programOtherCost" onclick="setTotal();" onkeyup="setTotal();" onfocusout="setVal(this)" value="<?php   echo     $progDetails['otherCost'];   ?>" class="form-control"/>
                                            </div>
                                            <div calss="col-3">
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Total Cost</small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small><b><label style="text-decoration-line: underline; text-decoration-style: double;"><?php   echo     "".$progDetails['currency']."  ".$progDetails['totalCost']."";   ?></label></b></small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <input type="hidden" min="0" style="width:100%; text-align: right;" name="programTotalCost" id="programTotalCost" value="<?php    echo    $progDetails['totalCost'];  ?>" class="form-control" readonly/>
                                            </div>
                                            <div class="col-3">
                                            </div>
                                        </div>
                                        </form>
                                        <hr>
                                        <form action="" method="POST" id="module">
                                            <div class="row">
                                                <div class="col-3 d-flex justify-content-between align-items-center">
                                                    <small>Module Status</small>
                                                </div>
                                                <div class="col-5 d-flex justify-content-between align-items-center">
                                                    <?php
                                                        if($progDetails['progModuleStatus'] == "Received"){
                                                            echo    '<span class="badge badge-pill badge-success">'.$progDetails['progModuleStatus'].'</span>';
                                                        }else if($progDetails['progModuleStatus'] == "Pending"){
                                                            echo    '<span class="badge badge-pill badge-warning">'.$progDetails['progModuleStatus'].'</span>';
                                                        }
                                                    ?>
                                                </div>
                                                <div  class="col-4">
                                                    <button type="button" name="edit_moduleStatus" id="edit_moduleStatus" style="display:inline-block;" class="btn btn-info btn-sm">Edit Status</button>
                                                    <button type="submit" name="progModulePending" id="progModulePending" style="display:none;" class="btn btn-warning btn-sm">Pending</button>
                                                    <button type="submit" name="progModuleReceived" id="progModuleReceived" style="display:none;" class="btn btn-success btn-sm">Received</button>
                                                    <button type="button" name="cancel_moduleStatus" id="cancel_moduleStatus" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-3 d-flex justify-content-between align-items-center">
                                                    <small>Module Count</small>
                                                </div>
                                                <div class="col-9">
                                                    <small>
                                                        <?php
                                                            $moduleQuery = "SELECT * FROM moduleprogramstatus WHERE idProgram = '$id'";
                                                            $resultModuleQuery = mysqli_query($conn,$moduleQuery) or die(mysqli_error($conn));
                                                            $moduleCount = mysqli_num_rows($resultModuleQuery);
                                                            echo     $moduleCount;   
                                                        ?>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mt-1" style="height:200px;">
                                                <div class="col-2 d-flex justify-content-between align-items-center" style="height:100%;">
                                                    <small>Modules</small>
                                                </div>
                                                <div class="col-5 justify-content-between align-items-center" style="height:100%; width:100%; overflow: auto; overflow-x: hidden;">
                                                    <small>
                                                        <!--<div class="row" style="height:100%; width:100%; overflow: auto; overflow-x: hidden;">-->
                                                            <table class="table table-bordered" style="width:100%;">
                                                                <tr>
                                                                    <th>Module Name</th>
                                                                    <th>Remove</th>
                                                                </tr>
                                                                <?php
                                                                    if($moduleCount>0){
                                                                        while($module = mysqli_fetch_array($resultModuleQuery)){
                                                                ?>
                                                                    <tr>
                                                                    <td><?php   echo    $module['moduleName'];    ?></td>
                                                                    <td><button type="button" name="removeModule" class="btn btn-group btn-danger removeModule" style="padding: .25rem .4rem; font-size: .875rem; line-height: .95; border-radius: .2rem;" id="<?php    echo    $module['idModule'];    ?>">Remove</button></td>
                                                                    </tr>
                                                                <?php
                                                                        }
                                                                    }else{
                                                                ?>
                                                                    <span class="text-danger">No modules given</span>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </table>
                                                        <!--</div>-->
                                                    </small>
                                                </div>
                                                <div class="col-3 d-flex justify-content-between align-items-center" style="height:100%;">
                                                    
                                                        <input type="hidden" style="width:170%;" name="programAddModule" id="programAddModule"  class="form-control mr-2"/>
                                                        <span id="error_programAddModule" class="text-danger"></span>
                                                        <button type="submit" name="add_programModule" id="add_programModule" style="display:none;" class="btn btn-info btn-sm">Add</button>
                                                </div>
                                                <div class="col-2 d-flex justify-content-between align-items-center" style="height:100%;">
                                                    <button type="button" name="edit_programModule" id="edit_programModule" style="display:inline-block;" class="btn btn-info btn-sm">Edit</button>
                                                    <button type="button" name="cancel_programModule" id="cancel_programModule" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                        <hr>
                                        <form action="" method="POST" id="nominee">
                                            <div class="row">
                                                <div class="col-3 d-flex justify-content-between align-items-center">
                                                    <small>Nominee Status</small>
                                                </div>
                                                <div class="col-5 d-flex justify-content-between align-items-center">
                                                    
                                                        <?php
                                                            if($progDetails['progNomStatus'] == "Received"){
                                                                echo    '<span class="badge badge-pill badge-success">'.$progDetails['progNomStatus'].'</span>';
                                                            }else if($progDetails['progNomStatus'] == "Pending"){
                                                                echo    '<span class="badge badge-pill badge-warning">'.$progDetails['progNomStatus'].'</span>';
                                                            }
                                                        ?>
                                                    
                                                </div>
                                                <div  class="col-4">
                                                    <button type="button" name="edit_nomineeStatus" id="edit_nomineeStatus" style="display:inline-block;" class="btn btn-info btn-sm">Edit Status</button>
                                                    <button type="submit" name="progNomineePending" id="progNomineePending" style="display:none;" class="btn btn-warning btn-sm">Pending</button>
                                                    <button type="submit" name="progNomineeReceived" id="progNomineeReceived" style="display:none;" class="btn btn-success btn-sm">Received</button>
                                                    <button type="button" name="cancel_nomineeStatus" id="cancel_nomineeStatus" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-3 d-flex justify-content-between align-items-center">
                                                    <small>Nominee Count</small>
                                                </div>
                                                <div class="col-9">
                                                    <small>
                                                        <?php
                                                            $nomineeQuery = "SELECT * FROM nomineeprogramstatus WHERE idProgram = '$id'";
                                                            $resultNomineeQuery = mysqli_query($conn,$nomineeQuery) or die(mysqli_error($conn));
                                                            $nomineeCount = mysqli_num_rows($resultNomineeQuery);
                                                            echo     $nomineeCount;   
                                                        ?>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mt-1" style="height:200px;">
                                                <div class="col-2 d-flex justify-content-between align-items-center" style="height:100%;">
                                                    <small>Nominees</small>
                                                </div>
                                                <div class="col-5 justify-content-between align-items-center" style="height:100%; width:100%; overflow: auto; overflow-x: hidden;">
                                                    <small>
                                                            <table class="table table-bordered" id="modules" style="width:100%;">
                                                                <tr>
                                                                    <th>Nominee Name</th>
                                                                    <th>Emp ID</th>
                                                                    <th>Remove</th>
                                                                </tr>
                                                                <?php
                                                                    if($nomineeCount>0){
                                                                        while($nominee = mysqli_fetch_array($resultNomineeQuery)){
                                                                ?>
                                                                    <tr>
                                                                    <td><?php   echo    $nominee['nomineeName'];    ?></td>
                                                                    <td><?php   echo    $nominee['empID'];    ?></td>
                                                                    <td><button type="button" name="removeNominee" class="btn btn-group btn-danger removeNominee" style="padding: .25rem .4rem; font-size: .875rem; line-height: .95; border-radius: .2rem;" id="<?php    echo    $nominee['idNominee'];    ?>">Remove</button></td>
                                                                    </tr>
                                                                <?php
                                                                        }
                                                                    }else{
                                                                ?>
                                                                    <span class="text-danger">No nominees given</span>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </table>
                                                    </small>
                                                </div>
                                                <div class="col-3" style="height:200px;">
                                                    <small id="nomName" style="display:none;">Nominee Name</small>
                                                    <input type="hidden" style="width:80%;" name="programAddNominee" id="programAddNominee"  class="form-control mr-2"/>
                                                    <small id="nomID" style="display:none;">Emp ID</small>
                                                    <input type="hidden" style="width:80%;" name="programAddNomin" id="programAddNomin"  class="form-control mr-2"/>
                                                    <br>
                                                    <span id="error_programAddNominee" class="text-danger"></span>
                                                    <button type="submit" name="add_programNominee" id="add_programNominee" style="display:none;"class="btn btn-info btn-sm">Add</button>
                                                </div>
                                                <div class="col-2 d-flex justify-content-between align-items-center" style="height:200px;">
                                                    <button type="button" name="edit_programNominee" id="edit_programNominee" style="display:inline-block;" class="btn btn-info btn-sm">Edit</button>
                                                    <button type="button" name="cancel_programNominee" id="cancel_programNominee" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                        <hr>
                                        <form action="" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div align="center" class="col">
                                                            <small><b>Upload Word File </b>
                                                                <?php   if($progDetails['statusWord'] == 0){   ?>
                                                                    <span class="badge badge-pill badge-warning">Pending</span>
                                                                <?php   }else if($progDetails['statusWord'] == 1){   ?>
                                                                    <span class="badge badge-pill badge-success">Uploaded</span>
                                                                <?php } ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <small>
                                                    <?php   if($progDetails['statusWord'] != 0){   ?>
                                                        <div class="row mt-3">
                                                            <div align="center" class="col">
                                                                <?php   echo    $progDetails['wordName']; ?>
                                                            </div>
                                                        </div>
                                                    <?php   }   ?>
                                                    <div class="row mt-3">
                                                        <div align="center" class="col">
                                                            <input type="file" class="border rounded" name="wordFile" id="wordFile"/>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div align="center" class="col">
                                                            <?php
                                                                if($progDetails['statusWord']== 0 & $progDetails['wordFile'] == ""){
                                                            ?>
                                                                <button type="submit" class="btn btn-info btn-sm" name="uploadWordFile" id="uploadWordFile">Upload</button>
                                                            <?php
                                                                }else if($progDetails['statusWord'] != 0 & $progDetails['wordFile'] != ""){
                                                            ?>
                                                                <button type="submit" class="btn btn-info btn-sm" name="uploadWordFile" id="uploadWordFile">Replace</button>
                                                            <?php
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    </small>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div align="center" class="col">
                                                            <small><b>Upload PDF File </b>
                                                                <?php   if($progDetails['statusPDF'] == 0){   ?>
                                                                    <span class="badge badge-pill badge-warning">Pending</span>
                                                                <?php   }else if($progDetails['statusPDF'] == 1){   ?>
                                                                    <span class="badge badge-pill badge-success">Uploaded</span>
                                                                <?php } ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <small>
                                                    <?php   if($progDetails['statusPDF'] != 0){   ?>
                                                        <div class="row mt-3">
                                                            <div align="center" class="col">
                                                                <?php   echo    $progDetails['PDFName']; ?>
                                                            </div>
                                                        </div>
                                                    <?php   }   ?>
                                                    <div class="row mt-3">
                                                        <div align="center" class="col">
                                                            <input type="file" class="border rounded" name="PDFFile"/>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div align="center" class="col">
                                                            <?php
                                                                if($progDetails['statusPDF']== 0 & $progDetails['PDFFile'] == ""){
                                                            ?>
                                                                <button type="submit" class="btn btn-info btn-sm" name="uploadPDFFile">Upload</button>
                                                            <?php
                                                                }else if($progDetails['statusPDF'] != 0 & $progDetails['PDFFile'] != ""){
                                                            ?>
                                                                <button type="submit" class="btn btn-info btn-sm" name="uploadPDFFile">Replace</button>
                                                            <?php
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    </small>
                                                </div>
                                            </div>
                                        </form>
                                        <hr>
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div align="center" class="col-6">
                                                <small><b>GTD Approval</b></small>
                                            </div>
                                            <div class="col-3">
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Request Sent Date</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <small>
                                                    <?php
                                                        if($progDetails['progApprGTD'] == 4){
                                                            echo    "-";
                                                        }else if($progDetails['reqDtAprGTD'] == ""){
                                                            echo    '<span class="text-danger">Did not sent for approval !</span>';
                                                        }else{
                                                            echo    $progDetails['reqDtAprGTD'];
                                                        }
                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <?php
                                                    if($progDetails['reqDtAprGTD'] == ""){
                                                ?>
                                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#sendMails" <?php   if($progDetails['progNomStatus'] == "Pending" | $progDetails['progModuleStatus'] == "Pending" | $progDetails['progApprGTD'] == 4){ echo    "disabled";  }else{   }   ?>>
                                                        Send
                                                    </button>
                                                <?php
                                                    }else if($progDetails['reqDtAprGTD'] != "" & $progDetails['progApprGTD'] == 3){
                                                ?>
                                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#resendMailGTD">
                                                        Resend
                                                    </button>
                                                <?php
                                                    }else{
                                                ?>
                                                    <button class="btn btn-sm btn-success" disabled>
                                                        Sent <i class="fa fa-check" aria-hidden="true"></i>
                                                    </button>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Approval Status</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <small>
                                                    <?php
                                                        if($progDetails['progApprGTD'] == 4){
                                                            echo 'N/A <i class="fas fa-ban text-secondary"></i> ';
                                                        }else if($progDetails['progApprGTD'] == 1){
                                                            echo 'Pending <i class="fas fa-clock" style="color: orange;"></i> ';
                                                        }else if($progDetails['progApprGTD'] == 2){
                                                            echo 'Approved <i class="fas fa-check-circle" style="color: green;"></i> ';
                                                        }else if($progDetails['progApprGTD'] == 3){
                                                            echo 'Rejected <i class="fas fa-times-circle" style="color: Red;"></i> ';
                                                        }else if($progDetails['progApprGTD'] == 0){
                                                            echo '-';
                                                        }
                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editGTDAppr" >
                                                    Edit Approval
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Delivered Date</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <small>
                                                    <?php
                                                        if($progDetails['progApprGTD'] == 0 | $progDetails['progApprGTD'] == 4){
                                                            echo '-';
                                                        }else{
                                                            if($progDetails['dtApprGTD'] == ""){
                                                                echo    '<span class="text-danger">Did not received yet !</span>';
                                                            }else{
                                                                echo    $progDetails['dtApprGTD'];
                                                            }
                                                        }
                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                
                                            </div>
                                        </div>
                                        <?php
                                            if($progDetails['statusCXO1'] == 0){ 
                                        ?>
                                        <hr>
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div align="center" class="col-6">
                                                <small>
                                                    <b>CXO-1 Approval (
                                                        
                                                    )</b>
                                                </small>
                                            </div>
                                            <div class="col-3">
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Request Sent Date</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <small>
                                                    <span class="text-danger">Did not sent for approval !</span>
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#sendMailCXO1" <?php   if($progDetails['progApprGTD'] == 1 | $progDetails['progApprGTD'] == 2){   }else{  echo    "disabled"; } if($progDetails['statusCXO1'] == 4){  echo    "disabled"; }  ?>>
                                                    Send
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Approval Status</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <small>
                                                    -
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editXCOAppr" >
                                                    Edit Approval
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Delivered Date</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <small>
                                                    -
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                
                                            </div>
                                        </div>
                                        <?php
                                            }else{
                                                $queryCXOApprAll = "SELECT * FROM cxoapproval WHERE idProgram = '$id' ORDER BY CXOid";
                                                $resultCXOApprAll = mysqli_query($conn,$queryCXOApprAll) or die(mysqli_error($conn));
                                                while($CXOApprAll = mysqli_fetch_array($resultCXOApprAll)){
                                        ?>
                                        <hr>
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div align="center" class="col-6">
                                                <small>
                                                    <b>CXO-1 Approval (
                                                        <?php
                                                            $UnitId = $CXOApprAll['CXOid'];
                                                            $queryCXO = "SELECT * FROM user WHERE role = 'CXO-1' AND unit = '$UnitId'";
                                                            $resultCXO = mysqli_query($conn,$queryCXO) or die(mysqli_error($conn));
                                                            $CXO = mysqli_fetch_array($resultCXO);
                                                            echo     $CXO['fName'];
                                                        ?>
                                                    )</b>
                                                </small>
                                            </div>
                                            <div class="col-3">
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Request Sent Date</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <small>
                                                    <?php
                                                        if($progDetails['statusCXO1'] != 4){
                                                            echo    $CXOApprAll['reqDtApprCXO1'];
                                                        }else if($progDetails['statusCXO1'] == 4){
                                                            echo    "-";
                                                        }
                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <?php
                                                    if($CXOApprAll['progApprCXO1'] == 3){
                                                ?>
                                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#resendMailXCO1<?php echo  $UnitId;  ?>">
                                                        Resend
                                                    </button>
                                                <?php
                                                    }else if($CXOApprAll['progApprCXO1'] == 1 | $CXOApprAll['progApprCXO1'] == 2){
                                                ?>
                                                    <button class="btn btn-sm btn-success" disabled>
                                                        Sent <i class="fa fa-check" aria-hidden="true"></i>
                                                    </button>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Approval Status</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <small>
                                                    <?php
                                                        if($progDetails['statusCXO1'] == 4){
                                                                echo 'N/A <i class="fas fa-ban text-secondary"></i> ';
                                                        }else if($progDetails['statusCXO1'] != 4){
                                                            if($CXOApprAll['progApprCXO1'] == 1){
                                                                echo 'Pending <i class="fas fa-clock" style="color: orange;"></i> ';
                                                            }else if($CXOApprAll['progApprCXO1'] == 2){
                                                                echo 'Approved <i class="fas fa-check-circle" style="color: green;"></i> ';
                                                            }else if($CXOApprAll['progApprCXO1'] == 3){
                                                                echo 'Rejected <i class="fas fa-times-circle" style="color: Red;"></i> ';
                                                            }
                                                        }
                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editXCOAppr" >
                                                    Edit Approval
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Delivered Date</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <small>
                                                    <?php
                                                        if($progDetails['statusCXO1'] == 4){
                                                            echo    '-';
                                                        }else{
                                                            
                                                            if($CXOApprAll['dtApprCXO1'] == ""){
                                                                echo    '<span class="text-danger">Did not received yet !</span>';
                                                            }else{
                                                                echo    $CXOApprAll['dtApprCXO1'];
                                                            }
                                                            
                                                        }
                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                
                                            </div>
                                        </div>
                                        <?php
                                                }
                                            }
                                        ?>
                                        <hr>
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div align="center" class="col-6">
                                                <small><b>GTCO Approval</b></small>
                                            </div>
                                            <div class="col-3">
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Request Sent Date</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <small>
                                                    <?php
                                                        if($progDetails['progApprGCTO'] == 4){
                                                            echo    '-';
                                                        }else if($progDetails['reqDtApprGCTO'] == ""){
                                                                echo    '<span class="text-danger">Did not sent for approval !</span>';
                                                        }else{
                                                            echo    $progDetails['reqDtApprGCTO'];
                                                        }
                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <?php
                                                    if($progDetails['reqDtApprGCTO'] == ""){
                                                ?>
                                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#sendMailGCTO" <?php   if(($progDetails['progApprCXO1_2'] == 2 | $progDetails['progApprCXO1'] == 2)&($progDetails['progApprGTD'] == 2)){   }else{  echo    "disabled"; }   ?>>
                                                        Send
                                                    </button>
                                                <?php
                                                    }else if($progDetails['reqDtApprGCTO'] != "" & ($progDetails['progApprGCTO'] == 3)){
                                                ?>
                                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#resendMailGCTO">
                                                        Resend
                                                    </button>
                                                <?php
                                                    }else{
                                                ?>
                                                    <button class="btn btn-sm btn-success" disabled>
                                                        Sent <i class="fa fa-check" aria-hidden="true"></i>
                                                    </button>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Approval Status</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <small>
                                                    <?php
                                                        if($progDetails['progApprGCTO'] == 4){
                                                            echo 'N/A <i class="fas fa-ban text-secondary"></i> ';
                                                        }else if($progDetails['progApprGCTO'] == 1){
                                                            echo 'Pending <i class="fas fa-clock" style="color: orange;"></i> ';
                                                        }else if($progDetails['progApprGCTO'] == 2){
                                                            echo 'Approved <i class="fas fa-check-circle" style="color: green;"></i> ';
                                                        }else if($progDetails['progApprGCTO'] == 3){
                                                            echo 'Rejected <i class="fas fa-times-circle" style="color: Red;"></i> ';
                                                        }else if($progDetails['progApprGCTO'] == 0){
                                                            echo '-';
                                                        }
                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editGCTOAppr" >
                                                    Edit Approval
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Delivered Date</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <small>
                                                    <?php
                                                        if($progDetails['progApprGCTO'] == 0 | $progDetails['progApprGCTO'] == 4){
                                                            echo '-';
                                                        }else{
                                                            if($progDetails['dtApprGCTO'] == ""){
                                                                echo    '<span class="text-danger">Did not received yet !</span>';
                                                            }else{
                                                                echo    $progDetails['dtApprGCTO'];
                                                            }
                                                        }
                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div align="center" class="col-6">
                                                <small><b>GCEO Approval</b></small>
                                            </div>
                                            <div class="col-3">
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Request Sent Date</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <small>
                                                    <?php
                                                        if($progDetails['progApprGCEO'] == 4){
                                                            echo    "-";
                                                        }else if($progDetails['reqDtApprGCEO'] == ""){
                                                            echo    '<span class="text-danger">Did not sent for approval !</span>';
                                                        }else{
                                                            echo    $progDetails['reqDtApprGCEO'];
                                                        }
                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <?php
                                                    if($progDetails['progApprGCEO'] == 4){
                                                ?>
                                                <?php
                                                    }else if($progDetails['reqDtApprGCEO'] == ""){
                                                ?>
                                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#sendMailGCEO" <?php   if($progDetails['progApprGCTO'] == 2){   }else{  echo    "disabled"; }   ?>>
                                                        Send
                                                    </button>
                                                <?php
                                                    }else if($progDetails['reqDtApprGCEO'] != "" & ($progDetails['progApprGCEO'] == 3)){
                                                ?>
                                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#resendMailGCEO">
                                                        Resend
                                                    </button>
                                                <?php
                                                    }else{
                                                ?>
                                                    <button class="btn btn-sm btn-success" disabled>
                                                        Sent <i class="fa fa-check" aria-hidden="true"></i>
                                                    </button>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Approval Status</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <small>
                                                    <?php
                                                        if($progDetails['progApprGCEO'] == 4){
                                                            echo 'N/A <i class="fas fa-ban text-secondary"></i> ';
                                                        }else if($progDetails['progApprGCEO'] == 1){
                                                            echo 'Pending <i class="fas fa-clock" style="color: orange;"></i> ';
                                                        }else if($progDetails['progApprGCEO'] == 2){
                                                            echo 'Approved <i class="fas fa-check-circle" style="color: green;"></i> ';
                                                        }else if($progDetails['progApprGCEO'] == 3){
                                                            echo 'Rejected <i class="fas fa-times-circle" style="color: Red;"></i> ';
                                                        }else if($progDetails['progApprGCEO'] == 0){
                                                            echo '-';
                                                        }
                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editGCEOAppr" >
                                                    Edit Approval
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Delivered Date</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <small>
                                                    <?php
                                                        if($progDetails['progApprGCEO'] == 0 | $progDetails['progApprGCEO'] == 4){
                                                            echo '-';
                                                        }else{
                                                            if($progDetails['dtApprGCEO'] == ""){
                                                                echo    '<span class="text-danger">Did not received yet !</span>';
                                                            }else{
                                                                echo    $progDetails['dtApprGCEO'];
                                                            }
                                                        }
                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-3">
                                            </div>
                                            <div align="center" class="col-6">
                                                <small><b>Delivery Details</b></small>
                                            </div>
                                            <div class="col-3">
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-3">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Date of Provide Details for HR Division</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <small>
                                                    <?php
                                                        if($progDetails['statusHR'] == 0){
                                                            echo '<span class="text-danger">Did not send yet !</span>';;
                                                        }else{
                                                            echo    $progDetails['dateHR'];
                                                        }
                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <?php
                                                    if($progDetails['statusHR'] == 0){
                                                ?>
                                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#sendMailHR" <?php   if(($progDetails['progApprGCTO'] == 2 & $progDetails['progApprGCEO'] == 4) | $progDetails['progApprGCEO'] == 2 | $progDetails['progType'] == 'Internal'){ if($progDetails['progNomStatus'] == "Pending" | $progDetails['progModuleStatus'] == "Pending"){  echo    "disabled"; }  }else{  echo    "disabled"; }   ?>>
                                                        Send
                                                    </button>
                                                <?php
                                                    }else if($progDetails['statusHR'] == 1){
                                                ?>
                                                    <button class="btn btn-sm btn-success" disabled>
                                                        Sent <i class="fa fa-check" aria-hidden="true"></i>
                                                    </button>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Delivery Status</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                    <?php
                                                        if($progDetails['deliveryStatus'] == 0){
                                                            echo '<span class="badge badge-pill badge-warning">Pending</span>';;
                                                        }else{
                                                            echo    '<span class="badge badge-pill badge-success">Delivered</span>';
                                                        }
                                                    ?>
                                            </div>
                                            <div  class="col-3">
                                                <form action="" method="POST" id="nominee">
                                                    <button type="button" name="edit_deliverStatus" id="edit_deliverStatus" style="display:inline-block;" class="btn btn-info btn-sm">Edit Deliver Status</button>
                                                    <button type="submit" name="progDeliverPending" id="progDeliverPending" style="display:none;" class="btn btn-warning btn-sm">Pending</button>
                                                    <button type="submit" name="progDeliverReceived" id="progDeliverReceived" style="display:none;" class="btn btn-success btn-sm">Delivered</button>
                                                    <button type="button" name="cancel_deliverStatus" id="cancel_deliverStatus" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                                </form>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div align="center" class="col">
                                                <button class="btn btn btn-danger">
                                                    Cancel This Program
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- end of cards -->
      
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>

        <script type="text/javascript">
            function loadDoc() {
                setInterval(function(){

                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("count").innerHTML = this.responseText;
                        }
                    };
                    xhttp.open("GET", "wl.php", true);
                    xhttp.send();

                },1000);
                
            }
            
            loadDoc();

            var GTDCXOid = [];

            function Selection(checking){
                if(checking.checked){
                    if(checking.value=="GTD"){
                        $("#sendFirst").prop('disabled',false);
                    }else if(checking.id=="checkCXO"){
                        GTDCXOid.push(checking.value);
                        if(document.getElementById("GTD").checked == false){
                            document.getElementById("GTD").checked = true;
                            $("#sendFirst").prop('disabled',false);
                        }
                    }
                }else{
                    if(checking.value=="GTD"){
                        $("#sendFirst").prop('disabled',true);
                    }else if(checking.id=="checkCXO"){
                        var index = GTDCXOid.indexOf(checking.value);
                        GTDCXOid.splice(index, 1);
                    }
                }
                //alert(GTDCXOid);
            }

            var CXOid = [];

            function SelectionCXO(checking){
                if(checking.checked){
                    CXOid.push(checking.value);
                    $("#sendCXO").prop('disabled',false);
                }else{
                    var index = CXOid.indexOf(checking.value);
                    CXOid.splice(index, 1);
                    if(CXOid.length == 0){
                        $("#sendCXO").prop('disabled',true);
                    }
                }
            }
            
            $(document).ready(function(){
 
                function load_unseen_notification(view = '')
                {
                $.ajax({
                url:"notification.php",
                method:"POST",
                data:{view:view},
                dataType:"json",
                success:function(data)
                {
                    $('.dropdown-menu-notify').html(data.notification);
                    //if(data.unseen_notification > 0)
                    //{
                    //$('.count').html(data.unseen_notification);
                    //}
                }
                });
                }
                
                load_unseen_notification();

                var progFee = "";
                var progOtherCost = "";
                var progStDate = "";
                var progEdDate = "";
                var progComment = "";

                $('#sendFirst').click(function(){
                    var id = <?php  echo    $id;    ?>;
                    document.querySelector('#sendFirst').innerHTML = 'Sending...';
                    if(GTDCXOid.length == 0){
                        // alert("GTD");
                        $.ajax({
                            url: "sendMailGTD.php",
                            method: "POST",
                            data: {id:id},
                            dataType: "text",
                            success: function(data){
                                $("#send").submit();
                            }
                        })
                    }else{
                        // alert("CXO");
                        $.ajax({
                            url: "sendMailGTDCXO.php",
                            method: "POST",
                            data: {id:id,GTDCXOid:GTDCXOid},
                            dataType: "text",
                            success: function(data){
                                $("#send").submit();
                            }
                        })
                    }
                });

                $('#resendGTD').click(function(){
                    var id = <?php  echo    $id;    ?>;
                    document.querySelector('#resendGTD').innerHTML = 'Sending...';
                    $.ajax({
                        url: "sendMailGTD.php",
                        method: "POST",
                        data: {id:id},
                        dataType: "text",
                        success: function(data){
                            $("#send").submit();
                        }
                    })
                });

                $('#sendCXO').click(function(){
                    var id = <?php  echo    $id;    ?>;
                    document.querySelector('#sendCXO').innerHTML = 'Sending...';
                    $.ajax({
                        url: "sendMailCXO.php",
                        method: "POST",
                        data: {id:id,CXOid:CXOid},
                        dataType: "text",
                        success: function(data){
                            $("#send").submit();
                        }
                    })
                });

                <?php
                    $queryCXOAll = "SELECT * FROM user WHERE role = 'CXO-1' ORDER BY unit";
                    $resultCXOAll = mysqli_query($conn,$queryCXOAll) or die(mysqli_error($conn));
                    while($CXOAll = mysqli_fetch_array($resultCXOAll)){
                        $cxoUnit = $CXOAll['unit'];
                ?>

                $('#resendCXO<?php  echo    $cxoUnit;   ?>').click(function(){
                    var id = <?php  echo    $id;    ?>;
                    var CXOi = <?php echo $cxoUnit; ?>;
                    document.querySelector('#resendCXO<?php  echo    $cxoUnit;   ?>').innerHTML = 'Sending...';
                    $.ajax({
                        url: "reSendCXO.php",
                        method: "POST",
                        data: {id:id,CXOid:CXOi},
                        dataType: "text",
                        success: function(data){
                            $("#send").submit();
                            alert(data);
                            reCXOid = [];
                        }
                    })
                });

                <?php
                    }
                ?>

                $('#sendGCTO').click(function(){
                    var id = <?php  echo    $id;    ?>;
                    document.querySelector('#sendGCTO').innerHTML = 'Sending...';
                    $.ajax({
                        url: "sendMailGCTO.php",
                        method: "POST",
                        data: {id:id},
                        dataType: "text",
                        success: function(data){
                            $("#send").submit();
                        }
                    })
                });

                $('#resendGCTO').click(function(){
                    var id = <?php  echo    $id;    ?>;
                    document.querySelector('#resendGCTO').innerHTML = 'Sending...';
                    $.ajax({
                        url: "sendMailGCTO.php",
                        method: "POST",
                        data: {id:id},
                        dataType: "text",
                        success: function(data){
                            $("#send").submit();
                        }
                    })
                });

                $('#sendGCEO').click(function(){
                    var id = <?php  echo    $id;    ?>;
                    document.querySelector('#sendGCEO').innerHTML = 'Sending...';
                    $.ajax({
                        url: "sendMailGCEO.php",
                        method: "POST",
                        data: {id:id},
                        dataType: "text",
                        success: function(data){
                            $("#send").submit();
                        }
                    })
                });

                $('#resendGCEO').click(function(){
                    var id = <?php  echo    $id;    ?>;
                    document.querySelector('#resendGCEO').innerHTML = 'Sending...';
                    $.ajax({
                        url: "sendMailGCEO.php",
                        method: "POST",
                        data: {id:id},
                        dataType: "text",
                        success: function(data){
                            $("#send").submit();
                        }
                    })
                });

                $('#sendHR').click(function(){
                    var id = <?php  echo    $id;    ?>;
                    document.querySelector('#sendHR').innerHTML = 'Sending...';
                    $.ajax({
                        url: "sendMailHR.php",
                        method: "POST",
                        data: {id:id},
                        dataType: "text",
                        success: function(data){
                            alert(data);
                            $("#send").submit();
                        }
                    })
                });

                $('#editGTDApproval').click(function(){
                    var id = <?php  echo    $id;    ?>;
                    var reqDate =   $('#GTDSentDate').val();
                    var status =   $('#GTDStatus').val();
                    var delDate =   $('#GTDDeliveredDate').val();
                    document.querySelector('#editGTDApproval').innerHTML = 'Saving...';
                    $.ajax({
                        url: "editGTDAppr.php",
                        method: "POST",
                        data: {id:id,reqDate:reqDate,status:status,delDate:delDate},
                        dataType: "text",
                        success: function(data){
                            alert(data);
                            $("#SaveAppr").submit();
                        }
                    })
                });

                $('#editCXOApproval').click(function(){
                    var id = <?php  echo    $id;    ?>;
                    var reqDate =   $('#CXOSentDate').val();
                    var status =   $('#CXOStatus').val();
                    var delDate =   $('#CXODeliveredDate').val();
                    document.querySelector('#editCXOApproval').innerHTML = 'Saving...';
                    $.ajax({
                        url: "editCXOAppr.php",
                        method: "POST",
                        data: {id:id,reqDate:reqDate,status:status,delDate:delDate},
                        dataType: "text",
                        success: function(data){
                            alert(data);
                            $("#SaveAppr").submit();
                        }
                    })
                });

                $('#editGCTOApproval').click(function(){
                    var id = <?php  echo    $id;    ?>;
                    var reqDate =   $('#GCTOSentDate').val();
                    var status =   $('#GCTOStatus').val();
                    var delDate =   $('#GCTODeliveredDate').val();
                    document.querySelector('#editGCTOApproval').innerHTML = 'Saving...';
                    $.ajax({
                        url: "editGCTOAppr.php",
                        method: "POST",
                        data: {id:id,reqDate:reqDate,status:status,delDate:delDate},
                        dataType: "text",
                        success: function(data){
                            alert(data);
                            $("#SaveAppr").submit();
                        }
                    })
                });

                $('#editGCEOApproval').click(function(){
                    var id = <?php  echo    $id;    ?>;
                    var reqDate =   $('#GCEOSentDate').val();
                    var status =   $('#GCEOStatus').val();
                    var delDate =   $('#GCEODeliveredDate').val();
                    document.querySelector('#editGCEOApproval').innerHTML = 'Saving...';
                    $.ajax({
                        url: "editGCEOAppr.php",
                        method: "POST",
                        data: {id:id,reqDate:reqDate,status:status,delDate:delDate},
                        dataType: "text",
                        success: function(data){
                            alert(data);
                            $("#SaveAppr").submit();
                        }
                    })
                });

                $('#edit_programDate').click(function(){                    
                    document.getElementById("programStartDate").type = 'date';
                    document.getElementById("programEndDate").type = 'date';
                    document.getElementById("edit_programDate").style.display='none';
                    document.getElementById("cancel_programDate").style.display='inline-block';
                    document.getElementById("save_programDate").style.display='inline-block';
                });
                $('#save_programDate').click(function(){
                    document.getElementById("save_programDate").style.display='none';
                    document.getElementById("cancel_programDate").style.display='none';
                    document.getElementById("edit_programDate").style.display='block';                   
                });
                $('#cancel_programDate').click(function(){
                    document.getElementById("programStartDate").type = 'hidden';
                    document.getElementById("programEndDate").type = 'hidden';
                    document.getElementById("cancel_programDate").style.display='none';
                    document.getElementById("save_programDate").style.display='none';
                    document.getElementById("edit_programDate").style.display='block';
                });

                $('#edit_programScheduleComment').click(function(){                    
                    document.getElementById("programScheduleComment").type = 'text';
                    document.getElementById("edit_programScheduleComment").style.display='none';
                    document.getElementById("cancel_programScheduleComment").style.display='inline-block';
                    document.getElementById("save_programScheduleComment").style.display='inline-block';
                });
                $('#save_programScheduleComment').click(function(){
                    document.getElementById("save_programScheduleComment").style.display='none';
                    document.getElementById("cancel_programScheduleComment").style.display='none';
                    document.getElementById("edit_programScheduleComment").style.display='block';                   
                });
                $('#cancel_programScheduleComment').click(function(){
                    document.getElementById("programScheduleComment").type = 'hidden';
                    document.getElementById("cancel_programScheduleComment").style.display='none';
                    document.getElementById("save_programScheduleComment").style.display='none';
                    document.getElementById("edit_programScheduleComment").style.display='block';
                });

                $('#edit_programDuration').click(function(){                    
                    document.getElementById("programDuration").type = 'text';
                    document.getElementById("edit_programDuration").style.display='none';
                    document.getElementById("cancel_programDuration").style.display='inline-block';
                    document.getElementById("save_programDuration").style.display='inline-block';
                });
                $('#save_programDuration').click(function(){
                    document.getElementById("save_programDuration").style.display='none';
                    document.getElementById("cancel_programDuration").style.display='none';
                    document.getElementById("edit_programDuration").style.display='block';                   
                });
                $('#cancel_programDuration').click(function(){
                    document.getElementById("programDuration").type = 'hidden';
                    document.getElementById("cancel_programDuration").style.display='none';
                    document.getElementById("save_programDuration").style.display='none';
                    document.getElementById("edit_programDuration").style.display='block';
                });

                $('#edit_programPaymentMethod').click(function(){                    
                    document.getElementById("programPaymentMethod").type = 'text';
                    document.getElementById("edit_programPaymentMethod").style.display='none';
                    document.getElementById("cancel_programPaymentMethod").style.display='inline-block';
                    document.getElementById("save_programPaymentMethod").style.display='inline-block';
                });
                $('#save_programPaymentMethod').click(function(){
                    document.getElementById("save_programPaymentMethod").style.display='none';
                    document.getElementById("cancel_programPaymentMethod").style.display='none';
                    document.getElementById("edit_programPaymentMethod").style.display='block';                   
                });
                $('#cancel_programPaymentMethod').click(function(){
                    document.getElementById("programPaymentMethod").type = 'hidden';
                    document.getElementById("cancel_programPaymentMethod").style.display='none';
                    document.getElementById("save_programPaymentMethod").style.display='none';
                    document.getElementById("edit_programPaymentMethod").style.display='block';
                });

                $('#edit_programOtherCostComment').click(function(){                    
                    document.getElementById("programOtherCostComment").type = 'text';
                    document.getElementById("edit_programOtherCostComment").style.display='none';
                    document.getElementById("cancel_programOtherCostComment").style.display='inline-block';
                    document.getElementById("save_programOtherCostComment").style.display='inline-block';
                });
                $('#save_programOtherCostComment').click(function(){
                    document.getElementById("save_programOtherCostComment").style.display='none';
                    document.getElementById("cancel_programOtherCostComment").style.display='none';
                    document.getElementById("edit_programOtherCostComment").style.display='block';                   
                });
                $('#cancel_programOtherCostComment').click(function(){
                    document.getElementById("programOtherCostComment").type = 'hidden';
                    document.getElementById("cancel_programOtherCostComment").style.display='none';
                    document.getElementById("save_programOtherCostComment").style.display='none';
                    document.getElementById("edit_programOtherCostComment").style.display='block';
                });

                $('#edit_programBudgetSource').click(function(){                    
                    document.getElementById("programBudgetSource").type = 'text';
                    document.getElementById("edit_programBudgetSource").style.display='none';
                    document.getElementById("cancel_programBudgetSource").style.display='inline-block';
                    document.getElementById("save_programBudgetSource").style.display='inline-block';
                });
                $('#save_programBudgetSource').click(function(){
                    document.getElementById("save_programBudgetSource").style.display='none';
                    document.getElementById("cancel_programBudgetSource").style.display='none';
                    document.getElementById("edit_programBudgetSource").style.display='block';                   
                });
                $('#cancel_programBudgetSource').click(function(){
                    document.getElementById("programBudgetSource").type = 'hidden';
                    document.getElementById("cancel_programBudgetSource").style.display='none';
                    document.getElementById("save_programBudgetSource").style.display='none';
                    document.getElementById("edit_programBudgetSource").style.display='block';
                });

                $('#edit_programCost').click(function(){                    
                    progFee = $('#programCourseFee').val();
                    progOtherCost = $('#programOtherCost').val();
                    document.getElementById("programCourseFee").type = 'number';
                    document.getElementById("programOtherCost").type = 'number';
                    document.getElementById("programTotalCost").type = 'number';
                    document.getElementById("edit_programCost").style.display='none';
                    document.getElementById("cancel_programCost").style.display='inline-block';
                    document.getElementById("save_programCost").style.display='inline-block';
                });
                $('#save_programCost').click(function(){
                    document.getElementById("save_programCost").style.display='none';
                    document.getElementById("cancel_programCost").style.display='none';
                    document.getElementById("edit_programCost").style.display='block';                   
                });
                $('#cancel_programCost').click(function(){
                    document.getElementById('programCourseFee').value=progFee;
                    document.getElementById('programOtherCost').value=progOtherCost;
                    document.getElementById("programCourseFee").type = 'hidden';
                    document.getElementById("programOtherCost").type = 'hidden';
                    document.getElementById("programTotalCost").type = 'hidden';
                    document.getElementById("cancel_programCost").style.display='none';
                    document.getElementById("save_programCost").style.display='none';
                    document.getElementById("edit_programCost").style.display='block';
                    setTotal();
                });

                $('#edit_programModule').click(function(){
                    document.getElementById("programAddModule").type = 'text';
                    document.getElementById("add_programModule").style.display='inline-block';
                    document.getElementById("edit_programModule").style.display='none';
                    document.getElementById("cancel_programModule").style.display='inline-block';
                });
                $('#cancel_programModule').click(function(){
                    document.getElementById("programAddModule").type = 'hidden';
                    document.getElementById("add_programModule").style.display='none';
                    document.getElementById("edit_programModule").style.display='inline-block';
                    document.getElementById("cancel_programModule").style.display='none';
                });

                $('#edit_programNominee').click(function(){
                    document.getElementById("programAddNominee").type = 'text';
                    document.getElementById("programAddNomin").type = 'text';
                    document.getElementById("nomName").style.display='inline-block';
                    document.getElementById("nomID").style.display='inline-block';
                    document.getElementById("add_programNominee").style.display='inline-block';
                    document.getElementById("edit_programNominee").style.display='none';
                    document.getElementById("cancel_programNominee").style.display='inline-block';
                });
                $('#cancel_programNominee').click(function(){
                    document.getElementById("programAddNominee").type = 'hidden';
                    document.getElementById("programAddNomin").type = 'hidden';
                    document.getElementById("nomName").style.display='none';
                    document.getElementById("nomID").style.display='none';
                    document.getElementById("add_programNominee").style.display='none';
                    document.getElementById("edit_programNominee").style.display='inline-block';
                    document.getElementById("cancel_programNominee").style.display='none';
                });

                $('#edit_moduleStatus').click(function(){
                    document.getElementById("progModulePending").style.display='inline-block';
                    document.getElementById("edit_moduleStatus").style.display='none';
                    document.getElementById("progModuleReceived").style.display='inline-block';
                    document.getElementById("cancel_moduleStatus").style.display='inline-block';
                });
                $('#cancel_moduleStatus').click(function(){
                    document.getElementById("progModulePending").style.display='none';
                    document.getElementById("edit_moduleStatus").style.display='inline-block';
                    document.getElementById("progModuleReceived").style.display='none';
                    document.getElementById("cancel_moduleStatus").style.display='none';
                });

                $('#edit_nomineeStatus').click(function(){
                    document.getElementById("progNomineePending").style.display='inline-block';
                    document.getElementById("edit_nomineeStatus").style.display='none';
                    document.getElementById("progNomineeReceived").style.display='inline-block';
                    document.getElementById("cancel_nomineeStatus").style.display='inline-block';
                });
                $('#cancel_nomineeStatus').click(function(){
                    document.getElementById("progNomineePending").style.display='none';
                    document.getElementById("edit_nomineeStatus").style.display='inline-block';
                    document.getElementById("progNomineeReceived").style.display='none';
                    document.getElementById("cancel_nomineeStatus").style.display='none';
                });

                $('#edit_deliverStatus').click(function(){
                    document.getElementById("progDeliverPending").style.display='inline-block';
                    document.getElementById("edit_deliverStatus").style.display='none';
                    document.getElementById("progDeliverReceived").style.display='inline-block';
                    document.getElementById("cancel_deliverStatus").style.display='inline-block';
                });
                $('#cancel_deliverStatus').click(function(){
                    document.getElementById("progDeliverPending").style.display='none';
                    document.getElementById("edit_deliverStatus").style.display='inline-block';
                    document.getElementById("progDeliverReceived").style.display='none';
                    document.getElementById("cancel_deliverStatus").style.display='none';
                });

                $(document).on('click', '.removeModule', function(){
                    var idModule = $(this).attr("id");
                    var idProgram = <?php   echo    $id;    ?>;
                    $.ajax({
                        url: "removeModule.php",
                        method: "POST",
                        data: {idModule:idModule,idProgram:idProgram},
                        dataType: "text",
                        success: function(data){
                            $("#module").submit();
                        }
                    })
                    

                });

                $(document).on('click', '.removeNominee', function(){
                    var idNominee = $(this).attr("id");
                    var idProgram = <?php   echo    $id;    ?>;
                    $.ajax({
                        url: "removeNominee.php",
                        method: "POST",
                        data: {idNominee:idNominee,idProgram:idProgram},
                        dataType: "text",
                        success: function(data){
                            $("#nominee").submit();
                        }
                    })
                    

                });
                
            });

            function setTotal(){
                val1 = document.getElementById("programCourseFee").value;
                val2 = document.getElementById("programOtherCost").value;
                document.getElementById("programTotalCost").value = parseFloat(val1)+parseFloat(val2);

            }

            function setVal(outFocus){
                if(outFocus.value == "" | outFocus.value == 0){
                    outFocus.value = 0;
                }
                setTotal();
            }

        </script>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" 
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" 
        integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
        <script src="script.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

      </body>
</html>
