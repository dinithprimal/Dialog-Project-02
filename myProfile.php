<?php

    include("database.php");

    session_start();
    if(isset($_SESSION['username'])){

        $user = $_SESSION['username'];

        //$conn = mysqli_connect("localhost","root","","training");
        $sql = "SELECT idUser, Password, role FROM logdetail WHERE Username = '$user'";
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
                                    text-uppercase mb-0">my profile</h4>
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
                        <div class="row pt-md-5 mt-md-3 pt-xs-5 mt-xs-3">
                            <div class="col-lg-2">
                            </div>
                            <div class="col-lg-8 col-sm-12">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <div class="panel-title" align="center"><?php  echo    ''.$userDetails['fName'].' '.$userDetails['lName'].'';    ?></div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row px-3 py-2">
                                            <div class="col-4">
                                                <small>E-mail Address :</small>
                                            </div>
                                            <div class="col-8">
                                                <small><?php  echo    ''.$userDetails['email'].'';  ?></small>
                                            </div>
                                        </div>
                                        <div class="row px-3 py-2">
                                            <div class="col-4">
                                                <small>Division :</small>
                                            </div>
                                            <div class="col-8">
                                                <small><?php  echo    ''.$userDetails['Department'].'';  ?></small>
                                            </div>
                                        </div>
                                        <div class="row px-3 py-2">
                                            <div class="col-4">
                                                <small>Unit :</small>
                                            </div>
                                            <div class="col-8">
                                                <small><?php  echo    ''.$userDetails['unit'].'';   ?></small>
                                            </div>
                                        </div>
                                        <div class="row px-3 py-2">
                                            <div class="col-4">
                                                <small>Employee ID :</small>
                                            </div>
                                            <div class="col-8">
                                                <small><?php  echo    ''.$userDetails['empID'].'';  ?></small>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row px-3 py-2">
                                            <div class="col-4">
                                                <small>Username :</small>
                                            </div>
                                            <div class="col-8">
                                                <small><?php  echo    $user;    ?></small>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row px-3 py-2" id="chpw">
                                            <div class="col" align="center">
                                                <button class="btn btn-sm btn-info" name="changePWA" id="changePWA">Change Password</button>
                                            </div>
                                        </div>
                                        <div class="row px-3 py-2" id="cupw" hidden>
                                            <div class="col-3">
                                            </div>
                                            <div class="col-6">
                                                <label for="password"><small>Current Password</small></label>
                                                <input type="password" class="form-control" name="cuPassword" id="cuPassword">
                                                <small><span id="error_cupw" class="text-danger"></span></small>
                                            </div>
                                            <div class="col-3">
                                            </div>
                                        </div>
                                        <div class="row px-3 py-2" id="nepw" hidden>
                                            <div class="col-3">
                                            </div>
                                            <div class="col-6">
                                                <label for="password"><small>New Password</small></label>
                                                <input type="password" class="form-control" name="nwPassword" id="nwPassword">
                                                <small><span id="error_nepw" class="text-danger"></span></small>
                                            </div>
                                            <div class="col-3">
                                            </div>
                                        </div>
                                        <div class="row px-3 py-2" id="copw" hidden>
                                            <div class="col-3">
                                            </div>
                                            <div class="col-6">
                                                <label for="password"><small>Confirm Password</small></label>
                                                <input type="password" class="form-control" name="cPassword" id="cPassword">
                                                <small><span id="error_copw" class="text-danger"></span></small>
                                            </div>
                                            <div class="col-3">
                                            </div>
                                        </div>
                                        <div class="row px-3 py-2 mt-2" id="svpw" hidden>
                                            <div class="col" align="center">
                                                <form id="chngePW" action="">
                                                </form>
                                                <button class="btn btn-sm btn-info" name="savePW" id="savePW">Save Password</button>
                                                <button class="btn btn-sm btn-danger" name="cancel" id="cancel">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- end of cards -->
      
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
   
            $(document).ready(function() {

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
                    
                load_unseen_notification();
                    
                    
                    
                $(document).on('click', '.dropdown-toggle', function(){
                    //$('.count').html('');
                    load_unseen_notification('yes');
                });
                
                setInterval(function(){ 
                    load_unseen_notification();; 
                }, 5000);
                

                $('#changePWA').click(function(){
                    $('#chpw').prop("hidden", true);
                    $('#cupw').prop("hidden", false);
                    $('#nepw').prop("hidden", false);
                    $('#copw').prop("hidden", false);               
                    $('#svpw').prop("hidden", false);
                });

                $('#cancel').click(function(){
                    document.getElementById('cuPassword').value = "";
                    document.getElementById('nwPassword').value = "";
                    document.getElementById('cPassword').value = "";
                    $('#chpw').prop("hidden", false);
                    $('#cupw').prop("hidden", true);
                    $('#nepw').prop("hidden", true);
                    $('#copw').prop("hidden", true);               
                    $('#svpw').prop("hidden", true);
                });

                var currentPw = <?php   echo    $userId['Password'];    ?>;

                $('#savePW').click(function(){
                    var error_cupw = '';
                    var error_nepw = '';
                    var error_copw = '';
                    if($.trim($('#cuPassword').val()).length == 0){
                        error_cupw = 'Current password is required';
                        $('#error_cupw').text(error_cupw);
                    }else if($.trim($('#cuPassword').val()).length != 0){
                        if($.trim($('#cuPassword').val()) != currentPw){
                            error_cupw = 'You entered current password is wrong..!';
                            $('#error_cupw').text(error_cupw);
                        }else if($.trim($('#cuPassword').val()) == currentPw){
                            error_cupw = '';
                            $('#error_cupw').text(error_cupw);
                        }
                    }
                    if($.trim($('#nwPassword').val()).length == 0){
                        error_nepw = 'New password is required';
                        $('#error_nepw').text(error_nepw);
                    }else if($.trim($('#nwPassword').val()).length != 0){
                        if($.trim($('#nwPassword').val()) == currentPw){
                            error_nepw = 'You can not use current password as new password..!';
                            $('#error_nepw').text(error_nepw);
                        }else if($.trim($('#nwPassword').val()) != currentPw){
                            error_nepw = '';
                            $('#error_nepw').text(error_nepw);
                        }
                    }
                    if($.trim($('#cPassword').val()).length == 0){
                        error_copw = 'New password confirmation is required';
                        $('#error_copw').text(error_copw);
                    }else if($.trim($('#cPassword').val()).length != 0){
                        if($.trim($('#cPassword').val()) != $.trim($('#nwPassword').val())){
                            error_copw = 'Password confirmation was not matched..!';
                            $('#error_copw').text(error_copw);
                        }else if($.trim($('#cPassword').val()) == $.trim($('#nwPassword').val())){
                            error_copw = '';
                            $('#error_copw').text(error_copw);
                        }
                    }
                    if(error_cupw != '' || error_nepw != '' || error_copw != ''){
                        return false;
                    }else{
                        var userID = <?php  echo    $userId['idUser'];  ?>;
                        var password = document.getElementById('nwPassword').value;
                        $.ajax({
                            url: "changePW.php",
                            method: "POST",
                            data: {userID:userID,password:password},
                            dataType: "json",
                            success: function(data){
                                alert(data.message);
                                $("#chngePW").submit();
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
       <!-- <script src="../script.js"></script>-->

       <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />

    </body>
</html>
