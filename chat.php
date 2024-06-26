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

    $root = $_SERVER['DOCUMENT_ROOT'];
    $userName = $_SESSION['userName'];
    require_once($root . "/partials/_dbconnect.php");

    $stmt = $conn->prepare("select status from users where username=?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();

    if ($status == "waitroom") {
        header("location:/waitroom.php");
        exit();
    }

    require_once($root . "/partials/_navbar.php");

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
