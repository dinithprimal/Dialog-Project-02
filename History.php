<?php

    include("database.php");

    $output = '';

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

    //this import excell file

    if(isset($_POST['submitFileHistory'])){
        $fileName = $_FILES['fileHistory']['name'];
        $fileTmpName = $_FILES['fileHistory']['tmp_name'];
        $fileExtension = pathinfo($fileName,PATHINFO_EXTENSION);

        require 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';
        $allowedType = array('csv','xls','xlsx');

        if(!in_array($fileExtension,$allowedType)){
            echo '<script type="text/javascript">alert("Invalied File!\nPlease select correct file..");</script>';
        }else{
            
            $objPHPExcel = PHPExcel_IOFactory::load($fileTmpName);

            foreach($objPHPExcel->getWorksheetIterator() as $worksheet){

                $highestRow = $worksheet->getHighestRow();
                
                for($row = 2;$row<=$highestRow;$row++){
                    
                    $prticipantName = $worksheet->getCellByColumnAndRow(4,$row)->getValue();
                    $empID = $worksheet->getCellByColumnAndRow(2,$row)->getValue();
                    $empCatgry = $worksheet->getCellByColumnAndRow(5,$row)->getValue();
                    $workingCompany = $worksheet->getCellByColumnAndRow(3,$row)->getValue();
                    $PGRCode = $worksheet->getCellByColumnAndRow(0,$row)->getValue();
                    $portfolio = $worksheet->getCellByColumnAndRow(6,$row)->getValue();
                    $hDivision = $worksheet->getCellByColumnAndRow(7,$row)->getValue();
                    $gender = $worksheet->getCellByColumnAndRow(8,$row)->getValue();
                    $progName = $worksheet->getCellByColumnAndRow(9,$row)->getValue();
                    $insProjName = $worksheet->getCellByColumnAndRow(10,$row)->getValue();
                    $trainerName = $worksheet->getCellByColumnAndRow(11,$row)->getValue();
                    $triner = $worksheet->getCellByColumnAndRow(12,$row)->getValue();
                    $trnngLoc = $worksheet->getCellByColumnAndRow(14,$row)->getValue();
                    $participationStat = $worksheet->getCellByColumnAndRow(15,$row)->getValue();
                    $trainingHrs = $worksheet->getCellByColumnAndRow(16,$row)->getValue();
                    $skillCat = $worksheet->getCellByColumnAndRow(18,$row)->getValue();
                    $channel = $worksheet->getCellByColumnAndRow(19,$row)->getValue();
                    $AcdCompe = $worksheet->getCellByColumnAndRow(20,$row)->getValue();
                    $progIdenty = $worksheet->getCellByColumnAndRow(21,$row)->getValue();
                    $year = $worksheet->getCellByColumnAndRow(13,$row)->getValue();
                    $year = substr($year,strlen($year)-4,strlen($year)-1);
                    $month = $worksheet->getCellByColumnAndRow(1,$row)->getValue();
                    //echo '<script type="text/javascript">alert("'.$name.'");</script>';
                    
                    $query = "INSERT INTO traininghistory (particpantName, empID, empCategory, 	workingCompany, PGRCode, portfolio, division, gender, programName, insti_projName, trainerName, triner, trnngLocation, participationStatus, trainngHrs, skillCat, channel, academyComp, progIdentity, year, month) VALUES ('$prticipantName','$empID', '$empCatgry', '$workingCompany', '$PGRCode','$portfolio', '$hDivision', '$gender', '$progName', '$insProjName', '$trainerName', '$triner', '$trnngLoc', '$participationStat', '$trainingHrs', '$skillCat', '$channel', '$AcdCompe', '$progIdenty', '$year', '$month')";
                    
                    
                    if ($conn->query($query) === TRUE) {
                        continue;
                    }
                }
            }
            
            echo '<script type="text/javascript">alert("Successfully Uploaded..!");</script>';
        }

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
                                current"><i 
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
                                    text-uppercase mb-0">History</h4>
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
                        <div class="row pt-md-5 mt-md-3 pt-xs-5 mt-xs-3 mb-3">
                            <div class="col-xl-12 col-sm-12">
                                <div class="card card-common" id="info">
                                    <div class="card-header">
                                        <div class="panel-title" align="center">Programs History</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <i class="fas fa-upload text-info"></i>
                                            <div class="text-right text-secondary">
                                                <h6 class="mb-1">Upload History Excel File</h6>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-1">
                                            </div>
                                            <div class="col-10">
                                                <form action="" method="POST" enctype="multipart/form-data">
                                                    <div class="row form-group">
                                                        <div class="col-4 d-flex justify-content-between align-items-center">
                                                            
                                                        </div>
                                                        <div class="col-8 d-flex justify-content-between align-items-center">
                                                            <input type="file" style="width:75%;" name="fileHistory" id="fileHistory" class="form-control"/>
                                                            <small><span id="error_file" class="text-danger"></span></small>
                                                        </div>
                                                    </div>
                                                    <div align="center" class="from-group">
                                                        
                                                        <button type="button" name="cancelHistory" style="display:inline-block;" id="cancelHistory" class="btn btn-danger">Cancel</button>
                                                        <button type="submit" class="btn btn-info" name="submitFileHistory" id="submitFileHistory">Upload</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-1">
                                            </div>
                                        </div>
                                        <hr>
                                        <hr>
                                        <small> 
                                            <table cellpadding="3" cellspacing="0" border="0" style="width: 67%; margin: 0 auto 2em auto;">
                                                <thead>
                                                    <tr>
                                                        <th>Target</th>
                                                        <th align="center">Search text</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="filter_global">
                                                        <td>Global search</td>
                                                        <td align="center"><input type="text" class="global_filter" id="global_filter"></td>
                                                        
                                                    </tr>
                                                    <tr id="filter_col1" data-column="0">
                                                        <td>Participant Name</td>
                                                        <td align="center"><input type="text" class="column_filter" id="col0_filter"></td>
                                                        
                                                    </tr>
                                                    <tr id="filter_col2" data-column="1">
                                                        <td>Emp ID</td>
                                                        <td align="center"><input type="text" class="column_filter" id="col1_filter"></td>
                                                        
                                                    </tr>
                                                    <tr id="filter_col3" data-column="2">
                                                        <td>Gender</td>
                                                        <td align="center"><input type="text" class="column_filter" id="col2_filter"></td>
                                                        
                                                    </tr>
                                                    <tr id="filter_col4" data-column="3">
                                                        <td>Employee Category</td>
                                                        <td align="center"><input type="text" class="column_filter" id="col3_filter"></td>
                                                        
                                                    </tr>
                                                    <tr id="filter_col5" data-column="4">
                                                        <td>Division</td>
                                                        <td align="center"><input type="text" class="column_filter" id="col4_filter"></td>
                                                        
                                                    </tr>
                                                    <tr id="filter_col6" data-column="5">
                                                        <td>Company</td>
                                                        <td align="center"><input type="text" class="column_filter" id="col5_filter"></td>
                                                        
                                                    </tr>
                                                    <tr id="filter_col7" data-column="6">
                                                        <td>Portfolio</td>
                                                        <td align="center"><input type="text" class="column_filter" id="col6_filter"></td>
                                                        
                                                    </tr>
                                                    <tr id="filter_col8" data-column="7">
                                                        <td>Participated Program Name</td>
                                                        <td align="center"><input type="text" class="column_filter" id="col7_filter"></td>
                                                        
                                                    </tr>
                                                    <tr id="filter_col9" data-column="8">
                                                        <td>Trainner / Facilitator</td>
                                                        <td align="center"><input type="text" class="column_filter" id="col8_filter"></td>
                                                        
                                                    </tr>
                                                    <tr id="filter_col10" data-column="9">
                                                        <td>Training Type</td>
                                                        <td align="center"><input type="text" class="column_filter" id="col9_filter"></td>
                                                        
                                                    </tr>
                                                    <tr id="filter_col18" data-column="17">
                                                        <td>Year</td>
                                                        <td align="center"><input type="text" class="column_filter" id="col17_filter"></td>
                                                        
                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                            <table id="programsHistory" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th><small>Participant Name</small></th>
                                                        <th><small>Emp ID</small></th>
                                                        <th><small>Gender</small></th>
                                                        <th><small>Employee Category</small></th>
                                                        <th><small>Division</small></th>
                                                        <th><small>Company</small></th>
                                                        <th><small>Portfolio</small></th>
                                                        <th><small>Participated Program Name</small></th>
                                                        <th><small>Trainner / Facilitator</small></th>
                                                        <th><small>Training Type</small></th>
                                                        <th><small>Location</small></th>
                                                        <th><small>Participation Status</small></th>
                                                        <th><small>Training Hours</small></th>
                                                        <th><small>Skill Category</small></th>
                                                        <th><small>Channel</small></th>
                                                        <th><small>Competency</small></th>
                                                        <th><small>Program Identification</small></th>
                                                        <th><small>Year</small></th>
                                                        <th><small>Month</small></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    //$conn = mysqli_connect("localhost", "root", "", "training");
                                                    $query = "SELECT * FROM traininghistory";
                                                    $result = mysqli_query($conn, $query);
                                                        if(mysqli_num_rows($result) > 0){

                                                            while($row = mysqli_fetch_array($result)){
                                                ?>
                                                                        <tr>
                                                                            <td><?php echo  $row["particpantName"]; ?></td>
                                                                            <td><?php echo  $row['empID']; ?></td>
                                                                            <td><?php echo  $row["gender"]; ?></td>
                                                                            <td><?php echo  $row['empCategory']; ?></td>
                                                                            <td><?php echo  $row["division"]; ?></td>
                                                                            <td><?php echo  $row['workingCompany']; ?></td>
                                                                            <td><?php echo  $row["portfolio"]; ?></td>
                                                                            <td><?php echo  $row['programName']; ?></td>
                                                                            <td><?php echo  $row["trainerName"]; ?></td>
                                                                            <td><?php echo  $row['triner']; ?></td>
                                                                            <td><?php echo  $row["trnngLocation"]; ?></td>
                                                                            <td><?php echo  $row['participationStatus']; ?></td>
                                                                            <td><?php echo  $row["trainngHrs"]; ?></td>
                                                                            <td><?php echo  $row['skillCat']; ?></td>
                                                                            <td><?php echo  $row["channel"]; ?></td>
                                                                            <td><?php echo  $row['academyComp']; ?></td>
                                                                            <td><?php echo  $row['progIdentity']; ?></td>
                                                                            <td><?php echo  $row['year']; ?></td>
                                                                            <td><?php echo  $row['month']; ?></td>
                                                                        </tr>
                                                <?php
                                                            }
                                                        }

                                                ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th><small>Participant Name</small></th>
                                                        <th><small>Emp ID</small></th>
                                                        <th><small>Gender</small></th>
                                                        <th><small>Employee Category</small></th>
                                                        <th><small>Division</small></th>
                                                        <th><small>Company</small></th>
                                                        <th><small>Portfolio</small></th>
                                                        <th><small>Participated Program Name</small></th>
                                                        <th><small>Trainner / Facilitator</small></th>
                                                        <th><small>Training Type</small></th>
                                                        <th><small>Location</small></th>
                                                        <th><small>Participation Status</small></th>
                                                        <th><small>Training Hours</small></th>
                                                        <th><small>Skill Category</small></th>
                                                        <th><small>Channel</small></th>
                                                        <th><small>Competency</small></th>
                                                        <th><small>Program Identification</small></th>
                                                        <th><small>Year</small></th>
                                                        <th><small>Month</small></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </small>
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
                
            });

            function filterGlobal () {
                $('#programsHistory').DataTable().search(
                    $('#global_filter').val(),
                    $('#global_regex').prop('checked'),
                    $('#global_smart').prop('checked')
                ).draw();
            }
            
            function filterColumn ( i ) {
                $('#programsHistory').DataTable().column( i ).search(
                    $('#col'+i+'_filter').val(),
                    $('#col'+i+'_regex').prop('checked'),
                    $('#col'+i+'_smart').prop('checked')
                ).draw();
            }

            $(document).ready(function() {
                $('#programsHistory').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [,
                        'excelHtml5'
                    ],
                    "scrollY":        "500px",
                    "scrollX":        "100%",
                    "scrollCollapse": true,
                    "paging":         true,
                    
                } );
                $('input.global_filter').on( 'keyup click', function () {
                    filterGlobal();
                } );
            
                $('input.column_filter').on( 'keyup click', function () {
                    filterColumn( $(this).parents('tr').attr('data-column') );
                } );
            } );

            

        </script>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" 
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" 
        integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
        <script src="script.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>

      </body>
</html>
