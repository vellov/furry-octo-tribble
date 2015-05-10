<?php

include 'conf.php';

$params = json_decode(file_get_contents('php://input'),true);
$electionId=$params["electionId"];

$qry = "SELECT * FROM Elections WHERE id='$electionId'";
$result=pg_query($qry);
if(pg_num_rows($result)> 0){
    $qry="DELETE FROM Elections WHERE id='$electionId'";
}

$qry_res = pg_query($qry);
if ($qry_res) {
    //printf($qry_res);
    $arr = array('msg' => "Election deleted Successfully!!!", 'error' => '');
    $jsn = json_encode($arr);
// print_r($jsn);
} else {
    $arr = array('msg' => "", 'error' => 'Error In deleting record');
    $jsn = json_encode($arr);
// print_r($jsn);
}
print($jsn);
?>