<?php
$cleardb_server = "localhost";
$cleardb_username = "root";
$cleardb_password = "sheerovlakas";
$cleardb_db = "mydb";

// Connect to DB
$con = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
if (!$con){
	die("Connection failed: " . mysqli_connect_error());
}

?>