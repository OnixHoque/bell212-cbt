<?php
session_start();


// connect to database
$db = mysqli_connect("localhost", "root", "mysql", "cbt-db");

$pincode = mysqli_query($db, "SELECT * FROM CREDENTIAL");
$row = mysqli_fetch_array($pincode);


$pin = $row['PINCODE'];

if(isset($_POST['password']) && $_POST['password']==$pin){
		$num = rand();
		$code = md5($num); 
		$_SESSION["code"] = $code;
		echo 'true';
    }
    else{
        unset($_SESSION);
        echo 'false';
    }

?>
