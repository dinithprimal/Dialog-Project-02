<?php

    include("database.php");

    $id = $_POST['id'];
    $reqDate = $_POST['reqDate'];
    $status = $_POST['status'];
    $delDate = $_POST['delDate'];

    if($reqDate != ''){
        $Dt = new DateTime($reqDate);
        $Dt = $Dt->format("Y-m-d");
        $updateQuery = "UPDATE programstatus SET reqDtAprGTD = '$Dt' WHERE idProgram = '$id'";
        if ($conn->query($updateQuery) === TRUE) {
            //unset($_POST['save_programTrasup']);                    
        }
    }

    if($status != 'Select Status'){
        if($status == 'Pending'){
            $stat = '1';
        }else if($status == 'Approved'){
            $stat = '2';
        }else if($status == 'Rejected'){
            $stat = '3';
        }else if($status == 'N/A'){
            $stat = '4';
        }
        
        $updateQuery = "UPDATE programstatus SET progApprGTD = '$stat' WHERE idProgram = '$id'";
        if ($conn->query($updateQuery) === TRUE) {
            //unset($_POST['save_programTrasup']);                    
        }
    }

    if($delDate != ''){
        $Dt = new DateTime($delDate);
        $Dt = $Dt->format("Y-m-d");
        $updateQuery = "UPDATE programstatus SET dtApprGTD = '$Dt' WHERE idProgram = '$id'";
        if ($conn->query($updateQuery) === TRUE) {
            //unset($_POST['save_programTrasup']);                    
        }
    }

?>