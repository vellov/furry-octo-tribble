<?php
/**
 * Created by PhpStorm.
 * User: vellovaherpuu
 * Date: 15/02/15
 * Time: 22:41
 */

include 'conf.php';

$params = json_decode(file_get_contents('php://input'),true);
$firstName=$params["firstName"];
$lastName=$params["lastName"];
$fbid=$params["fbid"];
$email=$params["email"];
//ADD USER QUERY
$qry =
    "INSERT INTO USERS
    (name,lastname,fbid,email)
    SELECT '$firstName', '$lastName','$fbid','$email'
    WHERE
      NOT EXISTS (
      SELECT fbid FROM Users WHERE fbid='$fbid'
      )";

//GET ROLE QUERY
$getRole="SELECT role FROM Users WHERE fbid='$fbid';";

//Insert user if doesn't exist
$qry_res =pg_query($conn,$qry);
if ($qry_res) {
    $qry_res=pg_fetch_all($qry_res);
    $role=pg_query($conn,$getRole);//get role
    $role=pg_fetch_all($role);
    $rows = array();
    foreach($role as $row){
        $rows[]=$row;
    }
    print json_encode($rows);
} else {
    $arr = array('error' => 'Error In Updating record');
    $jsn = json_encode($arr);
    print_r($jsn);
}
?>
