<?php

include 'conf.php';

$params=$_GET;
$userId=$params["userId"];
$electionId=$params["electionId"];
$candidateId=$params["candidateId"];

if ($result = pg_query("SELECT * FROM Votes where user_id='$userId' and election_id='$electionId' and candidate_id='$candidateId'")) {
      printf(json_encode(array('hasVoted' =>  pg_num_rows($result))));
}
?>