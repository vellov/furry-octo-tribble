<?php
/**
 * Created by PhpStorm.
 * User: vellovaherpuu
 * Date: 15/02/15
 * Time: 22:41
 */

include 'conf.php';

$params = json_decode(file_get_contents('php://input'),true);
//printf($params["id"]);
$userId=$params["userId"];
$electionId=$params["electionId"];

$qry = "SELECT * FROM Candidates WHERE user_id='$userId' and election_id='$electionId'";
$result=pg_query($qry);
if(pg_num_rows($result)> 0){
    $qry="DELETE FROM Candidates WHERE user_id='$userId' and election_id='$electionId'";
}

$qry_res = pg_query($qry);
if ($qry_res) {
    //printf($qry_res);
    $arr = array('msg' => "Candiadate deleted Successfully!!!", 'error' => '');
    $jsn = json_encode($arr);
// print_r($jsn);
} else {
    $arr = array('msg' => "", 'error' => 'Error In deleting record');
    $jsn = json_encode($arr);
// print_r($jsn);
}
print($jsn);
?>