<?php

    include("database.php");

    //$conn = mysqli_connect("localhost", "root", "", "training");
    $output = '';
    $query = '';
    if(isset($_POST["ids"])){

        $id = $_POST["ids"];

        if($id != 0){
        
            $query = "UPDATE user SET status = '0' WHERE idUser = '$id'";
            if(mysqli_query($conn, $query)){
                
                //sleep(1);

            }

        }
        
    }
    $queryLoad = "SELECT * FROM user WHERE status = '1' AND role = 'User'";
        $result = mysqli_query($conn, $queryLoad);
        if(mysqli_num_rows($result) > 0){

            while($row = mysqli_fetch_array($result)){

                $output .= '
                        <tr>
                            <td><small>'.$row["fName"].' '.$row['lName'].'</small></td>
                            <td><small>'.$row['Department'].'</small></td>
                            <td><button type="button" name="removeUser" onclick="removeUser(this); setTimeout(addUser, 200);" class="btn btn-group btn-danger" style="padding: .25rem .4rem; font-size: .875rem; line-height: .95; border-radius: .2rem;" value="'.$row['idUser'].'">Remove</button></td>
                        </tr>
                        ';
            }
        echo $output;
        }






?>