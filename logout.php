<?php

header("Cache-Control: no-store, no-cache, must-revalidate");
session_start();

$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root . "/partials/_navbar.php");
require_once($root . "/partials/_dbconnect.php");

$userName = $_SESSION['userName'];
$sql = "DELETE FROM sessions WHERE userName = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userName);
$stmt->execute();

$sql = "update users set status='offline' where username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userName);
$stmt->execute();

$stmt->close();

$_SESSION = array();
session_destroy();

header("Location: /home.php");
exit();

?>
