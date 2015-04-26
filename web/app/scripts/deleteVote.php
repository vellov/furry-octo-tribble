<?php

include 'conf.php';

$params = json_decode(file_get_contents('php://input'),true);
$candidateId=$params["candidateId"];
$userId=$params["userId"];
$electionId=$params["electionId"];

$qry = "SELECT * FROM VOTES WHERE user_id='$userId' and election_id='$electionId'";
$result=pg_query($qry);
if(pg_num_rows($result)> 0){
    $qry="DELETE FROM Votes WHERE candidate_id='$candidateId' and user_id='$userId' and election_id='$electionId'";
}

$qry_res = pg_query($qry);
if ($qry_res) {
    //printf($qry_res);
    $arr = array('msg' => "Vote Deleted Successfully!!!");
    $jsn = json_encode($arr);
// print_r($jsn);
} else {
    $arr = array('error' => 'Error in deleting vote');
    $jsn = json_encode($arr);

}
print_r($jsn);
?>