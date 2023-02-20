<?php

    include("database.php");

    $id = $_GET['id'];
    $err = '';
    $user = '';
    $userId = '';
    $ct = '';

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

        <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" /> 
        <link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
        <style>.bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, .bootstrap-iso form{font-family: Arial, Helvetica, sans-serif; color: black}.bootstrap-iso form button, .bootstrap-iso form button:hover{color: white !important;} .asteriskField{color: red;}</style>

        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" 
        integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>

        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
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
                                    text-uppercase mb-0">Training Programs</h4>
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

        <?php

            $queryTrainingPrograms = "SELECT * FROM sheduleprogram WHERE id = '$id' AND status = '0'";
            $trainingProgramArray = mysqli_query($conn,$queryTrainingPrograms) or die(mysqli_error($conn));
            $valied = mysqli_num_rows($trainingProgramArray);
            if($valied ==0){
                echo '<script type="text/javascript">alert("Wrong Entry !");</script>';
                echo "<script>location.href='Dashboard.php'</script>";
            }
            $trainingProgram = mysqli_fetch_array($trainingProgramArray);
        
        ?>

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-10 col-lg-9 col-md-9 ml-auto">
                        <div class="row pt-md-5 mt-md-3 pt-xs-5 mt-xs-3 mb-3">
                            <div class="col-xl-12 col-sm-12 ">
                                <div class="card card-common">
                                    <div class="row">
                                        <div class="col-1">

                                        </div>
                                        <div class="col-10">

                                            <div class="card-body">
                                                <div align="center" class="panel-heading p-2">
                                                    <?php echo $trainingProgram['remark'];?>
                                                </div>
                                                <div class="table-responsive text-nowrap mt-2 px-5">
                                                    <table class="table table-striped table-bordered" id="modules">
                                                        <tr>
                                                            <td><small>Start Date</small></td>                                                                        
                                                            <td align="right"><small>
                                                                <?php
                                                                    $startDt = $trainingProgram['startdate'];
                                                                    $stDt = new DateTime($startDt);
                                                                    echo $stDt->format("l, d F Y, h:i A");
                                                                ?>
                                                            </small></td>
                                                        </tr>
                                                        <tr>
                                                            <td><small>End Date</small></td>                                                                        
                                                            <td align="right"><small>
                                                                <?php
                                                                    $endDt = $trainingProgram['enddate'];
                                                                    $edDt = new DateTime($endDt);
                                                                    echo $edDt->format("l, d F Y, h:i A");
                                                                ?>
                                                            </small></td>
                                                        </tr>
                                                        <tr>
                                                            <td><small>
                                                                <?php
                                                                    $now = new DateTime();

                                                                    $interval = $edDt->diff($now);
                                                                    if($edDt>$now){
                                                                        echo    'Remaining Time';
                                                                    }else{
                                                                        echo    'Overdue by';
                                                                    }
                                                                ?>
                                                            </small></td> 
                                                            <?php
                                                                if($edDt>$now){

                                                                    echo    '<td align="right" class="text-success"><small>';
                                                                    if(($interval->format("%a"))>0){

                                                                        echo $interval->format("%a day(s), %h hour(s)");
                    
                                                                    }else if(($interval->format("%h"))>0){
                    
                                                                        echo $interval->format("%h hour(s), %i minute(s)");
                    
                                                                    }else if(($interval->format("%i"))>0){
                    
                                                                        echo $interval->format("%i minute(s), %s second(s)");
                    
                                                                    }else{
                    
                                                                        echo $interval->format("%s second(s)");
                    
                                                                    }
                                                                    echo    '</small></td>';

                                                                }else{
                                                                    echo    '<td align="right" class="text-danger"><small>';
                                                                    if(($interval->format("%a"))>0){

                                                                        echo $interval->format("%a day(s), %h hour(s)");
                    
                                                                    }else if(($interval->format("%h"))>0){
                    
                                                                        echo $interval->format("%h hour(s), %i minute(s)");
                    
                                                                    }else if(($interval->format("%i"))>0){
                    
                                                                        echo $interval->format("%i minute(s), %s second(s)");
                    
                                                                    }else{
                    
                                                                        echo $interval->format("%s second(s)");
                    
                                                                    }
                                                                    echo    '</small></td>';
                                                                }
                                                            ?>
                                                        </tr>
                                                        <tr>
                                                            <td><small>Status</small></td>
                                                            <?php
                                                                if($trainingProgram['status']==0){
                                                                    echo    '<td align="right" class="text-success"><small>';
                                                                    echO    'Active';
                                                                    echo    '</small></td>';
                                                                }else if($trainingProgram['status']==1){
                                                                    echo    '<td align="right" class="text-danger"><small>';
                                                                    echO    'Closed';
                                                                    echo    '</small></td>';
                                                                }
                                                            ?>
                                                            
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php
                                                if($edDt<$now){
                                            ?>
                                                <div class="px-5">    
                                                    <div align="right" class="mr-5">
                                                    <!--<form method="post" action="exportExcell.php">-->
                                                        <button type="button" name="finalize" style="display:inline-block;" id="finalize" class="btn btn-info btn-sm">Finalize</button>
                                                    <!--</form>-->
                                                    </div>
                                                </div>    
                                            <?php
                                                }
                                            ?>
                                            <div class="card-body">
                                                <div align="center" class="panel-heading p-2">
                                                    Change End Date
                                                </div>
                                                <div class="row d-flex justify-content-between align-items-center">
                                                    
                                                        <?php
                                                            if($edDt>$now){
                                                                echo    '<div class="col-xl-2 col-sm-1">';
                                                                echo    '</div>';

                                                                echo    '<div class="col-xl-8 col-sm-10">';
                                                                echo    '<form action="" id="date">';
                                                                echo        '<div class="form-group px-2">';
                                                                echo            '<label><small>Change Date and Time</small></label>';
                                                                echo            '<input type="datetime-local" style="display: inline-block;" name="datetime" id="datetime" class="form-control" readonly/>';
                                                                echo            '<small><span id="error_datetime" class="text-danger"></span></small>';
                                                                echo            '<div align="right" class="pt-2">';
                                                                echo                '<button type="button" name="changeDateTime" style="display:inline-block;" id="changeDateTime" class="btn btn-info btn-sm">Change</button>';
                                                                echo                '<button type="button" name="saveDateTime" style="display:none;" id="saveDateTime" class="btn btn-info btn-sm mr-2">Save</button>';
                                                                echo                '<button type="button" name="cancelDateTime" style="display:none;" id="cancelDateTime" class="btn btn-danger btn-sm">Cancel</button>';
                                                                echo            '</div>';
                                                                echo        '</div>';
                                                                echo    '</form>';
                                                                echo    '</div>';

                                                                echo    '<div class="col-xl-2 col-sm-1">';
                                                                echo    '</div>';
                                                            }
                                                        ?>
                                                </div>
                                                <div class="row d-flex justify-content-between align-items-center mt-2">
                                                        <?php    
                                                            if($edDt<$now){

                                                                
                                                                echo        '<div class="col-3">';
                                                                echo                '<lable>Select Users*</lebel>';
                                                                echo            '<div class="pt-2 px-3 d-flex" style="height:200px; width:100%; overflow: auto; overflow-x: hidden;">';
                                                                
                                                                echo                '<table style="width:100% height: 100%">';

                                                                $queryGetUsers = "SELECT * FROM user WHERE role='User' AND status = '1'";
                                                                $getUsers = mysqli_query($conn,$queryGetUsers) or die(mysqli_error($conn));

                                                                echo                        '<tr>';
                                                                echo                        '<td><input type="checkbox" name="userCheck" onclick=" Selection(this);" value="All"/><small>  All Users</small></td>';
                                                                echo                        '</tr>';
                                                                while($user = mysqli_fetch_array($getUsers)){
                                                                echo                        '<tr>';
                                                                echo                        '<td><input type="checkbox" name="userCheck" onclick=" Selection(this);" value="'.$user['idUser'].'"/><small> '.$user['fName'].'</small></td>';
                                                                echo                        '</tr>';
                                                                }
                                                                echo                '</table>';
                                                                echo            '</div>';
                                                                echo        '</div>';
                                                                echo        '<div class="col-9">';
                                                                echo                '<lable>Select Programs* <span class="text-secondary ml-4"><small><small>(Please select users to veiw programs)</small></small></span></lebel>';
                                                                echo            '<div class="pt-2 px-3 d-flex" id="resultTable" style="height:200px; width:100%; overflow: auto; overflow-x: hidden;">';
                                                                
                                                                echo            '</div>';
                                                                echo        '</div>';
                                                                


                                                                
                                                                
                                                               
                                                            }
                                                        ?>
                                                </div>    
                                                <div class="row d-flex justify-content-between align-items-center">    
                                                        <?php
                                                            if($edDt<$now){
                                                                echo            '<div class="col-xl-2 col-sm-1">';
                                                                echo            '</div>';

                                                                echo            '<div class="col-xl-8 col-sm-10">';
                                                                echo                '<form action="" id="date">';
                                                                echo                    '<div class="form-group px-2">';
                                                                echo                        '<label><small>Change Date and Time</small></label>';
                                                                echo                        '<input type="datetime-local" style="display: inline-block;" name="datetime2" id="datetime2" class="form-control" readonly/>';
                                                                echo                        '<small><span id="error_datetime2" class="text-danger"></span></small>';
                                                                echo                        '<div align="right" class="pt-2">';
                                                                echo                            '<button type="button" name="changeDateTime2" style="display:inline-block;" id="changeDateTime2" class="btn btn-info btn-sm">Change</button>';
                                                                echo                            '<button type="button" name="saveDateTime2" style="display:none;" id="saveDateTime2" class="btn btn-info btn-sm mr-2">Save</button>';
                                                                echo                            '<button type="button" name="cancelDateTime2" style="display:none;" id="cancelDateTime2" class="btn btn-danger btn-sm">Cancel</button>';
                                                                echo                        '</div>';
                                                                echo                    '</div>';
                                                                echo                '</form>';
                                                                echo            '</div>';

                                                                echo            '<div class="col-xl-2 col-sm-1">';
                                                                echo            '</div>';
                                                            }
                                                        ?>
                                                    
                                                </div>
                                                <div class="row d-flex justify-content-between align-items-center mb-2">
                                                        <?php
                                                            if($edDt<$now){
                                                                echo            '<div class="col-xl-1 col-sm-1">';
                                                                echo            '</div>';

                                                                echo            '<div class="col-xl-10 col-sm-10">';
                                                                echo                '<small><div class="panel-body divbody d-flex" style="height:200px; width:100%; overflow: auto; overflow-x: hidden;">';
                                                                echo                    '<table class="table table-striped table-bordered"  style="width:100%;">';
                                                                echo                        '<thead>';
                                                                echo                            '<tr>';
                                                                echo                                '<th style="width:17%">Name</th>';
                                                                echo                                '<th style="width:50%">Description</th>';
                                                                echo                                '<th style="width:33%">Due Date</th>';
                                                                echo                            '</tr>';
                                                                echo                        '</thead>';
                                                                echo                        '<tbody id="userAddedTable">';
                                                                
                                                                
                                                                $selectUserDue = "SELECT * FROM useraccess";
                                                                $userDueArray = mysqli_query($conn,$selectUserDue) or die(mysqli_error($conn));
                                                                while($userDue = mysqli_fetch_array($userDueArray)){

                                                                    $endDt = $userDue['enddate'];
                                                                    $edDt = new DateTime($endDt);
                                                                    $edDt = $edDt->format("d F Y, h:i A");

                                                                    $qyeryGetName = "SELECT fName FROM user WHERE idUser = ".$userDue['idUser']."";
                                                                    $getNameArray = mysqli_query($conn,$qyeryGetName) or die(mysqli_error($conn));
                                                                    $name = mysqli_fetch_array($getNameArray);

                                                                    echo                        '<tr>';
                                                                    echo                            '<td>'.$name['fName'].'</td>';
                                                                    echo                            '<td>Give access for add new programs</td>';
                                                                    echo                            '<td align="right">'.$edDt.'</td>';
                                                                    echo                        '</tr>';


                                                                }


                                                                $selectProgDue = "SELECT * FROM programaccess";
                                                                $progDueArray = mysqli_query($conn,$selectProgDue) or die(mysqli_error($conn));
                                                                while($progDue = mysqli_fetch_array($progDueArray)){

                                                                    $endDt = $progDue['enddate'];
                                                                    $edDt = new DateTime($endDt);
                                                                    $edDt = $edDt->format("d F Y, h:i A");

                                                                    $qyeryGetName = "SELECT fName FROM user WHERE idUser = ANY (SELECT idUser FROM program_has_user WHERE idProgram = '".$progDue['idProgram']."')";
                                                                    $getNameArray = mysqli_query($conn,$qyeryGetName) or die(mysqli_error($conn));
                                                                    $name = mysqli_fetch_array($getNameArray);

                                                                    $qyeryGetProgName = "SELECT progName FROM program WHERE idProgram = '".$progDue['idProgram']."'";
                                                                    $getProgNameArray = mysqli_query($conn,$qyeryGetProgName) or die(mysqli_error($conn));
                                                                    $progName = mysqli_fetch_array($getProgNameArray);

                                                                    echo                        '<tr>';
                                                                    echo                            '<td>'.$name['fName'].'</td>';
                                                                    echo                            '<td>Give access for edit program: '.$progName['progName'].'</td>';
                                                                    echo                            '<td align="right">'.$edDt.'</td>';
                                                                    echo                        '</tr>';


                                                                }


                                                                echo                        '</tbody>';
                                                                echo                    '</table>';
                                                                echo                '</div></small>';
                                                                echo            '</div>';

                                                                echo            '<div class="col-xl-1 col-sm-1">';
                                                                echo            '</div>';
                                                            }
                                                    ?>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-1">

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

        <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

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
                
                
                
                $(document).on('click', '.dropdown-toggle', function(){
                //$('.count').html('');
                load_unseen_notification('yes');
                });
                
                setInterval(function(){ 
                load_unseen_notification();; 
                }, 5000);

                $('#changeDateTime').click(function(){
                    $('#datetime').prop("readonly", false);
                    document.getElementById("changeDateTime").style.display = 'none';
                    document.getElementById("saveDateTime").style.display = 'inline-block';
                    document.getElementById("cancelDateTime").style.display = 'inline-block';
                });

                $('#cancelDateTime').click(function(){
                    document.getElementById('datetime').value = "";
                    $('#datetime').prop("readonly",true);
                    document.getElementById("changeDateTime").style.display = 'inline-block';
                    document.getElementById("saveDateTime").style.display = 'none';
                    document.getElementById("cancelDateTime").style.display = 'none';
                });

                $('#saveDateTime').click(function(){
                    var error_datetime = '';
                    if($('#datetime').val()==''){
                        error_datetime = 'Please select a date first';
                        $('#error_datetime').text(error_datetime).css("display", "inline").fadeOut(4000);
                    }else{
                        error_datetime = '';
                        $('#error_datetime').text(error_datetime);
                    }

                    if(error_datetime != ''){
                        return false;
                    }else{
                        var datetime = $('#datetime').val();
                        var id = <?php echo $id;?>;

                        $.ajax({
                            url: "changeDate.php",
                            method: "POST",
                            data: {id:id,datetime:datetime},
                            dataType: "text",
                            success: function(data){
                                alert("Successfully Updated!");
                                document.getElementById('datetime').value = "";
                                $('#datetime').prop("readonly",true);
                                document.getElementById("changeDateTime").style.display = 'inline-block';
                                document.getElementById("saveDateTime").style.display = 'none';
                                document.getElementById("cancelDateTime").style.display = 'none';
                                location.href='trainingPrograms.php?id='+id+'';
                            }
                        })
                    }
                });

            });
            var ids = [];
            var progs = [];

            //User selecting part

            function Selection(checking){
                
                if(checking.checked){
                    
                    if(checking.value!="All"){
                        ids.push(checking.value);
                        load_data(ids);
                    }else if(checking.value=="All"){

                        var check = document.getElementsByName('userCheck');
                        for(var i = 1;i<check.length;i++){
                            if(check[i].checked == false){
                                check[i].checked = true;
                                ids.push(check[i].value);
                            }
                        }
                        load_data(ids);
                        
                    }
                }else{
                    if(checking.value!="All"){
                        var check = document.getElementsByName('userCheck');
                        if(check[0].checked == true){
                            check[0].checked = false;
                        }
                        var pos = ids.indexOf(checking.value);
                        ids.splice(pos, 1);
                        load_data(ids);
                    }else if(checking.value=="All"){
                        var check = document.getElementsByName('userCheck');
                        for(var i = 1;i<check.length;i++){
                            if(check[i].checked == true){
                                var pos = ids.indexOf(check[i].value);
                                ids.splice(pos, 1);
                                check[i].checked = false;
                            }
                        }
                        load_data(ids);
                    }
                }
            }

            //end of user selecting part

            //program selecting part

            function progSelection(checking){

                if(checking.checked){
                    if(checking.value!="All"){
                        progs.push(checking.value);
                    }else if(checking.value=="All"){

                        var check = document.getElementsByName('progCheck');
                        for(var i = 2;i<check.length;i++){
                            if(check[i].checked == false){
                                check[i].checked = true;
                                progs.push(check[i].value);
                            }
                        }
                        //load_data(ids);
                        
                    }
                }else{
                    if(checking.value!="All"){
                        var check = document.getElementsByName('progCheck');
                        if(check[1].checked == true&checking.value!="newProg"){
                            check[1].checked = false;
                        }
                        var pos = progs.indexOf(checking.value);
                        progs.splice(pos, 1);
                        
                    }else if(checking.value=="All"){
                        var check = document.getElementsByName('progCheck');
                        for(var i = 2;i<check.length;i++){
                            if(check[i].checked == true){
                                var pos = progs.indexOf(check[i].value);
                                progs.splice(pos, 1);
                                check[i].checked = false;
                            }
                        }
                        
                    }
                }
            }

            //end of program selecting part

            $('#changeDateTime2').click(function(){
                $('#datetime2').prop("readonly", false);
                document.getElementById("changeDateTime2").style.display = 'none';
                document.getElementById("saveDateTime2").style.display = 'inline-block';
                document.getElementById("cancelDateTime2").style.display = 'inline-block';
            });

            $('#cancelDateTime2').click(function(){
                document.getElementById('datetime2').value = "";
                $('#datetime2').prop("readonly",true);
                document.getElementById("changeDateTime2").style.display = 'inline-block';
                document.getElementById("saveDateTime2").style.display = 'none';
                document.getElementById("cancelDateTime2").style.display = 'none';
            });

            $('#finalize').click(function(){
                location.href='exportExcell.php?id=<?php echo   $id; ?>';
                setInterval(function(){location.href='Dashboard.php'},1000);
            });

            function load_data(ids){
                
                $.ajax({
                    url:"loadProg.php",
                    method:"POST",
                    data:{ids:ids},
                    success:function(data){
                        $('#resultTable').html(data);
                    }
                });

            }


            $('#saveDateTime2').click(function(){
                
                var error_datetime2 = '';

                if(ids.length == 0){
                    error_datetime2 = 'Please select required fields';
                    $('#error_datetime2').text(error_datetime2).css("display", "inline").fadeOut(8000);
                }else if(progs.length == 0){
                    error_datetime2 = 'Please select required fields';
                    $('#error_datetime2').text(error_datetime2).css("display", "inline").fadeOut(8000);
                }else if($('#datetime2').val()==''){
                    error_datetime2 = 'Please select a date';
                    $('#error_datetime2').text(error_datetime2).css("display", "inline").fadeOut(4000);
                }else{
                    error_datetime2 = '';
                    $('#error_datetime2').text(error_datetime2);
                }

                if(error_datetime2 != ''){
                    return false;
                }else{
                    
                    var datetime2 = $('#datetime2').val();
                    var id = <?php echo $id;?>;
                    
                    $.ajax({
                    
                        url: "changeAccess.php",
                        method: "POST",
                        data: {ids:ids,progs:progs,datetime2:datetime2},
                        
                        success: function(data){
                            alert("Successfully Updated!");
                            
                            location.href='trainingPrograms.php?id='+id+'';
                        }
                        
                    })
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
