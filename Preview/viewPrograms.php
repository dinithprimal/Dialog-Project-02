<?php
    $id = $_GET['id'];

    include("../database.php");

    date_default_timezone_set("Asia/Colombo");


?>

<!Doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="title icon" href="../images/title-img2.jpg">
        <link rel="stylesheet" href="../css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <!--<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>-->

        <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" 
        integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">-->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" 
        integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <title>Admin Dashboard</title>
    </head>
    <body>
        <?php
            $progDetailsQuery = "SELECT * FROM programstatus WHERE idProgram = '$id'";
            $progDetailsQueryResult = mysqli_query($conn,$progDetailsQuery) or die(mysqli_error($conn));
            $progDetails = mysqli_fetch_array($progDetailsQueryResult);
        ?>
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
                        
                        <!--end of sidebar-->

                        <!--TopNav-->
                        <div class="col-12 ml-auto bg-dark fixed-top py-2 top-navbar">
                            <div class="row align-items-center">
                                <div class="col-md-9">
                                    <h4 class="text-light 
                                    text-uppercase mb-0">View Program <br><small><small><small>(<?php   echo    $progDetails['progName'];   ?>)</small></small></small></h4>
                                </div>
                            </div>
                        </div>
                        <!--end of TopNav-->
                    </div>
                </div>
            </div>
        </nav>

        <!-- end of navbar -->

        <!-- cards -->

        <section>
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col-12 ml-auto">
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
                                        <div class="row mt-3">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Given Program Start Date</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
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
                                                
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Given Program End Date</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
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
                                                
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Program Schedule Comment</small>
                                            </div>
                                            <div class="col-9 d-flex justify-content-between align-items-center">
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
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Program Duration</small>
                                            </div>
                                            <div class="col-9 d-flex justify-content-between align-items-center">
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
                                        </div>
                                        <hr>
                                        <form action="" method="POST">
                                        <div class="row">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Payment Method</small>
                                            </div>
                                            <div class="col-9">
                                                <small><?php    if($progDetails['paymentMeth']==""){    echo    '<label class="text-danger">Not given</label>'; }else{  echo    $progDetails['paymentMeth'];   }   ?></small>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Other Cost Comment</small>
                                            </div>
                                            <div class="col-9 d-flex justify-content-between align-items-center">
                                                <small><?php    if($progDetails['otherCostComment']==""){    echo    '<label class="text-danger">Not given</label>'; }else{  echo    $progDetails['otherCostComment'];   }   ?></small>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Budget Source</small>
                                            </div>
                                            <div class="col-9">
                                                <small><?php   echo    $progDetails['bSource'];   ?></small>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Course Fee</small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small><?php   echo     "".$progDetails['currency']."  ".$progDetails['courseFee']."";   ?></small>
                                            </div>
                                            <div class="col-6">
                                                
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Other Cost</small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small><?php   echo     "".$progDetails['currency']."  ".$progDetails['otherCost']."";   ?></small>
                                            </div>
                                            <div class="col-6">
                                                
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Total Cost</small>
                                            </div>
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small><b><label style="text-decoration-line: underline; text-decoration-style: double;"><?php   echo     "".$progDetails['currency']."  ".$progDetails['totalCost']."";   ?></label></b></small>
                                            </div>
                                            <div class="col-6">
                                               
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
                                                    
                                                </div>
                                            </div>
                                            <div class="row mt-2">
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
                                            <div class="row mt-2" style="height:200px;">
                                                <div class="col-3 d-flex justify-content-between align-items-center" style="height:100%;">
                                                    <small>Modules</small>
                                                </div>
                                                <div class="col-8 justify-content-between align-items-center" style="height:100%; width:100%; overflow: auto; overflow-x: hidden;">
                                                    <small>
                                                        <!--<div class="row" style="height:100%; width:100%; overflow: auto; overflow-x: hidden;">-->
                                                            <table class="table table-bordered" style="width:100%;">
                                                                <tr>
                                                                    <th>Module Name</th>
                                                                </tr>
                                                                <?php
                                                                    if($moduleCount>0){
                                                                        while($module = mysqli_fetch_array($resultModuleQuery)){
                                                                ?>
                                                                    <tr>
                                                                        <td><?php   echo    $module['moduleName'];    ?></td>
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
                                                <div class="col-1" style="height:100%;">
                                                    
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
                                                    
                                                </div>
                                            </div>
                                            <div class="row mt-2">
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
                                            <div class="row mt-2" style="height:200px;">
                                                <div class="col-3 d-flex justify-content-between align-items-center" style="height:100%;">
                                                    <small>Nominees</small>
                                                </div>
                                                <div class="col-8 justify-content-between align-items-center" style="height:100%; width:100%; overflow: auto; overflow-x: hidden;">
                                                    <small>
                                                            <table class="table table-bordered" id="modules" style="width:100%;">
                                                                <tr>
                                                                    <th>Nominee Name</th>
                                                                </tr>
                                                                <?php
                                                                    if($nomineeCount>0){
                                                                        while($nominee = mysqli_fetch_array($resultNomineeQuery)){
                                                                ?>
                                                                    <tr>
                                                                        <td><?php   echo    $nominee['nomineeName'];    ?></td>
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
                                                <div class="col-1" style="height:200px;">
                                                    
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
                                            <div class="col-3">
                                                
                                            </div>
                                        </div>
                                        <div class="row mt-3">
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
                                            <div class="col-3">
                                               
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
                                            <div class="col-3">
                                                
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
                                            <div class="col-3">
                                               
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <small>Approval Status</small>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <small>
                                                    -
                                                </small>
                                            </div>
                                            <div class="col-3">
                                               
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
                                            <div class="col-3">
                                                
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
                                            <div class="col-3">
                                                
                                            </div>
                                        </div>
                                        <div class="row mt-3">
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
                                            <div class="col-3">
                                               
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
                                            <div class="col-3">
                                                
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
                                            <div class="col-3">
                                                
                                            </div>
                                        </div>
                                        <div class="row mt-3">
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
                                            <div class="col-3">
                                               
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
                                            <div class="col-3">
                                                
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
                                            <div class="col-3">
                                                
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
                                                
                                            </div>
                                        </div>
                                        <hr>
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
            
            $(document).ready(function(){
 
                function load_unseen_notification(view = ''){
                    $.ajax({
                        url:"notification.php",
                        method:"POST",
                        data:{view:view},
                        dataType:"json",
                        success:function(data){
                            $('.dropdown-menu-notify').html(data.notification);
                            //if(data.unseen_notification > 0)
                            //{
                            //$('.count').html(data.unseen_notification);
                            //}
                        }
                    });
                }
                
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

      </body>
</html>
