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
$qry = "INSERT IGNORE INTO Users(name,lastname,fbid,email) VALUES('$firstName','$lastName','$fbid','$email');";
//Get role after insert
$getRole="SELECT role FROM Users WHERE fbid='$fbid';";
$qry_res = $conn->query($qry);
if ($qry_res) {
    $role=$conn->query($getRole);
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
