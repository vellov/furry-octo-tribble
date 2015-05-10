<?php
/**
 * Created by PhpStorm.
 * User: vellovaherpuu
 * Date: 15/02/15
 * Time: 22:41
 */

include 'conf.php';
//Baasist kandidaadid, kus election_id=parameeter $http päringust
$params=$_GET;
$electionId=$params["electionId"];
$qry="select Candidates.id,Candidates.firstname,Candidates.lastname,Candidates.user_id as userid, Candidates.description, COALESCE(x.cnt,0) as votecount
from Candidates
left outer join (SELECT candidate_id, count(*) cnt from Votes GROUP by candidate_id) x on Candidates.id=x.candidate_id
where Candidates.election_id='$electionId'";

$result = pg_query($qry);
$result=pg_fetch_all($result);
$rows = array();
if($result){
	foreach($result as $row){
	    $rows[]=$row;
	}
}
print json_encode($rows);
?>