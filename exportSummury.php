<?php  
//export.php 

    include("database.php");

    $id = $_GET['id'];

    //$conn = mysqli_connect("localhost","root","","training");

    $get_remark = "SELECT * FROM sheduleprogram WHERE id = '$id'";
    $remarkResult = mysqli_query($conn, $get_remark);
    $remarkArray = mysqli_fetch_array($remarkResult);

    $remark = $remarkArray['remark'];

    $queryTotalProgram = "SELECT COUNT(*) AS tot FROM program WHERE remark = '$remark'";
    $totalProgramArray = mysqli_query($conn,$queryTotalProgram) or die(mysqli_error($conn));
    $totalProgram = mysqli_fetch_array($totalProgramArray);

    $queryForiegnProgram = "SELECT COUNT(*) AS totf FROM program WHERE typ = 'Foriegn' AND remark='$remark'";
    $foriegnProgramArray = mysqli_query($conn,$queryForiegnProgram) or die(mysqli_error($conn));
    $foriegnProgram = mysqli_fetch_array($foriegnProgramArray);

    $queryLocalProgram = "SELECT COUNT(*) AS totl FROM program WHERE typ = 'Local' AND remark='$remark'";
    $localProgramArray = mysqli_query($conn,$queryLocalProgram) or die(mysqli_error($conn));
    $localProgram = mysqli_fetch_array($localProgramArray);

    $queryOnlineProgram = "SELECT COUNT(*) AS toto FROM program WHERE typ = 'Online' AND remark='$remark'";
    $onlineProgramArray = mysqli_query($conn,$queryOnlineProgram) or die(mysqli_error($conn));
    $onlineProgram = mysqli_fetch_array($onlineProgramArray);

    $queryInternalProgram = "SELECT COUNT(*) AS toti FROM program WHERE typ = 'Internal' AND remark='$remark'";
    $internalProgramArray = mysqli_query($conn,$queryInternalProgram) or die(mysqli_error($conn));
    $internalProgram = mysqli_fetch_array($internalProgramArray);

    $output = '';

    $output .=  '
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="4">'.$remark.'</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr></tr>
                        <tr>
                            <th colspan="2">Started Date Time</th>
                            <td colspan="2">'.$remarkArray['startdate'].'</td>
                        </tr>
                        <tr>
                            <th colspan="2">Sheduled End Date Time</th>
                            <td colspan="2">'.$remarkArray['enddate'].'</td>
                        </tr>
                        <tr>
                            <th colspan="3">Total Number of Programs Registered</th>
                            <td colspan="1">'.$totalProgram['tot'].'</td>
                        </tr>
                        <tr></tr>
                        <tr></tr>
                        <tr>
                            <th colspan="4">Number of Programs form each Category</th>
                        </tr>
                        <tr></tr>
                        <tr>
                            <th colspan="2">Foriegn</th>
                            <td colspan="2">'.$foriegnProgram['totf'].'</td>
                        </tr>
                        <tr>
                            <th colspan="2">Local</th>
                            <td colspan="2">'.$localProgram['totl'].'</td>
                        </tr>
                        <tr>
                            <th colspan="2">Online</th>
                            <td colspan="2">'.$onlineProgram['toto'].'</td>
                        </tr>
                        <tr>
                            <th colspan="2">Internal</th>
                            <td colspan="2">'.$internalProgram['toti'].'</td>
                        </tr>
                        <tr></tr>
                        <tr></tr>
                        <tr>
                            <th colspan="4">Number of Programs from each Division</th>
                        </tr>
                        <tr></tr>
                ';
                $queryDepartment = "SELECT Department FROM user WHERE role = 'User' AND Department != 'Excecitive Board' group by Department";
                $queryDepartmentArray = mysqli_query($conn,$queryDepartment) or die(mysqli_error($conn));
                while($department = mysqli_fetch_array($queryDepartmentArray)){
    $output .=  '
                            <tr>
                                <th colspan="2">'.$department['Department'].'</th>
                ';
                    $count = "SELECT COUNT(*) AS count FROM program WHERE remark = '$remark' AND idProgram IN (SELECT idProgram FROM program_has_user WHERE idUser IN (SELECT idUser FROM user WHERE Department = '".$department['Department']."'))";
                    $countArray = mysqli_query($conn,$count) or die(mysqli_error($conn));
                    $countDepartment = mysqli_fetch_array($countArray);
    $output .=  '
                                <td colspan="2">'.$countDepartment['count'].'</td>
                            </tr>
                ';
                }
    $output .=  '   
                    </tbody>
                </table>
                ';

    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=ProgramSummary.xls');
    
    
    echo $output;

?>