<?php

include("database.php");

//$conn = mysqli_connect("localhost", "root", "", "training");
$output = '';
$query = '';
if(isset($_POST["ids"])){

    $id = $_POST["ids"];
    $out = "".$id[0]."";
    $count = 1;
    while($count<count($id)){
        $out .= ','.$id[$count].'';
        $count++;
    }
    
    $query = "SELECT idProgram, ProgName FROM program WHERE remark = (SELECT remark FROM sheduleprogram WHERE status = '0') AND idProgram IN (SELECT idProgram FROM program_has_user WHERE idUser IN ($out))";

    $output .= '
            <table style="width:100% height: 100%">
                <tr>
                    <td><input type="checkbox" name="progCheck" onclick="return progSelection(this);" value="newProg"/><small>  New Program</small></td>
                </tr>';

    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
        $output .= '
                <tr>
                    <td><input type="checkbox" name="progCheck" onclick="return progSelection(this);" value="All"/><small>  All Programs</small></td>
                </tr>
            ';
        while($row = mysqli_fetch_array($result)){
           // $querySelProg = "SELECT ProgName FROM program WHERE idProgram = ".$row["idProgram"]."";
           // $res = mysqli_query($conn, $querySelProg);
           // $name = mysqli_fetch_array($res);

            $output .= '
                    <tr>
                        <td><input type="checkbox" name="progCheck" onclick="return progSelection(this);" value="'.$row["idProgram"].'"/><small> '.$row["ProgName"].'</small></td>
                    </tr>
                    ';
        }
    echo $output;
    }else{
        $output .='<tr><td><small>No programs to preview</small></td></tr>';
        echo $output;
    }
}




?>