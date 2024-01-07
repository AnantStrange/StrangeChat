<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="refresh" content="10"> <!-- Refresh every 5 seconds -->
    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <link rel="stylesheet" href="/css/chat_message_iframe.css" class="css">
    <title>chat_iframe</title>
</head>



<body>

    <?php
    session_start();

    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once($root . "/partials/_dbconnect.php");

    $sql = "Select * from messages";
    $result = mysqli_query($conn, $sql);
    while ($row = $result->fetch_assoc()) {
        $para = "<p class='user_messages'><span class='message-info'>" . $row['dt'] . " : " . $row['sender'] . '</span> - <span class="message-text">' . $row['text'] . "</span></p>";
        echo $para;
    }



    ?>

</body>
