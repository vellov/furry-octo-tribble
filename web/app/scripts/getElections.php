<?php
/**
 * Created by PhpStorm.
 * User: vellovaherpuu
 * Date: 09/03/15
 * Time: 22:37
 */
include 'conf.php';

if ($result =pg_query($conn,"SELECT * FROM Elections")) {
    //  printf("Select returned %d rows.\n", $result->num_rows);
}
$rows = array();
$result=pg_fetch_all($result);
foreach($result as $row){
    $rows[]=$row;
}
print json_encode($rows);
?>