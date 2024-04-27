<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta http-equiv="refresh" content="10">
    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <link rel="stylesheet" href="/css/waitroom.css" class="css">
    <title>Waitroom</title>
    <?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['userName'])) {
        header("location:/home.php");
        exit();
    }

    $root = $_SERVER['DOCUMENT_ROOT'];

    if (!isset($_SESSION['in_waitroom']) || !$_SESSION['in_waitroom']) {
        header("location:/chat.php");
        exit();
    }


    ?>
</head>

<body>
    waitroom enabled
        <?php
        
        

        ?>



</body>
