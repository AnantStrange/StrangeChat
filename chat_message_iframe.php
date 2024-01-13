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

    /* $sql = "Select * from messages "; */

    $userRole = $_SESSION['role'];
    $specialChannel = ($userRole == 'admin') ? 'EVERYONE' : $userRole;
    $sql = "SELECT * FROM messages WHERE reciever = ? OR reciever = 'EVERYONE' ORDER BY dt DESC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $specialChannel);
    mysqli_stmt_execute($stmt);

    $messages = mysqli_stmt_get_result($stmt);

    /* $messages = mysqli_query($conn, $sql); */
    while ($row = mysqli_fetch_assoc($messages)) {

        $sql = "SELECT * FROM user_settings WHERE username='" .$row["sender"] . "'";
        $result = mysqli_query($conn, $sql);
        $color = "";
        if (mysqli_num_rows($result) == 1) {
            $result = $result->fetch_assoc();
            $color = $result['color'];
        }

        $style = ($color !== '') ? "style='color: $color;'" : ''; // Apply user-specific color if available


        $channelIndicator = "";
        if ($row['reciever'] == "member") {
            $channelIndicator = "[M] ";
        }
        if ($row['reciever'] == "Admin") {
            $channelIndicator = "[A] ";
        }

        $dt = (new DateTime($row['dt']))->format('m-d H:i:s');

        $para = "<p class='user_messages'>
            <span class='msg-dt'>" . $dt . " ||</span>
            <span class='msg-sender'>$style" . $channelIndicator . $row['sender'] . " =></span>
            <span class='msg-text'>" . $row['text'] . "</span>
            </p>";
        echo $para;
        echo "<hr>";
    }



    ?>

</body>
