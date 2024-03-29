<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <link rel="stylesheet" href="/css/chat.css" class="css">
    <title>Home Page</title>

    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['userName'])) {
        header("location:/home.php");
        exit();
    }
    if (isset($_SESSION['in_waitroom']) && $_SESSION['in_waitroom']) {
        header("location:/waitroom.php");
        exit();
    }

    $root = $_SERVER['DOCUMENT_ROOT'];
    $username = $_SESSION['userName'];
    require($root . "/partials/_navbar.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'settings') {
        header('Location: settings.php');
        exit;
    }

    ?>

</head>


<body>

    <div id="chat_header_iframe">
        <iframe src="/chat_header_iframe.php"></iframe>
    </div>
    <div class="midsec">
        <div id="chat_message_iframe">
            <iframe src="/chat_message_iframe.php"></iframe>
        </div>

        <div id="chat_aside_iframe">
            <iframe src="/chat_aside_iframe.php"></iframe>
        </div>

    </div>

</body>

</html>
