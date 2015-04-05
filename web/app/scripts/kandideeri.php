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
$kandidaat=$params["kandidaat"];
$nimi=$kandidaat["eesnimi"];
$perenimi=$kandidaat["perenimi"];
$kirjeldus=$kandidaat["kirjeldus"];
$electionId=$kandidaat["electionId"];
$userId=$kandidaat["userId"];
$qry = "INSERT INTO Candidates(firstname,lastname,description,election_id,user_id) VALUES('$nimi','$perenimi','$kirjeldus','$electionId','$userId');";

$qry_res = pg_query($qry);
if ($qry_res) {
    //printf($qry_res);
    $arr = array('msg' => "Candiadate inserted Successfully!!!", 'error' => '');
    $jsn = json_encode($arr);
// print_r($jsn);
} else {
    $arr = array('msg' => "", 'error' => 'Error In Updating record');
    $jsn = json_encode($arr);
// print_r($jsn);
}
print($jsn);
?>