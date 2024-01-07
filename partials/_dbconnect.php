<?php

$server = "localhost";
$user = "StrangeChat";
$pass = "StrangeChat";
$db = "StrangeChat";

$conn = mysqli_connect($server,$user,$pass,$db);
if (!$conn){
    die("Error".mysqli_connect_error());
}



?>


