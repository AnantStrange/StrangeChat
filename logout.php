<?php

header("Cache-Control: no-store, no-cache, must-revalidate");
session_start();

$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root . "/partials/_navbar.php");
require_once($root . "/partials/_dbconnect.php");

$username = mysqli_real_escape_string($conn, $_SESSION['userName']);
$sql = "DELETE FROM users_logged_in WHERE users_logged_in.username = '$username'";
$result = mysqli_query($conn, $sql);

$_SESSION = array();
session_destroy();

header("Location: /home.php");
exit();

?>
