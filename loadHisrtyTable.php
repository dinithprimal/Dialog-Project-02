<?php

    include("database.php");

    //$conn = mysqli_connect("localhost", "root", "", "training");
    $query = "SELECT * FROM traininghistory where particpantName LIKE '%dil%' and year LIKE '%%'";
    $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0){

            while($row = mysqli_fetch_array($result)){

                $output .= '
                        <tr>
                            <td>'.$row["particpantName"].'</td>
                            <td>'.$row['empID'].'</td>
                            <td>'.$row["gender"].'</td>
                            <td>'.$row['empCategory'].'</td>
                            <td>'.$row["division"].'</td>
                            <td>'.$row['workingCompany'].'</td>
                            <td>'.$row["portfolio"].'</td>
                            <td>'.$row['programName'].'</td>
                            <td>'.$row["trainerName"].'</td>
                            <td>'.$row['triner'].'</td>
                            <td>'.$row["trnngLocation"].'</td>
                            <td>'.$row['participationStatus'].'</td>
                            <td>'.$row["trainngHrs"].'</td>
                            <td>'.$row['skillCat'].'</td>
                            <td>'.$row["channel"].'</td>
                            <td>'.$row['academyComp'].'</td>
                            <td>'.$row['progIdentity'].'</td>
                            <td>'.$row['year'].'</td>
                            <td>'.$row['month'].'</td>
                        </tr>
                        ';
            }
        }

?>