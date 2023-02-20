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

    if(isset($_POST['addDiv'])){

        $divition = $_POST['divsion'];

        $queryAddDiv ="INSERT INTO divisions (divitionName) VALUES ('$divition')";

        if($conn->query($queryAddDiv)=== TRUE){
            echo    '<script>alert("Successfully Added!");</script>';
        }else{
            echo    '<script>alert("Something went wrong! Please try again...");</script>';
        }
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
                                current"><i 
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
                                    text-uppercase mb-0">Settings</h4>
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
                        <form action="" method="POST">
                            
                            <button type="submit" name="Logout" class="btn btn-danger btn-block">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- end of Modal -->

        <!-- cards -->

        <?php
            $queryDivisions = "SELECT * FROM divisions";
            $divisionArray = mysqli_query($conn,$queryDivisions) or die(mysqli_error($conn));
        ?>

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-10 col-lg-9 col-md-9 ml-auto">
                        <div class="row pt-md-5 mt-md-3 pt-xs-5 mt-xs-3">
                            <div class="col-xl-12 col-sm-12">
                                <div class="card card-common mr-auto">
                                    <div class="card-body ml-2">
                                        <div class="d-flex justify-content-between mb-3">
                                            <i class="text-info fas fa-tasks fa-lg"></i>
                                            <div class="text-right text-secondary">
                                                <h5 class="mb-4">Add Divisions</h5>
                                            </div>
                                        </div>
                                        <form action="settings.php" method="POST" id="settingsDiv">
                                            <div class="row">
                                                <div class="col-lg-10 col-sm-8 col-7">
                                                    <input type="text" name="divsion" onkeyup="activeBut();" id="divsion" class="form-control" />
                                                </div>
                                                <div class="col-lg-2 col-sm-4 col-5">
                                                    <button class="btn btn-info" name="addDiv" id="addDiv"  type="submit" method="POST" disabled>Add Divisions</button>
                                                </div>
                                            </div>
                                            <div class="row mt-5 pl-3 panel-body" style="height:300px; width:100%; overflow: auto;">
                                                <table class="table table-striped table-bordered col" style="width:100%;">
                                                    <col style="width:85%">
	                                                <col style="width:15%">
                                                    <tr>
                                                        <th>Division</th>
                                                        <th>Remove</th>
                                                    </tr>
                                                    <?php
                                                        while($div = mysqli_fetch_array($divisionArray)){
                                                            echo                        '<tr>';
                                                            echo                        '<td>'.$div['divitionName'].'<input type="hidden" name="'.$div['divitionName'].'" id="'.$div['divitionName'].'" value="'.$div['divitionName'].'"/></td>';                                                        
                                                            echo                        '<td><button type="button" name="remove" class="btn btn-group btn-danger remove" style="padding: .25rem .4rem; font-size: .875rem; line-height: .95; border-radius: .2rem;" id="'.$div['divitionName'].'">Remove</button></td>';
                                                            echo                        '</tr>';
                                                        }
                                                    ?>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-md-3 mt-md-2 pt-xs-5 mt-xs-3 mb-3">
                            <div class="col-xl-12 col-sm-12">
                                <div class="card card-common mr-auto">
                                    <div class="card-body ml-2">
                                        <div class="d-flex justify-content-between mb-3">
                                            <i class="text-info fas fa-tasks fa-lg"></i>
                                            <div class="text-right text-secondary">
                                                <h5 class="mb-4">Change Email Password</h5>
                                            </div>
                                        </div>
                                        <form action="settings.php" method="POST" id="settingsDiv">
                                            <div class="row">
                                                <div class="col-lg-10 col-sm-8 col-7">
                                                    <input type="text" name="password" onkeyup="activePwBut();" id="password" class="form-control" />
                                                </div>
                                                <div class="col-lg-2 col-sm-4 col-5">
                                                    <button class="btn btn-info" name="addPw" id="addPw"  type="button" disabled>Add Password</button>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col" align="center" style="width: 100%;">
                                                    <button class="btn btn-success" name="sendTest" id="sendTest"  type="button">Send Test mail</button>
                                                </div>
                                            </div>
                                        </form>
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

            function activeBut(){
                if(document.getElementById("divsion").value != ""){
                    $("#addDiv").prop('disabled', false);
                }else{
                    $("#addDiv").prop('disabled', true);
                }
            }

            function activePwBut(){
                if(document.getElementById("password").value != ""){
                    $("#addPw").prop('disabled', false);
                }else{
                    $("#addPw").prop('disabled', true);
                }
            }
            
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

                $(document).on('click', '.remove', function(){
                    if(confirm("Are you sure you want to remove this division?")){
                        var divName = $(this).attr("id");

                        $.ajax({
                            url: "removeDiv.php",
                            method: "POST",
                            data: {divName:divName},
                            dataType: "text",
                            success: function(data){
                                alert("Successfully Deleted!");
                                $("#settingsDiv").submit();
                            }
                        })
                    }else{
                        return false;
                    }
                    
                });

                $('#addPw').click(function(){
                    var password = document.getElementById('password').value;
                    $.ajax({
                        url: "Change-Email-Password.php",
                        method: "POST",
                        data: {password:password},
                        dataType: "text",
                        success: function(data){
                            if(data == "true"){
                                alert("Successfully Changed");
                                location.reload();
                            }else{
                                alert("Something went wrong..! Please try again...");
                            }
                        }
                    })
                });

                
                
            });

            

            $('#sendTest').click(function(){
                var fName = "<?php  echo    $userDetails['fName'];  ?>";
                var email = "<?php   echo    $userDetails['email']; ?>";
                $.ajax({
                    url: "Send-Test-Mail.php",
                    method: "POST",
                    data: {fName:fName,email:email},
                    dataType: "text",
                    success: function(data){
                        if(data == "true"){
                            alert("Successfully Sent");
                            location.reload();
                        }else{
                            alert("Something went wrong..! Please try again...");
                        }
                    }
                })
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
