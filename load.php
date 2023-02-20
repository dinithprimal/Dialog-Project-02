<?php

//load.php

$connect = new PDO('mysql:host=localhost;dbname=training', 'root', '');

$data = array();

$query = "SELECT * FROM programstatus WHERE statusHR = '1' ORDER BY idProgram";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["idProgram"],
  'title'   => $row["progName"],
  'start'   => $row["stDate"],
  'end'   => $row["edDate"]
 );
}

echo json_encode($data);

?>