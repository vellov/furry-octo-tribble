<?php
/**
 * Created by PhpStorm.
 * User: vellovaherpuu
 * Date: 15/02/15
 * Time: 22:41
 */

include 'conf.php';

if ($result = $conn->query("SELECT * FROM Candidates")) {
  //  printf("Select returned %d rows.\n", $result->num_rows);
}
$rows = array();
foreach($result as $row){
    $rows[]=$row;
}
print json_encode($rows);
?>