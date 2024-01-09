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
    $messages = mysqli_query($conn, $sql);
    while ($row = $messages->fetch_assoc()) {

        $sql = "SELECT * FROM user_settings WHERE username='" . $row['sender'] . "'";
        $result = mysqli_query($conn, $sql);
        $color = "";
        if (mysqli_num_rows($result) == 1) {
            $result = $result->fetch_assoc();
            $color = $result['color'];
        }

        $style = ($color !== '') ? "style='color: $color;'" : ''; // Apply user-specific color if available

        $para = "<p class='user_messages'>
            <span class='msg-dt'>" . $row['dt'] . " :</span>
            <span class='msg-sender' $style>" . $row['sender'] . " -</span>
            <span class='msg-text'>" . $row['text'] . "</span>
        </p>";
        echo $para;
        echo "<hr>";
    }



    ?>

</body>
