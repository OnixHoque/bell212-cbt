<?php
$servername ="localhost";
$username = "root";
$password= "mysql";
$dbname="cbt-db";

$conn = mysqli_connect($servername,$username,$password,$dbname);

if($conn){
	//echo "Connection OK";
}

else
{
	die("Connection failed beacuse ".mysqli_connect_error());
}