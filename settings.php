<head>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <link rel="stylesheet" href="/css/settings.css" class="css">

    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once($root . "/partials/_navbar.php");
    require_once($root . "/partials/_dbconnect.php");

    ?>

</head>

<body>

    <div class="box">

        <label for="username">Role Update</label>
        
        <hr>


    </div>


</body>
