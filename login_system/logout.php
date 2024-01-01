<?php
    header("Cache-Control: no-store, no-cache, must-revalidate");
    session_start();
    $root = $_SERVER['DOCUMENT_ROOT'];
    require $root . "/components/navbar.php";
    $_SESSION = array();
    session_destroy();
    header("Location: /home.php");
    exit();
?>
