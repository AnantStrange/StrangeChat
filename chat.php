<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Home Page</title>
</head>

<style>
    html,
    body {
        color: rgb(209, 205, 199);
        background-color: rgb(24, 26, 27);
        height: 100%;
    }

    body {
        position: relative;
    }

    body:before {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1;
        background-image: url('images/skeletons.png');
        opacity: 0.1;
    }

    body>* {
        position: relative;
        z-index: 2;
    }

    *,
    p {
        margin: 0px 0px;
        box-sizing: border-box;
    }

    header {
        margin: 50px auto;
        text-align: center;
    }

    .inbox {
        display: flex;
        flex-direction: column;
        margin: 20px;
        align-items: center;
    }

    input {
        background-color: rgb(59, 59, 59);
        border-radius: 6px;
    }

    .inbox>button,
    select {
        margin: 6px auto;
        border-radius: 3px;
        width: 100px;
        text-align: center;
    }

    input {
        color: white;
    }

    .box_item {
        margin: auto;
        display: block;
        margin: 4px;
        width: fit-content;
    }

    #captcha {
        margin-left: 11px;
    }

    .box {
        padding: 40px;
        border: 2px soild blue;
        display: block;
        width: fit-content;
        margin: 30px auto;
        border: 3px solid purple;
        border-radius: 10px;
    }
</style>

<body>

    <?php
    session_start();
    $root = $_SERVER['DOCUMENT_ROOT'];
    require($root . "/components/navbar.php");
    ?>

    <header>
        <h1>StrangeChat</h1>
    </header>

        <?php
        echo $_SESSION['userName'] 
        ?> 
    


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
