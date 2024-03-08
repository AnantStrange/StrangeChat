<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <link rel="stylesheet" href="/css/profile.css" class="css">
    <title>Profile</title>
    <?php
    session_start();
    if (!isset($_SESSION['userName'])) {
        header("location:/home.php");
        die();
    }

    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once($root . "/partials/_navbar.php");
    ?>
</head>

<body>







</body>




