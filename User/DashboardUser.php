<?php
    
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

        //session_destroy();

    }else{

        echo "<script>location.href='../Login.php'</script>";

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
                                current"><i 
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
                                    text-uppercase mb-0">Home</h4>
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
                        <form action="DashboardUser.php" method="POST">
                            
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

                        <?php

                            date_default_timezone_set("Asia/Colombo");

                            $newprog = "SELECT * FROM `sheduleprogram` where status = '0'";
                            $resNewProg = mysqli_query($conn,$newprog) or die(mysqli_error($conn));
                            $dt = mysqli_fetch_array($resNewProg);
                            $totProg = mysqli_num_rows($resNewProg);

                            $value = $dt['enddate'];
                            $datetime = new DateTime($value);

                            $now = new DateTime();

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

                            

                            $interval = $datetime->diff($now);

                            

                            $progcount = "SELECT * FROM program WHERE remark = '".$dt['remark']."' AND idprogram = ANY (SELECT idProgram FROM program_has_user WHERE idUser = '".$userId['idUser']."')";
                            $res = mysqli_query($conn,$progcount) or die(mysqli_error($conn));
                            
                            $tot = mysqli_num_rows($res);


                        if($totProg!=0 & $Userstatus !=0){
                            if($datetime>$now){
                                echo '<div class="row pt-md-5 mt-md-3">';
                                echo    '<div class="col-xl-12 col-sm-12 p-2">';
                                echo        '<div class="d-flex justify-content-between">';                            
                                echo            '<div class="text-left text-secondary px-3">';
                                echo                '<h5>';
                                echo                    $dt['remark'];
                                echo                '</h5>';
                                echo            '</div>';
                                echo        '</div>';
                                echo    '</div>';
                                echo '</div>';

                                echo '<div class="row pt-md-1 mt-md-1 mb-1 program-data">';                                
                                echo    '<div class="col-xl-4 col-lg-5 p-2">';
                                echo        '<div class="card-programe pl-4">';
                                echo            '<form action="DashboardUser.php" method="POST">';
                                echo                '<button class="button button-add" type="submit" name="NewProg">';
                                echo                    '<i class="fa fa-plus mr-4" aria-hidden="true"></i>Add New Program';
                                echo                '</button>';
                                echo            '</form>';                      
                                echo        '</div>';
                                echo        '<br/>';
                                echo        '<div class="card-programe px-4 d-flex justify-content-between align-items-center">';                                   
                                echo            '<span class="float-left"><small>Total Number of Your Programs</small></span>';
                                echo            '<span class="float-right mr-5" style="font-size: 15pt; vertical-align: middle">';
                                                                                                
                                                    echo $tot;                                            

                                echo            '</span>';                                                                                                        
                                echo        '</div>';                                                       
                                echo    '</div>';
                                echo    '<div class="col-xl-2 col-lg-1">';

                                echo    '</div>';
                                echo    '<div class="col-xl-6 col-lg-6 p-2">';
                                echo        '<div class="card-programe pt-2 px-2 d-flex justify-content-between align-items-center">';
                                echo            '<span class="float-left">Due Date : </span>';
                                echo            '<span class="float-right " style=" vertical-align: middle">';
                                echo                $datetime->format("l, d F Y, h:i A");
                                echo            '</span>';
                                echo        '</div>';
                                echo        '<div class="card-programe pt-2 px-2 d-flex justify-content-between align-items-center">';
                                echo            '<span class="float-left">Remaining Time : </span>';
                                echo            '<span class="float-right" style=" vertical-align: middle">';

                                                if(($interval->format("%a"))>0){

                                                    echo $interval->format("%a day(s), %h hour(s)");

                                                }else if(($interval->format("%h"))>0){

                                                    echo $interval->format("%h hour(s), %i minute(s)");

                                                }else if(($interval->format("%i"))>0){

                                                    echo $interval->format("%i minute(s), %s second(s)");

                                                }else{

                                                    echo $interval->format("%s second(s)");

                                                }
                                echo            '</span>';
                                echo        '</div>';                                                        
                                echo    '</div>';
                                echo '</div>';                            
                     
                                echo '<div class="row pt-md-2 mt-md-1 mb-5 program-data">';
                            }else{
                                echo '<div class="row pt-md-2 mt-md-5 mb-5 program-data">';
                            }

                        
                                if($tot>0){

                                   //$allData = "SELECT * FROM program_has_user WHERE idUser='".$userId['idUser']."' ORDER BY idProgram DESC";
                                    //$dataArray = mysqli_query($conn,$allData) or die(mysqli_error($conn));

                                    while($ct = mysqli_fetch_array($res)){

                                        $progDate = "SELECT * FROM program_has_user WHERE idProgram = '".$ct['idProgram']."'";
                                        $progDateArray = mysqli_query($conn,$progDate) or die(mysqli_error($conn));
                                        $date = mysqli_fetch_array($progDateArray);

                                        $moduleData = "SELECT idModule FROM user_program_module WHERE idProgram = '".$ct['idProgram']."'";
                                        $moduleDataArray = mysqli_query($conn,$moduleData) or die(mysqli_error($conn));
                                        $modCount = mysqli_num_rows($moduleDataArray);

                                        $nomineeData = "SELECT Name, empID FROM nominee WHERE idProgram = '".$ct['idProgram']."'";
                                        $nomineeDataArray = mysqli_query($conn,$nomineeData) or die(mysqli_error($conn));
                                        $nomConunt = mysqli_num_rows($nomineeDataArray);

                                        echo '<div class="col-xl-12 col-sm-12 p-2 ">';
                                        echo    '<div class="card card-common">';
                                        echo        '<div class="card-body">';
                                        echo            '<div class="d-flex justify-content-between">';
                                        echo                '<i class="fas fa-tasks text-info"></i>';
                                        echo                '<div class="text-right text-secondary">';
                                        echo                    '<a href="prgram.php?id='; echo $ct['idProgram'];echo '" class="card-link text-blue mb-4"><h5><small>';
                                        echo                        $ct['ProgName'];
                                        echo                    '</small></h5></a>';
                                        echo                '</div>';
                                        echo            '</div>';

                                        echo            '<div class="row pl-md-auto ml-md-auto pr-md-auto mr-md-auto mb-2">';
                                        echo                '<div class="col-xl-3">';
                                        echo                    '<div class="panel panel-default rounded-top">';
                                        echo                        '<div class="panel-heading overview-color-bg">';
                                        echo                            '<div class="panel-title pl-2 pt-1 pb-1 ml-auto">Details</div>';
                                        echo                        '</div>';                                        
                                        echo                        '<div class="panel-body pt-2 px-3 d-flex justify-content-between align-items-center">';
                                        echo                            '<span class="float-left"><small>Trainer/Sup. : </small></span>';
                                        echo                            '<span class="float-right " style=" vertical-align: middle"><small>';
                                        echo                                $ct['trasup'];
                                        echo                            '</small></span>';
                                        echo                        '</div>';

                                        echo                        '<div class="panel-body pt-2 px-3 d-flex justify-content-between align-items-center">';
                                        echo                            '<span class="float-left"><small>Type : </small></span>';
                                        echo                            '<span class="float-right " style=" vertical-align: middle"><small>';
                                        echo                                $ct['typ'];
                                        echo                            '</small></span>';
                                        echo                        '</div>';

                                        echo                        '<div class="panel-body pt-2 px-3 d-flex justify-content-between align-items-center">';
                                        echo                            '<span class="float-left"><small>Priority : </small></span>';
                                        echo                            '<span class="float-right " style=" vertical-align: middle"><small>';
                                        echo                                $ct['prio'];
                                        echo                            '</small></span>';
                                        echo                        '</div>';

                                        echo                        '<div class="panel-body pt-2 px-3 d-flex justify-content-between align-items-center">';
                                        echo                            '<span class="float-left"><small>Slots : </small></span>';

                                        if($ct['slot'] !=''){

                                            echo                            '<span class="float-right " style=" vertical-align: middle"><small>';
                                            echo                                $ct['slot'];
                                            echo                            '</small></span>';
                                            
                                        }else{

                                            echo                            '<span class="float-right text-danger" style=" vertical-align: middle"><small>Not given</small></span>';
                                            
                                        }
                                        echo                        '</div>';

                                        echo                        '<div class="panel-body pt-2 px-3 pb-2 d-flex justify-content-between align-items-center">';
                                        echo                            '<span class="float-left"><small>Date added : </small></span>';
                                        echo                            '<span class="float-right " style=" vertical-align: middle"><small>';
                                        echo                                $date['Dt'];
                                        echo                            '</small></span>';
                                        echo                        '</div>';

                                        echo                    '</div>';
                                        echo                '</div>';

                                        echo                '<div class="col-xl-5">';
                                        echo                    '<div class="panel panel-default rounded-top mt-xl-0 mt-2">';
                                        echo                        '<div class="panel-heading">';
                                        echo                            '<div class="panel-title pl-2 pt-1 pb-1 ml-auto">Modules</div>';
                                        echo                        '</div>';
                                        echo                        '<div class="panel-body divbody pt-2 px-3 d-flex" style="height:168px; width:100%; overflow: auto; overflow-x: hidden;">';
                                        if($modCount==0){
                                            echo                        '<div class="col-1">';
                                            echo                        '</div>';
                                            echo                        '<div class="col-10 d-flex align-items-center" style=" align: center">';
                                            echo                            '<label class="text-danger text-center" style="width:100%; align: center">Not given</label>';
                                            echo                        '</div>';
                                            echo                        '<div class="col-1">';
                                            echo                        '</div>';
                                        }else{
                                            echo                        '<table style="width:100%; height: 100%">';
                                            while($mdA = mysqli_fetch_array($moduleDataArray)){
                                                $moduleNamesql = "SELECT moduleName FROM module WHERE idModule = '".$mdA['idModule']."'";
                                                $moduleNameArray = mysqli_query($conn,$moduleNamesql) or die(mysqli_error($conn));                                                
                                                $mNA = mysqli_fetch_array($moduleNameArray);

                                                echo                        '<tr>';
                                                echo                        '<td><small>'. $mNA['moduleName'] .'</small></td>';
                                                echo                        '</tr>';


                                            }
                                            echo                        '</table>';
                                        }
                                        echo                        '</div>';
                                        echo                    '</div>';
                                        echo                '</div>';

                                        echo                '<div class="col-xl-4">';
                                        echo                    '<div class="panel panel-default rounded-top mt-xl-0 mt-2">';
                                        echo                        '<div class="panel-heading overview-color-bg">';
                                        echo                            '<div class="panel-title pl-2 pt-1 pb-1 ml-auto">Nominees</div>';
                                        echo                        '</div>';
                                        echo                        '<div class="panel-body divbody pt-2 px-3 d-flex" style="height:168px; overflow: auto; overflow-x: hidden; width:100%;">';
                                        if($nomConunt==0){
                                            echo                        '<div class="col-1">';
                                            echo                        '</div>';
                                            echo                        '<div class="col-10 d-flex align-items-center" style=" align: center">';
                                            echo                            '<label class="text-danger text-center" style="width:100%; align: center">Not given</label>';
                                            echo                        '</div>';
                                            echo                        '<div class="col-1">';
                                            echo                        '</div>';
                                        }else{
                                            //echo                        '<div class="divbody" style="height: 150px; overflow: auto; overflow-x: hidden;">';
                                            echo                        '<table class="ModuleTable" id="ModuleTable" style="width:100%;">';
                                            while($ndA = mysqli_fetch_array($nomineeDataArray)){
                                                

                                                echo                        '<tr>';
                                                echo                        '<td><small>'. $ndA['Name'] .'</small></td>';
                                                echo                        '<td><small>'. $ndA['empID'] .'</small></td>';
                                                echo                        '</tr>';


                                            }
                                            echo                        '</table>';
                                           // echo                        '</div>';
                                        }
                                        echo                        '</div>';
                                        echo                    '</div>';
                                        echo                '</div>';
                                        
                                        echo            '</div>';

                                        echo        '</div>';
                                        echo    '</div>';
                                        echo '</div>';

                                    }

                                }else if($tot==0){
                                    echo '<div class="col-xl-12 col-sm-12 p-2">';
                                    echo '<div class="card card-common">';
                                    echo '<div class="card-body">';
                                    echo '<h5 class="m-2 text-danger" style="text-align: center">No Programs to Preview!</h5>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                        }else{
                                    echo '<div class="row pt-md-5 mt-md-3">';
                                    echo '<div class="col-xl-12 col-sm-12 p-2">';
                                    echo '<div class="card card-common mx-3">';
                                    echo '<div class="card-body">';
                                    echo '<h5 class="m-2 text-danger" style="text-align: center">No New Sheduled Programs</h5>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                        }
                            ?>
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
