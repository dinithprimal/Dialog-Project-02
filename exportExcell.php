<?php  
//export.php 

    include("database.php");

    $id = $_GET['id'];

    //$conn = mysqli_connect("localhost","root","","training");

    $get_remark = "SELECT remark FROM sheduleprogram WHERE id = '$id'";
    $remarkResult = mysqli_query($conn, $get_remark);
    $remarkArray = mysqli_fetch_array($remarkResult);

    $remark = $remarkArray['remark'];

    $output = '';
    $nomine = '';
//if(isset($_POST["id"])){

    $query = "SELECT * FROM program WHERE remark = '$remark'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
        $output .= '
                    <table class="table" bordered="1">  
                        <tr>  
                            <th>Training Program</th>  
                            <th>Modules</th>  
                            <th>Clubbed</th>  
                            <th>Type</th>
                            <th>Trainer/Supplier</th>
                            <th>Payment Method</th>
                            <th>Budget Source</th>
                            <th>Requested Devision</th>
                            <th>Requested Unit</th>
                            <th>Remark (C/F or Fresh)</th>
                            <th>Requested By</th>
                            <th>Divisional Priority</th>
                            <th>Requested Slots</th>
                            <th>Currency</th>
                            <th>Estimated Course Fee</th>
                            <th>Estimated Other Cost</th>
                            <th>Estimated Total Cost</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Level</th>
                            <th>Duration</th>
                            <th>Internal Category</th>
                            <th>Module Status</th>
                            <th>Nominee Status</th>
                            <th>User Comment</th>
                        </tr>
                        <tr>
                        </tr>
                    ';
        while($row = mysqli_fetch_array($result)){
            $queryUserDetails = "SELECT fullName, Department, unit FROM user WHERE idUser = (SELECT idUser FROM program_has_user WHERE idProgram = '".$row['idProgram']."')";
            $resultUserDetails = mysqli_query($conn, $queryUserDetails);
            $userDetails = mysqli_fetch_array($resultUserDetails);
            $output .= '
                        <tr>  
                            <td>'.$row["ProgName"].'</td>  
                            <td></td>  
                            <td></td>  
                            <td>'.$row["typ"].'</td>  
                            <td>'.$row["trasup"].'</td>
                            <td>'.$row["feeType"].'</td>  
                            <td></td>  
                            <td>'.$userDetails['Department'].'</td>
                            <td>'.$userDetails['unit'].'</td>  
                            <td></td>
                            <td>'.$userDetails['fullName'].'</td>
                            <td>'.$row["prio"].'</td>  
                            <td>'.$row["slot"].'</td>
                            <td>'.$row["currency"].'</td>  
                            <td>'.$row["fee"].'</td>  
                            <td>'.$row["otherCost"].'</td>  
                            <td>'.$row["totCost"].'</td>
                            <td>'.$row["stDate"].'</td>  
                            <td>'.$row["edDate"].'</td>  
                            <td></td>  
                            <td></td>  
                            <td></td>
                            <td></td>  
                            <td></td>
                            <td>'.$row["comment"].'</td>
                        </tr>
                        ';
            $modules = "SELECT moduleName FROM module WHERE idModule = ANY (SELECT idModule FROM user_program_module WHERE idProgram = '".$row['idProgram']."')";
            $resultModule = mysqli_query($conn, $modules);
            if(mysqli_num_rows($resultModule) > 0){
                while($rowM = mysqli_fetch_array($resultModule)){
                    $output .= '
                        <tr>  
                            <td>'.$row["ProgName"].'</td>  
                            <td>'.$rowM["moduleName"].'</td>  
                            <td></td>  
                            <td></td>  
                            <td></td>
                            <td></td>  
                            <td></td>  
                            <td></td>
                            <td></td>  
                            <td></td>
                            <td></td>
                            <td></td>  
                            <td></td>
                            <td></td>  
                            <td></td>  
                            <td></td>  
                            <td></td>
                            <td></td>  
                            <td></td>  
                            <td></td>  
                            <td></td>  
                            <td></td>
                            <td></td>  
                            <td></td>
                            <td></td>
                        </tr>
                        ';
                }
            }
        }
        $output .='<tr></tr><tr></tr><tr></tr>';
        $output .= '</table>';
        $queryUpdate = "UPDATE sheduleprogram SET status= '1' WHERE id = '$id'";

    
        if(mysqli_query($conn, $queryUpdate)){

        }
    
        $queryProg = "SELECT ProgName,idProgram FROM program WHERE remark = '$remark'";
    $resultProg = mysqli_query($conn, $queryProg);
    if(mysqli_num_rows($resultProg) > 0){
        $nomine .= '
                    <table class="table" bordered="1">  
                        <tr>  
                            <th>Training Program</th>  
                            <th>Nominee Name</th>  
                            <th>Employee ID</th>
                        </tr>
                        <tr>
                        </tr>
                    ';
        while($row = mysqli_fetch_array($resultProg)){
            $nomine .= '
                        <tr>  
                            <td>'.$row["ProgName"].'</td>  
                            <td></td>
                            <td></td>
                        </tr>
                        ';
            $nominees = "SELECT Name, empID FROM nominee WHERE idProgram = '".$row['idProgram']."'";
            $resultNominee = mysqli_query($conn, $nominees);
            if(mysqli_num_rows($resultNominee) > 0){
                while($rowN = mysqli_fetch_array($resultNominee)){
                    $nomine .= '
                        <tr>  
                            <td>'.$row["ProgName"].'</td>  
                            <td>'.$rowN["Name"].'</td>
                            <td>'.$rowN["empID"].'</td>
                        </tr>
                        ';
                }
            }
        }
        $nomine .= '</table>';

        

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename=ProgramDetails.xls');
        
        $output .= $nomine;
        echo $output;
    }

        //header('Content-Type: application/xls');
        //header('Content-Disposition: attachment; filename=download.xls');
        //echo $output;

    }

    
//}
?>