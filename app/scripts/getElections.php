<?php
/**
 * Created by PhpStorm.
 * User: vellovaherpuu
 * Date: 09/03/15
 * Time: 22:37
 */
include 'conf.php';

if ($result = $conn->query("SELECT * FROM Elections")) {
    //  printf("Select returned %d rows.\n", $result->num_rows);
}
$rows = array();
foreach($result as $row){
    $rows[]=$row;
}
print json_encode($rows);
?>