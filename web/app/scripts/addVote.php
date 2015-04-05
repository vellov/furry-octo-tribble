<?php
/**
 * Created by PhpStorm.
 * User: vellovaherpuu
 * Date: 15/02/15
 * Time: 22:41
 */

include 'conf.php';

$params = json_decode(file_get_contents('php://input'),true);
$candidateId=$params["candidateId"];
$userId=$params["userId"];
$electionId=$params["electionId"];

$qry = "SELECT * FROM VOTES WHERE user_id='$userId' and election_id='$electionId'";
$result=pg_query($qry);
if(pg_num_rows($result)> 0){
    $qry="UPDATE Votes SET candidate_id='$candidateId' WHERE user_id='$userId' and election_id='$electionId'";
}
else{
    $qry="INSERT INTO Votes (candidate_id, election_id, user_id) VALUES ('$candidateId', '$electionId', '$userId')";
}

$qry_res = pg_query($qry);
if ($qry_res) {
    //printf($qry_res);
    $arr = array('msg' => "Vote Added Successfully!!!");
    $jsn = json_encode($arr);
// print_r($jsn);
} else {
    $arr = array('error' => 'Error in saving vote');
    $jsn = json_encode($arr);

}
print_r($jsn);
?>