<?php

    include("database.php");
    //$conn = mysqli_connect("localhost","root","","training");
    $err = '';

    //$status_query = "SELECT * FROM notify WHERE nt_status=0";
    //$result_query = mysqli_query($conn,$status_query);
    //$count = mysqli_num_rows($result_query);

    //echo $count;

    if(isset($_POST["view"])){
 
        if($_POST["view"] != ''){
            $update_query = "UPDATE notify SET nt_status=1 WHERE nt_status=0";
            mysqli_query($conn, $update_query);
        }
        $query = "SELECT * FROM notify WHERE nt_status=0 ORDER BY idNotify DESC LIMIT 5";
        $result = mysqli_query($conn, $query);
        $output = '';
 
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $output .= '
   
                    <a class="dropdown-item" href="#">
                        <strong>'.$row["mes"].'</strong><br />
                        <small><em>'.$row["dt"].'</em></small>
                    </a>
   
                    <div class="dropdown-divider"></div>
                ';
            }
        }else{
            $output .= '<li><h6 class="text-danger dropdown-item">No New Notification Found</h6></li>';
        }

        $output .= '<a class="dropdown-item" href="#">View All Notification</a>';
 
        $query_1 = "SELECT * FROM notify WHERE nt_status=0";
        $result_1 = mysqli_query($conn, $query_1);
        $count = mysqli_num_rows($result_1);
        $data = array(
            'notification'   => $output,
            'unseen_notification' => $count
        );
        echo json_encode($data);
    }
?>