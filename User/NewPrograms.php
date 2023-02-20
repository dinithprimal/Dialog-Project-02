<?php
    
    include("database.php");

    $err = '';
    $user = '';
    $userId = '';
    $ct = '';

    //$conn = mysqli_connect("localhost","root","","training");

    date_default_timezone_set("Asia/Colombo");

    $newprog = "SELECT * FROM `sheduleprogram` where status = '0'";
    $resNewProg = mysqli_query($conn,$newprog) or die(mysqli_error($conn));
    $dt = mysqli_fetch_array($resNewProg);

    $value = $dt['enddate'];
    $datetime = new DateTime($value);    

    $now = new DateTime();

    

    session_start();
    if(isset($_SESSION['username'])){

        $user = $_SESSION['username'];

        
        $sql = "SELECT idUser FROM logdetail WHERE Username = '$user'";
        $result_sql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
        $userId = mysqli_fetch_array($result_sql);

        $queryUserDetail = "SELECT * FROM user WHERE idUser = '".$userId['idUser']."'";
        $result_query = mysqli_query($conn,$queryUserDetail) or die(mysqli_error($conn));
        $userDetails = mysqli_fetch_array($result_query);


        if($datetime<$now){
            //Access for New Program
            $accessNewProg = "SELECT * FROM useraccess WHERE idUser = '".$userId['idUser']."'";
            $resAccessNewProg = mysqli_query($conn,$accessNewProg) or die(mysqli_error($conn));
            $accessTot = mysqli_num_rows($resAccessNewProg);
    
            $accessDate = "";
    
            if($accessTot!=0){
                $access = mysqli_fetch_array($resAccessNewProg);
                $accessDate = new DateTime($access['enddate']);
                $datetime = $accessDate;
            }
    
            //End of acees for new program
        }
    
        if($datetime<$now){
            echo "<script>location.href='DashboardUser.php'</script>";
        }
        //session_destroy();

    }else{

        echo "<script>location.href='../Login.php'</script>";

    }


    function programID($conn,$programName,$userId){
        $sel = "SELECT COUNT(*) AS total FROM program";
        $res = mysqli_query($conn,$sel) or die(mysqli_error($conn));
        $tot = mysqli_fetch_array($res);
        $tot = $tot['total'] +1;
        
        return "". $userId['idUser'] ."_". substr($programName,0,4) ."_" . $tot . "";

       //echo "<script>console.log('Program ID: ". $userId ."_". substr($programName,0,4) ."_" . $tot . "' );</script>";
    }

    //programID($conn);
    $message = '';    
    $fid = '';
    $pid = '';
    $uid = '';
    $moduleName = '';
    $rowCountModule=0;
    $rowCountNominee=0;

    if(isset($_POST['addProgram'])){
       
            $programName = $_POST['programName'];
            $sup = $_POST['programTraSup'];
            $type = $_POST['programType'];
            $prio = $_POST['programPiority'];
            $slots = $_POST['programSlots'];
            $remark = $dt['remark'];
            $fee = $_POST['programFeeh'];
            $feeType = $_POST['progFeeType'];
            $currency = $_POST['progCurrencyType'];
            $otherCost = $_POST['programOtherCosth'];
            $totCost = $_POST['programTotCosth'];
            $stDt = $_POST['programStartDate'];
            $edDt = $_POST['programEndDate'];
            $comment = $_POST['programComment'];

            $fid = programID($conn,$programName,$userId);
            $query = "";
            if($stDt == "" && $edDt == ""){
                $query = "INSERT INTO program ( programdefid, ProgName, trasup, typ, prio, slot, remark, currency, feeType, fee, otherCost, totCost, comment) VALUES ('$fid','$programName','$sup','$type','$prio','$slots','$remark','$currency','$feeType','$fee','$otherCost','$totCost','$comment')";
            }else{

                $stDt = new DateTime($stDt);
                $edDt = new DateTime($edDt);

                $stDt = $stDt->format("Y-m-d");
                $edDt = $edDt->format("Y-m-d");

                $query = "INSERT INTO program ( programdefid, ProgName, trasup, typ, prio, slot, remark, currency, feeType, fee, otherCost, totCost, stDate, edDate, comment) VALUES ('$fid','$programName','$sup','$type','$prio','$slots','$remark','$currency','$feeType','$fee','$otherCost','$totCost','$stDt','$edDt','$comment')";
            }

            if ($conn->query($query) === TRUE) {
           //     echo "New record created successfully";

                $selid = "SELECT idProgram FROM program WHERE programdefid = '$fid'";
                $resul = mysqli_query($conn,$selid) or die(mysqli_error($conn));
                $pid = mysqli_fetch_array($resul);
                $pid = $pid['idProgram'];

                $uid = $userId['idUser'];
                $dt = $now->format("Y-m-d");

                $prouser = "INSERT INTO program_has_user (idProgram, idUser, Dt) VALUES ('$pid','$uid','$dt')";
                
                if ($conn->query($prouser) === TRUE) {

                    

                    for($countModule = 0; $countModule<count($_POST['hidden_programModule']); $countModule++){

                        $moduleName = $_POST['hidden_programModule'][$countModule];

                        $queryModule = "INSERT INTO module (moduleName) VALUES ('$moduleName')";                        

                        if($conn->query($queryModule)=== TRUE){                            

                            $getMId = "SELECT MAX(idModule) AS maximum FROM module WHERE moduleName = '$moduleName'";
                            $resMId = mysqli_query($conn,$getMId) or die(mysqli_error($conn));
                            $mId = mysqli_fetch_array($resMId);
                            $mId = $mId['maximum'];

                            $queryProgModule = "INSERT INTO user_program_module (idUser, idProgram, idModule) VALUES ('$uid','$pid','$mId')";
                            
                            if($conn->query($queryProgModule) === TRUE){
                                
                                continue;
                            }
                            
                        }

                    }


                    for($countNominee = 0; $countNominee<count($_POST['hidden_programNominee']); $countNominee++){

                        $NomineeName = $_POST['hidden_programNominee'][$countNominee];
                        $empID = $_POST['hidden_programEmpID'][$countNominee];

                        $queryNominee = "INSERT INTO nominee (idProgram,idUser,Name,empID) VALUES ('$pid','$uid','$NomineeName','$empID')";                        

                        if($conn->query($queryNominee)=== TRUE){

                            continue;
                            
                        }

                    }

                    unset($_POST['addProgram']);
                    echo '<script type="text/javascript">alert("Successfully Added!");</script>';
                    echo "<script>location.href='NewPrograms.php'</script>";
                }else{

                }



            } else {
           //     echo "Error: " . $query . "<br>" . $conn->error;
            }
           //   $conn->close();
    }

   

    if(isset($_POST['Logout'])){

        session_destroy();
        unset($_SESSION["username"]);
        header("location: ../Login.php");

    }

    if(isset($_POST['NewProg'])){

        session_start();
        $_SESSION["username"] = $user;
        header("location: NewPrograms.php");

    }

    

?>
<!--
<style>
    .divhead {
        height: 30px;
        padding: 0;
        margin: 0;
        background-color: gray;
    }

    .divbody {
        height: 100px;
        overflow: auto;
        overflow-x: hidden;
    }

    .tablebody {
        height: 100%;
    }
</style>
-->
<!--
<style>
    .box{
        width: 800px;
        margin: 0 auto;
    }

    .active_tab1 {
        background-color: #fff;
        color: #333;
        font-weight: 600;
    }

    .inactive_tab1 {
        background-color: #f5f5f5;
        color: #333;
        cursor: not-allowed;
    }

    .panel-heading {
        color:#333;
        background-color:#f5f5f5;
        border-color:#ddd;
    }

    .panel-body{
        border-top-color:#ddd
    }

    .has-error{
        border-color: #cc0000;
        background-color: #ffff99;
    }
</style>
-->
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

        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <title>User Dashboard</title>
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
                        <div class="col-xl-2 col-lg-3 col-md-4 sidebar fixed-top">
                            <a href="DashboardUser.php" class="navbar-brand
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
                                
                                <li class="nav-item"><a href="trainingUserDashboard.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-tachometer-alt text-light 
                                fa-lg fa-fw mr-3"></i>Dashboard</a></li>
                            
                                <li class="nav-item"><a href="DashboardUser.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-home text-light 
                                fa-lg fa-fw mr-3"></i>Home</a></li>

                                <li class="nav-item"><a href="myPrograms.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-tasks text-light 
                                fa-lg fa-fw mr-3"></i>My Programs</a></li>

                                <li class="nav-item"><a href="userCalender.php"
                                class="nav-link text-white p-3 mb-2 
                                sidebar-link"><i 
                                class="fas fa-calendar text-light 
                                fa-lg fa-fw mr-3"></i>Calendar</a></li>
                                
                            </ul>
                        </div>
                        <!--end of sidebar-->

                        <!--TopNav-->
                        <div class="col-xl-10 col-lg-9 col-md-8 ml-auto bg-dark fixed-top py-2 top-navbar">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h4 class="text-light 
                                    text-uppercase mb-0">Add Programs</h4>
                                </div>
                                <div class="col-md-5">
                                    
                                </div>
                                <div class="col-md-3">
                                    <ul class="navbar-nav">                            

                                        <li class="nav-item ml-md-auto dropdown">
                                            <a href="#" class="nav-link dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown"><i class="fas fa-bell text-muted fa-lg"></i>
                                                <span class="badge badge-danger" id="countModule"></span>
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
                                                <a class="dropdown-item" href="DashboardUser.php"><i class="fas fa-home text-dark 
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
                        <form action="NewPrograms.php" method="POST">                            
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
                    <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                        <div class="col-xl-12 col-sm-12 p-2">
                            <div class="row pt-md-5 mt-md-3 px-md-5 mx-md-3 mb-1 program-data">
                                <div class="container box">
                                    <br/>
                                    <h2 align="center">Program Registration</h2>
                                    
                                    <form class="form" method="post" id="new_program">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active active_tab1 mr-1" style="border:1px solid #ccc" id="list_program_details">Program Details</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link inactive_tab1 mr-1" style="border:1px solid #ccc" id="list_program_modules">Program Modules</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link inactive_tab1 mr-1" style="border:1px solid #ccc" id="list_program_Nominees">Program Nominees</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link inactive_tab1" style="border:1px solid #ccc" id="list_program_review">Program Review</a>
                                            </li>                                    
                                        </ul>
                                        <div class="tab-content" style="margin-top: 16px;">
                                            <div class="tab-pane active" id="program_details">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading p-2">Program Details</div>
                                                    <div class="panel-body p-3">
                                                        <div class="form-group">
                                                            <label>Program Name *</label>
                                                            <input type="text" name="programName" id="programName" class="form-control" />
                                                            <span id="error_programName" class="text-danger"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Program Trainer/Supplier *</label>
                                                            <input type="text" name="programTraSup" onfocusout="costDissable()" list="traSup" id="programTraSup" class="form-control" />
                                                            <datalist id="traSup">
                                                                <option>Huawei</option>
                                                            </datalist>
                                                            <span id="error_programTraSup" class="text-danger"></span>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl col-lg">                                                               
                                                                <div class="form-group">
                                                                    <label>Program Type *</label>
                                                                    <select class="form-control" name="programType" id="programType">
                                                                        <option>Select Type</option>
                                                                        <option>Local</option>
                                                                        <option>Foriegn</option>
                                                                        <option>Online</option>
                                                                        <option>Internal</option>
                                                                    </select>
                                                                    <span id="error_programType" class="text-danger"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl col-lg">
                                                                <div class="form-group">
                                                                    <label>Program Priority *</label>
                                                                    <select class="form-control" name="programPiority" id="programPiority">
                                                                        <option>Select Piority</option>
                                                                        <option>01</option>
                                                                        <option>02</option>
                                                                        <option>03</option>
                                                                        <option>04</option>
                                                                        <option>05</option>
                                                                        <option>06</option>
                                                                        <option>07</option>
                                                                        <option>08</option>
                                                                        <option>09</option>
                                                                        <option>10</option>
                                                                    </select>
                                                                    <span id="error_programPiority" class="text-danger"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl col-lg">
                                                                <div class="form-group">
                                                                    <label>Program Slots</label>
                                                                    <input type="number" min="0" name="programSlots" id="programSlots" class="form-control" />
                                                                    <span id="error_programSlots" class="text-danger"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>Select Currency *</label><br>
                                                                            <input type="checkbox" class="ml-4" name="programCurrencyLKR" onclick="setLKR(this);"  id="programCurrencyLKR" value="LKR" /> LKR
                                                                            <input type="checkbox" class="ml-4" name="programCurrencyUSD" onclick="setUSD(this);"  id="programCurrencyUSD" value="USD" /> USD
                                                                            <span id="error_programCurrency" class="text-danger"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">        
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>Course Fee *</label>
                                                                            <input type="number" min="0" step="any" style="text-align: right" name="programFee" onclick="setTotal();" onkeyup="setTotal();" onfocusout="setVal(this)" id="programFee" value="0" class="form-control" />
                                                                            <input type="hidden" name="programFeeh" id="programFeeh" value="0" class="form-control" />
                                                                            <input type="checkbox" name="programFeeFree" onclick=" free(this);" id="programFeeFree" value="Free" /> Free
                                                                            <br><span id="error_programFee" class="text-danger"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>Other Cost *</label>
                                                                            <input type="number" min="0" step="any" style="text-align: right" name="programOtherCost" onclick="setTotal();" onkeyup="setTotal();" onfocusout="setVal(this)" id="programOtherCost" value="0" class="form-control" />
                                                                            <input type="hidden" name="programOtherCosth" id="programOtherCosth" class="form-control" />
                                                                            <span id="error_programOtherCost" class="text-danger"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>Total Cost</label>
                                                                            <input type="number" min="0" style="text-align: right" name="programTotCost" id="programTotCost" value="0" class="form-control" disabled/>
                                                                            <input type="hidden" name="programTotCosth" id="programTotCosth" value="0" class="form-control" />
                                                                        </div>
                                                                    </div>
                                                                </div>    
                                                            </div>    
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-5">
                                                                <div class="form-group">
                                                                    <label>Program Start Date</label>
                                                                    <input type="date" style="text-align: right" name="programStartDate" id="programStartDate" class="form-control"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-2">
                                                            </div>
                                                            <div class="col-5">
                                                                <div class="form-group">
                                                                    <label>Program End Date</label>
                                                                    <input type="date" style="text-align: right" name="programEndDate" id="programEndDate" class="form-control"/>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <span id="error_programDate" class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Any Comment ?</label>
                                                                    <textarea name="programComment" id="programComment" class="form-control"></textarea>
                                                                    <span id="error_programComment" class="text-danger"></span>
                                                                </div>
                                                            </div>
                                                        </div>                                                        
                                                        <label><small>* Reqired fields</small></label>
                                                        <br/>
                                                        <div align="center">
                                                            <button type="button" name="btn_program_details" id="btn_program_details" class="btn btn-info btn-lg">Next</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="program_modules">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading p-2">Program Modules</div>
                                                    <div class="panel-body p-3">
                                                        <div class="form-group">
                                                            <div class="mb-2">
                                                                <label>Module Name</label>
                                                                <input type="text" name="programModule" id="programModule" class="form-control" />
                                                                <span id="error_programModule" class="text-danger"></span>
                                                            </div>
                                                            <div align="right" style="margin-bottom:5px;">
                                                                <button type="button" name="addModule" id="addModule" class="btn btn-success btn-sm">Add</button>
                                                            </div>                                                            
                                                            <div class="table-responsive mt-2">
                                                                <table class="table table-striped table-bordered" id="modules">
                                                                    <tr>
                                                                        <th>Module Name</th>                                                                        
                                                                        <th>Remove</th>
                                                                    </tr>
                                                                </table>
                                                            </div>                                                            
                                                        </div>
                                                        <br/>
                                                        <div align="center">
                                                            <button type="button" name="previous_btn_program_details" id="previous_btn_program_details" class="btn btn-default btn-lg">Previous</button>
                                                            <button type="button" name="btn_program_modules" id="btn_program_modules" class="btn btn-info btn-lg">Next</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="program_nominees">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading p-2">Program Nominees</div>
                                                    <div class="panel-body p-3">
                                                        <div class="form-group">
                                                            <div class="row mb-2">
                                                                <div class="col-8">
                                                                    <label>Name of the Nominee</label>
                                                                    <input type="text" name="programNominee" id="programNominee" class="form-control" />
                                                                </div>
                                                                <div class="col-4">
                                                                    <label>Employee ID</label>
                                                                    <input type="text" name="programEmpID" id="programEmpID" class="form-control" />
                                                                </div>
                                                                <span id="error_programNominee" class="text-danger"></span>
                                                            </div>
                                                            <div align="right" style="margin-bottom:5px;">
                                                                <button type="button" name="addNominee" id="addNominee" class="btn btn-success btn-sm">Add</button>
                                                            </div>
                                                            <div class="table-responsive mt-2">
                                                                <table class="table table-striped table-bordered" id="nominees">
                                                                    <tr>
                                                                        <th>Nominee Name</th>   
                                                                        <th>Employee ID</th>                                                                     
                                                                        <th>Remove</th>
                                                                    </tr>
                                                                </table>
                                                            </div> 
                                                        </div>                                                        
                                                        <br/>
                                                        <div align="center">
                                                            <button type="button" name="previous_btn_program_modules" id="previous_btn_program_modules" class="btn btn-default btn-lg">Previous</button>
                                                            <button type="button" name="btn_program_nominees" id="btn_program_nominees" class="btn btn-info btn-lg">Review</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="program_review">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading p-2">Program Review</div>
                                                    <div class="panel-body p-3">
                                                        <div class="form-group">
                                                            <div class="row px-4">
                                                                <div class="col-3">
                                                                    <label>Program Name</label>
                                                                </div>
                                                                <div class="col-9">
                                                                    <span id="progName" class="text-default ml-4"></span>
                                                                </div>
                                                            </div>
                                                            <div class="row px-4">
                                                                <div class="col-3">
                                                                    <label>Trainer / Supplier</label>
                                                                </div>
                                                                <div class="col-9">
                                                                    <span id="progTrasup" class="text-default ml-4"></span>
                                                                </div>
                                                            </div>
                                                            <div class="row px-4">
                                                                <div class="col-3">
                                                                    <label>Type</label>
                                                                </div>
                                                                <div class="col-9">
                                                                    <span id="progType" class="text-default ml-4"></span>
                                                                </div>
                                                            </div>
                                                            <div class="row px-4">
                                                                <div class="col-3">
                                                                    <label>Piority</label>
                                                                </div>
                                                                <div class="col-9">
                                                                    <span id="progPio" class="text-default ml-4"></span>
                                                                </div>
                                                            </div>
                                                            <div class="row px-4">
                                                                <div class="col-3">
                                                                    <label>Slots</label>
                                                                </div>
                                                                <div class="col-9">
                                                                    <span id="progSlot" class="text-default ml-4"></span>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row px-4">
                                                                <div class="col-6">
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <label>Course Fee</label>
                                                                            <input type="hidden" name="progFeeType" id="progFeeType" class="form-control"/>
                                                                            <input type="hidden" name="progCurrencyType" id="progCurrencyType" class="form-control"/>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <span id="progFee" class="text-default ml-4"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <label>Other Cost</label>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <span id="progOthrCost" class="text-default ml-4"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <label>Total Cost</label>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <span id="progTotCost" class="text-default ml-4"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <label>Payment Type</label>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <span id="progPaymentType" class="text-default ml-4"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row px-4">
                                                                <div class="col-2">
                                                                    <label>Start Date</label>
                                                                </div>
                                                                <div class="col-4">
                                                                    <span id="progStartDt" class="text-default ml-4"></span>
                                                                </div>
                                                                <div class="col-2">
                                                                    <label>End Date</label>
                                                                </div>
                                                                <div class="col-4">
                                                                    <span id="progEndDt" class="text-default ml-4"></span>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row px-4">
                                                                <div class="col-2">
                                                                    <label>Comments</label>
                                                                </div>
                                                                <div class="col-4">
                                                                    <span id="progComment" class="text-default ml-4"></span>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row px-4">
                                                                <div class="col-3">
                                                                    <label>Modules</label>
                                                                </div>
                                                                <div class="col-9">
                                                                    <div class="divhead" style="height: 30px; padding: 0; margin: 0; background-color: gray;">
                                                                        <table class="display tablehead" style="width:100%">
                                                                            <thead align="center">
                                                                                <tr>
                                                                                    <th>Module Name</th>                                                                                
                                                                                </tr>
                                                                            </thead>
                                                                        </table>
                                                                    </div>
                                                                    <div class="divbody" style="height: 150px; overflow: auto; overflow-x: hidden;">
                                                                        <table class ="ModuleTable" id="ModuleTable" style="height: 100%;">
                                                                            
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br/>
                                                            <br/>
                                                            <div class="row px-4">
                                                                <div class="col-3">
                                                                    <label>Nominees</label>
                                                                </div>
                                                                <div class="col-9">
                                                                    <!--<div class="divhead" style="height: 30px; padding: 0; margin: 0; background-color: gray;">
                                                                        <table class="display" style="width:100%">
                                                                            <thead align="center">
                                                                                <tr>
                                                                                    <th>Nominee Name</th> 
                                                                                    <th>Employee ID</th>                                                                                
                                                                                </tr>
                                                                            </thead>
                                                                        </table>
                                                                    </div>-->
                                                                    <div class="divbody" style="height: 150px; overflow: auto; overflow-x: hidden;">
                                                                        <table class="display" style="width:100%" id="NomineeTable" style="height: 100%;">

                                                                            <tr style="height: 30px; padding: 0; margin: 0; background-color: gray;">
                                                                                <th>Nominee Name</th> 
                                                                                <th>Employee ID</th>                                                                                
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                                                        
                                                        <hr>
                                                        <div align="center">
                                                            <button type="button" name="previous_btn_program_nominees" id="previous_btn_program_nominees" class="btn btn-default btn-lg">Previous</button>
                                                            <form action="DashboardUser.php" method="POST">                            
                                                                <button type="submit" name="addProgram" class="btn btn-success">Submit</button>
                                                            </form>
                                                            <!--<button type="button" name="btn_program_submit" id="btn_program_submit" class="btn btn-success btn-lg">Submit</button>-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- end of cards -->

        <!-- model add dialog -->

        <div id="actionAllert" title="Action">

        </div>

        <!-- end of model add dialog -->
      
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
        
        

        <script type="text/javascript">

            function setUSD(check){
                if(check.checked == true){
                    document.getElementById('programCurrencyLKR').checked = false;
                }
            }

            function setLKR(check){
                if(check.checked == true){
                    document.getElementById('programCurrencyUSD').checked = false;
                }
            }

            function setVal(outFocus){
                if(outFocus.value == ""){
                    outFocus.value = 0;
                    document.getElementById("programOtherCosth").value = document.getElementById("programOtherCost").value;
                    document.getElementById("programFeeh").value = document.getElementById("programFee").value;
                }
                setTotal();
            }

            function setTotal(){
                val1 = document.getElementById("programFee").value;
                val2 = document.getElementById("programOtherCost").value;
                document.getElementById("programTotCost").value = parseFloat(val1)+parseFloat(val2);
                document.getElementById("programTotCosth").value = parseFloat(val1)+parseFloat(val2);

            }

            function free(checking){
                if(checking.checked){
                    $('#programFee').prop("disabled", true);
                    document.getElementById("programFee").value = 0;
                    setTotal();
                }else{
                    $('#programFee').prop("disabled", false);
                    document.getElementById("programFee").value = 0;
                    setTotal();
                }
            }

            var progFeeType = "";

            function costDissable(){
                var val = document.getElementById("programTraSup").value;
                if(val=="Huawei"||val=="huawei"){
                    
                    document.getElementById("programTraSup").value = "Huawei";
                    document.getElementById('programFeeFree').checked = false
                    $('#programFee').prop("disabled", true);
                    document.getElementById("programFee").value = 0;
                    $('#programOtherCost').prop("disabled", true);
                    document.getElementById("programOtherCost").value = 0;
                    $('#programFeeFree').prop("disabled", true);
                    $('#programCurrencyUSD').prop("disabled", true);
                    $('#programCurrencyLKR').prop("disabled", true);
                    setTotal();
                }else{
                    
                    if(document.getElementById('programFeeFree').checked == false){
                        $('#programFee').prop("disabled", false);
                        document.getElementById("programFee").value = 0;
                        $('#programOtherCost').prop("disabled", false);
                        document.getElementById("programOtherCost").value = 0;
                        $('#programFeeFree').prop("disabled", false);

                    }
                    $('#programCurrencyUSD').prop("disabled", false);
                    $('#programCurrencyLKR').prop("disabled", false);
                    setTotal();
                }
            }
            

            function loadDoc() {
                setInterval(function(){

                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("countModule").innerHTML = this.responseText;
                        }
                    };
                    xhttp.open("GET", "../wl.php", true);
                    xhttp.send();

                },5000);
                
            }
            
            loadDoc();
            
            $(document).ready(function(){

                /* Notification */
 
                function load_unseen_notification(view = ''){
                    $.ajax({
                        url:"../notification.php",
                        method:"POST",
                        data:{view:view},
                        dataType:"json",
                        success:function(data){
                            $('.dropdown-menu-notify').html(data.notification);
                            //if(data.unseen_notification > 0)
                            //{
                            //$('.countModule').html(data.unseen_notification);
                            //}
                        }
                    });
                }
                
                load_unseen_notification();
                
                
                
                $(document).on('click', '.dropdown-toggle', function(){
                    //$('.countModule').html('');
                    load_unseen_notification('yes');
                });
                
                setInterval(function(){ 
                    load_unseen_notification();; 
                }, 5000);

                /* end of Notification */

                /* Add program */
                
                $('#btn_program_details').click(function(){
                    var error_programName = '';
                    var error_programTraSup = '';
                    var error_programType = '';
                    var error_programPiority = '';
                    var error_programCurrency = '';
                    var error_programFee = '';
                    var error_programOtherCost = '';
                    var error_programDate = '';

                    if($.trim($('#programName').val()).length == 0){

                        error_programName = 'Program Name is Required';
                        $('#error_programName').text(error_programName);
                        $('#programName').addClass('has-error');

                    }else{
                        error_programName = '';
                        $('#error_programName').text(error_programName);
                        $('#programName').removeClass('has-error');
                    }

                    if($.trim($('#programTraSup').val()).length == 0){

                        error_programTraSup = 'Program Trainer/Supplier is Required';
                        $('#error_programTraSup').text(error_programTraSup);
                        $('#programTraSup').addClass('has-error');

                    }else{

                        error_programTraSup = '';
                        $('#error_programTraSup').text(error_programTraSup);
                        $('#programTraSup').removeClass('has-error');

                    }

                    if($.trim($('#programType').val()) == 'Select Type'){

                        error_programType = 'Program Type is Required';
                        $('#error_programType').text(error_programType);
                        $('#programType').addClass('has-error');

                    }else{

                        error_programType = '';
                        $('#error_programType').text(error_programType);
                        $('#programType').removeClass('has-error');

                    }

                    if($.trim($('#programPiority').val()) == 'Select Piority'){

                        error_programPiority = 'Program Piority is Required';
                        $('#error_programPiority').text(error_programPiority);
                        $('#programPiority').addClass('has-error');

                    }else{

                        error_programPiority = '';
                        $('#error_programPiority').text(error_programPiority);
                        $('#programPiority').removeClass('has-error');

                    }

                    if((document.getElementById('programCurrencyLKR').checked == false & document.getElementById('programCurrencyUSD').checked == false) & document.getElementById("programTraSup").value != "Huawei"){
                        error_programCurrency = 'Currency is Required';
                        $('#error_programCurrency').text(error_programCurrency);
                    }else{
                        error_programCurrency = '';
                        $('#error_programCurrency').text(error_programCurrency);
                    }

                    if(document.getElementById("programFee").value == "0" ){
                        var field = document.getElementById('programFee');
                        if(!field.disabled){
                            error_programFee = 'Program Fee is Required';
                            $('#error_programFee').text(error_programFee);
                            $('#programFee').addClass('has-error');
                        }else{
                            error_programFee = '';
                            $('#error_programFee').text(error_programFee);
                            $('#programFee').removeClass('has-error');
                        }
                    }else{
                        error_programFee = '';
                        $('#error_programFee').text(error_programFee);
                        $('#programFee').removeClass('has-error');
                    }

                    if(document.getElementById("programOtherCost").value == "0" & document.getElementById("programTraSup").value != "Huawei"){
                        if($.trim($('#programType').val()) != 'Foriegn'){
                            error_programOtherCost = '';
                            $('#error_programOtherCost').text(error_programOtherCost);
                            $('#programOtherCost').removeClass('has-error');
                        }else{
                            error_programOtherCost = 'Program Other Cost is Required';
                            $('#error_programOtherCost').text(error_programOtherCost);
                            $('#programOtherCost').addClass('has-error');
                        }
                    }else{
                        error_programOtherCost = '';
                        $('#error_programOtherCost').text(error_programOtherCost);
                        $('#programOtherCost').removeClass('has-error');
                    }

                    if(($.trim($('#programStartDate').val()) == "" && !($.trim($('#programEndDate').val()) == "")) || (!($.trim($('#programStartDate').val()) == "") && ($.trim($('#programEndDate').val()) == ""))){
                        error_programDate = 'Both Start and End Dates are Required.. (Hint: You can provide both fields later..)';
                        $('#error_programDate').text(error_programDate);
                    }else{
                        error_programDate = '';
                        $('#error_programDate').text(error_programDate);
                    }

                    if(error_programName != '' || error_programTraSup != '' || error_programType != '' || error_programPiority != '' || error_programCurrency != '' || error_programFee != '' || error_programOtherCost != '' || error_programDate != ''){

                        return false;

                    }else{

                        $('#list_program_details').removeClass('active active_tab1');
                        $('#list_program_details').removeAttr('href data-toggle');
                        $('#program_details').removeClass('active');
                        $('#list_program_details').addClass('inactive_tab1');

                        $('#list_program_modules').removeClass('inactive_tab1');
                        $('#list_program_modules').addClass('active_tab1 active');
                        $('#list_program_modules').attr('href','#program_modules');
                        $('#list_program_modules').attr('data-toggle','tab');
                        $('#program_modules').removeClass('fade');
                        $('#program_modules').addClass('active in');



                    }

                });

                $('#previous_btn_program_details').click(function(){

                    $('#list_program_modules').removeClass('active_tab1 active');
                    $('#list_program_modules').removeAttr('href data-toggle');
                    $('#program_modules').removeClass('active in');
                    $('#list_program_modules').addClass('inactive_tab1');

                    $('#list_program_details').removeClass('inactive_tab1');
                    $('#list_program_details').addClass('active_tab1 active');
                    $('#list_program_details').attr('href','#program_details');
                    $('#list_program_details').attr('data-toggle','tab');
                    $('#program_details').addClass('active in');

                });

                var rowCountModule = 0;
                var moduleCount = 0;
                var programModule = '';
                var rowCountNominee = 0;
                var nomineeCount = 0;
                var programNominee = '';
                var programEmpID = '';

                $('#addModule').click(function(){
                    var error_programModule = '';

                    if($('#programModule').val() == ''){
                        error_programModule = 'Please insert the module name here';
                        $('#error_programModule').text(error_programModule);
                        $('#programModule').addClass('has-error');
                    }else{
                        error_programModule = '';
                        $('#error_programModule').text(error_programModule);
                        $('#programModule').removeClass('has-error');
                        programModule = $('#programModule').val();
                    }

                    if(error_programModule != ''){
                        return false;
                    }else{
                        rowCountModule = rowCountModule + 1;
                        moduleCount = moduleCount + 1;
                        

                        output = '<tr id="row_'+rowCountModule+'">';
                        output += '<td>'+programModule+'<input type="hidden" name="hidden_programModule[]" id="programModule'+rowCountModule+'" value="'+programModule+'"/></td>';
                        output += '<td><button type="button" name="removeModule" class="btn btn-group btn-danger removeModule" style="padding: .25rem .4rem; font-size: .875rem; line-height: .95; border-radius: .2rem;" id="'+rowCountModule+'">Remove</button></td>';
                        output += '</tr>';
                        $('#modules').append(output);

                        out = '<tr id="row_'+rowCountModule+'">';
                        out += '<td>'+programModule+'<input type="hidden" name="hidden_programModul[]" id="programModul'+rowCountModule+'"/></td>';
                        out += '</tr>';
                        $('#ModuleTable').append(out);  

                        document.getElementById('programModule').value="";
                    }

                });

                $(document).on('click', '.removeModule', function(){
                    var row_id_module = $(this).attr("id");
                    if(confirm("Are you sure you want to remove this module?")){
                        $('#row_'+row_id_module+'').remove();
                        document.getElementById("ModuleTable").rows.namedItem('row_'+row_id_module+'').remove();
                        //$('#ModuleTable').remove('#row_'+row_id_module+'');  
                        //rowCountModule = rowCountModule - 1;  
                        moduleCount = moduleCount - 1;                   
                    }else{
                        return false;
                    }
                });

                $('#btn_program_modules').click(function(){

                    if(moduleCount != 0){
                        
                            $('#list_program_modules').removeClass('active_tab1 active');
                            $('#list_program_modules').removeAttr('href data-toggle');
                            $('#program_modules').removeClass('active in');
                            $('#list_program_modules').addClass('inactive_tab1');

                            $('#list_program_Nominees').removeClass('inactive_tab1');
                            $('#list_program_Nominees').addClass('active_tab1 active');
                            $('#list_program_Nominees').attr('href','#program_nominees');
                            $('#list_program_Nominees').attr('data-toggle','tab');
                            $('#program_nominees').removeClass('fade');
                            $('#program_nominees').addClass('active in');
                        
                    }else{
                        alert("You must provide the module details !");
                    }
                });

                $('#previous_btn_program_modules').click(function(){

                    $('#list_program_Nominees').removeClass('active_tab1 active');
                    $('#list_program_Nominees').removeAttr('href data-toggle');
                    $('#program_nominees').removeClass('active in');
                    $('#list_program_Nominees').addClass('inactive_tab1');

                    $('#list_program_modules').removeClass('inactive_tab1');
                    $('#list_program_modules').addClass('active_tab1 active');
                    $('#list_program_modules').attr('href','#program_modules');
                    $('#list_program_modules').attr('data-toggle','tab');
                    $('#program_modules').addClass('active in');

                });

                $('#addNominee').click(function(){
                    var error_programNominee = '';

                    if($('#programNominee').val() == ''){
                        error_programNominee = 'Please insert the nominee\'s name and employee ID here';
                        $('#error_programNominee').text(error_programNominee);
                        $('#programNominee').addClass('has-error');
                    }else{
                        error_programNominee = '';
                        $('#error_programNominee').text(error_programNominee);
                        $('#programNominee').removeClass('has-error');
                        programNominee = $('#programNominee').val();
                    }
                    
                    if($('#programEmpID').val() == ''){
                        error_programNominee = 'Please insert the nominee\'s name and employee ID here';
                        $('#error_programNominee').text(error_programNominee);
                        $('#programEmpID').addClass('has-error');
                    }else{
                        error_programNominee = '';
                        $('#error_programNominee').text(error_programNominee);
                        $('#programEmpID').removeClass('has-error');
                        programEmpID = $('#programEmpID').val();
                    }

                    if(error_programNominee != ''){
                        return false;
                    }else{
                        rowCountNominee = rowCountNominee + 1;

                        nomineeCount = nomineeCount + 1;

                        output = '<tr id="row_'+rowCountNominee+'">';
                        output += '<td>'+programNominee+'<input type="hidden" name="hidden_programNominee[]" id="programNominee'+rowCountNominee+'" value="'+programNominee+'"/></td>';
                        output += '<td>'+programEmpID+'<input type="hidden" name="hidden_programEmpID[]" id="programEmpID'+rowCountNominee+'" value="'+programEmpID+'"/></td>';
                        output += '<td><button type="button" name="removeNominee" class="btn btn-group btn-danger removeNominee" style="padding: .25rem .4rem; font-size: .875rem; line-height: .95; border-radius: .2rem;" id="'+rowCountNominee+'">Remove</button></td>';
                        output += '</tr>';
                        $('#nominees').append(output);

                        out = '<tr id="row_'+rowCountNominee+'">';
                        out += '<td>'+programNominee+'<input type="hidden" name="hidden_programNomine[]" id="programNomine'+rowCountNominee+'"/></td>';
                        out += '<td>'+programEmpID+'<input type="hidden" name="hidden_programEmpID[]" id="programEmpID'+rowCountNominee+'"/></td>';
                        out += '</tr>';
                        $('#NomineeTable').append(out);

                        document.getElementById('programNominee').value="";
                        document.getElementById('programEmpID').value="";


                    }

                });

                $(document).on('click', '.removeNominee', function(){
                    var row_id_nominee = $(this).attr("id");
                    if(confirm("Are you sure you want to remove this nominee?")){
                        $('#row_'+row_id_nominee+'').remove();
                        document.getElementById("NomineeTable").rows.namedItem('row_'+row_id_module+'').remove(); 
                        //rowCountNominee = rowCountNominee - 1; 
                        nomineeCount = nomineeCount - 1;                     
                    }else{
                        return false;
                    }
                });

                $('#btn_program_nominees').click(function(){

                    if(nomineeCount == 0 && $('#programType').val() == 'Foriegn'){

                        alert("You are select program type as Forieng.. Therefore you must provide the nominee details !");

                    }else{

                        if(rowCountNominee == 0){
                            if(confirm("You did not provide the nominees. Are you sure want to go next? if yes click 'OK' else click 'Cancel'")){
                                $('#list_program_Nominees').removeClass('active_tab1 active');
                                $('#list_program_Nominees').removeAttr('href data-toggle');
                                $('#program_nominees').removeClass('active in');
                                $('#list_program_Nominees').addClass('inactive_tab1');

                                $('#list_program_review').removeClass('inactive_tab1');
                                $('#list_program_review').addClass('active_tab1 active');
                                $('#list_program_review').attr('href','#program_nominees');
                                $('#list_program_review').attr('data-toggle','tab');
                                $('#program_review').removeClass('fade');
                                $('#program_review').addClass('active in');

                                $('#progName').text($('#programName').val());
                                $('#progTrasup').text($('#programTraSup').val());
                                $('#progType').text($('#programType').val());
                                $('#progPio').text($('#programPiority').val());
                                if($('#programSlots').val()!=""){
                                    $('#progSlot').text($('#programSlots').val());
                                }else{
                                    $('#progSlot').text('-');
                                }
                                var currency = "";
                                if(document.getElementById('programCurrencyLKR').checked == true){
                                    currency = "LKR";
                                    document.getElementById("progCurrencyType").value = "LKR";
                                }else if(document.getElementById('programCurrencyUSD').checked == true){
                                    currency = "USD";
                                    document.getElementById("progCurrencyType").value = "USD";
                                }

                                if(document.getElementById("programTraSup").value == "Huawei"){
                                    $('#progFee').text($('#programFee').val());
                                    progFeeType = "Voucher";
                                }else if(document.getElementById('programFeeFree').checked == true){
                                    $('#progFee').text($(currency+' '+'#programFee').val());
                                    progFeeType = "Free";
                                }else{
                                    $('#progFee').text(currency+' '+$('#programFee').val());
                                    progFeeType = "Default";
                                }
                                
                                $('#progPaymentType').text(progFeeType);

                                $('#progOthrCost').text(currency+' '+$('#programOtherCost').val());
                                $('#progTotCost').text(currency+' '+$('#programTotCost').val());

                                document.getElementById("progFeeType").value = progFeeType;

                                document.getElementById("programOtherCosth").value = document.getElementById("programOtherCost").value;
                                document.getElementById("programFeeh").value = document.getElementById("programFee").value;

                                if($('#programStartDate').val() != "" && $('#programEndDate').val() != ""){
                                    $('#progStartDt').text($('#programStartDate').val());
                                    $('#progStartDt').removeClass('text-danger');
                                    $('#progEndDt').text($('#programEndDate').val());
                                    $('#progEndDt').removeClass('text-danger');
                                }else{
                                    $('#progStartDt').text("Not given");
                                    $('#progStartDt').addClass('text-danger');
                                    $('#progEndDt').text("Not given");
                                    $('#progEndDt').addClass('text-danger');
                                }

                                if($('#programComment').val() == ""){
                                    $('#progComment').text("No Comments")
                                }else{
                                    $('#progComment').text($('#programComment').val());
                                }
                                

                            }else{
                                return false;
                            }

                        }else if(rowCountNominee>0){

                            $('#list_program_Nominees').removeClass('active_tab1 active');
                            $('#list_program_Nominees').removeAttr('href data-toggle');
                            $('#program_nominees').removeClass('active in');
                            $('#list_program_Nominees').addClass('inactive_tab1');

                            $('#list_program_review').removeClass('inactive_tab1');
                            $('#list_program_review').addClass('active_tab1 active');
                            $('#list_program_review').attr('href','#program_nominees');
                            $('#list_program_review').attr('data-toggle','tab');
                            $('#program_review').removeClass('fade');
                            $('#program_review').addClass('active in');

                            $('#progName').text($('#programName').val());
                            $('#progTrasup').text($('#programTraSup').val());
                            $('#progType').text($('#programType').val());
                            $('#progPio').text($('#programPiority').val());
                            if($('#programSlots').val()!=""){
                                $('#progSlot').text($('#programSlots').val());
                            }else{
                                $('#progSlot').text('-');
                            }

                            var currency = "";
                            if(document.getElementById('programCurrencyLKR').checked == true){
                                currency = "LKR";
                                document.getElementById("progCurrencyType").value = "LKR";
                            }else if(document.getElementById('programCurrencyUSD').checked == true){
                                currency = "USD";
                                document.getElementById("progCurrencyType").value = "USD";
                            }

                            if(document.getElementById("programTraSup").value == "Huawei"){
                                $('#progFee').text(currency+' '+$('#programFee').val());
                                progFeeType = "Voucher";
                            }else if(document.getElementById('programFeeFree').checked == true){
                                $('#progFee').text(currency+' '+$('#programFee').val());
                                progFeeType = "Free";
                            }else{
                                $('#progFee').text(currency+' '+$('#programFee').val());
                                progFeeType = "";
                            }
                            

                            $('#progPaymentType').text(progFeeType);

                            $('#progOthrCost').text(currency+' '+$('#programOtherCost').val());
                            $('#progTotCost').text(currency+' '+$('#programTotCost').val());

                            document.getElementById("progFeeType").value = progFeeType;

                            document.getElementById("programOtherCosth").value = document.getElementById("programOtherCost").value;
                            document.getElementById("programFeeh").value = document.getElementById("programFee").value;

                            if($('#programStartDate').val() != "" && $('#programEndDate').val() != ""){
                                $('#progStartDt').text($('#programStartDate').val());
                                $('#progStartDt').removeClass('text-danger');
                                $('#progEndDt').text($('#programEndDate').val());
                                $('#progEndDt').removeClass('text-danger');
                            }else{
                                $('#progStartDt').text("Not given");
                                $('#progStartDt').addClass('text-danger');
                                $('#progEndDt').text("Not given");
                                $('#progEndDt').addClass('text-danger');
                            }

                            if($('#programComment').val() == ""){
                                $('#progComment').text("No Comments")
                            }else{
                                $('#progComment').text($('#programComment').val());
                            }

                        }
                    }
                });

                $('#previous_btn_program_nominees').click(function(){

                    $('#list_program_review').removeClass('active_tab1 active');
                    $('#list_program_review').removeAttr('href data-toggle');
                    $('#program_review').removeClass('active in');
                    $('#list_program_review').addClass('inactive_tab1');

                    $('#list_program_Nominees').removeClass('inactive_tab1');
                    $('#list_program_Nominees').addClass('active_tab1 active');
                    $('#list_program_Nominees').attr('href','#program_modules');
                    $('#list_program_Nominees').attr('data-toggle','tab');
                    $('#program_nominees').addClass('active in');

                });
                
                $('#btn_program_submit').click(function(){

                    $('#btn_program_submit').attr("disabled","disabled");
                    $(document).css('cursur','progress');
                    $("#new_program").submit();

                });
                
                /* end of Add program */
                
            });

               

        </script>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" 
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" 
        integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
       <!-- <script src="../script.js"></script>-->

        <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
 
        <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>

        <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />

      </body>
</html>
