<?php
// Create connection
$username=getenv ('dbuser');
$password=getenv('dbpw');
$conn_string = "host=ec2-54-163-226-9.compute-1.amazonaws.com port=5432 dbname=dab5ij0qg92dja user=$username password=$password";
$conn = pg_connect($conn_string) or die ("connection failed");


?>