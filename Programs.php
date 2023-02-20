<?php

    include("database.php");

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

    if(isset($_POST['submitFile'])){
        $remark = $_POST['selectProgram'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileExtension = pathinfo($fileName,PATHINFO_EXTENSION);

        require 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';
        $allowedType = array('csv','xls','xlsx');

        if(!in_array($fileExtension,$allowedType) | $remark == "Select program here..."){
            echo '<script type="text/javascript">alert("Error in selecting a program or invalied File!\nPlease select correct program and file..");</script>';
        }else{

            $countSheet = 1;
            
            $objPHPExcel = PHPExcel_IOFactory::load($fileTmpName);

            foreach($objPHPExcel->getWorksheetIterator() as $worksheet){

                if($countSheet < 3){

                    $highestRow = $worksheet->getHighestRow();
                    
                    $progname = "";
                    for($row = 4;$row<=$highestRow;$row++){
                        $progName = $worksheet->getCellByColumnAndRow(0,$row)->getValue();
                        if($progname != $progName){
                            $progname = $progName;
                            $progType = $worksheet->getCellByColumnAndRow(3,$row)->getValue();
                            $trainrSupp = $worksheet->getCellByColumnAndRow(4,$row)->getValue();
                            $division = $worksheet->getCellByColumnAndRow(7,$row)->getValue();
                            $unit = $worksheet->getCellByColumnAndRow(8,$row)->getValue();
                            $requestedBy = $worksheet->getCellByColumnAndRow(10,$row)->getValue();
                            $priority = $worksheet->getCellByColumnAndRow(11,$row)->getValue();
                            $slots = $worksheet->getCellByColumnAndRow(12,$row)->getValue();
                            $paymentMeth = $worksheet->getCellByColumnAndRow(5,$row)->getValue();
                            $bSource = $worksheet->getCellByColumnAndRow(6,$row)->getValue();
                            $currency = $worksheet->getCellByColumnAndRow(13,$row)->getValue();
                            $courseFee = $worksheet->getCellByColumnAndRow(14,$row)->getValue();
                            $otherCost = $worksheet->getCellByColumnAndRow(15,$row)->getValue();
                            $totalCost = $worksheet->getCellByColumnAndRow(16,$row)->getValue();
                            $progModuleStatus = $worksheet->getCellByColumnAndRow(23,$row)->getValue();
                            $progNomStatus = $worksheet->getCellByColumnAndRow(24,$row)->getValue();
                            $stDate = $worksheet->getCellByColumnAndRow(18,$row)->getValue();
                            $edDate = $worksheet->getCellByColumnAndRow(19,$row)->getValue();
                            $duration = $worksheet->getCellByColumnAndRow(21,$row)->getValue();
                            //echo '<script type="text/javascript">alert("'.$name.'");</script>';
                            $query = "";
                            if($stDate == "" | $edDate == ""){
                                $query = "INSERT INTO programstatus (remark, progName, progType, trainrSupp, division, unit, requestedBy, priority, slots, paymentMeth, bSource, currency, courseFee, otherCost, totalCost, progModuleStatus, progNomStatus, duration, progApprGTD, statusCXO1, progApprCXO1, progApprCXO1_2, progApprGCTO, progApprGCEO, statusWord, statusPDF, statusHR, cancelStatus, deliveryStatus) VALUES ('$remark', '$progName', '$progType', '$trainrSupp', '$division', '$unit', '$requestedBy', '$priority', '$slots', '$paymentMeth', '$bSource', '$currency', '$courseFee', '$otherCost', '$totalCost', '$progModuleStatus', '$progNomStatus', '$duration', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)";
                            }else if($stDate != "" | $edDate != ""){
                                $stDt = new DateTime($stDate);
                                $edDt = new DateTime($edDate);

                                $stDt = $stDt->format("Y-m-d");
                                $edDt = $edDt->format("Y-m-d");

                                $query = "INSERT INTO programstatus (remark, progName, progType, trainrSupp, division, unit, requestedBy, priority, slots, paymentMeth, bSource, currency, courseFee, otherCost, totalCost, progModuleStatus, progNomStatus, duration, stDate, edDate, progApprGTD, statusCXO1, progApprCXO1, progApprCXO1_2, progApprGCTO, progApprGCEO, statusWord, statusPDF, statusHR, cancelStatus, deliveryStatus) VALUES ('$remark', '$progName', '$progType', '$trainrSupp', '$division', '$unit', '$requestedBy', '$priority', '$slots', '$paymentMeth', '$bSource', '$currency', '$courseFee', '$otherCost', '$totalCost', '$progModuleStatus', '$progNomStatus', '$duration', '$stDt', '$edDt', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)";
                            }
                            
                            if ($conn->query($query) === TRUE) {
                                continue;
                            }
                        }else if($progname == $progName){
                            $progModuleName = $worksheet->getCellByColumnAndRow(1,$row)->getValue();

                            $getProgIDQuery = "SELECT idProgram FROM programstatus WHERE progName = '$progName' AND remark = '$remark'";
                            $result_sql = mysqli_query($conn,$getProgIDQuery) or die(mysqli_error($conn));
                            $progId = mysqli_fetch_array($result_sql);
                            $progId = $progId['idProgram'];

                            $insertModuleQuery = "INSERT INTO  moduleprogramstatus (idProgram, moduleName) VALUES ('$progId','$progModuleName')";
                            if ($conn->query($insertModuleQuery) === TRUE) {
                                continue;
                            }
                        }
                    }
                }else if($countSheet == 3){
                    $highestRow = $worksheet->getHighestRow();
                    $progname = "";
                    for($row = 2;$row<=$highestRow;$row++){
                        $progName = $worksheet->getCellByColumnAndRow(0,$row)->getValue();
                        if($progname != $progName){
                            $progname = $progName;
                        }else if($progname == $progName){
                            $progNomineeName = $worksheet->getCellByColumnAndRow(1,$row)->getValue();
                            $progNomineeEmpID = $worksheet->getCellByColumnAndRow(2,$row)->getValue();

                            $getProgIDQuery = "SELECT idProgram FROM programstatus WHERE progName = '$progName' AND remark = '$remark'";
                            $result_sql = mysqli_query($conn,$getProgIDQuery) or die(mysqli_error($conn));
                            $progId = mysqli_fetch_array($result_sql);
                            $progId = $progId['idProgram'];

                            $insertNomineeQuery = "INSERT INTO  nomineeprogramstatus (idProgram, nomineeName, empID) VALUES ('$progId','$progNomineeName', '$progNomineeEmpID')";
                            if ($conn->query($insertNomineeQuery) === TRUE) {
                                continue;
                            }
                        }
                    }
                }

                $countSheet = $countSheet + 1;
            }
            $updateSeduleProgActive = "UPDATE sheduleprogram SET active = '0' WHERE '1'";
            if ($conn->query($updateSeduleProgActive) === TRUE) {
                $updateSeduleProg = "UPDATE sheduleprogram SET upStatus = '1', active= '1' WHERE remark = '$remark'";
                if ($conn->query($updateSeduleProg) === TRUE) {
                    echo '<script type="text/javascript">alert("Successfully Uploaded..!");</script>';
                }
            }
            
        }

    }

    if(isset($_POST['Logout'])){

        session_destroy();
        unset($_SESSION["username"]);
        header("location: Login.php");

    }

    date_default_timezone_set("Asia/Colombo");

    //$conn = mysqli_connect("localhost","root","","training");
    $err = '';

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

        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
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
                                current"><i 
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
                                    text-uppercase mb-0">Programs</h4>
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

        <!-- cards -->

       
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-10 col-lg-9 col-md-9 ml-auto">
                    <?php
                        $query = "SELECT * FROM sheduleprogram WHERE status = '1' AND upStatus = '0'";
                        $queryArray = mysqli_query($conn,$query) or die(mysqli_error($conn));
                        $search = mysqli_num_rows($queryArray);

                        if($search != 0){
                    ?>
                        <div class="row pt-md-5 mt-md-3 pt-xs-5 mt-xs-3">
                            <div class="col-xl-2 col-sm-0">
                            </div>
                            <div class="col-xl-8 col-sm-12">
                                <div class="card card-common">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <i class="fas fa-upload text-info"></i>
                                            <div class="text-right text-secondary">
                                                <h6 class="mb-1">Upload Excel File</h6>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-1">
                                            </div>
                                            <div class="col-10">
                                                <span id="message"></span>
                                                <form action="" method="POST" enctype="multipart/form-data">
                                                <div class="row mt-3 form-group">
                                                    <div class="col-4 d-flex justify-content-between align-items-center">
                                                        Select Program :
                                                    </div>
                                                    <div class="col-8 d-flex justify-content-between align-items-center">
                                                        <select class="form-control"  name="selectProgram" id="selectProgram"  style="width:100%;">
                                                            <option class="text-secondary">Select program here...</option>
                                                            <?php
                                                                while($progs = mysqli_fetch_array($queryArray)){
                                                                    echo    '<option>'.$progs['remark'].'</option>';
                                                                }
                                                            ?>                                            
                                                            
                                                        </select>
                                                        <small><span id="error_selectProgram" class="text-danger"></span></small>
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="row form-group">
                                                    <div class="col-4 d-flex justify-content-between align-items-center">
                                                         
                                                    </div>
                                                    <div class="col-8 d-flex justify-content-between align-items-center">
                                                        <input type="file" style="width:75%;" name="file" id="file" class="form-control"/>
                                                        <small><span id="error_file" class="text-danger"></span></small>
                                                    </div>
                                                </div>
                                                <div align="center" class="from-group">
                                                    
                                                    <button type="button" name="cancel" style="display:inline-block;" id="cancel" class="btn btn-danger">Cancel</button>
                                                    <button type="submit" class="btn btn-info" name="submitFile" id="submitFile">Upload</button>
                                                </div>
                                                </form>
                                            </div>
                                            <div class="col-1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-sm-0">
                            </div>
                        </div>
                    <?php
                        }
                        if($search != 0){
                    ?>
                        <div class="row mt-md-2 pt-md-2 pt-sm-2 mt-sm-2 pt-2 mt-2">
                    <?php
                        }else{
                    ?>
                        <div class="row pt-md-5 mt-md-3 pt-xs-5 mt-xs-3">
                    <?php
                        }
                    ?>
                            <div class="col-xl-12 col-sm-12">
                                <div class="card card-common" style="width: 100%; height:620px;">
                                    <div class="card-header">
                                        <div class="panel-title" align="center">Previous Trainings Programs</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="scroll" style="height:530px; overflow-y: auto;">
                                        <?php
                                            $remarkQuery = "SELECT id, remark FROM sheduleprogram WHERE status = '1' ORDER BY id DESC";
                                            $resultRemarkQuery = mysqli_query($conn,$remarkQuery) or die(mysqli_error($conn));
                                            $countRemarkQuery = mysqli_num_rows($resultRemarkQuery);
                                            if($countRemarkQuery>0){
                                        ?>
                                            <ul style="list-style-type:none;">
                                        <?php
                                                while($arrayRemarkQuery = mysqli_fetch_array($resultRemarkQuery)){
                                        ?>
                                                <li class="mt-2"><a href="viewHistoryPrograms.php?spid=<?php echo    $arrayRemarkQuery['id']; ?>" class="text-dark"><i class="fas fa-tasks text-dark fa-sm fa-fw mr-3"></i><?php  echo    $arrayRemarkQuery['remark'];    ?></a></li>
                                        <?php
                                                }
                                        ?>
                                            </ul>
                                        <?php
                                            }else{
                                        ?>
                                            <div class="col-3 d-flex justify-content-between align-items-center text-danger">
                                                No programs to view
                                            </div>
                                        <?php
                                            }
                                        ?>
                                        </div>
                                    </div>
                                </div>
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
                
            });

        </script>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" 
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" 
        integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
        <script src="script.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>

      </body>
</html>
