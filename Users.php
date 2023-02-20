<?php

    include("database.php");

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

    if(isset($_POST['NewUser'])){

        session_start();
        $_SESSION["username"] = $user;
        header("location: addUser.php");

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
                                <a href="myProfile.php" class="text-white" >
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
                                current"><i 
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
                                    text-uppercase mb-0">Users</h4>
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

            $queryUsers = "SELECT * FROM user WHERE idUser != '".$userId['idUser']."' ORDER BY idUser DESC";
            $queryCountUser = "SELECT COUNT(*) AS tot FROM user WHERE idUser != '".$userId['idUser']."'";

            $usersArray = mysqli_query($conn,$queryUsers) or die(mysqli_error($conn));
            $usersCount = mysqli_query($conn,$queryCountUser) or die(mysqli_error($conn));

            $count = mysqli_fetch_array($usersCount);

        ?>

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-10 col-lg-9 col-md-9 ml-auto">
                        <div class="row pt-md-5 mt-md-3 pt-xs-5 mt-xs-3">
                            <div class="col-xl-12 col-sm-12">
                                <div class="card card-common">
                                    <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-6 col-sm-5 col-4">
                                            <form action="Users.php" method="POST">
                                                <button class="button btn btn-info" type="submit" name="NewUser">
                                                    <i class="fa fa-plus mr-4" aria-hidden="true"></i>Add New User
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-xl-2 col-sm-1 col-1">

                                        </div>
                                        <div class="col-xl-4 col-sm-6 col-7 d-flex justify-content-between align-items-center">
                                            <span class="float-left">Number of Users</span>
                                            <span class="float-right mr-5" style="font-size: 15pt; vertical-align: middle">
                                            <?php
                                                echo    $count['tot'];
                                            ?>
                                            </span>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-md-2 pt-md-2 pt-sm-2 mt-sm-2 pt-2 mt-2">
                            <div class="col-xl-12 col-sm-12">
                                <div class="card card-common" style="width: 100%;">
                                    <div class="card-body">
                                        <div class="panel-body divbody d-flex" style="height:200px; width:100%; overflow: auto; overflow-x: hidden;">
                                            <table class="table table-striped table-bordered" style="width:100%;">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Division</th>
                                                    <th>View</th>
                                                </tr>
                                                <?php
                                                    
                                                    while($users = mysqli_fetch_array($usersArray)){
                                                        $queryGetRole = "SELECT role FROM logdetail WHERE idUser= '".$users['idUser']."'";
                                                        $roleArray = mysqli_query($conn,$queryGetRole) or die(mysqli_error($conn));
                                                        $role = mysqli_fetch_array($roleArray);
                                                        echo                        '<tr>';
                                                        echo                        '<td>'.$users['fName'].' '.$users['lName'].'<input type="hidden" name="fname'.$users['idUser'].'" id="fname'.$users['idUser'].'" value="'.$users['fName'].'"/><input type="hidden" name="lname'.$users['idUser'].'" id="lname'.$users['idUser'].'" value="'.$users['lName'].'"/><input type="hidden" name="role'.$users['idUser'].'" id="role'.$users['idUser'].'" value="'.$users['role'].'"/></td>';
                                                        echo                        '<td>'.$users['Department'].'<input type="hidden" name="division'.$users['idUser'].'" id="division'.$users['idUser'].'" value="'.$users['Department'].'"/><input type="hidden" name="unit'.$users['idUser'].'" id="unit'.$users['idUser'].'" value="'.$users['unit'].'"/><input type="hidden" name="empid'.$users['idUser'].'" id="empid'.$users['idUser'].'" value="'.$users['empID'].'"/><input type="hidden" name="email'.$users['idUser'].'" id="email'.$users['idUser'].'" value="'.$users['email'].'"/></td>';                                                        
                                                        echo                        '<td><button type="button" name="viewUser" class="btn btn-group btn-info viewUser" style="padding: .25rem .4rem; font-size: .875rem; line-height: .95; border-radius: .2rem;" id="'.$users['idUser'].'">View</button></td>';
                                                        echo                        '</tr>';
                                                    }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-md-2 pt-md-2 pt-sm-2 mt-sm-2 pt-2 mt-2 mb-2">
                            <div class="col-xl-12 col-sm-12">
                                <div class="card card-common" id="info">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-2">
                                            
                                            </div>
                                            <div class="col-8">
                                                <form action="" method="POST" style="width:100%;" class=" justify-content-between align-items-center" id="editUser">
                                                    <div class="row form-group">
                                                        <div class="col-4 d-flex justify-content-between align-items-center">
                                                            First Name :
                                                        </div>
                                                        <div class="col-8 d-flex justify-content-between align-items-center">
                                                            <input type="text" style="width:100%;" name="userFName" id="userFName" class="form-control" readonly/>
                                                            <small><span id="error_userFName" class="text-danger"></span></small>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-4 d-flex justify-content-between align-items-center">
                                                            Last Name :
                                                        </div>
                                                        <div class="col-8 d-flex justify-content-between align-items-center">
                                                            <input type="text" style="width:100%;" name="userLName" id="userLName" class="form-control" readonly/>
                                                            <small><span id="error_userLName" class="text-danger"></span></small>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-4 d-flex justify-content-between align-items-center">
                                                            Role :
                                                        </div>
                                                        <div class="col-8 d-flex justify-content-between align-items-center">
                                                        <select class="form-control"  name="userRole" id="userRole"  style="width:50%;" disabled>                                            
                                                                <option></option>
                                                                <option>Admin</option>
                                                                <option>User</option>
                                                                <option>GTD</option>
                                                                <option>CXO-1</option>
                                                                <option>GCTO</option>
                                                                <option>GCEO</option>
                                                                <option>Training HR</option>
                                                                <option>HR Supervisor</option>
                                                                <option>HR Partner</option>
                                                            </select>
                                                            <small><span id="error_userRole" class="text-danger"></span></small>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-4 d-flex justify-content-between align-items-center">
                                                            Division :
                                                        </div>
                                                        <div class="col-8 d-flex justify-content-between align-items-center">
                                                            <select class="form-control"  name="userDivision" id="userDivision"  style="width:50%;" disabled>                                            
                                                                <option></option>
                                                                <?php
                                                                    $queryDivision = "SELECT * FROM divisions";
                                                                    $divisionArray = mysqli_query($conn,$queryDivision) or die(mysqli_error($conn));
                                                                    while($divisions = mysqli_fetch_array($divisionArray)){
                                                                ?>
                                                                    <option><?php   echo    $divisions['divitionName'];   ?></option>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                            <small><span id="error_userDivision" class="text-danger"></span></small>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-4 d-flex justify-content-between align-items-center">
                                                            Unit :
                                                        </div>
                                                        <div class="col-8 d-flex justify-content-between align-items-center">
                                                            <input type="text" style="width:50%;" name="unit" id="unit" class="form-control" readonly/>
                                                            <small><span id="error_unit" class="text-danger"></span></small>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-4 d-flex justify-content-between align-items-center">
                                                            Employee ID :
                                                        </div>
                                                        <div class="col-8 d-flex justify-content-between align-items-center">
                                                            <input type="text" style="width:50%;" name="userEMPID" id="userEMPID" class="form-control" readonly/>
                                                            <small><span id="error_userEMPID" class="text-danger"></span></small>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-4 d-flex justify-content-between align-items-center">
                                                            E-mail :
                                                        </div>
                                                        <div class="col-8 d-flex justify-content-between align-items-center">
                                                            <input type="text" style="width:100%;" name="userEmail" id="userEmail" class="form-control" readonly/>
                                                            <small><span id="error_userEmail" class="text-danger"></span></small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-9 d-flex justify-content-between align-items-center">
                                                        </div>
                                                        <div class="col-3 d-flex justify-content-between align-items-center">
                                                            <button type="button" name="edit_user" id="edit_user" style="display:none;" class="btn btn-info btn-sm">Edit</button>
                                                                                    
                                                            <button type="button" name="save_user" id="save_user" style="display:none;" class="btn btn-info btn-sm">Save</button>
                                                            
                                                            <button type="button" name="cancel_user" id="cancel_user" style="display:none;" class="btn btn-danger btn-sm">Cancel</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-2">
                                        
                                            </div>
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
                
                
                
                $(document).on('click', '.dropdown-toggle', function(){
                //$('.count').html('');
                load_unseen_notification('yes');
                });
                
                setInterval(function(){ 
                load_unseen_notification();; 
                }, 5000);

                var uid = "";
                var fName = "";
                var lName = "";
                var division = "";
                var unit = "";
                var empID = "";
                var role = "";
                var email = "";

                $(document).on('click', '.viewUser', function(){

                    document.getElementById('info').scrollIntoView();

                    var id = $(this).attr("id");
                    uid = id;
                    document.getElementById('userFName').value=$('#fname'+id+'').val();
                    document.getElementById('userLName').value=$('#lname'+id+'').val();
                    document.getElementById('userDivision').value=$('#division'+id+'').val();
                    document.getElementById('unit').value=$('#unit'+id+'').val();
                    document.getElementById('userEMPID').value=$('#empid'+id+'').val();
                    document.getElementById('userEmail').value=$('#email'+id+'').val();
                    document.getElementById('userRole').value=$('#role'+id+'').val();

                    document.getElementById("edit_user").style.display='block';
                    
                });

                $('#edit_user').click(function(){
                    document.getElementById("edit_user").style.display='none';
                    document.getElementById("save_user").style.display='block';
                    document.getElementById("cancel_user").style.display='block';

                    $('#userFName').prop("readonly", false);
                    $('#userLName').prop("readonly", false);
                    $('#userDivision').prop("disabled", false);
                    $('#unit').prop("readonly", false);
                    $('#userEMPID').prop("readonly", false);
                    $('#userEmail').prop("readonly", false);
                    $('#userRole').prop("disabled", false);

                    fName = $('#userFName').val();
                    lName = $('#userLName').val();
                    division = $('#userDivision').val();
                    unit = $('#unit').val();
                    empID = $('#userEMPID').val();
                    email = $('#userEmail').val();
                    role = $('#userRole').val();
                });

                $('#cancel_user').click(function(){
                    document.getElementById("edit_user").style.display='block';
                    document.getElementById("save_user").style.display='none';
                    document.getElementById("cancel_user").style.display='none';

                    $('#userFName').prop("readonly", true);
                    $('#userLName').prop("readonly", true);
                    $('#userDivision').prop("disabled", true);
                    $('#unit').prop("readonly", true);
                    $('#userEMPID').prop("readonly", true);
                    $('#userEmail').prop("readonly", true);
                    $('#userRole').prop("disabled", true);

                    document.getElementById('userFName').value = fName;
                    document.getElementById('userLName').value = lName;
                    document.getElementById('userDivision').value = division;
                    document.getElementById('unit').value = unit;
                    document.getElementById('userEMPID').value = empID;
                    document.getElementById('userEmail').value = email;
                    document.getElementById('userRole').value = role;
                });

                $('#save_user').click(function(){
                    var errorFName = "";
                    var errorLName = "";
                    var errorDivision = "";
                    var errorUnit = "";
                    var errorEMPID = "";
                    var errorEmail = "";
                    var errorRole = "";

                    if($.trim($('#userFName').val()).length == 0){
                        errorFName = 'First Name is Required';
                        $('#error_userFName').text(errorFName);
                        $('#error_userFName').css("display", "inline").fadeOut(2000);
                    }else{
                        errorFName = '';
                        $('#error_userFName').text(errorFName);
                    }

                    if($.trim($('#userLName').val()).length == 0){
                        errorLName = 'Last Name is Required';
                        $('#error_userLName').text(errorLName);
                        $('#error_userLName').css("display", "inline").fadeOut(2000);
                    }else{
                        errorLName = '';
                        $('#error_userLName').text(errorLName);
                    }

                    if($.trim($('#userDivision').val())== ''){
                        errorDivision = 'Division is Required';
                        $('#error_userDivision').text(errorDivision);
                        $('#error_userDivision').css("display", "inline").fadeOut(2000);
                    }else{
                        errorDivision = '';
                        $('#error_userDivision').text(errorDivision);
                    }

                    if($.trim($('#unit').val()).length == 0){
                        errorEMPID = 'Unit is Required';
                        $('#error_unit').text(errorUnit);
                        $('#error_unit').css("display", "inline").fadeOut(2000);
                    }else{
                        errorUnit = '';
                        $('#error_unit').text(errorUnit);
                    }

                    if($.trim($('#userEMPID').val()).length == 0){
                        errorEMPID = 'Employee ID is Required';
                        $('#error_userEMPID').text(errorEMPID);
                        $('#error_userEMPID').css("display", "inline").fadeOut(2000);
                    }else{
                        errorEMPID = '';
                        $('#error_userEMPID').text(errorEMPID);
                    }

                    if($.trim($('#userEmail').val()).length == 0){
                        errorEmail = 'Email is Required';
                        $('#error_userEmail').text(errorEmail);
                        $('#error_userEmail').css("display", "inline").fadeOut(2000);
                    }else{
                        errorEmail = '';
                        $('#error_userEmail').text(errorEmail);
                    }

                    if($.trim($('#userRole').val()) == ''){
                        errorRole = 'Role is Required';
                        $('#error_userRole').text(errorRole);
                        $('#error_userRole').css("display", "inline").fadeOut(2000);
                    }else{
                        errorRole = '';
                        $('#error_userRole').text(errorRole);
                    }

                    if(errorFName != '' || errorLName != '' || errorDivision != '' || errorUnit != '' || errorEMPID != '' || errorEmail != '' || errorRole != ''){
                        return false;
                    }else{
                        
                        fName = $('#userFName').val();
                        lName = $('#userLName').val();
                        division = $('#userDivision').val();
                        unit = $('#unit').val();
                        empID = $('#userEMPID').val();
                        email = $('#userEmail').val();
                        role = $('#userRole').val();

                        $.ajax({
                            url: "editUser.php",
                            method: "POST",
                            data: {uid:uid,fName:fName,lName:lName,division:division,unit:unit,empID:empID,email:email,role:role},
                            dataType: "text",
                            success: function(data){
                                alert("Successfully Updated!");
                                $("#editUser").submit();
                            }
                        })
                    }
                });
                
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
