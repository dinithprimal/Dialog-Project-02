<?php

include("database.php");

//$conn = mysqli_connect("localhost", "root", "", "training");
$output = '';
$query = '';
if(isset($_POST["ids"])){

    $ids = $_POST["ids"];
    $progs = $_POST["progs"];
    $datetime2 = $_POST['datetime2'];

    $Dt = new DateTime($datetime2);
    $Dt = $Dt->format("Y-m-d H:i:s");
    
    $countUid = 0;
    $countProgid = 0;

    $newProg = 0;

    while($countProgid<count($progs)){

        if($progs[$countProgid]!="newProg"){

            $querySearch = "SELECT * FROM programaccess WHERE idProgram = '$progs[$countProgid]'";
            $searchArray = mysqli_query($conn,$querySearch) or die(mysqli_error($conn));
            $search = mysqli_num_rows($searchArray);

            if($search == 0){
                $insertQuery = "INSERT INTO programaccess (idProgram, enddate) VALUES ('$progs[$countProgid]','$Dt')";
                if ($conn->query($insertQuery) === TRUE) {

                }
            }else if($search == 1){
                $updateQuery = "UPDATE programaccess SET enddate = '$Dt' WHERE idProgram = '$progs[$countProgid]'";
                if(mysqli_query($conn, $updateQuery)){

                }
            }

        }else{
            $newProg = 1;
        }

        $countProgid++;
    }


    if($newProg == 1){
        while($countUid<count($ids)){

            $querySearch = "SELECT * FROM useraccess WHERE idUser = '$ids[$countUid]'";
            $searchArray = mysqli_query($conn,$querySearch) or die(mysqli_error($conn));
            $search = mysqli_num_rows($searchArray);

            if($search == 0){
                $insertQuery = "INSERT INTO useraccess (idUser, enddate) VALUES ('$ids[$countUid]','$Dt')";
                if ($conn->query($insertQuery) === TRUE) {}
            }else if($search == 1){
                $updateQuery = "UPDATE useraccess SET enddate = '$Dt' WHERE idUser = '$ids[$countUid]'";
                if(mysqli_query($conn, $updateQuery)){

                }
            }

                                    

            $countUid++;
        }
    }
    
}




?>