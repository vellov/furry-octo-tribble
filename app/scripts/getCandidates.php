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
if ($result = $conn->query("SELECT * FROM Candidates WHERE election_id=$electionId")) {
}
$rows = array();
foreach($result as $row){
    $rows[]=$row;
}
print json_encode($rows);
?>