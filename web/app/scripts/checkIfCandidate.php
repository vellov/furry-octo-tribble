<?php
/**
 * Created by PhpStorm.
 * User: vellovaherpuu
 * Date: 09/03/15
 * Time: 22:37
 */
include 'conf.php';

$params=$_GET;
$userId=$params["userId"];
$electionId=$params["electionId"];

if ($result = pg_query("SELECT * FROM Candidates where user_id='$userId' and election_id='$electionId'")) {
      printf(json_encode(array('isCandidate' =>  pg_num_rows($result))));
}
?>