<?php

    include("database.php");

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

    if(isset($_POST['viewShedule'])){
        session_start();
        $_SESSION["username"] = $user;
        header("location: trainingPrograms.php?id=".$_POST['idSheduleProgram']."");
    }

    if(isset($_POST['Logout'])){

        session_destroy();
        unset($_SESSION["username"]);
        header("location: Login.php");

    }

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
                        <div class="col-xl-2 col-lg-3 col-md-4 sidebar fixed-top">
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
                                current"><i 
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
                    <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <?php
                        echo    '<div class="row pt-md-5 mt-md-2 mb-auto">';
                            

                                date_default_timezone_set("Asia/Colombo");

                                $queryShedule = "SELECT * FROM sheduleprogram WHERE status= '0'";
                                $sheduleArray = mysqli_query($conn,$queryShedule) or die(mysqli_error($conn));
                                $check = mysqli_num_rows($sheduleArray);
                                $shedule = mysqli_fetch_array($sheduleArray);

                                $value = $shedule['enddate'];
                                $datetime = new DateTime($value);                            

                                $now = new DateTime();

                                $interval = $datetime->diff($now);

                                if($check !=0){

                                    echo    '<div class="col-xl-4 col-sm-4 p-2">';
                                    echo        '<div class="card card-common">';
                                    echo            '<div class="card-body">';
                                    echo                '<div class="d-flex justify-content-between">';
                                    echo                    '<i class="fas fa-info text-info"></i>';                                                    
                                    echo                    '<div class="text-right text-secondary">';
                                    echo                        '<h6 class="mb-1"><small>'.$shedule['remark'].'</small></h6>';
                                    echo                    '</div>';
                                    echo                '</div>';
                                    echo                '<div class="row">';    
                                    echo                '<div class="col">';                                        
                                    
                                    echo                    '<div class="card-programe pt-2 px-2 d-flex justify-content-between align-items-center">';
                                    echo                        '<span class="float-left"><small><small>Due Date : </small></small></span>';
                                    echo                        '<span class="float-right " style=" vertical-align: middle"><small><small>';
                                    echo                            $datetime->format("l, d F Y, h:i A");
                                    echo                        '</small></small></span>';
                                    echo                    '</div>';
                                    echo                    '<div class="card-programe pt-2 px-2 d-flex justify-content-between align-items-center">';
                                    if($datetime>$now){
                                        echo                        '<span class="float-left"><small><small>Remaining Time : </small></small></span>';
                                        echo                        '<span class="float-right" style=" vertical-align: middle"><small><small>';
                                    }else{
                                        echo                        '<span class="float-left text-danger"><small><small>Overdue by : </small></small></span>';
                                        echo                        '<span class="float-right text-danger" style=" vertical-align: middle"><small><small>';
                                    }
                                                                    if(($interval->format("%a"))>0){

                                                                        echo $interval->format("%a day(s), %h hour(s)");

                                                                    }else if(($interval->format("%h"))>0){

                                                                        echo $interval->format("%h hour(s), %i minute(s)");

                                                                    }else if(($interval->format("%i"))>0){

                                                                        echo $interval->format("%i minute(s), %s second(s)");

                                                                    }else{

                                                                        echo $interval->format("%s second(s)");

                                                                    }
                                    echo                        '</small></small></span>';
                                    echo                    '</div>';


                                                                                
                                    echo                '</div>';
                                    echo                '</div>';
                                    echo                '<div class="row">';                                    
                                    echo                    '<div class="col">';                                    
                                    echo                        '<div align="right">';
                                    echo                            '<form action="" method="POST">';
                                    echo                                '<button type="sumbit" name="viewShedule" id="viewShedule" class="btn btn-info btn-sm mt-3 mr-auto">View</button>';
                                    echo                                '<input type="hidden" name="idSheduleProgram" id="idSheduleProgram" value="'.$shedule['id'].'"/>';
                                    echo                            '</form>';
                                    echo                        '</div>';
                                    echo                    '</div>';
                                    echo                '</div>';
                                    echo            '</div>';
                                    echo        '</div>';
                                    echo    '</div>';

                                

                            

                                    echo    '<div class="col-xl-4 col-sm-4 p-2">';
                                    echo        '<div class="card card-common" style="height:176px">';
                                    echo            '<div class="card-body">';
                                    echo                '<div class="d-flex justify-content-between">';
                                    echo                '<i class="fas fa-info text-info"></i>';
                                    echo                    '<div class="text-right text-secondary">';

                                                    $remark = $shedule['remark'];
                                                    $queryTotalProgram = "SELECT COUNT(*) AS tot FROM program WHERE remark = '$remark'";
                                                    $totalProgramArray = mysqli_query($conn,$queryTotalProgram) or die(mysqli_error($conn));
                                                    $totalProgram = mysqli_fetch_array($totalProgramArray);
                                                
                                    echo                        '<h6 class="mb-1"><small>Total Number of Programs - '.$totalProgram['tot'].'</small></h6>';
                                    echo                    '</div>';
                                    echo                '</div>';
                                    echo                '<div class="row my-3">';
                                    echo                    '<div class="col">';
                                    echo                        '<div class="card-programe pt-2 px-2 d-flex justify-content-between align-items-center">';
                                    echo                            '<span class="float-left"><small><small>Foriegn : </small></small></span>';
                                                    
                                                        $queryForiegnProgram = "SELECT COUNT(*) AS totf FROM program WHERE typ = 'Foriegn' AND remark='$remark'";
                                                        $foriegnProgramArray = mysqli_query($conn,$queryForiegnProgram) or die(mysqli_error($conn));
                                                        $foriegnProgram = mysqli_fetch_array($foriegnProgramArray);
                                                    
                                    echo                            '<span class="float-right " style=" vertical-align: middle"><small><small>'.$foriegnProgram['totf'].'</small></small></span>';
                                    echo                        '</div>';
                                    echo                    '</div>';
                                    echo                    '<div class="col">';
                                    echo                        '<div class="card-programe pt-2 px-2 d-flex justify-content-between align-items-center">';
                                    echo                            '<span class="float-left"><small><small>Local : </small></small></span>';
                                                    
                                                        $queryLocalProgram = "SELECT COUNT(*) AS totl FROM program WHERE typ = 'Local' AND remark='$remark'";
                                                        $localProgramArray = mysqli_query($conn,$queryLocalProgram) or die(mysqli_error($conn));
                                                        $localProgram = mysqli_fetch_array($localProgramArray);
                                                    
                                    echo                            '<span class="float-right " style=" vertical-align: middle"><small><small>'.$localProgram['totl'].'</small></small></span>';
                                    echo                        '</div>';
                                    echo                    '</div>';
                                    echo                '</div>';
                                    echo                '<div class="row">';
                                    echo                    '<div class="col">';
                                    echo                        '<div class="card-programe pt-2 px-2 d-flex justify-content-between align-items-center">';
                                    echo                            '<span class="float-left"><small><small>Online : </small></small></span>';
                                                    
                                                        $queryOnlineProgram = "SELECT COUNT(*) AS toto FROM program WHERE typ = 'Online' AND remark='$remark'";
                                                        $onlineProgramArray = mysqli_query($conn,$queryOnlineProgram) or die(mysqli_error($conn));
                                                        $onlineProgram = mysqli_fetch_array($onlineProgramArray);
                                                    
                                    echo                            '<span class="float-right " style=" vertical-align: middle"><small><small>'.$onlineProgram['toto'].'</small></small></span>';
                                    echo                        '</div>';
                                    echo                    '</div>';
                                    echo                    '<div class="col">';
                                    echo                        '<div class="card-programe pt-2 px-2 d-flex justify-content-between align-items-center">';
                                    echo                            '<span class="float-left"><small><small>Internal : </small></small></span>';
                                                    
                                                        $queryInternalProgram = "SELECT COUNT(*) AS toti FROM program WHERE typ = 'Internal' AND remark='$remark'";
                                                        $internalProgramArray = mysqli_query($conn,$queryInternalProgram) or die(mysqli_error($conn));
                                                        $internalProgram = mysqli_fetch_array($internalProgramArray);
                                                    
                                    echo                            '<span class="float-right " style=" vertical-align: middle"><small><small>'.$internalProgram['toti'].'</small></small></span>';
                                    echo                        '</div>';
                                    echo                    '</div>';
                                    echo                '</div>';
                                    echo            '</div>';
                                    echo        '</div>';
                                    echo    '</div>';
                                    echo    '<div class="col-xl-4 col-sm-4 p-2">';
                                    echo        '<div class="card card-common" style="height:176px">';
                                    echo            '<div class="card-body">';
                                    echo                '<div class="d-flex justify-content-between">';
                                    echo                    '<i class="fas fa-info text-info"></i>';
                                    echo                    '<div class="text-right text-secondary">';
                                    echo                        '<h6 class="mb-1"><small>Number of Programs for each Division</small></h6>';
                                    echo                    '</div>';
                                    echo                '</div>';
                                    echo                '<div class="row">';
                                    echo                    '<div class="col" style="height:115px; width:100%; overflow: auto; overflow-x: hidden;">';

                                    $queryDepartment = "SELECT Department FROM user WHERE role = 'User' AND Department != 'Excecitive Board' group by Department";
                                    $queryDepartmentArray = mysqli_query($conn,$queryDepartment) or die(mysqli_error($conn));
                                    while($department = mysqli_fetch_array($queryDepartmentArray)){

                                    echo                        '<div class="row">';
                                    echo                            '<div class="col">';
                                    echo                                '<div class="card-programe pt-2 px-2 d-flex justify-content-between align-items-center">';
                                    echo                                    '<span class="float-left"><small><small>'.$department['Department'].' : </small></small></span>';

                                        $count = "SELECT COUNT(*) AS count FROM program WHERE remark = '".$shedule['remark']."' AND idProgram IN (SELECT idProgram FROM program_has_user WHERE idUser IN (SELECT idUser FROM user WHERE Department = '".$department['Department']."'))";
                                        $countArray = mysqli_query($conn,$count) or die(mysqli_error($conn));
                                        $countDepartment = mysqli_fetch_array($countArray);
                                    echo                                    '<span class="float-right " style=" vertical-align: middle"><small><small>'.$countDepartment['count'].'</small></small></span>';
                                    echo                                '</div>';
                                    echo                            '</div>';
                                    echo                        '</div>';

                                    }
                                    echo                    '</div>';
                                    echo                '</div>';
                                    echo            '</div>';
                                    echo        '</div>';
                                    echo    '</div>';
                                }
                            
                            

                        echo    '</div>';
                        if($check !=0){
                        echo    '<div class="row">';
                        echo        '<div class="col-xl-12 col-sm-12 p-2">';
                        echo            '<div class="card card-common">';
                        echo                '<div class="card-body">';
                        echo                    '<div class="d-flex justify-content-between">';
                        echo                        '<i class="text-info fas fa-tasks fa-lg"></i>';
                        echo                        '<div class="text-right text-secondary">';
                        echo                            '<h5 class="mb-4">Programs</h5>';
                        echo                        '</div>';
                        echo                    '</div>';
                        echo                    '<small>';   
                        echo                    '<table id="programs" class="display" style="width:100%">';
                        echo                        '<thead>';
                        echo                            '<tr>';
                        echo                                '<th><small>Program Name</small></th>';
                        echo                                '<th><small>Trainer/Supp.</small></th>';
                        echo                                '<th><small>Type</small></th>';
                        echo                                '<th><small>Priority</small></th>';
                        echo                                '<th><small>Slots</small></th>';
                        echo                                '<th><small>Date Added</small></th>';
                        echo                                '<th><small>Modules</small></th>';
                        echo                                '<th><small>Nominees</small></th>';
                        echo                                '<th><small>Added Person</small></th>';
                        echo                                '<th><small>Division</small></th>';
                        echo                            '</tr>';
                        echo                        '</thead>';
                        echo                        '<tbody>';
                                                
                                                    
                                                    $queryProgram = "SELECT * FROM program WHERE remark='$remark'";
                                                    $programArray = mysqli_query($conn,$queryProgram) or die(mysqli_error($conn));

                                                    while($program = mysqli_fetch_array($programArray)){
                                                        echo    '<tr>';
                                                        echo        '<td><small>'.$program['ProgName'].'</small></td>';
                                                        echo        '<td><small>'.$program['trasup'].'</small></td>';
                                                        echo        '<td><small>'.$program['typ'].'</small></td>';
                                                        echo        '<td><small>'.$program['prio'].'</small></td>';
                                                        echo        '<td><small>'.$program['slot'].'</small></td>';

                                                        $queryProgDetails = "SELECT * FROM program_has_user WHERE idProgram = '".$program['idProgram']."'";
                                                        $progDetailsArray = mysqli_query($conn,$queryProgDetails) or die(mysqli_error($conn));
                                                        $programDetails = mysqli_fetch_array($progDetailsArray);
                                                        echo        '<td><small>'.$programDetails['Dt'].'</small></td>';

                                                        $queryCountModule = "SELECT COUNT(idModule) AS totMod FROM user_program_module WHERE idProgram = '".$program['idProgram']."'";
                                                        $countModuleArray = mysqli_query($conn,$queryCountModule) or die(mysqli_error($conn));
                                                        $counrModule = mysqli_fetch_array($countModuleArray);
                                                        echo        '<td><small>'.$counrModule['totMod'].'</small></td>';

                                                        $queryCountNominee = "SELECT COUNT(idNominee) AS totNom FROM nominee WHERE idProgram = '".$program['idProgram']."'";
                                                        $countNomineeArray = mysqli_query($conn,$queryCountNominee) or die(mysqli_error($conn));
                                                        $counrNominee = mysqli_fetch_array($countNomineeArray);
                                                        echo        '<td><small>'.$counrNominee['totNom'].'</small></td>';

                                                        $queryUserDetails = "SELECT * FROM user WHERE idUser = '".$programDetails['idUser']."'";
                                                        $userDetailsArray = mysqli_query($conn,$queryUserDetails) or die(mysqli_error($conn));
                                                        $userDetails = mysqli_fetch_array($userDetailsArray);
                                                        echo        '<td><small>'.$userDetails['fName'].'</small></td>';
                                                        echo        '<td><small>'.$userDetails['Department'].'</small></td>';
                                                        echo    '</tr>';                                            
                                                    }
                                                    

                                                
                        echo                        '</tbody>';
                        echo                        '<tfoot>';
                        echo                            '<tr>';
                        echo                                '<th><small>Program Name</small></th>';
                        echo                                '<th><small>Trainer/Supp.</small></th>';
                        echo                                '<th><small>Type</small></th>';
                        echo                                '<th><small>Priority</small></th>';
                        echo                                '<th><small>Slots</small></th>';
                        echo                                '<th><small>Date Added</small></th>';
                        echo                                '<th><small>Modules</small></th>';
                        echo                                '<th><small>Nominees</small></th>';
                        echo                                '<th><small>Added Person</small></th>';
                        echo                                '<th><small>Division</small></th>';
                        echo                            '</tr>';
                        echo                        '</tfoot>';
                        echo                    '</table>'; 
                        echo                    '</small>';                                       
                        echo                '</div>';
                        echo            '</div>';
                        echo        '</div>';
                        echo    '</div>';
                        }else{
                        echo    '<div class="row pt-md-5 mt-md-2 mb-auto">';
                        echo        '<div class="col-xl-1 col-sm-0 p-2">';
                        echo        '</div>';

                        echo        '<div class="col-xl-10 col-sm-12 p-2">';
                        echo            '<div class="card card-common" style="width:100%;">';
                        echo                '<div class="card-body" style="width:100%;">';
                        echo                    '<div class="d-flex justify-content-between" style="width:100%;" align="center;">';
                        echo                        '<i class="text-info fas fa-tasks fa-lg"></i>';
                        echo                        '<div class="text-right text-secondary">';
                        echo                            '<h6 class="mb-1">Shedule New Program</h6>';
                        echo                        '</div>';
                        echo                    '</div>';
                        //echo                    '<form class="form" action="" method="POST">';
                        echo                    '<div class="row">';
                        echo                        '<div class="col">';
                        
                        echo                                '<div class="row form-group mt-4 mx-2">';
                        echo                                    '<div class="col-4 d-flex justify-content-between align-items-center">';
                        echo                                        'Program Title* :';
                        echo                                    '</div>';
                        echo                                    '<div class="col-8 d-flex justify-content-between align-items-center">';
                        echo                                        '<input type="text" style="width:100%;" name="progTitle" id="progTitle" class="form-control"/>';
                        //echo                                        '<small><span id="error_progTitle" class="text-danger"></span></small>';
                        echo                                    '</div>';
                        echo                                '</div>';
                        echo                                '<div class="row form-group mt-4 mx-2">';
                        echo                                    '<div class="col-4 d-flex justify-content-between align-items-center">';
                        echo                                        'End Date* :';
                        echo                                    '</div>';
                        echo                                    '<div class="col-8 d-flex justify-content-between align-items-center">';
                        echo                                        '<input type="datetime-local" style="width:50%;" name="progEndDate" id="progEndDate" class="form-control"/>';
                        //echo                                        '<small><span id="error_progEndDate" class="text-danger"></span></small>';
                        echo                                    '</div>';
                        echo                                '</div>';
                        
                        echo                        '</div>';
                        echo                    '</div>';
                        echo                    '<div class="row mt-2">';
                        echo                        '<div class="col">';
                        echo                            '<div align="center" class="panel-heading p-2">';
                        echo                                'Added Users';
                        echo                            '</div>';
                        echo                            '<small><div class="panel-body divbody d-flex" style="height:200px; width:100%; overflow: auto; overflow-x: hidden;">';
                        echo                                '<table class="table table-striped table-bordered"  style="width:100%;">';
                        echo                                    '<thead>';
                        echo                                        '<tr>';
                        echo                                            '<th style="width:50%">Name</th>';
                        echo                                            '<th style="width:30%">Division</th>';
                        echo                                            '<th style="width:20%">Remove</th>';
                        echo                                        '</tr>';
                        echo                                    '</thead>';
                        echo                                    '<tbody id="userAddedTable">';
                                            //eliyen data enwa
                        echo                                    '</tbody>';
                        echo                                '</table>';
                        echo                            '</div></small>';
                        echo                        '</div>';
                        echo                    '</div>';
                        echo                    '<div class="row mt-2">';
                        echo                        '<div class="col">';
                        echo                            '<div align="center" class="panel-heading p-2">';
                        echo                                'Removeded Users';
                        echo                            '</div>';
                        echo                            '<small><div class="panel-body divbody d-flex" style="height:200px; width:100%; overflow: auto; overflow-x: hidden;">';
                        echo                                '<table class="table table-striped table-bordered"  style="width:100%;">';
                        echo                                    '<thead>';
                        echo                                        '<tr>';
                        echo                                            '<th style="width:50%">Name</th>';
                        echo                                            '<th style="width:30%">Division</th>';
                        echo                                            '<th style="width:20%">Add</th>';
                        echo                                        '</tr>';
                        echo                                    '</thead>';
                        echo                                    '<tbody id="userRemovedTable">';
                                            // eliyen data enwa
                        echo                                    '</tbody>';
                        echo                                '</table>';
                        echo                            '</div></small>';
                        echo                        '</div>';
                        echo                    '</div>';
                        echo                    '<div class="row mt-2">';
                        echo                        '<div class="col">';
                        echo                            '<div align="center" class="panel-heading p-2">';
                        echo                                'Email Details';                                
                        echo                            '</div>';
                        echo                            '<div class="row form-group mx-2">';
                        echo                                '<div class="col-4 d-flex justify-content-between align-items-center">';
                        echo                                    'Email Subject* :';
                        echo                                '</div>';
                        echo                                '<div class="col-8 d-flex justify-content-between align-items-center">';
                        echo                                    '<input type="text" style="width:100%;" name="emailSubject" id="emailSubject" class="form-control"/>';
                        //echo                                    '<small><span id="error_emailSubject" class="text-danger"></span></small>';
                        echo                                '</div>';
                        echo                            '</div>';
                        echo                            '<div class="row form-group mx-2">';
                        echo                                '<div class="col-4 d-flex justify-content-between align-items-center">';
                        echo                                    'Message* :';
                        echo                                '</div>';
                        echo                                '<div class="col-8 d-flex justify-content-between align-items-center">';
                        echo                                    '<textarea type="text" style="width:100%;" rows="4" name="emailMes" id="emailMes" class="form-control"></textarea>';
                        //echo                                    '<small><span id="error_emailMes" class="text-danger"></span></small>';
                        echo                                '</div>';
                        echo                            '</div>';
                        echo                        '</div>';                        
                        echo                    '</div>';
                        echo                    '<div class="row mt-2">';
                        echo                        '<div class="col">';
                        echo                            '<form class="form" id="proceed" action="" method="POST">';
                        echo                            '<div align="center" class="panel-heading p-2">';
                        echo                                '<small><span id="error" class="text-danger"></span></small>';
                        echo                            '</div>';
                        echo                            '<div align="center" class="panel-heading p-2">';                        
                        echo                                '<button type="button" name="makeProgram" id="makeProgram" class="btn btn-group btn-lg btn-success">Proceed</button>';
                        echo                            '</div>';
                        echo                            '</form>';
                        echo                        '</div>';
                        echo                    '</div>';
                        //echo                    '</form>';
                        echo                '</div>';
                        echo            '</div>';
                        echo        '</div>';

                        echo        '<div class="col-xl-1 col-sm-0 p-2">';
                        echo        '</div>';
                        echo    '</div>';
                        }
                    ?>
                        <!--methnt echo daann oni-->
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
                    if(data.unseen_notification > 0)
                    {
                    $('.count').html(data.unseen_notification);
                    }
                }
                });
                }
                
                load_unseen_notification();
                
                
                
                $(document).on('click', '.dropdown-toggle', function(){
                $('.count').html('');
                load_unseen_notification('yes');
                });
                
                setInterval(function(){ 
                load_unseen_notification();
                }, 5000);
                
            });

            $(document).ready(function() {
                $('#programs').DataTable( {
                    "scrollY":        "200px",
                    "scrollCollapse": true,
                    "paging":         false
                } );
            } );

            function removeUser(ids = 0){

                ids = ids.value;
                
                //alert(ids);
                $.ajax({
                    url:"loadAddedUsers.php",
                    method:"POST",
                    data:{ids:ids},
                    success:function(data){
                        $('#userAddedTable').html(data);
                    }
                });

            }

            function addUser(ids = 0){

                ids = ids.value;
                
                //alert(ids);
                $.ajax({
                    url:"loadRemovedUsers.php",
                    method:"POST",
                    data:{ids:ids},
                    success:function(data){
                        $('#userRemovedTable').html(data);
                    }
                });

            }
            removeUser();
            addUser();

            $('#makeProgram').click(function(){
                var error_progTitle = '';
                var error_progEndDate = '';
                var error_emailSubject = '';
                var error_emailMes = '';

                if($.trim($('#progTitle').val()).length == 0){

                    //document.getElementById('progTitle').scrollIntoView();
                    error_progTitle = 'Please fill all required field';
                    $('#error').text(error_progTitle);
                    $('#error').css("display", "inline").fadeOut(8000);
                    $('#progTitle').addClass('has-error');

                }else{
                    error_progTitle = '';
                    $('#error').text(error_progTitle);
                    $('#progTitle').removeClass('has-error');
                }

                if($.trim($('#progEndDate').val()) == ''){

                    //document.getElementById('progEndDate').scrollIntoView();
                    error_progEndDate = 'Please fill all required field';
                    $('#error').text(error_progEndDate);
                    $('#error').css("display", "inline").fadeOut(8000);
                    $('#progEndDate').addClass('has-error');

                }else{
                    error_progEndDate = '';
                    $('#error').text(error_progEndDate);
                    $('#progEndDate').removeClass('has-error');
                }

                if($.trim($('#emailSubject').val()) == ''){

                    //document.getElementById('progEndDate').scrollIntoView();
                    error_emailSubject = 'Please fill all required field';
                    $('#error').text(error_emailSubject);
                    $('#error').css("display", "inline").fadeOut(8000);
                    $('#emailSubject').addClass('has-error');

                }else{
                    error_emailSubject = '';
                    $('#error').text(error_emailSubject);
                    $('#emailSubject').removeClass('has-error');
                }

                if($.trim($('#emailMes').val()) == ''){

                    //document.getElementById('progEndDate').scrollIntoView();
                    error_emailMes = 'Please fill all required field';
                    $('#error').text(error_emailMes);
                    $('#error').css("display", "inline").fadeOut(8000);
                    $('#emailMes').addClass('has-error');

                }else{
                    error_emailMes = '';
                    $('#error').text(error_emailMes);
                    $('#emailMes').removeClass('has-error');
                }

                if(error_progTitle != '' || error_progEndDate != '' || error_emailSubject != '' || error_emailMes != ''){

                    return false;

                }else{

                    var title = $('#progTitle').val();
                    var endDt = $('#progEndDate').val();
                    var mailSub = $('#emailSubject').val();
                    var mes = $('#emailMes').val();
                    
                    $.ajax({
                        url:"proceedProgram.php",
                        method:"POST",
                        data:{title:title,endDt:endDt,mailSub:mailSub,mes:mes},
                        dataType: "text",
                        success:function(data){
                            location.href="Dashboard.php";
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
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

      </body>
</html>
