<?php

    $sheduleProgid = $_GET['spid'];
    $progid = $_GET['pid'];
    $userid = $_GET['uid'];
    
    include("database.php");

    $err = '';
    $user = '';
    $userId = '';
    $ct = '';
    $Userstatus = '';

    session_start();
    if(isset($_SESSION['username'])){

        $user = $_SESSION['username'];

        //$conn = mysqli_connect("localhost","root","","training");
        $sql = "SELECT idUser FROM logdetail WHERE Username = '$user'";
        $result_sql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
        $userId = mysqli_fetch_array($result_sql);

        $queryUserDetail = "SELECT * FROM user WHERE idUser = '".$userId['idUser']."'";
        $result_query = mysqli_query($conn,$queryUserDetail) or die(mysqli_error($conn));
        $userDetails = mysqli_fetch_array($result_query);
        $Userstatus = $userDetails['status'];

        if($userid != $userId['idUser']){
            echo '<script type="text/javascript">alert("Wrong Entry !");</script>';
            echo "<script>location.href='DashboardUser.php'</script>";
        }

        //session_destroy();

    }else{

        echo "<script>location.href='../Login.php'</script>";

    }


    if(isset($_POST['Logout'])){

        session_destroy();
        unset($_SESSION["username"]);
        header("location: ../Login.php");

    }

    date_default_timezone_set("Asia/Colombo"); 

    $sdProgQuery = "SELECT remark FROM sheduleprogram WHERE id = '$sheduleProgid'";
    $result_sdProgQuery = mysqli_query($conn,$sdProgQuery) or die(mysqli_error($conn));
    $count_sdProgQuery = mysqli_num_rows($result_sdProgQuery);

    if($count_sdProgQuery!=0){
        $sdProg = mysqli_fetch_array($result_sdProgQuery);

        $progDetailsQuery = "SELECT * FROM program WHERE remark = '".$sdProg['remark']."' AND idprogram = '$progid'";
    }else{
        echo '<script type="text/javascript">alert("Wrong Entry !");</script>';
        echo "<script>location.href='DashboardUser.php'</script>";
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
                                    text-uppercase mb-0">MY PROGRAM</h4>
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
                                    $result_sqlprog = mysqli_query($conn,$progDetailsQuery) or die(mysqli_error($conn));
                                    $progDetail = mysqli_fetch_array($result_sqlprog);

                                ?>

                                <div class="row mt-3 mb-3" style=" justify-content:center;">
                                    <h4>
                                        <?php echo $progDetail['ProgName'];?>
                                    </h4>
                                </div>
                                <div class="row form-group">
                                    <div class="col-3 d-flex justify-content-between align-items-center">
                                        Trainer / Supplier :
                                    </div>
                                    <div class="col-7 d-flex justify-content-between align-items-center">
                                            <?php echo $progDetail['trasup'];?>
                                    </div>
                                </div>
                                <div class="row mt-2 form-group">
                                    <div class="col-3 d-flex justify-content-between align-items-center">
                                        Type :
                                    </div>
                                    <div class="col-7 d-flex justify-content-between align-items-center">
                                        <?php
                                            echo    $progDetail['typ'];
                                        ?>
                                    </div>
                                        <div class="col-2 d-flex justify-content-between align-items-center">
                                        </div>
                                        
                                </div>
                                <div class="row mt-2 form-group">
                                    <div class="col-3 d-flex justify-content-between align-items-center">
                                        Priority :
                                    </div>
                                    <div class="col-7 d-flex justify-content-between align-items-center">
                                        <?php
                                            echo    $progDetail['prio'];
                                        ?>
                                    </div>
                                    <div class="col-2 d-flex justify-content-between align-items-center">
                                    </div>
                                </div>
                                <div class="row mt-2 form-group">
                                    <div class="col-3 d-flex justify-content-between align-items-center">
                                        Slots :
                                    </div>
                                    <div class="col-7 d-flex justify-content-between align-items-center">
                                        <?php if($progDetail['slot']!=""){ echo $progDetail['slot'];}else{ echo '<span class="text-danger">Not given</span>';}?>
                                    </div>
                                    <div class="col-2 d-flex justify-content-between align-items-center">
                                    </div>
                                </div>
                                <hr>
                                <?php 
                                    if($progDetail['feeType'] != ""){ 
                                ?>
                                    <div class="row mt-2 form-group">
                                        <div class="col-3 d-flex justify-content-between align-items-center">
                                            Payment Type :
                                        </div>
                                        <div class="col-7 d-flex justify-content-between align-items-center">
                                            <?php echo $progDetail['feeType']; ?>
                                        </div>
                                    </div>
                                <?php 
                                    }
                                    if($progDetail['feeType'] == ""){ 
                                ?>
                                    <div class="row mt-2 form-group">
                                        <div class="col-3 d-flex justify-content-between align-items-center">
                                            Course Fee :
                                        </div>
                                        <div class="col-1 d-flex justify-content-between align-items-center">
                                            <?php echo $progDetail['currency']; ?>
                                        </div>
                                        <div class="col-6 d-flex justify-content-between align-items-center">
                                            <?php echo $progDetail['fee']; ?>
                                        </div>
                                        <div class="col-2 d-flex justify-content-between align-items-center">
                                        </div>
                                    </div>
                                <?php   
                                } 
                                    if($progDetail['feeType'] != "Voucher"){
                                ?>
                                    <div class="row mt-2 form-group">
                                        <div class="col-3 d-flex justify-content-between align-items-center">
                                            Other Cost :
                                        </div>
                                        <div class="col-1 d-flex justify-content-between align-items-center">
                                            <?php echo $progDetail['currency']; ?>
                                        </div>
                                        <div class="col-6 d-flex justify-content-between align-items-center">
                                            <?php echo $progDetail['otherCost']; ?>
                                        </div>
                                        <div class="col-2 d-flex justify-content-between align-items-center">
                                        </div>
                                    </div>
                                <?php 
                                    } 
                                    if($progDetail['feeType'] != "Voucher"){
                                ?>
                                    <div class="row mt-2 form-group">
                                        <div class="col-3 d-flex justify-content-between align-items-center">
                                            Total Cost :
                                        </div>
                                        <div class="col-1 d-flex justify-content-between align-items-center">
                                            <?php echo $progDetail['currency']; ?>
                                        </div>
                                        <div class="col-6 d-flex justify-content-between align-items-center">
                                            <?php echo $progDetail['totCost']; ?>
                                        </div>
                                        <div class="col-2 d-flex justify-content-between align-items-center">
                                        </div>
                                    </div>
                                <?php 
                                    } 
                                ?>
                                    <hr>
                                    <div class="row mt-2 form-group">
                                        <div class="col-2 d-flex justify-content-between align-items-center">
                                            Start Date :
                                        </div>
                                        <div class="col-3 d-flex justify-content-between align-items-center">
                                            <?php 
                                                if($progDetail['stDate'] != ""){
                                                    echo $progDetail['stDate'];
                                                }else{
                                                    echo    '<span class="text-danger">Not given</span>';
                                                }
                                            ?>
                                        </div>
                                        <div class="col-2 d-flex justify-content-between align-items-center">
                                            End Date :
                                        </div>
                                        <div class="col-3 d-flex justify-content-between align-items-center">
                                            <?php 
                                                if($progDetail['edDate'] != ""){
                                                    echo $progDetail['edDate'];
                                                }else{
                                                    echo    '<span class="text-danger">Not given</span>';
                                                } 
                                            ?>
                                        </div>
                                        <div class="col-2 d-flex justify-content-between align-items-center">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mt-2 form-group">
                                        <div class="col-3 d-flex justify-content-between align-items-center">
                                            Comment :
                                        </div>
                                        <div class="col-7 d-flex justify-content-between align-items-center">
                                            <textarea style="width:100%;" name="programComment" id="programComment" value="<?php echo $progDetail['comment']; ?>" class="form-control" readonly></textarea>
                                        </div>
                                        <div class="col-2 d-flex justify-content-between align-items-center">
                                        </div>
                                        
                                    </div>
                                    <hr>
                                <?php
                                    $moduleData = "SELECT idModule FROM user_program_module WHERE idProgram = '$progid'";
                                    $moduleDataArray = mysqli_query($conn,$moduleData) or die(mysqli_error($conn));
                                    $modCount = mysqli_num_rows($moduleDataArray);
                                    
                                    $nomineeData = "SELECT Name, empID FROM nominee WHERE idProgram = '$progid'";
                                    $nomineeDataArray = mysqli_query($conn,$nomineeData) or die(mysqli_error($conn));
                                    $nomConunt = mysqli_num_rows($nomineeDataArray);
                                ?>
                                    <div class="row mt-2">
                                        <div class="col">                                                           
                                            <div class="table-responsive mt-2">
                                                <table class="table table-striped table-bordered" id="modules">
                                                    <tr>
                                                        <th>Module Name</th>
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
                                                                echo                        '</tr>';
                
                                                                $rowCountModule++;
                                                            }

                                                        }                                                       
                                                    ?>
                                                </table>
                                            </div>                                                            
                                        </div>
                                        <div class="col">                                                       
                                            <div class="table-responsive mt-2">
                                                <table class="table table-striped table-bordered" id="Nominees">
                                                    <tr>
                                                        <th>Nominee Name</th>
                                                        <th>Employee ID</th>
                                                    </tr>
                                                    <?php

                                                        $rowCountNominee = 0;
                                                        if($nomConunt==0){

                                                        }else{
                                                            while($ndA = mysqli_fetch_array($nomineeDataArray)){
                                                

                                                                echo                        '<tr id="row_'.$rowCountNominee.'">';
                                                                echo                        '<td>'.$ndA['Name'].'<input type="hidden" name="hidden_programNomine[]" id="programNomine'.$rowCountNominee.'" value="'.$ndA['Name'].'"/></td>';
                                                                echo                        '<td>'.$ndA['empID'].'<input type="hidden" name="hidden_programNomine[]" id="programNomine'.$rowCountNominee.'" value="'.$ndA['empID'].'"/></td>';
                                                                echo                        '</tr>';
                
                                                                $rowCountNominee++;
                                                            }
                                                        }
                                                    
                                                    ?>
                                                </table>
                                            </div>                                                            
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
 
                function load_unseen_notification(view = '')
                {
                $.ajax({
                url:"../notification.php",
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
                
                
                
                $(document).on('click', '.dropdown-toggle', function(){
                //$('.count').html('');
                load_unseen_notification('yes');
                });
                
                setInterval(function(){ 
                load_unseen_notification();; 
                }, 5000);
                
                });

        </script>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" 
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" 
        integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
       <!-- <script src="../script.js"></script>-->

       <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />

      </body>
</html>
