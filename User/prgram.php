<?php
    $id = $_GET['id'];

    include("database.php");

    $err = '';
    $user = '';
    $userId = '';
    $ct = '';
    $uid = '';

    session_start();
    if(isset($_SESSION['username'])){

        $user = $_SESSION['username'];

        //$conn = mysqli_connect("localhost","root","","training");
        $sql = "SELECT idUser FROM logdetail WHERE Username = '$user'";
        $result_sql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
        $userId = mysqli_fetch_array($result_sql);
        $uid = $userId['idUser'];

        $queryUserDetail = "SELECT * FROM user WHERE idUser = '".$userId['idUser']."'";
        $result_query = mysqli_query($conn,$queryUserDetail) or die(mysqli_error($conn));
        $userDetails = mysqli_fetch_array($result_query);

        $validationQuery = "SELECT * FROM program_has_user WHERE idProgram = '$id' AND idUser = '$uid'";
        $validateResult = mysqli_query($conn,$validationQuery) or die(mysqli_error($conn));
        $validateTot = mysqli_num_rows($validateResult);

        if($validateTot == 0){
            echo '<script type="text/javascript">alert("Wrong Entry !");</script>';
            echo "<script>location.href='DashboardUser.php'</script>";
        }
    

        //session_destroy();

    }else{

        echo "<script>location.href='../Login.php'</script>";

    }

    date_default_timezone_set("Asia/Colombo");

    $newprog = "SELECT * FROM `sheduleprogram` where status = '0'";
    $resNewProg = mysqli_query($conn,$newprog) or die(mysqli_error($conn));
    $dt = mysqli_fetch_array($resNewProg);

    $value = $dt['enddate'];
    $datetime = new DateTime($value);

    $now = new DateTime();

    if($datetime<$now){
        //Access for New Program
        $accessNewProg = "SELECT * FROM programaccess WHERE idProgram = '$id'";
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


    if(isset($_POST['Logout'])){

        session_destroy();
        unset($_SESSION["username"]);
        header("location: ../Login.php");

    } 
    if(isset($_POST['delete'])){
        $sqlNom = "DELETE FROM nominee WHERE idProgram = '$id'";

        if($conn->query($sqlNom) === TRUE){

            $selectModuleID = "SELECT idModule FROM user_program_module WHERE idProgram = '$id'";
            $resSelectModuleID = mysqli_query($conn,$selectModuleID) or die(mysqli_error($conn));

            while($moduleID = mysqli_fetch_array($resSelectModuleID)){

                $sqlModuleUser = "DELETE FROM user_program_module WHERE idModule = '".$moduleID['idModule']."'";
                if ($conn->query($sqlModuleUser) === TRUE) {
                    $sqlModule = "DELETE FROM module WHERE idModule = '".$moduleID['idModule']."'";
                    if ($conn->query($sqlModule) === TRUE) {
                        //echo "<script>location.href='DashboardUser.php'</script>";
                    } else {
                        echo '<script type="text/javascript">alert("Error deleting record!");</script>';
                        break;
                    }
                } else {
                    echo '<script type="text/javascript">alert("Error deleting record!");</script>';
                    break;
                }

            }
            $sqlProgUser = "DELETE FROM program_has_user WHERE idProgram = '$id'";
            if ($conn->query($sqlProgUser) === TRUE) {
                $sqlProg = "DELETE FROM program WHERE idProgram = '$id'";
                if ($conn->query($sqlProg) === TRUE) {
                    echo '<script type="text/javascript">alert("Successfully deleted..!");</script>';
                    echo "<script>location.href='DashboardUser.php'</script>";
                } else {
                    echo '<script type="text/javascript">alert("Error deleting record!");</script>';
                }
            } else {
                echo '<script type="text/javascript">alert("Error deleting record!");</script>';
            }
        }else{
            echo '<script type="text/javascript">alert("Error deleting record!");</script>';
        }

        
    } 
    if(isset($_POST['save_programTrasup'])){
        $trasup = $_POST['programTraSup'];
        $sqltrasup = "UPDATE program SET trasup = '$trasup' WHERE idProgram = '$id'";
                
                if ($conn->query($sqltrasup) === TRUE) {
                    //unset($_POST['save_programTrasup']);                    
                }else{
                    echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
                }

    }else if(isset($_POST['save_programType'])){
        $type="";
        
            $type = $_POST["programTyp"];
        
        $sqltype = "UPDATE program SET typ = '$type' WHERE idProgram = '$id'";
                
                if ($conn->query($sqltype) === TRUE) {
                    //unset($_POST['save_programType']);                    
                }else{
                    echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
                }

    }else if(isset($_POST['save_programPriority'])){
        $prio = $_POST['programPiority'];
        $sqlprio = "UPDATE program SET prio = '$prio' WHERE idProgram = '$id'";
                
                if ($conn->query($sqlprio) === TRUE) {
                    //unset($_POST['save_programPriority']);                    
                }else{
                    echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
                }

    }else if(isset($_POST['save_programSlot'])){
        $slot = $_POST['programSlots'];
        $sqlslot = "UPDATE program SET slot = '$slot' WHERE idProgram = '$id'";
                
                if ($conn->query($sqlslot) === TRUE) {
                    //unset($_POST['save_programPriority']);                    
                }else{
                    echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
                }

    }else if(isset($_POST['save_programFee'])){
        $fee = $_POST['programFee'];
        $tot = $_POST['programTotCost'];

        $sqlFee = "UPDATE program SET fee = '$fee', totCost= '$tot' WHERE idProgram = '$id'";
                
        if ($conn->query($sqlFee) === TRUE) {
            //unset($_POST['save_programPriority']);                    
        }else{
            echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
        }

    }else if(isset($_POST['save_programOtherCost'])){
        $otherCost = $_POST['programOtherCost'];
        $tot = $_POST['programTotCost'];

        $sqlFee = "UPDATE program SET otherCost = '$otherCost', totCost= '$tot' WHERE idProgram = '$id'";
                
        if ($conn->query($sqlFee) === TRUE) {
            //unset($_POST['save_programPriority']);                    
        }else{
            echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
        }

    }else if(isset($_POST['save_programDate'])){
        $stDate = $_POST['programStartDate'];
        $edDate = $_POST['programEndDate'];

        $stdate = new DateTime($stDate);
        $eddate = new DateTime($edDate);

        $sdt = $stdate->format("Y-m-d");
        $edt = $eddate->format("Y-m-d");

        $sqlFee = "UPDATE program SET stDate = '$sdt', edDate = '$edt' WHERE idProgram = '$id'";
                
        if ($conn->query($sqlFee) === TRUE) {
            //unset($_POST['save_programPriority']);                    
        }else{
            echo '<script type="text/javascript">alert("Somthing happen wrong... Please resubmit!");</script>';
        }

    }else if(isset($_POST['addModule'])){
        $module = $_POST['programModule'];
        if($module != ""){
            $addModuleSQL = "INSERT INTO module (moduleName) VALUES ('$module')";
            if($conn->query($addModuleSQL)=== TRUE){                            

                $getMId = "SELECT MAX(idModule) AS maximum FROM module WHERE moduleName = '$module'";
                $resMId = mysqli_query($conn,$getMId) or die(mysqli_error($conn));
                $mId = mysqli_fetch_array($resMId);
                $mId = $mId['maximum'];

                $queryProgModule = "INSERT INTO user_program_module (idUser, idProgram, idModule) VALUES ('$uid','$id','$mId')";
                
                if($conn->query($queryProgModule) === TRUE){
                    
                    
                }
                
            }
        }else{
            
        }

    }else if(isset($_POST['addNominee'])){
        $nominee = $_POST['programNominee'];
        $empID = $_POST['programEmpID'];
        if($nominee != ""){
            $queryNominee = "INSERT INTO nominee (idProgram,idUser,Name,empID) VALUES ('$id','$uid','$nominee','$empID')";                        

            if($conn->query($queryNominee)=== TRUE){
                
                
            }
        }
    }

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
                                    text-uppercase mb-0">Program</h4>
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
                        <form action="" method="POST">
                            
                            <button type="submit" name="Logout" class="btn btn-danger btn-block">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteProg">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Want to delete program?</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this program? If yes, press "Delete". Else, press "Cancel"
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                        <form action="" method="POST">
                            
                            <button type="submit" name="delete" class="btn btn-danger btn-block">Delete</button>
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
                        <div class="row pt-md-5 mt-md-3">
                            <div class="col-xl-1 col-lg-1">
                                
                            </div>
                            <div class="col-xl-10 col-lg-10">
                                <?php
                                                                        
                                    $sqlprog = "SELECT * FROM program WHERE idProgram = '$id'";
                                    $result_sqlprog = mysqli_query($conn,$sqlprog) or die(mysqli_error($conn));
                                    $progDetail = mysqli_fetch_array($result_sqlprog);

                                ?>

                                <div class="row mt-3 mb-3" style=" justify-content:center;">
                                    <h4>
                                    <?php echo $progDetail['ProgName'];?>
                                    </h4>
                                </div>
                                <form action="prgram.php?id=<?php echo $id;?>" method="POST" style="width:100%;" class=" justify-content-between align-items-center" id="1">
                                    <div class="row form-group">
                                         
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                            
                                                <!--<span class="float-left">Trainer / Supplier :</span>-->
                                                Trainer / Supplier :
                                            </div>
                                            <div class="col-7 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-right" style=" vertical-align: middle">-->
                                                    <input type="text" style="width:100%;" name="programTraSup" id="programTraSup" value="<?php echo $progDetail['trasup'];?>" class="form-control" readonly/>
                                                <!--</span>-->

                                            </div>
                                            <div class="col-2 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-left" style=" vertical-align: middle">-->
                                                <?php if($progDetail['trasup'] != "Huawei"){ ?>
                                                    <button type="button" name="edit_programTrasup" id="edit_programTrasup" <?php if($datetime<$now){ echo 'style="display:none;"';} ?> class="btn btn-info btn-sm">Edit</button>
                                                <?php } ?>                            
                                                        <button type="submit" name="save_programTrasup" id="save_programTrasup" style="display:none;" class="btn btn-info btn-sm">Save</button>
                                                    
                                                    <button type="button" name="cancel_programTrasup" id="cancel_programTrasup" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                                <!--</span>-->
                                                

                                            </div>
                                        
                                    </div>
                                </form>
                                <form action="" method="POST" style="width:100%;" class=" justify-content-between align-items-center" id="2"> 
                                    <div class="row mt-2 form-group">
                                        
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                            
                                                <!--<span class="float-left">Trype :</span>-->
                                                Type :
                                            </div>
                                            <div class="col-7 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-right" style=" vertical-align: middle">-->
                                                <?php
                                                    $selected = $progDetail['typ'];
                                                ?>
                                                <select class="form-control"  name="programTyp" id="programType"  style="width:50%;" disabled>                                            
                                                    <option <?php if($selected == 'Local'){echo("selected");}?>>Local</option>
                                                    <option <?php if($selected == 'Foriegn'){echo("selected");}?>>Foriegn</option>
                                                    <option <?php if($selected == 'Online'){echo("selected");}?>>Online</option>
                                                    <option <?php if($selected == 'Internal'){echo("selected");}?>>Internal</option>
                                                </select>
                                                <!--</span>-->
                                            </div>
                                            <div class="col-2 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-left" style=" vertical-align: middle">-->
                                                    <button type="button" name="edit_programType" id="edit_programType" <?php if($datetime<$now){ echo 'style="display:none;"';} ?> class="btn btn-info btn-sm">Edit</button>
                                                                            
                                                        <button type="submit" name="save_programType" id="save_programType" style="display:none;" class="btn btn-info btn-sm">Save</button>
                                                    
                                                    <button type="button" name="cancel_programType" id="cancel_programType" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                                <!--</span>-->
                                                

                                            </div>
                                        
                                    </div>
                                </form>
                                <form action="" method="POST" style="width:100%;" class=" justify-content-between align-items-center">
                                    <div class="row mt-2 form-group">
                                        
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                            
                                                <!--<span class="float-left">Trype :</span>-->
                                                Priority :
                                            </div>
                                            <div class="col-7 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-right" style=" vertical-align: middle">-->
                                                <?php
                                                    $select = $progDetail['prio'];
                                                ?>
                                                <select class="form-control" name="programPiority" id="programPiority" style="width:50%;" disabled>
                                                    <option <?php if($select == '1'){echo("selected");}?>>01</option>
                                                    <option <?php if($select == '2'){echo("selected");}?>>02</option>
                                                    <option <?php if($select == '3'){echo("selected");}?>>03</option>
                                                    <option <?php if($select == '4'){echo("selected");}?>>04</option>
                                                    <option <?php if($select == '5'){echo("selected");}?>>05</option>
                                                    <option <?php if($select == '6'){echo("selected");}?>>06</option>
                                                    <option <?php if($select == '7'){echo("selected");}?>>07</option>
                                                    <option <?php if($select == '8'){echo("selected");}?>>08</option>
                                                    <option <?php if($select == '9'){echo("selected");}?>>09</option>
                                                    <option <?php if($select == '10'){echo("selected");}?>>10</option>
                                                </select>
                                                <!--</span>-->
                                            </div>
                                            <div class="col-2 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-left" style=" vertical-align: middle">-->
                                                    <button type="button" name="edit_programPriority" id="edit_programPriority" <?php if($datetime<$now){ echo 'style="display:none;"';} ?> class="btn btn-info btn-sm">Edit</button>
                                                                                
                                                        <button type="submit" name="save_programPriority" id="save_programPriority" style="display:none;" class="btn btn-info btn-sm">Save</button>
                                                    
                                                    <button type="button" name="cancel_programPriority" id="cancel_programPriority" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                                <!--</span>-->
                                                

                                            </div>
                                        
                                    </div>
                                </form>
                                <form action="" method="POST" style="width:100%;" class=" justify-content-between align-items-center">
                                    <div class="row mt-2 form-group">
                                        
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                            
                                                <!--<span class="float-left">Trainer / Supplier :</span>-->
                                                Slots :
                                            </div>
                                            <div class="col-7 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-right" style=" vertical-align: middle">-->
                                                    <input type="text" style="width:50%;" name="programSlots" id="programSlots" value="<?php if($progDetail['slot']!=""){ echo $progDetail['slot'];}else{ echo "Not given";}?>" class="form-control <?php if($progDetail['slot']==""){ echo 'text-danger';} ?>" readonly/>
                                                <!--</span>-->

                                            </div>
                                            <div class="col-2 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-left" style=" vertical-align: middle">-->
                                                    <button type="button" name="edit_programSlot" id="edit_programSlot" <?php if($datetime<$now){ echo 'style="display:none;"';} ?> class="btn btn-info btn-sm">Edit</button>
                                                                            
                                                        <button type="submit" name="save_programSlot" id="save_programSlot" style="display:none;" class="btn btn-info btn-sm">Save</button>
                                                    
                                                    <button type="button" name="cancel_programSlot" id="cancel_programSlot" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                                <!--</span>-->
                                                

                                            </div>
                                        
                                    </div>
                                </form>
                                <hr>
                                <?php if($progDetail['feeType'] != ""){ ?>
                                    <div class="row mt-2 form-group">
                                        
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                            
                                                <!--<span class="float-left">Trainer / Supplier :</span>-->
                                                Payment Type :
                                            </div>
                                            <div class="col-7 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-right" style=" vertical-align: middle">-->
                                                    <?php echo $progDetail['feeType']; ?>
                                                <!--</span>-->

                                            </div>
                                    </div>
                                <?php 
                                    }
                                    if($progDetail['feeType'] == "" | $progDetail['feeType'] == "Free"){ 
                                ?>
                                <form action="" method="POST" style="width:100%;" class=" justify-content-between align-items-center">
                                    <div class="row mt-2 form-group">
                                        
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                            
                                                <!--<span class="float-left">Trainer / Supplier :</span>-->
                                                Course Fee :
                                            </div>
                                            <div class="col-1 d-flex justify-content-between align-items-center">
                                                <?php echo $progDetail['currency']; ?>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-right" style=" vertical-align: middle">-->
                                                    <input type="number" step="any" min="0" style="width:60%; text-align: right;" name="programFee" id="programFee" onclick="setTotal(); setFee();" onkeyup="setTotal();" onfocusout="setVal(this)" value="<?php echo $progDetail['fee']; ?>" class="form-control" readonly/>
                                                <!--</span>-->

                                            </div>
                                            <div class="col-2 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-left" style=" vertical-align: middle">-->
                                                <?php
                                                    if($progDetail['feeType'] == ""){
                                                ?>
                                                    <button type="button" name="edit_programFee" id="edit_programFee" <?php if($datetime<$now){ echo 'style="display:none;"';} ?> class="btn btn-info btn-sm">Edit</button>
                                                <?php
                                                    }
                                                ?>                             
                                                    <button type="submit" name="save_programFee" id="save_programFee" style="display:none;" class="btn btn-info btn-sm">Save</button>
                                                    
                                                    <button type="button" name="cancel_programFee" id="cancel_programFee" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                                <!--</span>-->
                                            </div>
                                        
                                    </div>
                                <!--</form>-->
                                <?php   
                                } 
                                    if($progDetail['feeType'] != "Voucher"){
                                ?>

                                <!--<form action="" method="POST" style="width:100%;" class=" justify-content-between align-items-center">-->
                                    <div class="row mt-2 form-group">
                                        
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                            
                                                <!--<span class="float-left">Trainer / Supplier :</span>-->
                                                Other Cost :
                                            </div>
                                            <div class="col-1 d-flex justify-content-between align-items-center">
                                                <?php echo $progDetail['currency']; ?>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-right" style=" vertical-align: middle">-->
                                                    <input type="number" step="any" min="0" style="width:60%; text-align: right;" name="programOtherCost" id="programOtherCost" onclick="setTotal(); setOtherCost();" onkeyup="setTotal();" onfocusout="setVal(this)" value="<?php echo $progDetail['otherCost']; ?>" class="form-control" readonly/>
                                                <!--</span>-->

                                            </div>
                                            <div class="col-2 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-left" style=" vertical-align: middle">-->
                                                    <button type="button" name="edit_programOtherCost" id="edit_programOtherCost" <?php if($datetime<$now){ echo 'style="display:none;"';} ?> class="btn btn-info btn-sm">Edit</button>
                                                                            
                                                    <button type="submit" name="save_programOtherCost" id="save_programOtherCost" style="display:none;" class="btn btn-info btn-sm">Save</button>
                                                    
                                                    <button type="button" name="cancel_programOtherCost" id="cancel_programOtherCost" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                                <!--</span>-->
                                            </div>
                                        
                                    </div>
                                <!--</form>-->
                                <?php 
                                    } 
                                    if($progDetail['feeType'] != "Voucher"){
                                ?>
                                    <div class="row mt-2 form-group">
                                        
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                            
                                                <!--<span class="float-left">Trainer / Supplier :</span>-->
                                                Total Cost :
                                            </div>
                                            <div class="col-1 d-flex justify-content-between align-items-center">
                                                <?php echo $progDetail['currency']; ?>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-right" style=" vertical-align: middle">-->
                                                    <input type="number" style="width:60%; text-align: right;" name="programTotCost" id="programTotCost" value="<?php echo $progDetail['totCost']; ?>" class="form-control" readonly/>
                                                <!--</span>-->

                                            </div>
                                            <div class="col-2 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-left" style=" vertical-align: middle">-->
                                                    
                                            </div>
                                        
                                    </div>
                                </form>
                                <?php } ?>
                                <hr>
                                <form action="" method="POST" style="width:100%;" class=" justify-content-between align-items-center">
                                    <div class="row mt-2 form-group">
                                        
                                            <div class="col-2 d-flex justify-content-between align-items-center">
                                            
                                                <!--<span class="float-left">Trainer / Supplier :</span>-->
                                                Start Date :
                                            </div>
                                            
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-right" style=" vertical-align: middle">-->
                                                    <input type="date" style="width:100%; text-align: right;" name="programStartDate" id="programStartDate" onmouseup="setDate();" value="<?php echo $progDetail['stDate']; ?>" class="form-control" readonly/>
                                                <!--</span>-->

                                            </div>
                                            <div class="col-2 d-flex justify-content-between align-items-center">
                                            
                                                <!--<span class="float-left">Trainer / Supplier :</span>-->
                                                End Date :
                                            </div>
                                            
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-right" style=" vertical-align: middle">-->
                                                    <input type="date" style="width:100%; text-align: right;" name="programEndDate" id="programEndDate" onmouseup="setDate();" value="<?php echo $progDetail['edDate']; ?>" class="form-control" readonly/>
                                                <!--</span>-->

                                            </div>
                                            
                                            <div class="col-2 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-left" style=" vertical-align: middle">-->
                                                <button type="button" name="edit_programDate" id="edit_programDate" <?php if($datetime<$now){ echo 'style="display:none;"';} ?> class="btn btn-info btn-sm">Edit</button>
                                                <button type="submit" name="save_programDate" id="save_programDate" style="display:none;" class="btn btn-info btn-sm" disabled>Save</button>
                                                <button type="button" name="cancel_programDate" id="cancel_programDate" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                                
                                            </div>
                                        
                                    </div>
                                    
                                        <small><span id="error_programDate" class="text-danger"></span></small>
                                    
                                </form>
                                <hr>
                                <form action="" method="POST" style="width:100%;" class=" justify-content-between align-items-center">
                                    <div class="row mt-2 form-group">
                                        
                                            <div class="col-3 d-flex justify-content-between align-items-center">
                                            
                                                <!--<span class="float-left">Trainer / Supplier :</span>-->
                                                Comment :
                                            </div>
                                            
                                            <div class="col-7 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-right" style=" vertical-align: middle">-->
                                                    <textarea style="width:100%;" name="programComment" id="programComment" value="<?php echo $progDetail['comment']; ?>" class="form-control" readonly></textarea>
                                                <!--</span>-->

                                            </div>
                                            <div class="col-2 d-flex justify-content-between align-items-center">
                                                <!--<span class="float-left" style=" vertical-align: middle">-->
                                                    <button type="button" name="edit_programComment" id="edit_programComment" <?php if($datetime<$now){ echo 'style="display:none;"';} ?> class="btn btn-info btn-sm">Edit</button>
                                                                            
                                                    <button type="submit" name="save_programComment" id="save_programComment" style="display:none;" class="btn btn-info btn-sm">Save</button>
                                                    
                                                    <button type="button" name="cancel_programComment" id="cancel_programComment" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                                <!--</span>-->
                                            </div>
                                        
                                    </div>
                                </form>
                                <hr>
                                <form action="" method="POST" id="moduleNominee" style="width:100%;" class=" justify-content-between align-items-center">

                                    <?php

                                        $moduleData = "SELECT idModule FROM user_program_module WHERE idProgram = '$id'";
                                        $moduleDataArray = mysqli_query($conn,$moduleData) or die(mysqli_error($conn));
                                        $modCount = mysqli_num_rows($moduleDataArray);

                                        $nomineeData = "SELECT Name,empID FROM nominee WHERE idProgram = '$id'";
                                        $nomineeDataArray = mysqli_query($conn,$nomineeData) or die(mysqli_error($conn));
                                        $nomConunt = mysqli_num_rows($nomineeDataArray);


                                    ?>

                                    <div class="row mt-2">
                                        <div class="col">
                                            <div class="mb-2" <?php if($datetime<$now){ echo 'style="display:none;"';} ?>>
                                                <label>Module Name</label>
                                                <input type="text" name="programModule" id="programModule" class="form-control" />
                                                <span id="error_programModule" class="text-danger"></span>
                                            </div>
                                            <div align="right" style="margin-bottom:5px;">
                                                <button type="submit" name="addModule" id="addModule" <?php if($datetime<$now){ echo 'style="display:none;"';} ?> class="btn btn-success btn-sm">Add</button>
                                            </div>                                                            
                                            <div class="table-responsive mt-2">
                                                <table class="table table-striped table-bordered" id="modules">
                                                    <tr>
                                                        <th>Module Name</th>                                                                        
                                                        <th <?php if($datetime<$now){ echo 'style="display:none;"';} ?>>Remove</th>
                                                    </tr>
                                                    <?php

                                                        $rowCountModule = 0;
                                                        if($modCount==0){

                                                        }else{

                                                            while($mdA = mysqli_fetch_array($moduleDataArray)){
                                                                $moduleNamesql = "SELECT moduleName FROM module WHERE idModule = '".$mdA['idModule']."'";
                                                                $moduleNameArray = mysqli_query($conn,$moduleNamesql) or die(mysqli_error($conn));                                                
                                                                $mNA = mysqli_fetch_array($moduleNameArray);
                
                                                                echo                        '<tr id="row_'.$rowCountModule.'">';
                                                                echo                        '<td>'.$mNA['moduleName'].'<input type="hidden" name="hidden_programModul[]" id="programModul'.$rowCountModule.'" value="'.$mNA['moduleName'].'"/></td>';
                                                                echo                        '<td'; if($datetime<$now){ echo 'style="display:none;"';}  echo '><button type="button" name="removeModule"'; if($datetime<$now){ echo 'style="display:none;"';}  echo ' class="btn btn-group btn-danger removeModule" style="padding: .25rem .4rem; font-size: .875rem; line-height: .95; border-radius: .2rem;" id="'.$rowCountModule.'">Remove</button></td>';
                                                                echo                        '</tr>';
                
                                                                $rowCountModule++;
                                                            }

                                                        }                                                       
                                                    ?>
                                                </table>
                                            </div>                                                            
                                        </div>
                                    
                                        <div class="col">
                                            <div class="row mb-2"<?php if($datetime<$now){ echo 'style="display:none;"';} ?>>
                                                <div class="col-4">
                                                    <label>Employee ID</label>
                                                    <input type="text" name="programEmpID" id="programEmpID" class="form-control" />
                                                </div>
                                                <div class="col-8">
                                                    <label>Nominee Name</label>
                                                    <input type="text" name="programNominee" id="programNominee" class="form-control" />
                                                </div>
                                                <span id="error_programNominee" class="text-danger"></span>
                                            </div>
                                            <div align="right" style="margin-bottom:5px;">
                                                <button type="submit" name="addNominee" id="addNominee" <?php if($datetime<$now){ echo 'style="display:none;"';} ?> class="btn btn-success btn-sm">Add</button>
                                            </div>                                                            
                                            <div class="table-responsive mt-2">
                                                <table class="table table-striped table-bordered" id="Nominees">
                                                    <tr>
                                                        <th>Nominee Name</th>   
                                                        <th>Employee ID</th>                                                                     
                                                        <th <?php if($datetime<$now){ echo 'style="display:none;"';} ?>>Remove</th>
                                                    </tr>
                                                    <?php

                                                        $rowCountNominee = 0;
                                                        if($nomConunt==0){

                                                        }else{
                                                            while($ndA = mysqli_fetch_array($nomineeDataArray)){
                                                

                                                                echo                        '<tr id="row_'.$rowCountNominee.'">';
                                                                echo                        '<td>'.$ndA['Name'].'<input type="hidden" name="hidden_programNomine[]" id="programNomine'.$rowCountNominee.'" value="'.$ndA['Name'].'"/></td>';
                                                                echo                        '<td>'.$ndA['empID'].'<input type="hidden" name="hidden_programEmpID[]" id="programEmpID'.$rowCountNominee.'" value="'.$ndA['empID'].'"/></td>';
                                                                echo                        '<td'; if($datetime<$now){ echo 'style="display:none;"';}  echo '><button type="submit" name="removeNominee"'; if($datetime<$now){ echo 'style="display:none;"';}  echo ' class="btn btn-group btn-danger removeNominee" style="padding: .25rem .4rem; font-size: .875rem; line-height: .95; border-radius: .2rem;" id="'.$rowCountNominee.'">Remove</button></td>';
                                                                echo                        '</tr>';
                
                                                                $rowCountNominee++;
                                                            }
                                                        }
                                                    
                                                    ?>
                                                </table>
                                            </div>                                                            
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mt-2 mb-4">
                                        <div class="col" align="center">
                                            <button type="button" data-toggle="modal" data-target="#deleteProg" <?php if($datetime<$now){ echo 'style="display:none;"';} ?> class="btn btn-danger btn-md">Delete This Program</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xl-1 col-lg-1">
                                
                            </div>                           
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- end of cards -->
      
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
        
        <script type="text/javascript">

            var feeTp = "<?php   echo    $progDetail['feeType']; ?>";

            function setFee(){
                if(document.getElementById("programFee").value == "" | document.getElementById("programFee").value == 0){
                    document.getElementById("save_programFee").disabled = true;
                }else{
                    document.getElementById("save_programFee").disabled = false;
                }
            }

            function setOtherCost(){
                if((document.getElementById("programOtherCost").value == "" | document.getElementById("programOtherCost").value == 0)&(feeTp != "Free")){
                    document.getElementById("save_programOtherCost").disabled = true;
                }else{
                    document.getElementById("save_programOtherCost").disabled = false;
                }
            }

            function setTotal(){
                val1 = document.getElementById("programFee").value;
                val2 = document.getElementById("programOtherCost").value;
                document.getElementById("programTotCost").value = parseFloat(val1)+parseFloat(val2);

            }

            function setVal(outFocus){
                if(outFocus.value == "" | outFocus.value == 0){
                    outFocus.value = 0;
                    document.getElementById("save_programFee").disabled = true;
                }else{
                    document.getElementById("save_programFee").disabled = false;
                }
                setTotal();
            }

            setInterval(function setDate(){
                if(document.getElementById("programStartDate").value != "" & document.getElementById("programEndDate").value != ""){
                    if(document.getElementById("programStartDate").value < document.getElementById("programEndDate").value){
                        document.getElementById("save_programDate").disabled = false;
                        $('#error_programDate').text('');
                    }else{
                        document.getElementById("save_programDate").disabled = true;
                        
                        $('#error_programDate').text('Please select correct dates');
                    }
                    
                }else{
                    document.getElementById("save_programDate").disabled = true;
                }
            },100);

            function loadDoc() {
                setInterval(function(){

                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("count").innerHTML = this.responseText;
                        }
                    };
                    xhttp.open("GET", "../wl.php", true);
                    xhttp.send();

                },1000);
                
            }
            
            loadDoc();
            
            $(document).ready(function(){
 
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
                            //$('.count').html(data.unseen_notification);
                            //}
                        }
                    });
                }
                
                load_unseen_notification();
                
                
                
                $(document).on('click', '.dropdown-toggle', function(){
                //$('.count').html('');
                load_unseen_notification('yes');
                });
                
                setInterval(function(){ 
                load_unseen_notification();; 
                }, 5000);

                var progTraSup = "";
                var progType = "";
                var progPri = "";
                var progSlot = "";
                var progFee = "";
                var progOtherCost = "";
                var progStDate = "";
                var progEdDate = "";
                var progComment = "";

                $('#edit_programTrasup').click(function(){                    
                    progTraSup = $('#programTraSup').val();
                    document.getElementById("edit_programTrasup").style.display='none';
                    document.getElementById("cancel_programTrasup").style.display='block';
                    document.getElementById("save_programTrasup").style.display='block';
                    $('#programTraSup').prop("readonly", false);
                });
                $('#save_programTrasup').click(function(){
                    document.getElementById("save_programTrasup").style.display='none';
                    document.getElementById("cancel_programTrasup").style.display='none';
                    document.getElementById("edit_programTrasup").style.display='block';                    
                    $('#programTraSup').prop("readonly", true);                   
                });
                $('#cancel_programTrasup').click(function(){
                    document.getElementById("cancel_programTrasup").style.display='none';
                    document.getElementById("save_programTrasup").style.display='none';
                    document.getElementById("edit_programTrasup").style.display='block';
                    document.getElementById('programTraSup').value=progTraSup;
                    $('#programTraSup').prop("readonly", true);
                });

                $('#edit_programType').click(function(){
                    progType = $('#programType').val();
                    document.getElementById("edit_programType").style.display='none';
                    document.getElementById("cancel_programType").style.display='block';
                    document.getElementById("save_programType").style.display='block';
                    $('#programType').prop("disabled", false);                    
                });
                $('#save_programType').click(function(){
                    document.getElementById("save_programType").style.display='none';
                    document.getElementById("cancel_programType").style.display='none';
                    document.getElementById("edit_programType").style.display='block'; 
                                      
                    setTimeout(function(){ $('#programType').prop("disabled", true); }, 5000);                   
                });
                $('#cancel_programType').click(function(){
                    document.getElementById("cancel_programType").style.display='none';
                    document.getElementById("save_programType").style.display='none';
                    document.getElementById("edit_programType").style.display='block';
                    document.getElementById('programType').value=progType;
                    $('#programType').prop("disabled", true);
                });

                $('#edit_programPriority').click(function(){
                    progPri = $('#programPiority').val();
                    document.getElementById("edit_programPriority").style.display='none';
                    document.getElementById("cancel_programPriority").style.display='block';
                    document.getElementById("save_programPriority").style.display='block';
                    $('#programPiority').prop("disabled", false);
                });
                $('#save_programPriority').click(function(){
                    document.getElementById("save_programPriority").style.display='none';
                    document.getElementById("cancel_programPriority").style.display='none';
                    document.getElementById("edit_programPriority").style.display='block';                    
                    setTimeout(function(){ $('#programPiority').prop("disabled", true); }, 5000);
                });
                $('#cancel_programPriority').click(function(){
                    document.getElementById("cancel_programPriority").style.display='none';
                    document.getElementById("save_programPriority").style.display='none';
                    document.getElementById("edit_programPriority").style.display='block';
                    document.getElementById('programPiority').value=progPri;
                    $('#programPiority').prop("disabled", true);
                });

                $('#edit_programSlot').click(function(){
                    progSlot = $('#programSlots').val();
                    document.getElementById("edit_programSlot").style.display='none';
                    document.getElementById("cancel_programSlot").style.display='block';
                    document.getElementById("save_programSlot").style.display='block';
                    $('#programSlots').prop("readonly", false);
                    if(document.getElementById('programSlots').value=="Not given"){
                        document.getElementById('programSlots').value="";
                        $('#programSlots').removeClass("text-danger");
                    }
                });
                $('#save_programSlot').click(function(){
                    document.getElementById("save_programSlot").style.display='none';
                    document.getElementById("cancel_programSlot").style.display='none';
                    document.getElementById("edit_programSlot").style.display='block';                    
                    $('#programSlots').prop("readonly", true);
                });
                $('#cancel_programSlot').click(function(){
                    document.getElementById("cancel_programSlot").style.display='none';
                    document.getElementById("save_programSlot").style.display='none';
                    document.getElementById("edit_programSlot").style.display='block';
                    if(progSlot=="Not given"){
                        document.getElementById('programSlots').value="Not given";
                        $('#programSlots').addClass("text-danger");
                    }else{
                        document.getElementById('programSlots').value=progSlot;
                    }
                    $('#programSlots').prop("readonly", true);
                });

                $('#edit_programFee').click(function(){
                    progFee = $('#programFee').val();
                    document.getElementById("edit_programFee").style.display='none';
                    document.getElementById("cancel_programFee").style.display='block';
                    document.getElementById("save_programFee").style.display='block';
                    $('#programFee').prop("readonly", false);
                    if(document.getElementById("programFee").value == 0){
                        document.getElementById("save_programFee").disabled = true;
                    }
                });
                $('#save_programFee').click(function(){
                    document.getElementById("save_programFee").style.display='none';
                    document.getElementById("cancel_programFee").style.display='none';
                    document.getElementById("edit_programFee").style.display='block';                    
                    setTimeout(function(){ $('#programFee').prop("readonly", true); }, 5000);
                });
                $('#cancel_programFee').click(function(){
                    document.getElementById("cancel_programFee").style.display='none';
                    document.getElementById("save_programFee").style.display='none';
                    document.getElementById("edit_programFee").style.display='block';
                    document.getElementById('programFee').value=progFee;
                    $('#programFee').prop("readonly", true);
                    setTotal();
                });

                $('#edit_programOtherCost').click(function(){
                    progOtherCost = $('#programOtherCost').val();
                    document.getElementById("edit_programOtherCost").style.display='none';
                    document.getElementById("cancel_programOtherCost").style.display='block';
                    document.getElementById("save_programOtherCost").style.display='block';
                    $('#programOtherCost').prop("readonly", false);
                    if(document.getElementById("programOtherCost").value == 0){
                        document.getElementById("save_programOtherCost").disabled = true;
                    }
                });
                $('#save_programOtherCost').click(function(){
                    document.getElementById("save_programOtherCost").style.display='none';
                    document.getElementById("cancel_programOtherCost").style.display='none';
                    document.getElementById("edit_programOtherCost").style.display='block';                    
                    setTimeout(function(){ $('#programOtherCost').prop("readonly", true); }, 5000);
                });
                $('#cancel_programOtherCost').click(function(){
                    document.getElementById("cancel_programOtherCost").style.display='none';
                    document.getElementById("save_programOtherCost").style.display='none';
                    document.getElementById("edit_programOtherCost").style.display='block';
                    document.getElementById('programOtherCost').value=progOtherCost;
                    $('#programOtherCost').prop("readonly", true);
                    setTotal();
                });

                $('#edit_programDate').click(function(){
                    progStDate = $('#programStartDate').val();
                    progEdDate = $('#programEndDate').val();
                    document.getElementById("edit_programDate").style.display='none';
                    document.getElementById("cancel_programDate").style.display='block';
                    document.getElementById("save_programDate").style.display='block';
                    $('#programStartDate').prop("readonly", false);
                    $('#programEndDate').prop("readonly", false);
                    if(document.getElementById("programStartDate").value == "" | document.getElementById("programEndDate").value == ""){
                        document.getElementById("save_programDate").disabled = true;
                    }
                });
                $('#save_programDate').click(function(){
                    document.getElementById("save_programDate").style.display='none';
                    document.getElementById("cancel_programDate").style.display='none';
                    document.getElementById("edit_programDate").style.display='block';                    
                    setTimeout(function(){ $('#programStartDate').prop("readonly", true); }, 5000);
                    setTimeout(function(){ $('#programEndDate').prop("readonly", true); }, 5000);
                });
                $('#cancel_programDate').click(function(){
                    document.getElementById("cancel_programDate").style.display='none';
                    document.getElementById("save_programDate").style.display='none';
                    document.getElementById("edit_programDate").style.display='block';
                    document.getElementById('programStartDate').value=progStDate;
                    document.getElementById('programEndDate').value=progEdDate;
                    $('#programStartDate').prop("readonly", true);
                    $('#programEndDate').prop("readonly", true);
                });

                $('#edit_programComment').click(function(){
                    progComment = $('#programComment').val();
                    document.getElementById("edit_programComment").style.display='none';
                    document.getElementById("cancel_programComment").style.display='block';
                    document.getElementById("save_programComment").style.display='block';
                    $('#programComment').prop("readonly", false);
                });
                $('#save_programComment').click(function(){
                    document.getElementById("save_programComment").style.display='none';
                    document.getElementById("cancel_programComment").style.display='none';
                    document.getElementById("edit_programComment").style.display='block';                    
                    setTimeout(function(){ $('#programComment').prop("readonly", true); }, 5000);
                });
                $('#cancel_programComment').click(function(){
                    document.getElementById("cancel_programComment").style.display='none';
                    document.getElementById("save_programComment").style.display='none';
                    document.getElementById("edit_programComment").style.display='block';
                    document.getElementById('programComment').value=progOtherCost;
                    $('#programComment').prop("readonly", true);
                });

                $('#addModule').click(function(){
                    var error_addModule = '';
                    if($('#programModule').val()==""){
                        error_addModule = "Please insert the module name here";
                        $('#error_programModule').text(error_addModule);
                        $('#programModule').addClass('has-error');
                    }else{
                        error_addModule = '';
                        $('#error_programModule').text(error_addModule);
                        $('#programModule').removeClass('has-error');                        
                    }
                });
                $('#addNominee').click(function(){
                    var error_addNominee = '';
                    if($('#programNominee').val()=="" | $('#programEmpID').val()==""){
                        error_addNominee = "Please insert the nominee name and employee ID here";
                        $('#error_programNominee').text(error_addNominee);
                        $('#programNominee').addClass('has-error');
                        $('#programEmpID').addClass('has-error');
                    }else{
                        error_addNominee = '';
                        $('#error_programNominee').text(error_addNominee);
                        $('#programNominee').removeClass('has-error'); 
                        $('#programEmpID').removeClass('has-error');                       
                    }
                });
                $(document).on('click', '.removeModule', function(){
                    var row_id_module = $(this).attr("id");
                    var valM = $('#programModul'+row_id_module+'').val();
                    
                    $.ajax({
                        url: "editModule.php",
                        method: "POST",
                        data: {valM:valM},
                        dataType: "text",
                        success: function(data){
                            $("#moduleNominee").submit();
                        }
                    })
                    

                });
                $(document).on('click', '.removeNominee', function(){
                    var row_id_Nominee = $(this).attr("id");
                    var valN = $('#programNomine'+row_id_Nominee+'').val();
                    var valEmpID = $('#programEmpID'+row_id_Nominee+'').val();
                    var idProg = <?php  echo    $id;    ?>;
                    $.ajax({
                        url: "editNominee.php",
                        method: "POST",
                        data: {valN:valN,valEmpID:valEmpID,idProg:idProg},
                        dataType: "text",
                        success: function(data){
                            $("#moduleNominee").submit();
                        }
                    })
                });
                
            });

        </script>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" 
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" 
        integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
       <!-- <script src="../script.js"></script>-->

      </body>
</html>
