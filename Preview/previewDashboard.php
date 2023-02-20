<?php

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
        <link rel="stylesheet" href="../style.css">
        <link rel="stylesheet" href="../styleAccordian.css">
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
                        
                        <!--end of sidebar-->

                        <!--TopNav-->
                        <div class="col-12 ml-auto bg-dark fixed-top py-2 top-navbar">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 align="center" class="text-light 
                                    text-uppercase mb-0">Group Technology - Trainings Dashboard</h4>
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
                <div class="row">
                    <div class="col">
                        <div class="row pt-md-1 mt-md-2 mb-auto">
                            <div class="container">
                                <?php
                                    $queryTrainingPrograms = "SELECT * FROM sheduleprogram WHERE status = '1' AND upStatus = '1' ORDER BY remark DESC";
                                    $resultQueryTrainingPrograms = mysqli_query($conn,$queryTrainingPrograms) or die(mysqli_error($conn));
                                    $countQueryTrainingPrograms = mysqli_num_rows($resultQueryTrainingPrograms);
                                    if($countQueryTrainingPrograms != 0){
                                        while($trainingPrograms = mysqli_fetch_array($resultQueryTrainingPrograms)){
                                            $remark = $trainingPrograms['remark'];
                                ?>
                                            <div class="card card-common2 mt-2" style="border-radius: 5px 5px 0px 0px;">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="panel panel-default card rounded" style="height:auto;">
                                                                <div class="card-header">
                                                                    <div class="panel-title">Total Programs</div>
                                                                </div>
                                                                <div class="card-body ">
                                                                    <div class="row">
                                                                        <div class="col">
                                                                        <div class="inner-content" style=" position: absolute; top: 50%; left: 50%; width: 100px; height: 10px; margin-top: -63px; margin-left: -50px; font-size: 40px; line-height: 100px; vertical-align: middle; text-align: center;">
                                                                                <?php 
                                                                                    $queryProgram = "SELECT COUNT(*) AS progCount FROM programstatus WHERE remark = '$remark'";
                                                                                    $resultQueryProgram = mysqli_query($conn,$queryProgram) or die(mysqli_error($conn));
                                                                                    $program = mysqli_fetch_array($resultQueryProgram);
                                                                                    echo $program['progCount'];
                                                                                ?>
                                                                            </div>
                                                                            <canvas id="chDonut<?php echo $trainingPrograms['id']; ?>"></canvas>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="panel panel-default card rounded" style="height:auto;">
                                                                        <div class="card-header">
                                                                            <div class="panel-title">Approval Status</div>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="panel-body row divbody pt-1 d-flex justify-content-between align-items-center" >
                                                                                <div class="col-2">
                                                                                    <small><small>GTD : </small></small>
                                                                                </div>
                                                                                <div class="col-10">
                                                                                    <?php

                                                                                        $totalProgs = $program['progCount'];
                                                                                    
                                                                                        $queryInProgGTD = "SELECT COUNT(*) AS inProgGTD FROM programstatus WHERE progApprGTD = 1 AND remark = '$remark'";
                                                                                        $resultQueryInProgGTD = mysqli_query($conn,$queryInProgGTD) or die(mysqli_error($conn));
                                                                                        $inProgGTD = mysqli_fetch_array($resultQueryInProgGTD);

                                                                                        $queryTotGTD = "SELECT COUNT(*) AS totGTD FROM programstatus WHERE (progApprGTD > 0 AND progApprGTD < 4)  AND remark = '$remark'";
                                                                                        $resultQueryTotGTD = mysqli_query($conn,$queryTotGTD) or die(mysqli_error($conn));
                                                                                        $totGTD = mysqli_fetch_array($resultQueryTotGTD);

                                                                                        $totGTD = $totGTD['totGTD'];
                                                                                        $inProgGTD = $inProgGTD['inProgGTD'];

                                                                                        $queryApprGTD = "SELECT COUNT(*) AS ApprGTD FROM programstatus WHERE progApprGTD = 2 AND remark = '$remark'";
                                                                                        $resultQueryApprGTD = mysqli_query($conn,$queryApprGTD) or die(mysqli_error($conn));
                                                                                        $apprGTD = mysqli_fetch_array($resultQueryApprGTD);

                                                                                        $apprGTD = $apprGTD['ApprGTD'];

                                                                                        $queryRejGTD = "SELECT COUNT(*) AS RejGTD FROM programstatus WHERE progApprGTD = 3 AND remark = '$remark'";
                                                                                        $resultQueryRejGTD = mysqli_query($conn,$queryRejGTD) or die(mysqli_error($conn));
                                                                                        $rejGTD = mysqli_fetch_array($resultQueryRejGTD);

                                                                                        $rejGTD = $rejGTD['RejGTD'];

                                                                                        $widthGTD = ($totGTD/$totalProgs)*100;

                                                                                        if($totGTD == 0){
                                                                                            $inProgressGTD = 0;
                                                                                            $ApprGTD = 0;
                                                                                            $RejGTD = 0;
                                                                                        }else{
                                                                                            $inProgressGTD = ($inProgGTD/$totGTD)*100;
                                                                                            $ApprGTD = ($apprGTD/$totGTD)*100;
                                                                                            $RejGTD = ($rejGTD/$totGTD)*100;
                                                                                        }
                                                                                        //echo $apprGTD['apprGTD']; 
                                                                                    ?>
                                                                                    <div class="progress" style="width:<?php    echo    $widthGTD;  ?>%">
                                                                                        <div class="progress-bar progress-bar-striped bg-warning" style="width:<?php echo   $inProgressGTD;   ?>%">
                                                                                            <?php   echo    $inProgGTD;    ?>
                                                                                        </div>
                                                                                        <div class="progress-bar progress-bar-striped bg-success" style="width:<?php echo   $ApprGTD;   ?>%">
                                                                                            <?php   echo    $apprGTD;    ?>
                                                                                        </div>
                                                                                        <div class="progress-bar progress-bar-striped bg-danger" style="width:<?php echo   $RejGTD;   ?>%">
                                                                                            <?php   echo    $rejGTD;    ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                                $queryCXOAll = "SELECT * FROM user WHERE role = 'CXO-1' ORDER BY unit";
                                                                                $resultCXOAll = mysqli_query($conn,$queryCXOAll) or die(mysqli_error($conn));
                                                                                while($CXOAll = mysqli_fetch_array($resultCXOAll)){
                                                                            ?>
                                                                            <div class="panel-body row divbody pt-1 d-flex justify-content-between align-items-center" >
                                                                                <div class="col-2">
                                                                                    <small><small>CXO1 : 
                                                                                        <?php
                                                                                            echo     "(".$CXOAll['fName'].")";
                                                                                        ?>
                                                                                    </small></small>
                                                                                </div>
                                                                                <div class="col-10">
                                                                                    <?php 
                                                                                        $unit = $CXOAll['unit'];    

                                                                                        $queryInProgCXO1 = "SELECT COUNT(*) AS inProgCXO1 FROM cxoapproval WHERE progApprCXO1 = 1 AND CXOid = $unit AND idProgram IN (SELECT idProgram FROM programstatus WHERE remark = '$remark')";
                                                                                        $resultQueryInProgCXO1 = mysqli_query($conn,$queryInProgCXO1) or die(mysqli_error($conn));
                                                                                        $inProgCXO1 = mysqli_fetch_array($resultQueryInProgCXO1);

                                                                                        $queryTotCXO1 = "SELECT COUNT(*) AS totCXO1 FROM cxoapproval WHERE (progApprCXO1 > 0 AND progApprCXO1 < 4) AND CXOid = $unit AND idProgram IN (SELECT idProgram FROM programstatus WHERE remark = '$remark')";
                                                                                        $resultQueryTotCXO1 = mysqli_query($conn,$queryTotCXO1) or die(mysqli_error($conn));
                                                                                        $totCXO1 = mysqli_fetch_array($resultQueryTotCXO1);

                                                                                        $totCXO1 = $totCXO1['totCXO1'];
                                                                                        $inProgCXO1 = $inProgCXO1['inProgCXO1'];

                                                                                        $queryApprCXO1 = "SELECT COUNT(*) AS ApprCXO1 FROM cxoapproval WHERE progApprCXO1 = 2 AND CXOid = $unit AND idProgram IN (SELECT idProgram FROM programstatus WHERE remark = '$remark')";
                                                                                        $resultQueryApprCXO1 = mysqli_query($conn,$queryApprCXO1) or die(mysqli_error($conn));
                                                                                        $apprCXO1 = mysqli_fetch_array($resultQueryApprCXO1);

                                                                                        $apprCXO1 = $apprCXO1['ApprCXO1'];

                                                                                        $queryRejCXO1 = "SELECT COUNT(*) AS RejCXO1 FROM cxoapproval WHERE progApprCXO1 = 3 AND CXOid = $unit AND idProgram IN (SELECT idProgram FROM programstatus WHERE remark = '$remark')";
                                                                                        $resultQueryRejCXO1 = mysqli_query($conn,$queryRejCXO1) or die(mysqli_error($conn));
                                                                                        $rejCXO1 = mysqli_fetch_array($resultQueryRejCXO1);

                                                                                        $rejCXO1 = $rejCXO1['RejCXO1'];

                                                                                        $widthCXO1 = ($totCXO1/$totalProgs)*100;

                                                                                        if($totCXO1 == 0){
                                                                                            $inProgressCXO1 = 0;
                                                                                            $ApprCXO1 = 0;
                                                                                            $RejCXO1 = 0;
                                                                                        }else{
                                                                                            $inProgressCXO1 = ($inProgCXO1/$totCXO1)*100;
                                                                                            $ApprCXO1 = ($apprCXO1/$totCXO1)*100;
                                                                                            $RejCXO1 = ($rejCXO1/$totCXO1)*100;
                                                                                        }

                                                                                        //echo $apprGTD['apprGTD']; 
                                                                                    ?>
                                                                                    <div class="progress" style="width:<?php    echo    $widthCXO1;  ?>%">
                                                                                        <div class="progress-bar progress-bar-striped bg-warning" style="width:<?php echo   $inProgressCXO1;   ?>%">
                                                                                            <?php   echo    $inProgCXO1;    ?>
                                                                                        </div>
                                                                                        <div class="progress-bar progress-bar-striped bg-success" style="width:<?php echo   $ApprCXO1;   ?>%">
                                                                                            <?php   echo    $apprCXO1;    ?>
                                                                                        </div>
                                                                                        <div class="progress-bar progress-bar-striped bg-danger" style="width:<?php echo   $RejCXO1;   ?>%">
                                                                                            <?php   echo    $rejCXO1;    ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                                }
                                                                            ?>
                                                                            <div class="panel-body row divbody pt-1 d-flex justify-content-between align-items-center" >
                                                                                <div class="col-2">
                                                                                    <small><small>GCTO : </small></small>
                                                                                </div>
                                                                                <div class="col-10">
                                                                                    <?php 
                                                                                        $queryInProgGCTO = "SELECT COUNT(*) AS inProgGCTO FROM programstatus WHERE progApprGCTO = 1 AND remark = '$remark'";
                                                                                        $resultQueryInProgGCTO = mysqli_query($conn,$queryInProgGCTO) or die(mysqli_error($conn));
                                                                                        $inProgGCTO = mysqli_fetch_array($resultQueryInProgGCTO);

                                                                                        $queryTotGCTO = "SELECT COUNT(*) AS totGCTO FROM programstatus WHERE (progApprGCTO > 0 AND progApprGCTO < 4)  AND remark = '$remark'";
                                                                                        $resultQueryTotGCTO = mysqli_query($conn,$queryTotGCTO) or die(mysqli_error($conn));
                                                                                        $totGCTO = mysqli_fetch_array($resultQueryTotGCTO);

                                                                                        $totGCTO = $totGCTO['totGCTO'];
                                                                                        $inProgGCTO = $inProgGCTO['inProgGCTO'];

                                                                                        $queryApprGCTO = "SELECT COUNT(*) AS ApprGCTO FROM programstatus WHERE progApprGCTO = 2 AND remark = '$remark'";
                                                                                        $resultQueryApprGCTO = mysqli_query($conn,$queryApprGCTO) or die(mysqli_error($conn));
                                                                                        $apprGCTO = mysqli_fetch_array($resultQueryApprGCTO);

                                                                                        $apprGCTO = $apprGCTO['ApprGCTO'];

                                                                                        $queryRejGCTO = "SELECT COUNT(*) AS RejGCTO FROM programstatus WHERE progApprGCTO = 3 AND remark = '$remark'";
                                                                                        $resultQueryRejGCTO = mysqli_query($conn,$queryRejGCTO) or die(mysqli_error($conn));
                                                                                        $rejGCTO = mysqli_fetch_array($resultQueryRejGCTO);

                                                                                        $rejGCTO = $rejGCTO['RejGCTO'];

                                                                                        $widthGCTO = ($totGCTO/$totalProgs)*100;

                                                                                        if($totGCTO == 0){
                                                                                            $inProgressGCTO = 0;
                                                                                            $ApprGCTO = 0;
                                                                                            $RejGCTO = 0;
                                                                                        }else{
                                                                                            $inProgressGCTO = ($inProgGCTO/$totGCTO)*100;
                                                                                            $ApprGCTO = ($apprGCTO/$totGCTO)*100;
                                                                                            $RejGCTO = ($rejGCTO/$totGCTO)*100;
                                                                                        }

                                                                                        //echo $apprGTD['apprGTD']; 
                                                                                    ?>
                                                                                    <div class="progress" style="width:<?php    echo    $widthGCTO;  ?>%">
                                                                                        <div class="progress-bar progress-bar-striped bg-warning" style="width:<?php echo   $inProgressGCTO;   ?>%">
                                                                                            <?php   echo    $inProgGCTO;    ?>
                                                                                        </div>
                                                                                        <div class="progress-bar progress-bar-striped bg-success" style="width:<?php echo   $ApprGCTO;   ?>%">
                                                                                            <?php   echo    $apprGCTO;    ?>
                                                                                        </div>
                                                                                        <div class="progress-bar progress-bar-striped bg-danger" style="width:<?php echo   $RejGCTO;   ?>%">
                                                                                            <?php   echo    $rejGCTO;    ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="panel-body row divbody pt-1 d-flex justify-content-between align-items-center" >
                                                                                <div class="col-2">
                                                                                    <small><small>GCEO : </small></small>
                                                                                </div>
                                                                                <div class="col-10">
                                                                                    <?php 
                                                                                        $queryInProgGCEO = "SELECT COUNT(*) AS inProgGCEO FROM programstatus WHERE progApprGCEO = 1 AND remark = '$remark'";
                                                                                        $resultQueryInProgGCEO = mysqli_query($conn,$queryInProgGCEO) or die(mysqli_error($conn));
                                                                                        $inProgGCEO = mysqli_fetch_array($resultQueryInProgGCEO);

                                                                                        $queryTotGCEO = "SELECT COUNT(*) AS totGCEO FROM programstatus WHERE (progApprGCEO > 0 AND progApprGCEO < 4)  AND remark = '$remark'";
                                                                                        $resultQueryTotGCEO = mysqli_query($conn,$queryTotGCEO) or die(mysqli_error($conn));
                                                                                        $totGCEO = mysqli_fetch_array($resultQueryTotGCEO);

                                                                                        $totGCEO = $totGCEO['totGCEO'];
                                                                                        $inProgGCEO = $inProgGCEO['inProgGCEO'];

                                                                                        $queryApprGCEO = "SELECT COUNT(*) AS ApprGCEO FROM programstatus WHERE progApprGCEO = 2 AND remark = '$remark'";
                                                                                        $resultQueryApprGCEO = mysqli_query($conn,$queryApprGCEO) or die(mysqli_error($conn));
                                                                                        $apprGCEO = mysqli_fetch_array($resultQueryApprGCEO);

                                                                                        $apprGCEO = $apprGCEO['ApprGCEO'];

                                                                                        $queryRejGCEO = "SELECT COUNT(*) AS RejGCEO FROM programstatus WHERE progApprGCEO = 3 AND remark = '$remark'";
                                                                                        $resultQueryRejGCEO = mysqli_query($conn,$queryRejGCEO) or die(mysqli_error($conn));
                                                                                        $rejGCEO = mysqli_fetch_array($resultQueryRejGCEO);

                                                                                        $rejGCEO = $rejGCEO['RejGCEO'];

                                                                                        $widthGCEO = ($totGCEO/$totalProgs)*100;

                                                                                        if($totGCEO == 0){
                                                                                            $inProgressGCEO = 0;
                                                                                            $ApprGCEO = 0;
                                                                                            $RejGCEO = 0;
                                                                                        }else{
                                                                                            $inProgressGCEO = ($inProgGCEO/$totGCEO)*100;
                                                                                            $ApprGCEO = ($apprGCEO/$totGCEO)*100;
                                                                                            $RejGCEO = ($rejGCEO/$totGCEO)*100;
                                                                                        }

                                                                                        //echo $apprGTD['apprGTD']; 
                                                                                    ?>
                                                                                    <div class="progress" style="width:<?php    echo    $widthGCEO;  ?>%">
                                                                                        <div class="progress-bar progress-bar-striped bg-warning" style="width:<?php echo   $inProgressGCEO;   ?>%">
                                                                                            <?php   echo    $inProgGCEO;    ?>
                                                                                        </div>
                                                                                        <div class="progress-bar progress-bar-striped bg-success" style="width:<?php echo   $ApprGCEO;   ?>%">
                                                                                            <?php   echo    $apprGCEO;    ?>
                                                                                        </div>
                                                                                        <div class="progress-bar progress-bar-striped bg-danger" style="width:<?php echo   $RejGCEO;   ?>%">
                                                                                            <?php   echo    $rejGCEO;    ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="panel-body row divbody mt-3 d-flex justify-content-between align-items-center" >
                                                                                <div class="col-3">
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div style="text-align:center" class="d-flex justify-content-between align-items-center">
                                                                                        <span class="dot" style="height: 13px; width: 13px; background-color: #FFC100; border-radius: 50%; display: inline-block;"></span>
                                                                                        <span><small><small>Pending</small></small></span>
                                                                                        <span class="dot" style="height: 13px; width: 13px; background-color: #03B000; border-radius: 50%; display: inline-block;"></span>
                                                                                        <span><small><small>Accepted</small></small></span>
                                                                                        <span class="dot" style="height: 13px; width: 13px; background-color: #BE2222; border-radius: 50%; display: inline-block;"></span>
                                                                                        <span><small><small>Rejected</small></small></span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-3">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="row mt-2">
                                                        <div class="col">
                                                            <div class="panel panel-default card rounded">
                                                                <div class="panel-body row m-2 pb-1 pt-1 px-3">
                                                                    <div class="col-6 p-2 d-flex justify-content-between align-items-center">
                                                                        <div class="row">
                                                                            <span>Total budget allcocation form <b>GT Training Budget</b></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 p-2 d-block justify-content-end align-items-center">
                                                                        <?php
                                                                            // $budgetQuery = "SELECT currency, totalCost FROM programstatus WHERE bSource LIKE '%GT Training Budget%' AND statusHR = '1' AND remark='$remark'";
                                                                            // $resultBudgetQuery= mysqli_query($conn,$budgetQuery) or die(mysqli_error($conn));
                                                                            // $totalCostLKR = 0;
                                                                            // $totalCostUSD = 0;
                                                                            // while($arrayBudget = mysqli_fetch_array($resultBudgetQuery)){
                                                                            //     $cost = $arrayBudget['totalCost'];
                                                                            //     $currency = $arrayBudget['currency'];
                                                                            //     if($currency == "USD"){
                                                                            //         $totalCostUSD = $totalCostUSD + $cost;
                                                                            //     }else if($currency == "LKR"){
                                                                            //         $totalCostLKR = $totalCostLKR + $cost;
                                                                            //     }
                                                                            // }
                                                                        ?>
                                                                        <div class="row">
                                                                            <div class="col-6 p-2 d-flex justify-content-start align-items-center">
                                                                                <small>Budget allocate from LKR:</small>
                                                                            </div>
                                                                            <div class="col-6 p-2 d-flex justify-content-end align-items-center">
                                                                                <b><?php// $totalCostLKR = number_format($totalCostLKR,2,'.',','); echo    "".$totalCostLKR." LKR";  ?></b>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6 p-2 d-flex justify-content-start align-items-center">
                                                                                <small>Budget allocate from USD:</small>
                                                                            </div>
                                                                            <div class="col-6 p-2 d-flex justify-content-end align-items-center">
                                                                                <b><?php// $totalCostUSD = number_format($totalCostUSD,2,'.',','); echo    "".$totalCostUSD." USD";  ?></b>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="row mt-2">
                                                        <div class="col">
                                                            <div class="panel panel-default card rounded">
                                                                <div class="card-header">
                                                                    <div class="panel-title">Types of Programs</div>
                                                                </div> 
                                                                <div class="panel-body mt-2 pb-1 pt-1 px-3">
                                                                    <small><small>
                                                                        <table class="table table-hover table-striped mb-2" style="width:100%;">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th scope="col">#</th>
                                                                                    <th scope="col" style="text-align:center">Requested Prog. Count</th>
                                                                                    <th scope="col" style="text-align:center">Prog. Count in Approval Path</th>
                                                                                    <th scope="col" style="text-align:center; background-color:#2BB9D0;">Module Pending</th>
                                                                                    <th scope="col" style="text-align:center; background-color:#FFD99A">Nominee Pending</th>
                                                                                    <th scope="col" style="text-align:center">Approval Pending</th>
                                                                                    <th scope="col" style="text-align:center">Ongoing</th>
                                                                                    <th scope="col" style="text-align:center">Deliverd</th>
                                                                                    <th scope="col" style="text-align:center">Canceled/Rejected</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th scope="row">Local</th>

                                                                                    <?php
                                                                                        $queryLocalProgram = "SELECT COUNT(*) AS totl FROM program WHERE typ = 'Local' AND remark='$remark'";
                                                                                        $localProgramArray = mysqli_query($conn,$queryLocalProgram) or die(mysqli_error($conn));
                                                                                        $localProgram = mysqli_fetch_array($localProgramArray);
                                                                                    ?>

                                                                                    <td style="text-align:center"><?php   echo    $localProgram['totl'];    ?></td>

                                                                                    <?php
                                                                                        $queryTotProgLocalCount = "SELECT COUNT(*) AS totLocal FROM programstatus WHERE remark = '$remark' AND progType = 'Local'";
                                                                                        $resultQueryTotProgLocalCount= mysqli_query($conn,$queryTotProgLocalCount) or die(mysqli_error($conn));
                                                                                        $countQueryTotProgLocalCount = mysqli_fetch_array($resultQueryTotProgLocalCount);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php   echo    $countQueryTotProgLocalCount['totLocal'];    ?></td>

                                                                                    <?php
                                                                                        $queryProgLocalModulePending = "SELECT COUNT(*) AS totLocalPending FROM programstatus WHERE remark = '$remark' AND progType = 'Local' AND progModuleStatus = 'Pending'";
                                                                                        $resultQueryProgLocalModulePending= mysqli_query($conn,$queryProgLocalModulePending) or die(mysqli_error($conn));
                                                                                        $countQueryProgLocalModulePending = mysqli_fetch_array($resultQueryProgLocalModulePending);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center; background-color:#2BB9D0;"><?php     if($countQueryProgLocalModulePending['totLocalPending']>0){     echo    '<span class="badge badge-pill badge-danger">'; echo  $countQueryProgLocalModulePending['totLocalPending']; echo  '</span>';     }else{    echo    $countQueryProgLocalModulePending['totLocalPending'];   }   ?></td>

                                                                                    <?php
                                                                                        $queryProgLocalNomineePending = "SELECT COUNT(*) AS totLocalNomineePending FROM programstatus WHERE remark = '$remark' AND progType = 'Local' AND progNomStatus = 'Pending'";
                                                                                        $resultQueryProgLocalNomineePending= mysqli_query($conn,$queryProgLocalNomineePending) or die(mysqli_error($conn));
                                                                                        $countQueryProgLocalNomineePending = mysqli_fetch_array($resultQueryProgLocalNomineePending);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center; background-color:#FFD99A"><?php     if($countQueryProgLocalNomineePending['totLocalNomineePending']>0){     echo    '<span class="badge badge-pill badge-danger">'; echo  $countQueryProgLocalNomineePending['totLocalNomineePending']; echo  '</span>';     }else{    echo    $countQueryProgLocalNomineePending['totLocalNomineePending'];   }   ?></td>

                                                                                    <?php
                                                                                        $queryProgLocalOngoing = "SELECT COUNT(*) AS totLocalOngoing FROM programstatus WHERE ((progApprGTD IN (0,1) OR statusCXO1 IN (0,1) OR progApprGCTO IN (0,1) OR progApprGCEO IN (0,1)) OR (progModuleStatus = 'Pending' OR progNomStatus = 'Pending')) AND (progApprGTD !=3 AND statusCXO1 != 3 AND progApprGCTO != 3 AND progApprGCEO != 3) AND cancelStatus != 1 AND deliveryStatus = 0 AND remark = '$remark' AND progType = 'Local'";
                                                                                        $resultQueryProgLocalOngoing= mysqli_query($conn,$queryProgLocalOngoing) or die(mysqli_error($conn));
                                                                                        $countQueryProgLocalOngoing = mysqli_fetch_array($resultQueryProgLocalOngoing);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php  if($countQueryProgLocalOngoing['totLocalOngoing']>0){   echo    '<span class="badge badge-pill badge-warning">'; echo  $countQueryProgLocalOngoing['totLocalOngoing']; echo  '</span>';    }else{    echo    $countQueryProgLocalOngoing['totLocalOngoing']; }   ?></td>

                                                                                    <?php
                                                                                        $queryProgLocalApproved = "SELECT COUNT(*) AS totLocalApproved FROM programstatus WHERE ((progApprGTD IN (2) AND statusCXO1 IN (2) AND progApprGCTO IN (2) AND progApprGCEO IN (2,4))) AND deliveryStatus = 0 AND (progModuleStatus != 'Pending' AND progNomStatus != 'Pending') AND cancelStatus != 1 AND remark = '$remark' AND progType = 'Local'";
                                                                                        $resultQueryProgLocalApproved= mysqli_query($conn,$queryProgLocalApproved) or die(mysqli_error($conn));
                                                                                        $countQueryProgLocalApproved = mysqli_fetch_array($resultQueryProgLocalApproved);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php  if($countQueryProgLocalApproved['totLocalApproved']>0){   echo    '<span class="badge badge-pill badge-success">'; echo  $countQueryProgLocalApproved['totLocalApproved']; echo  '</span>';    }else{    echo    $countQueryProgLocalApproved['totLocalApproved']; }   ?></td>

                                                                                    <?php
                                                                                        $queryProgLocalDelivered = "SELECT COUNT(*) AS totLocalDelivered FROM programstatus WHERE deliveryStatus = 1 AND cancelStatus = 0 AND remark = '$remark' AND progType = 'Local'";
                                                                                        $resultQueryProgLocalDelivered= mysqli_query($conn,$queryProgLocalDelivered) or die(mysqli_error($conn));
                                                                                        $countQueryProgLocalDelivered = mysqli_fetch_array($resultQueryProgLocalDelivered);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php  if($countQueryProgLocalDelivered['totLocalDelivered']>0){   echo    '<span class="badge badge-pill badge-primary">'; echo  $countQueryProgLocalDelivered['totLocalDelivered']; echo  '</span>';    }else{    echo    $countQueryProgLocalDelivered['totLocalDelivered']; }   ?></td>

                                                                                    <?php
                                                                                        $queryProgLocalRejected = "SELECT COUNT(*) AS totLocalRejected FROM programstatus WHERE (progApprGTD = 3 OR statusCXO1 = 3 OR progApprGCTO = 3 OR progApprGCEO = 3 OR cancelStatus = 1) AND remark = '$remark' AND progType = 'Local'";
                                                                                        $resultQueryProgLocalRejected= mysqli_query($conn,$queryProgLocalRejected) or die(mysqli_error($conn));
                                                                                        $countQueryProgLocalRejected = mysqli_fetch_array($resultQueryProgLocalRejected);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center;"><?php  if($countQueryProgLocalRejected['totLocalRejected']>0){   echo    '<span class="badge badge-pill badge-danger">'; echo  $countQueryProgLocalRejected['totLocalRejected']; echo  '</span>';    }else{    echo    $countQueryProgLocalRejected['totLocalRejected']; }   ?></td>

                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Foriegn</th>

                                                                                    <?php
                                                                                        $queryForiegnProgram = "SELECT COUNT(*) AS totf FROM program WHERE typ = 'Foriegn' AND remark='$remark'";
                                                                                        $foriegnProgramArray = mysqli_query($conn,$queryForiegnProgram) or die(mysqli_error($conn));
                                                                                        $foriegnProgram = mysqli_fetch_array($foriegnProgramArray);
                                                                                    ?>

                                                                                    <td style="text-align:center"><?php   echo    $foriegnProgram['totf'];    ?></td>

                                                                                    <?php
                                                                                        $queryTotProgForeignCount = "SELECT COUNT(*) AS totForeign FROM programstatus WHERE remark = '$remark' AND progType = 'Foreign'";
                                                                                        $resultQueryTotProgForeignCount= mysqli_query($conn,$queryTotProgForeignCount) or die(mysqli_error($conn));
                                                                                        $countQueryTotProgForeignCount = mysqli_fetch_array($resultQueryTotProgForeignCount);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php   echo    $countQueryTotProgForeignCount['totForeign'];    ?></td>

                                                                                    <?php
                                                                                        $queryProgForeignModulePending = "SELECT COUNT(*) AS totForeignPending FROM programstatus WHERE remark = '$remark' AND progType = 'Foreign' AND progModuleStatus = 'Pending'";
                                                                                        $resultQueryProgForeignModulePending= mysqli_query($conn,$queryProgForeignModulePending) or die(mysqli_error($conn));
                                                                                        $countQueryProgForeignModulePending = mysqli_fetch_array($resultQueryProgForeignModulePending);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center; background-color:#2BB9D0;"><?php     if($countQueryProgForeignModulePending['totForeignPending']>0){     echo    '<span class="badge badge-pill badge-danger">'; echo  $countQueryProgForeignModulePending['totForeignPending']; echo  '</span>';     }else{     echo    $countQueryProgForeignModulePending['totForeignPending']; }   ?></td>

                                                                                    <?php
                                                                                        $queryProgForeignNomineePending = "SELECT COUNT(*) AS totForeignNomineePending FROM programstatus WHERE remark = '$remark' AND progType = 'Foreign' AND progNomStatus = 'Pending'";
                                                                                        $resultQueryProgForeignNomineePending= mysqli_query($conn,$queryProgForeignNomineePending) or die(mysqli_error($conn));
                                                                                        $countQueryProgForeignNomineePending = mysqli_fetch_array($resultQueryProgForeignNomineePending);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center; background-color:#FFD99A"><?php     if($countQueryProgForeignNomineePending['totForeignNomineePending']>0){     echo    '<span class="badge badge-pill badge-danger">'; echo  $countQueryProgForeignNomineePending['totForeignNomineePending']; echo  '</span>';     }else{    echo    $countQueryProgForeignNomineePending['totForeignNomineePending'];   }   ?></td>

                                                                                    <?php
                                                                                        $queryProgForeignOngoing = "SELECT COUNT(*) AS totForeignOngoing FROM programstatus WHERE ((progApprGTD IN (0,1) OR statusCXO1 IN (0,1) OR progApprGCTO IN (0,1) OR progApprGCEO IN (0,1)) OR (progModuleStatus = 'Pending' OR progNomStatus = 'Pending')) AND (progApprGTD !=3 AND statusCXO1 != 3 AND progApprGCTO != 3 AND progApprGCEO != 3) AND cancelStatus != 1 AND deliveryStatus = 0 AND remark = '$remark' AND progType = 'Foreign'";
                                                                                        $resultQueryProgForeignOngoing= mysqli_query($conn,$queryProgForeignOngoing) or die(mysqli_error($conn));
                                                                                        $countQueryProgForeignOngoing = mysqli_fetch_array($resultQueryProgForeignOngoing);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php  if($countQueryProgForeignOngoing['totForeignOngoing']>0){   echo    '<span class="badge badge-pill badge-warning">'; echo  $countQueryProgForeignOngoing['totForeignOngoing']; echo  '</span>';    }else{    echo    $countQueryProgForeignOngoing['totForeignOngoing']; }   ?></td>

                                                                                    <?php
                                                                                        $queryProgForeignApproved = "SELECT COUNT(*) AS totForeignApproved FROM programstatus WHERE ((progApprGTD IN (2) AND statusCXO1 IN (2) AND progApprGCTO IN (2) AND progApprGCEO IN (2,4))) AND deliveryStatus = 0 AND (progModuleStatus != 'Pending' AND progNomStatus != 'Pending') AND cancelStatus != 1 AND remark = '$remark' AND progType = 'Foreign'";
                                                                                        $resultQueryProgForeignApproved= mysqli_query($conn,$queryProgForeignApproved) or die(mysqli_error($conn));
                                                                                        $countQueryProgForeignApproved = mysqli_fetch_array($resultQueryProgForeignApproved);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php  if($countQueryProgForeignApproved['totForeignApproved']>0){   echo    '<span class="badge badge-pill badge-success">'; echo  $countQueryProgForeignApproved['totForeignApproved']; echo  '</span>';    }else{    echo    $countQueryProgForeignApproved['totForeignApproved']; }   ?></td>

                                                                                    <?php
                                                                                        $queryProgForeignDelivered = "SELECT COUNT(*) AS totForeignDelivered FROM programstatus WHERE deliveryStatus = 1 AND cancelStatus = 0 AND remark = '$remark' AND progType = 'Foreign'";
                                                                                        $resultQueryProgForeignDelivered= mysqli_query($conn,$queryProgForeignDelivered) or die(mysqli_error($conn));
                                                                                        $countQueryProgForeignDelivered = mysqli_fetch_array($resultQueryProgForeignDelivered);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php  if($countQueryProgForeignDelivered['totForeignDelivered']>0){   echo    '<span class="badge badge-pill badge-primary">'; echo  $countQueryProgForeignDelivered['totForeignDelivered']; echo  '</span>';    }else{    echo    $countQueryProgForeignDelivered['totForeignDelivered']; }   ?></td>

                                                                                    <?php
                                                                                        $queryProgForeignRejected = "SELECT COUNT(*) AS totForeignRejected FROM programstatus WHERE (progApprGTD = 3 OR statusCXO1 = 3 OR progApprGCTO = 3 OR progApprGCEO = 3 OR cancelStatus = 1) AND remark = '$remark' AND progType = 'Foreign'";
                                                                                        $resultQueryProgForeignRejected= mysqli_query($conn,$queryProgForeignRejected) or die(mysqli_error($conn));
                                                                                        $countQueryProgForeignRejected = mysqli_fetch_array($resultQueryProgForeignRejected);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php  if($countQueryProgForeignRejected['totForeignRejected']>0){   echo    '<span class="badge badge-pill badge-danger">'; echo  $countQueryProgForeignRejected['totForeignRejected']; echo  '</span>';    }else{    echo    $countQueryProgForeignRejected['totForeignRejected']; }   ?></td>

                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Online</th>

                                                                                    <?php
                                                                                        $queryOnlineProgram = "SELECT COUNT(*) AS toto FROM program WHERE typ = 'Online' AND remark='$remark'";
                                                                                        $onlineProgramArray = mysqli_query($conn,$queryOnlineProgram) or die(mysqli_error($conn));
                                                                                        $onlineProgram = mysqli_fetch_array($onlineProgramArray);
                                                                                    ?>

                                                                                    <td style="text-align:center"><?php   echo    $onlineProgram['toto'];    ?></td>

                                                                                    <?php
                                                                                        $queryTotProgOnlineCount = "SELECT COUNT(*) AS totOnline FROM programstatus WHERE remark = '$remark' AND progType = 'Online'";
                                                                                        $resultQueryTotProgOnlineCount= mysqli_query($conn,$queryTotProgOnlineCount) or die(mysqli_error($conn));
                                                                                        $countQueryTotProgOnlineCount = mysqli_fetch_array($resultQueryTotProgOnlineCount);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php   echo    $countQueryTotProgOnlineCount['totOnline'];    ?></td>

                                                                                    <?php
                                                                                        $queryProgOnlineModulePending = "SELECT COUNT(*) AS totOnlinePending FROM programstatus WHERE remark = '$remark' AND progType = 'Online' AND progModuleStatus = 'Pending'";
                                                                                        $resultQueryProgOnlineModulePending= mysqli_query($conn,$queryProgOnlineModulePending) or die(mysqli_error($conn));
                                                                                        $countQueryProgOnlineModulePending = mysqli_fetch_array($resultQueryProgOnlineModulePending);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center; background-color:#2BB9D0;"><?php     if($countQueryProgOnlineModulePending['totOnlinePending']>0){     echo    '<span class="badge badge-pill badge-danger">'; echo  $countQueryProgOnlineModulePending['totOnlinePending']; echo  '</span>';     }else{    echo    $countQueryProgOnlineModulePending['totOnlinePending'];   } ?></td>

                                                                                    <?php
                                                                                        $queryProgOnlineNomineePending = "SELECT COUNT(*) AS totOnlineNomineePending FROM programstatus WHERE remark = '$remark' AND progType = 'Online' AND progNomStatus = 'Pending'";
                                                                                        $resultQueryProgOnlineNomineePending= mysqli_query($conn,$queryProgOnlineNomineePending) or die(mysqli_error($conn));
                                                                                        $countQueryProgOnlineNomineePending = mysqli_fetch_array($resultQueryProgOnlineNomineePending);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center; background-color:#FFD99A"><?php     if($countQueryProgOnlineNomineePending['totOnlineNomineePending']>0){     echo    '<span class="badge badge-pill badge-danger">'; echo  $countQueryProgOnlineNomineePending['totOnlineNomineePending']; echo  '</span>';     }else{    echo    $countQueryProgOnlineNomineePending['totOnlineNomineePending'];   } ?></td>

                                                                                    <?php
                                                                                        $queryProgOnlineOngoing = "SELECT COUNT(*) AS totOnlineOngoing FROM programstatus WHERE ((progApprGTD IN (0,1) OR statusCXO1 IN (0,1) OR progApprGCTO IN (0,1) OR progApprGCEO IN (0,1)) OR (progModuleStatus = 'Pending' OR progNomStatus = 'Pending')) AND (progApprGTD !=3 AND statusCXO1 != 3 AND progApprGCTO != 3 AND progApprGCEO != 3) AND cancelStatus != 1 AND deliveryStatus = 0 AND remark = '$remark' AND progType = 'Online'";
                                                                                        $resultQueryProgOnlineOngoing= mysqli_query($conn,$queryProgOnlineOngoing) or die(mysqli_error($conn));
                                                                                        $countQueryProgOnlineOngoing = mysqli_fetch_array($resultQueryProgOnlineOngoing);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php  if($countQueryProgOnlineOngoing['totOnlineOngoing']>0){   echo    '<span class="badge badge-pill badge-warning">'; echo  $countQueryProgOnlineOngoing['totOnlineOngoing']; echo  '</span>';    }else{    echo    $countQueryProgOnlineOngoing['totOnlineOngoing']; }   ?></td>

                                                                                    <?php
                                                                                        $queryProgOnlineApproved = "SELECT COUNT(*) AS totOnlineApproved FROM programstatus WHERE ((progApprGTD IN (2) AND statusCXO1 IN (2) AND progApprGCTO IN (2) AND progApprGCEO IN (2,4))) AND deliveryStatus = 0 AND (progModuleStatus != 'Pending' AND progNomStatus != 'Pending') AND cancelStatus != 1 AND remark = '$remark' AND progType = 'Online'";
                                                                                        $resultQueryProgOnlineApproved= mysqli_query($conn,$queryProgOnlineApproved) or die(mysqli_error($conn));
                                                                                        $countQueryProgOnlineApproved = mysqli_fetch_array($resultQueryProgOnlineApproved);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php  if($countQueryProgOnlineApproved['totOnlineApproved']>0){   echo    '<span class="badge badge-pill badge-success">'; echo  $countQueryProgOnlineApproved['totOnlineApproved']; echo  '</span>';    }else{    echo    $countQueryProgOnlineApproved['totOnlineApproved']; }   ?></td>

                                                                                    <?php
                                                                                        $queryProgOnlineDelivered = "SELECT COUNT(*) AS totOnlineDelivered FROM programstatus WHERE deliveryStatus = 1 AND cancelStatus = 0 AND remark = '$remark' AND progType = 'Online'";
                                                                                        $resultQueryProgOnlineDelivered= mysqli_query($conn,$queryProgOnlineDelivered) or die(mysqli_error($conn));
                                                                                        $countQueryProgOnlineDelivered = mysqli_fetch_array($resultQueryProgOnlineDelivered);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php  if($countQueryProgOnlineDelivered['totOnlineDelivered']>0){   echo    '<span class="badge badge-pill badge-primary">'; echo  $countQueryProgOnlineDelivered['totOnlineDelivered']; echo  '</span>';    }else{    echo    $countQueryProgOnlineDelivered['totOnlineDelivered']; }   ?></td>

                                                                                    <?php
                                                                                        $queryProgOnlineRejected = "SELECT COUNT(*) AS totOnlineRejected FROM programstatus WHERE (progApprGTD = 3 OR statusCXO1 = 3 OR progApprGCTO = 3 OR progApprGCEO = 3 OR cancelStatus = 1) AND remark = '$remark' AND progType = 'Online'";
                                                                                        $resultQueryProgOnlineRejected= mysqli_query($conn,$queryProgOnlineRejected) or die(mysqli_error($conn));
                                                                                        $countQueryProgOnlineRejected = mysqli_fetch_array($resultQueryProgOnlineRejected);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php  if($countQueryProgOnlineRejected['totOnlineRejected']>0){   echo    '<span class="badge badge-pill badge-danger">'; echo  $countQueryProgOnlineRejected['totOnlineRejected']; echo  '</span>';    }else{    echo    $countQueryProgOnlineRejected['totOnlineRejected']; }   ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Internal</th>

                                                                                    <?php
                                                                                        $queryInternalProgram = "SELECT COUNT(*) AS toti FROM program WHERE typ = 'Internal' AND remark='$remark'";
                                                                                        $internalProgramArray = mysqli_query($conn,$queryInternalProgram) or die(mysqli_error($conn));
                                                                                        $internalProgram = mysqli_fetch_array($internalProgramArray);
                                                                                    ?>

                                                                                    <td style="text-align:center"><?php   echo    $internalProgram['toti'];    ?></td>

                                                                                    <?php
                                                                                        $queryTotProgInternalCount = "SELECT COUNT(*) AS totInternal FROM programstatus WHERE remark = '$remark' AND progType = 'Internal'";
                                                                                        $resultQueryTotProgInternalCount= mysqli_query($conn,$queryTotProgInternalCount) or die(mysqli_error($conn));
                                                                                        $countQueryTotProgInternalCount = mysqli_fetch_array($resultQueryTotProgInternalCount);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php   echo    $countQueryTotProgInternalCount['totInternal'];    ?></td>

                                                                                    <?php
                                                                                        $queryProgInternalModulePending = "SELECT COUNT(*) AS totInternalPending FROM programstatus WHERE remark = '$remark' AND progType = 'Internal' AND progModuleStatus = 'Pending'";
                                                                                        $resultQueryProgInternalModulePending= mysqli_query($conn,$queryProgInternalModulePending) or die(mysqli_error($conn));
                                                                                        $countQueryProgInternalModulePending = mysqli_fetch_array($resultQueryProgInternalModulePending);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center; background-color:#2BB9D0;"><?php     if($countQueryProgInternalModulePending['totInternalPending']>0){     echo    '<span class="badge badge-pill badge-danger">'; echo  $countQueryProgInternalModulePending['totInternalPending']; echo  '</span>';     }else{    echo    $countQueryProgInternalModulePending['totInternalPending'];   } ?></td>

                                                                                    <?php
                                                                                        $queryProgInternalNomineePending = "SELECT COUNT(*) AS totInternalNomineePending FROM programstatus WHERE remark = '$remark' AND progType = 'Internal' AND progNomStatus = 'Pending'";
                                                                                        $resultQueryProgInternalNomineePending= mysqli_query($conn,$queryProgInternalNomineePending) or die(mysqli_error($conn));
                                                                                        $countQueryProgInternalNomineePending = mysqli_fetch_array($resultQueryProgInternalNomineePending);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center; background-color:#FFD99A"><?php     if($countQueryProgInternalNomineePending['totInternalNomineePending']>0){     echo    '<span class="badge badge-pill badge-danger">'; echo  $countQueryProgInternalNomineePending['totInternalNomineePending']; echo  '</span>';     }else{    echo    $countQueryProgInternalNomineePending['totInternalNomineePending'];   } ?></td>

                                                                                    <?php
                                                                                        $queryProgInternalOngoing = "SELECT COUNT(*) AS totInternalOngoing FROM programstatus WHERE ((progApprGTD IN (0,1) OR statusCXO1 IN (0,1) OR progApprGCTO IN (0,1) OR progApprGCEO IN (0,1)) OR (progModuleStatus = 'Pending' OR progNomStatus = 'Pending')) AND (progApprGTD !=3 AND statusCXO1 != 3 AND progApprGCTO != 3 AND progApprGCEO != 3) AND cancelStatus != 1 AND deliveryStatus = 0 AND remark = '$remark' AND progType = 'Internal'";
                                                                                        $resultQueryProgInternalOngoing= mysqli_query($conn,$queryProgInternalOngoing) or die(mysqli_error($conn));
                                                                                        $countQueryProgInternalOngoing = mysqli_fetch_array($resultQueryProgInternalOngoing);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php  if($countQueryProgInternalOngoing['totInternalOngoing']>0){   echo    '<span class="badge badge-pill badge-warning">'; echo  $countQueryProgInternalOngoing['totInternalOngoing']; echo  '</span>';    }else{    echo    $countQueryProgInternalOngoing['totInternalOngoing']; }   ?></td>

                                                                                    <?php
                                                                                        $queryProgInternalApproved = "SELECT COUNT(*) AS totInternalApproved FROM programstatus WHERE ((progApprGTD IN (2) AND statusCXO1 IN (2) AND progApprGCTO IN (2) AND progApprGCEO IN (2,4))) AND deliveryStatus = 0 AND (progModuleStatus != 'Pending' AND progNomStatus != 'Pending') AND cancelStatus != 1 AND remark = '$remark' AND progType = 'Internal'";
                                                                                        $resultQueryProgInternalApproved= mysqli_query($conn,$queryProgInternalApproved) or die(mysqli_error($conn));
                                                                                        $countQueryProgInternalApproved = mysqli_fetch_array($resultQueryProgInternalApproved);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php  if($countQueryProgInternalApproved['totInternalApproved']>0){   echo    '<span class="badge badge-pill badge-success">'; echo  $countQueryProgInternalApproved['totInternalApproved']; echo  '</span>';    }else{    echo    $countQueryProgInternalApproved['totInternalApproved']; }   ?></td>

                                                                                    <?php
                                                                                        $queryProgInternalDelivered = "SELECT COUNT(*) AS totInternalDelivered FROM programstatus WHERE deliveryStatus = 1 AND cancelStatus = 0 AND remark = '$remark' AND progType = 'Internal'";
                                                                                        $resultQueryProgInternalDelivered= mysqli_query($conn,$queryProgInternalDelivered) or die(mysqli_error($conn));
                                                                                        $countQueryProgInternalDelivered = mysqli_fetch_array($resultQueryProgInternalDelivered);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php  if($countQueryProgInternalDelivered['totInternalDelivered']>0){   echo    '<span class="badge badge-pill badge-primary">'; echo  $countQueryProgInternalDelivered['totInternalDelivered']; echo  '</span>';    }else{    echo    $countQueryProgInternalDelivered['totInternalDelivered']; }   ?></td>

                                                                                    <?php
                                                                                        $queryProgInternalRejected = "SELECT COUNT(*) AS totInternalRejected FROM programstatus WHERE (progApprGTD = 3 OR statusCXO1 = 3 OR progApprGCTO = 3  OR progApprGCEO = 3 OR cancelStatus = 1) AND remark = '$remark' AND progType = 'Internal'";
                                                                                        $resultQueryProgInternalRejected= mysqli_query($conn,$queryProgInternalRejected) or die(mysqli_error($conn));
                                                                                        $countQueryProgInternalRejected = mysqli_fetch_array($resultQueryProgInternalRejected);
                                                                                        
                                                                                    ?>
                                                                                    <td style="text-align:center"><?php  if($countQueryProgInternalRejected['totInternalRejected']>0){   echo    '<span class="badge badge-pill badge-danger">'; echo  $countQueryProgInternalRejected['totInternalRejected']; echo  '</span>';    }else{    echo    $countQueryProgInternalRejected['totInternalRejected']; }   ?></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </small></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="accordion"><?php echo $remark ?></button>
                                            <div class="accordion-content">
                                                <div class="row">
                                                    <div class="col" style="height:480px; width:100%; overflow: auto; overflow-x: hidden;">
                                                        <?php

                                                            $queryTotProgCount = "SELECT * FROM programstatus WHERE remark = '$remark'";
                                                            $resultQueryTotProgCount= mysqli_query($conn,$queryTotProgCount) or die(mysqli_error($conn));

                                                            while($queryAllProgs = mysqli_fetch_array($resultQueryTotProgCount)){
                                                                $id = $queryAllProgs['idProgram'];

                                                        ?>
                                                            <div class="card card-common my-2 bg-light mb-3 bordred">
                                                                <div class="card-body">

                                                                    <div class="d-flex justify-content-between">
                                                                        <i class="fas fa-tasks text-info"></i>
                                                                        <div class="text-right text-secondary">
                                                                            <a href="viewPrograms.php?id=<?php  echo    $queryAllProgs['idProgram'];    ?>" class="card-link text-blue"><h5><small>
                                                                            <?php
                                                                                if($queryAllProgs['deliveryStatus']==1){
                                                                                    echo    '<span class="badge badge-pill badge-success">Delivered</span>';
                                                                                }
                                                                                echo    $queryAllProgs['progName'];
                                                                            ?>
                                                                            </small></h5></a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row pl-md-auto mb-1">
                                                                        <div class="col-xl-4">
                                                                            <div class="panel card panel-default rounded" style="height:152px;">
                                                                                <div class="panel-heading rounded-top" style="background-color: #DEDEDE;">
                                                                                    <div class="panel-title pl-2 pt-1 pb-1 ml-auto"><small>Overview</small></div>
                                                                                </div>
                                                                                <div class="panel-body pt-1 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Trainer/Sup. : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        echo    $queryAllProgs['trainrSupp'];
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                                <div class="panel-body pt-1 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Type : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        echo    $queryAllProgs['progType'];
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                                <div class="panel-body pt-1 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Priority : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        echo    $queryAllProgs['priority'];
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                                <div class="panel-body pt-1 pb-2 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Slots : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        echo    $queryAllProgs['slots'];
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="col-xl-4">
                                                                            <div class="panel card panel-default rounded" style="height:152px;">
                                                                                <div class="panel-heading rounded-top" style="background-color: #DEDEDE;">
                                                                                    <div class="panel-title pl-2 pt-1 pb-1 ml-auto"><small>Other Details</small></div>
                                                                                </div>
                                                                                <div class="panel-body pt-2 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Requested Division : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        echo    $queryAllProgs['division'];
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                                <div class="panel-body pt-1 mt-2 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Budget Source : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        echo    $queryAllProgs['bSource'];
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                                <div class="panel-body pt-1 mt-2 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Total Cost : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        echo    "".$queryAllProgs['currency']."  ".$queryAllProgs['totalCost']."";
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-xl-4">
                                                                            <div class="panel card panel-default rounded" style="height:152px;">
                                                                                <div class="panel-heading rounded-top" style="background-color: #DEDEDE;">
                                                                                    <div class="panel-title pl-2 pt-1 pb-1 ml-auto"><small>Other Details</small></div>
                                                                                </div>
                                                                                <div class="panel-body pt-1 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Module Status : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small>
                                                                                    <?php
                                                                                        if($queryAllProgs['progModuleStatus'] == "Received"){
                                                                                            echo    '<span class="badge badge-pill badge-success">'.$queryAllProgs['progModuleStatus'].'</span>';
                                                                                        }else if($queryAllProgs['progModuleStatus']){
                                                                                            echo    '<span class="badge badge-pill badge-warning">'.$queryAllProgs['progModuleStatus'].'</span>';
                                                                                        }
                                                                                    ?>
                                                                                    </small></span>
                                                                                </div>
                                                                                <div class="panel-body pt-1 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>No. of Modules : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        $moduleQuery = "SELECT * FROM moduleprogramstatus WHERE idProgram = '$id'";
                                                                                        $resultModuleQuery = mysqli_query($conn,$moduleQuery) or die(mysqli_error($conn));
                                                                                        $moduleCount = mysqli_num_rows($resultModuleQuery);
                                                                                        echo     $moduleCount;
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                                <div class="panel-body pt-1 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Nominee Status : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small>
                                                                                    <?php
                                                                                        if($queryAllProgs['progNomStatus'] == "Received"){
                                                                                            echo    '<span class="badge badge-pill badge-success">'.$queryAllProgs['progNomStatus'].'</span>';
                                                                                        }else if($queryAllProgs['progNomStatus']){
                                                                                            echo    '<span class="badge badge-pill badge-warning">'.$queryAllProgs['progNomStatus'].'</span>';
                                                                                        }
                                                                                    ?>
                                                                                    </small></span>
                                                                                </div>
                                                                                <div class="panel-body pt-1 pb-2 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>No. of Nominees : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        $nomineeQuery = "SELECT * FROM nomineeprogramstatus WHERE idProgram = '$id'";
                                                                                        $resultNomineeQuery = mysqli_query($conn,$nomineeQuery) or die(mysqli_error($conn));
                                                                                        $nomineeCount = mysqli_num_rows($resultNomineeQuery);
                                                                                        echo     $nomineeCount;  
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="row pl-md-auto mt-3 mb-1">
                                                                        <div class="col-xl-3">
                                                                            <div class="panel card panel-default rounded">
                                                                                <div class="panel-heading rounded-top" style="background-color: #B0E0E6;">
                                                                                    <div class="panel-title pl-2 pt-1 pb-1 ml-auto"><small>GTD Approval</small></div>
                                                                                </div>
                                                                                <div class="panel-body pt-1 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Requested Date : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        if($queryAllProgs['reqDtAprGTD']==""){
                                                                                            echo "-";
                                                                                        }else{
                                                                                            echo    $queryAllProgs['reqDtAprGTD'];
                                                                                        }
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                                <div class="panel-body pt-1 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Status : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        if($queryAllProgs['progApprGTD'] == 4){
                                                                                            echo 'N/A <i class="fas fa-ban text-secondary"></i> ';
                                                                                        }else if($queryAllProgs['progApprGTD'] == 1){
                                                                                            echo 'Pending <i class="fas fa-clock" style="color: orange;"></i> ';
                                                                                        }else if($queryAllProgs['progApprGTD'] == 2){
                                                                                            echo 'Approved <i class="fas fa-check-circle" style="color: green;"></i> ';
                                                                                        }else if($queryAllProgs['progApprGTD'] == 3){
                                                                                            echo 'Rejected <i class="fas fa-times-circle" style="color: Red;"></i> ';
                                                                                        }else if($queryAllProgs['progApprGTD'] == 0){
                                                                                            echo '<span class="text-danger">Did not send for approval</span> <i class="fas fa-sync fa-spin" style="color: red;"></i> ';
                                                                                        }
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                                <div class="panel-body pt-1 pb-2 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Delivered Date : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        if($queryAllProgs['dtApprGTD']==""){
                                                                                            echo "-";
                                                                                        }else{
                                                                                            echo    $queryAllProgs['dtApprGTD'];
                                                                                        }
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                            $queryCXODetails = "SELECT * FROM cxoapproval WHERE idProgram = '$id'";
                                                                            $resultQueryCXODetails= mysqli_query($conn,$queryCXODetails) or die(mysqli_error($conn));
                                                                            $CXOCount = 0;
                                                                            while($CXODetails = mysqli_fetch_array($resultQueryCXODetails)){
                                                                                $CXOCount++;
                                                                        ?>
                                                                        <div class="col-xl-3">
                                                                            <div class="panel card panel-default rounded">
                                                                                <div class="panel-heading rounded-top" style="background-color: #FFFACD;">
                                                                                    <div class="panel-title pl-2 pt-1 pb-1 ml-auto"><small>CXO1 Approval</small></div>
                                                                                </div>
                                                                                <div class="panel-body pt-1 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Requested Date : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        if($CXODetails['progApprCXO1']==0 | $CXODetails['progApprCXO1']==4){
                                                                                            echo "-";
                                                                                        }else{
                                                                                            if($CXODetails['reqDtApprCXO1']==""){
                                                                                                echo "-";
                                                                                            }else{
                                                                                                echo    $CXODetails['reqDtApprCXO1'];
                                                                                            }
                                                                                        }
                                                                                        
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                                <div class="panel-body pt-1 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Status : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        if($CXODetails['progApprCXO1']==0){
                                                                                            echo '<span class="text-danger">Did not send for approval</span> <i class="fas fa-sync fa-spin" style="color: red;"></i> ';
                                                                                        }else if($CXODetails['progApprCXO1'] == 4){
                                                                                            echo 'N/A <i class="fas fa-ban text-secondary"></i> ';
                                                                                        }else if($CXODetails['progApprCXO1'] == 1){
                                                                                            echo 'Pending <i class="fas fa-clock" style="color: orange;"></i> ';
                                                                                        }else if($CXODetails['progApprCXO1'] == 2){
                                                                                            echo 'Approved <i class="fas fa-check-circle" style="color: green;"></i> ';
                                                                                        }else if($CXODetails['progApprCXO1'] == 3){
                                                                                            echo 'Rejected <i class="fas fa-times-circle" style="color: Red;"></i> ';
                                                                                        }
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                                <div class="panel-body pt-1 pb-2 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Delivered Date : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        if($CXODetails['progApprCXO1']==0 | $CXODetails['progApprCXO1']==4){
                                                                                            echo "-";
                                                                                        }else{
                                                                                            if($CXODetails['dtApprCXO1']==""){
                                                                                                echo "-";
                                                                                            }else{
                                                                                                echo    $CXODetails['dtApprCXO1'];
                                                                                            }
                                                                                        }
                                                                                        
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                            }
                                                                            if($CXOCount==0){
                                                                        ?>

                                                                        <div class="col-xl-3">
                                                                            <div class="panel card panel-default rounded">
                                                                                <div class="panel-heading rounded-top" style="background-color: #FFFACD;">
                                                                                    <div class="panel-title pl-2 pt-1 pb-1 ml-auto"><small>CXO1 Approval</small></div>
                                                                                </div>
                                                                                <div class="panel-body pt-1 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Requested Date : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        echo "-";
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                                <div class="panel-body pt-1 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Status : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        echo '<span class="text-danger">Did not send for approval</span> <i class="fas fa-sync fa-spin" style="color: red;"></i> ';
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                                <div class="panel-body pt-1 pb-2 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Delivered Date : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        echo "-";
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                        <div class="col-xl-3">
                                                                            <div class="panel card panel-default rounded">
                                                                                <div class="panel-heading rounded-top" style="background-color: #F5F5DC;">
                                                                                    <div class="panel-title pl-2 pt-1 pb-1 ml-auto"><small>GCTO Approval</small></div>
                                                                                </div>
                                                                                <div class="panel-body pt-1 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Requested Date : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        if($queryAllProgs['reqDtApprGCTO']==""){
                                                                                            echo "-";
                                                                                        }else{
                                                                                            echo    $queryAllProgs['reqDtApprGCTO'];
                                                                                        }
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                                <div class="panel-body pt-1 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Status : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        if($queryAllProgs['progApprGCTO'] == 4){
                                                                                            echo 'N/A <i class="fas fa-ban text-secondary"></i> ';
                                                                                        }else if($queryAllProgs['progApprGCTO'] == 1){
                                                                                            echo 'Pending <i class="fas fa-clock" style="color: orange;"></i> ';
                                                                                        }else if($queryAllProgs['progApprGCTO'] == 2){
                                                                                            echo 'Approved <i class="fas fa-check-circle" style="color: green;"></i> ';
                                                                                        }else if($queryAllProgs['progApprGCTO'] == 3){
                                                                                            echo 'Rejected <i class="fas fa-times-circle" style="color: Red;"></i> ';
                                                                                        }else if($queryAllProgs['progApprGCTO'] == 0){
                                                                                            echo '<span class="text-danger">Did not send for approval</span> <i class="fas fa-sync fa-spin" style="color: red;"></i> ';
                                                                                        }
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                                <div class="panel-body pt-1 pb-2 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Delivered Date : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        if($queryAllProgs['dtApprGCTO']==""){
                                                                                            echo "-";
                                                                                        }else{
                                                                                            echo    $queryAllProgs['dtApprGCTO'];
                                                                                        }
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-xl-3">
                                                                            <div class="panel card panel-default rounded">
                                                                                <div class="panel-heading rounded-top" style="background-color: #9370DB;">
                                                                                    <div class="panel-title pl-2 pt-1 pb-1 ml-auto"><small>GCEO Approval</small></div>
                                                                                </div>
                                                                                <div class="panel-body pt-1 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Requested Date : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        if($queryAllProgs['reqDtApprGCEO']==""){
                                                                                            echo "-";
                                                                                        }else{
                                                                                            echo    $queryAllProgs['reqDtApprGCEO'];
                                                                                        }
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                                <div class="panel-body pt-1 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Status : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        if($queryAllProgs['progApprGCEO'] == 4){
                                                                                            echo 'N/A <i class="fas fa-ban text-secondary"></i> ';
                                                                                        }else if($queryAllProgs['progApprGCEO'] == 1){
                                                                                            echo 'Pending <i class="fas fa-clock" style="color: orange;"></i> ';
                                                                                        }else if($queryAllProgs['progApprGCEO'] == 2){
                                                                                            echo 'Approved <i class="fas fa-check-circle" style="color: green;"></i> ';
                                                                                        }else if($queryAllProgs['progApprGCEO'] == 3){
                                                                                            echo 'Rejected <i class="fas fa-times-circle" style="color: Red;"></i> ';
                                                                                        }else if($queryAllProgs['progApprGCEO'] == 0){
                                                                                            echo '<span class="text-danger">Did not send for approval</span> <i class="fas fa-sync fa-spin" style="color: red;"></i> ';
                                                                                        }
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                                <div class="panel-body pt-1 pb-2 px-3 d-flex justify-content-between align-items-center">
                                                                                    <span class="float-left"><small><small>Delivered Date : </small></small></span>
                                                                                    <span class="float-right " style=" vertical-align: middle"><small><small>
                                                                                    <?php
                                                                                        if($queryAllProgs['dtApprGCEO']==""){
                                                                                            echo "-";
                                                                                        }else{
                                                                                            echo    $queryAllProgs['dtApprGCEO'];
                                                                                        }
                                                                                    ?>
                                                                                    </small></small></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        <?php
                                                            } 
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                <?php
                                        }

                                    }else{
                                ?>
                                    <div class="col-xl-12 col-sm-12 p-2">
                                        <div class="card card-common">
                                            <div class="card-body">
                                                <h5 class="m-2 text-danger" style="text-align: center">No programs</h5>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                    }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- end of cards -->
      
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>

        <script type="text/javascript">

            var accordions = document.getElementsByClassName("accordion");

            for (var i = 0; i < accordions.length; i++) {
                accordions[i].onclick = function() {
                    this.classList.toggle('is-open');

                    var content = this.nextElementSibling;
                    if (content.style.maxHeight) {
                    // accordion is currently open, so close it
                    content.style.maxHeight = null;
                    } else {
                    // accordion is currently closed, so open it
                    content.style.maxHeight = content.scrollHeight + "px";
                    }
                }
            } 
            <?php
                $queryTrainingPrograms = "SELECT * FROM sheduleprogram WHERE status = '1' AND upStatus = '1' ORDER BY remark DESC";
                $resultQueryTrainingPrograms = mysqli_query($conn,$queryTrainingPrograms) or die(mysqli_error($conn));
                $countQueryTrainingPrograms = mysqli_num_rows($resultQueryTrainingPrograms);
                if($countQueryTrainingPrograms != 0){
                    while($trainingPrograms = mysqli_fetch_array($resultQueryTrainingPrograms)){
                        $remark = $trainingPrograms['remark'];
            ?>
            var ctxD = document.getElementById("chDonut<?php echo $trainingPrograms['id']; ?>").getContext('2d');
            var myLineChart = new Chart(ctxD, {
                type: 'doughnut',
                showInLegend: true,
                legendText: "{label} : {y}",
                indexLabel: "{symbol} - {y}",
		        yValueFormatString: "#,##0.0\"%\"",
                data: {
                    labels: ["Pendings","To be Approved", "Delivered" , "Canceled/Rejected"],
                    legendText: "{label} :",
                    datasets: [{
                        data: [
                            <?php 
                                $queryPendings = "SELECT COUNT(*) AS Pendings FROM programstatus WHERE ((progApprGTD IN (0,1) OR ((statusCXO1 IN (0,1,3) AND progApprCXO1 IN (0,1)) OR (statusCXO1 IN (0,2,3) AND progApprCXO1_2 IN (0,1))) OR progApprGCTO IN (0,1) OR progApprGCEO IN (0,1)) OR (progModuleStatus = 'Pending' OR progNomStatus = 'Pending')) AND (progApprGTD !=3 AND (progApprCXO1 != 3 AND progApprCXO1_2 != 3) AND progApprGCTO != 3 AND progApprGCEO != 3) AND cancelStatus != 1 AND deliveryStatus = 0 AND remark = '$remark'";
                                $resultQueryPendings = mysqli_query($conn,$queryPendings) or die(mysqli_error($conn));
                                $pendings = mysqli_fetch_array($resultQueryPendings);
                                echo $pendings['Pendings'];
                            ?>
                            ,
                            <?php
                                $queryOngoing = "SELECT COUNT(*) AS OngoingCount FROM programstatus WHERE ((progApprGTD IN (2) AND ((statusCXO1 IN (1,3) AND progApprCXO1 IN (2)) OR (statusCXO1 IN (2,3) AND progApprCXO1_2 IN (2))) AND progApprGCTO IN (2) AND progApprGCEO IN (2,4))) AND deliveryStatus = 0 AND (progModuleStatus != 'Pending' AND progNomStatus != 'Pending') AND cancelStatus != 1 AND remark = '$remark'";
                                $resultQueryOngoing = mysqli_query($conn,$queryOngoing) or die(mysqli_error($conn));
                                $ongoing = mysqli_fetch_array($resultQueryOngoing);
                                echo $ongoing['OngoingCount']; 
                            ?>
                            /* , 
                            <?php 
                                /* $queryAppr = "SELECT COUNT(*) AS appr FROM programstatus WHERE (progApprGTD = 2 AND (progApprCXO1 = 2 OR progApprCXO1_2 = 2) AND progApprGCTO = 2 AND (progApprGCEO = 2 OR progApprGCEO = 4)) AND deliveryStatus = 0 AND cancelStatus != 1 AND remark = '$remark'";
                                $resultQueryAppr = mysqli_query($conn,$queryAppr) or die(mysqli_error($conn));
                                $appr = mysqli_fetch_array($resultQueryAppr);
                                echo $appr['appr'];  */
                            ?> */
                            ,
                            <?php
                                $queryProgDelivered = "SELECT COUNT(*) AS totDelivered FROM programstatus WHERE deliveryStatus = 1 AND cancelStatus != 1 AND remark = '$remark'";
                                $resultQueryProgDelivered= mysqli_query($conn,$queryProgDelivered) or die(mysqli_error($conn));
                                $countQueryProgDelivered = mysqli_fetch_array($resultQueryProgDelivered);
                                echo $countQueryProgDelivered['totDelivered'];
                            ?>
                            ,
                            <?php 
                                $queryRejected = "SELECT COUNT(*) AS rejected FROM programstatus WHERE ((progApprGTD = 3 OR progApprCXO1 = 3 OR progApprGCTO = 3 OR progApprGCEO = 3) OR cancelStatus = 1) AND remark = '$remark'";
                                $resultQueryRejected = mysqli_query($conn,$queryRejected) or die(mysqli_error($conn));
                                $Rejected = mysqli_fetch_array($resultQueryRejected);
                                echo $Rejected['rejected']; 
                            ?>
                            ],
                        backgroundColor: ["#FFFF00","#FF8700", "#026AFF", "#FF0000"],
                        hoverBackgroundColor: ["#FFFF11","#DE7500", "#0055D1", "#D10000"]
                    }]
                },
                options: {
                    responsive: true,
                    cutoutPercentage: 70,
                    legend: {position:'bottom',  labels: {pointStyle:'circle', usePointStyle:true, fontSize: 10}},
                    pieceLabel: {
      render: 'label',
      arc: true,
      fontColor: '#DE7500',
      position: 'outside'
    },
                }
            }); 

            <?php

                }
            }
            
            ?>  

            /*var donutOptions = {
                cutoutPercentage: 85, 
                legend: {position:'bottom', padding:5, labels: {pointStyle:'circle', usePointStyle:true}}
                };

                // donut 1
                var chDonutData1 = {
                    labels: ['Bootstrap', 'Popper', 'Other'],
                    datasets: [
                    {
                        backgroundColor: colors.slice(0,3),
                        borderWidth: 0,
                        data: [74, 11, 40]
                    }
                    ]
                };

                var chDonut1 = document.getElementById("chDonut1").getContext('2d');
                if (chDonut1) {
                new Chart(chDonut1, {
                    type: 'pie',
                    data: chDonutData1,
                    options: donutOptions
                });
                }*/

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
