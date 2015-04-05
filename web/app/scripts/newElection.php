<?php
/**
 * Created by PhpStorm.
 * User: vellovaherpuu
 * Date: 15/02/15
 * Time: 22:41
 */

include 'conf.php';
/*
if ($result = $conn->query("SELECT * FROM Candidates")) {
  //  printf("Select returned %d rows.\n", $result->num_rows);
}
----------*/
$params = json_decode(file_get_contents('php://input'),true);
//var_dump($params);
$valimine=$params["valimine"];
$name=$valimine["nimetus"];
$description=$valimine["kirjeldus"];
$qry = "INSERT INTO Elections(name, description) VALUES('$name','$description');";

$qry_res = pg_query($qry);
if ($qry_res) {
    // printf($qry_res);
    $arr = array('msg' => "Product Updated Successfully!!!", 'error' => '');
    $jsn = json_encode($arr);
// print_r($jsn);
} else {
    $arr = array('msg' => "", 'error' => 'Error In Updating record');
    $jsn = json_encode($arr);
// print_r($jsn);
}
?>