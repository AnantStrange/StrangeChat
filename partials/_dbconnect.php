<?php

$server = "localhost";
$user = "StrangeChat";
$pass = "StrangeChat";
$db = "StrangeDB";

$conn = mysqli_connect($server,$user,$pass,$db);
if (!$conn){
    die("Error".mysqli_connect_error());
}

date_default_timezone_set('UTC'); // Set the timezone to UTC


?>


