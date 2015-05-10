<?php

include 'conf.php';

$params=$_GET;
$electionId=$params["electionId"];
$qry="select * from Votes where election_id='$electionId'";

$result = pg_query($qry);
$count = pg_num_rows($result);
// $result=pg_fetch_object($result, 0);
// $rows = array();
// foreach($result as $row){
//     $rows[]=$row;
// }
print json_encode($count);
?>