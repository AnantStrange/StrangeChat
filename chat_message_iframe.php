<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="refresh" content="10">
    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <link rel="stylesheet" href="/css/chat_message_iframe.css" class="css">
    <title>chat_iframe</title>
    <script>
        var audio = new Audio("sound1.mp3");
    </script>

    <?php

    session_start();
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once($root . "/partials/_dbconnect.php");

    $userName = $_SESSION['userName'];
    $userRole = $_SESSION['userRole'];

    ?>
</head>

<?php

function getStyle($conn, $userName)
{
    $setting = '';
    $stmt = $conn->prepare("SELECT setting FROM user_settings WHERE username = ?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $stmt->bind_result($setting);

    // Fetch the setting (assuming it's a JSON string)
    if ($stmt->fetch()) {
        $userSettings = json_decode($setting, true);

        // Initialize style string
        $style = "style=\"";

        // Check and add userColor to style
        if (isset($userSettings['userColor'])) {
            $userColor = $userSettings['userColor'];
            $style .= "color: $userColor; ";
        }

        // Check and add fontColor to style
        if (isset($userSettings['fontColor'])) {
            $fontColor = $userSettings['fontColor'];
            $style .= "font-color: $fontColor; ";
        }

        // Check and add Italics to style
        if (isset($userSettings['italics']) && $userSettings['italics'] == true) {
            $style .= "font-style: italic; ";
        }

        // Check and add bold to style
        if (isset($userSettings['bold']) && $userSettings['bold'] == true) {
            $style .= "font-weight: bold; ";
        }

        // Close the style attribute
        $style .= "\"";

        return $style;
    }
    return;
}


function getChannelIndicator($msgRow)
{

    $messageId = $msgRow['id'];
    $userName = $_SESSION['userName'];
    $sender = $msgRow['sender'];

    if (!isset($_SESSION['read_messages'])) {
        $_SESSION['read_messages'] = array();
    }

    switch ($msgRow['receiver']) {
        case "admin":
            $channelIndicator = "[A] " . $sender;
            break;
        case "staff":
            $channelIndicator = "[S] " . $sender;
            break;
        case "mod":
            $channelIndicator = "[M] " . $sender;
            break;
        case "everyone":
            $channelIndicator = $sender;
            break;
        case $userName:
            $channelIndicator = "[{$msgRow['sender']} to {$msgRow['receiver']}]";
            if (!in_array($messageId, $_SESSION['read_messages'])) {
                $_SESSION['read_messages'][] = $messageId;
            }
            break;
        default:
            break;
    }
    return $channelIndicator;
}

function getMessages($conn)
{

    $userName = $_SESSION['userName'];
    $visibilityLevel = $_SESSION['visibilityLevel'];

    $sql = "SELECT * FROM messages WHERE receiver = ? OR visibility_level >= ? ORDER BY dt DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $userName, $visibilityLevel);
    $stmt->execute();
    $messages = $stmt->get_result();
    $stmt->close();

    while ($msgRow = mysqli_fetch_assoc($messages)) {

        $channelIndicator = getChannelIndicator($msgRow);
        $style = getStyle($conn, $msgRow['sender']);
        $dt = (new DateTime($msgRow['dt']))->format('m-d H:i:s');

        echo "<p class='user_messages'>";
        echo "<small class='msg-dt'>" . $dt . " || </small>";
        echo "<span class='msg-sender' $style> $channelIndicator </span>";
        echo " => ";
        echo "<span class='msg-text' $style>" . $msgRow['text'] . "</span>";
        echo "</p>";

        echo "<hr>";
    }
}

?>



<body>

    <?php

    /* admin 0 staff 1 mod 2 member 3 guest 3 */
    getMessages($conn);

    ?>

</body>
