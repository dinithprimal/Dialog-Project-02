<?php

    include("database.php");

    $id = $_GET['id'];
    $cnfrm = $_GET['confirm'];

    //$conn = mysqli_connect("localhost","root","","training");

    date_default_timezone_set("Asia/Colombo");

    $query = "SELECT * FROM programstatus WHERE idProgram = '$id'";
    $cnfrmId = mysqli_query($conn,$query) or die(mysqli_error($conn));
    $GCEOis = mysqli_num_rows($cnfrmId);
    $GCEOconfirm = mysqli_fetch_array($cnfrmId);
    $GCEOStage = $GCEOconfirm['progApprGCEO'];

    $Dt = new DateTime();
    $Dt = $Dt->format("Y-m-d");
    
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
        <link rel="stylesheet" href="loginstyle.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
        <title>Admin Dashboard</title>
    </head>
    <body>
        <div class="container-fluid bg">
            <?php
                if($GCEOis==1 & $GCEOconfirm['GCEOConfirm'] == $cnfrm){
                    if($GCEOStage == '1'){
                        $updateAccept = "UPDATE programstatus SET progApprGCEO= '2' , dtApprGCEO = '$Dt' WHERE idProgram = '$id'";
                        if ($conn->query($updateAccept) === TRUE) {

                            echo    '<script type="text/javascript"> 
                                        function sendMailAproveGCEO(){
                                            var id = '.$id.';
                                            $.ajax({
                                                url: "sendMailAproveGCEO.php",
                                                method: "POST",
                                                data: {id:id},
                                                dataType: "text",
                                                success: function(data){
                                                    //$("#send").submit();
                                                }
                                            })
                                        }
                                        sendMailAproveGCEO(); </script>';
            ?>
                <div class="row pt-5">
                    <div class="col">
                        <h1 class="text-center pt-5">Thank You</h1>
                    </div>
                </div>                
                <div class="row mt-5 pt-5">            
                    <div class="col-xl-3 col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col">
                                <h1 class="text-center"><span class="badge badge-pill badge-success">Accepted</span></h1>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col">
                                <h4 class="text-center"><small>You have succesfully accepted <b><?php  echo    "".$GCEOconfirm['progName']." ".$GCEOconfirm['progType']." ";    ?></b>training program</small></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
                </div>
            <?php

                            echo    '<script>
                                        function sendMailHR(){
                                            var id = '.$id.';
                                            $.ajax({
                                                url: "sendMailHR.php",
                                                method: "POST",
                                                data: {id:id},
                                                dataType: "text",
                                                success: function(data){
                                                    //$("#send").submit();
                                                }
                                            })
                                        }
                                        sendMailHR();
                                    </script>';
                            
                    }else{
            ?>
                <div class="row pt-5">
                    <div class="col">
                        <h1 class="text-center pt-5"><i class="fas fa-lg fa-exclamation-triangle"></i></h1>
                    </div>
                </div>                
                <div class="row mt-5 pt-5">            
                    <div class="col-xl-3 col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col">
                                <h1 class="text-center"><span class="badge badge-pill badge-warning">Oops..!</span></h1>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col">
                                <h4 class="text-center"><small>Somthigng went wrong...</small></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col" align="center">
                                <form action="" method="POST">
                                    <button class="btn btn-info" type="submit"><small>Please Refresh</small></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
                </div>
            <?php
                        }
                    }else{
            ?>
                <div class="row pt-5">
                    <div class="col">
                        <h1 class="text-center pt-5"><span class="badge badge-pill badge-danger">Thank you</span></h1>
                    </div>
                </div>                
                <div class="row mt-5 pt-5">            
                    <div class="col-xl-3 col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12">
                        <div class="row mt-5">
                            <div class="col">
                                <h4 class="text-center"><small>You alredy made the respond for this program !</small></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
                </div>
            <?php

                    }
                }else{
            ?>
                <div class="row pt-5">
                    <div class="col">
                        <h1 class="text-center pt-5"><span class="badge badge-pill badge-danger">SORRY</span></h1>
                    </div>
                </div>                
                <div class="row mt-5 pt-5">            
                    <div class="col-xl-3 col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-xs-12">
                        <div class="row mt-5">
                            <div class="col">
                                <h4 class="text-center"><small>This is not a valied entry !</small></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
                </div>
            <?php
                }
            ?>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>

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