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

    /* $visibilityLevels = [ */
    /*     'admin'  => 0, */
    /*     'staff'  => 1, */
    /*     'mod'    => 2, */
    /*     'member' => 3, */
    /*     'guest' => 3, */
    /* ]; */
    /* $visibilityLevel = isset($visibilityLevels[$userRole]) ? $visibilityLevels[$userRole] : 3; */

    ?>
</head>

<?php

function getStyle($conn, $userName)
{
    // Perform a SQL query to fetch the userColor for the given username
    $sql = "SELECT settings FROM user_settings WHERE username = '$userName'";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        // Fetch the row as an associative array
        $row = mysqli_fetch_assoc($result);

        // Check if the row exists and contains the 'settings' column
        if ($row && isset($row['settings'])) {
            // Decode the JSON-like settings data
            $settings = json_decode($row['settings'], true);

            // Check if 'userColor' exists in the settings
            if (isset($settings['userColor'])) {
                // Return the style attribute with the color
                return "style='color: " . $settings['userColor'] . "'";
            }
        }
    }

    // Default return value if something goes wrong
    return null;
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

    $sql = "SELECT * FROM messages WHERE receiver = '$userName' OR visibility_level >= '$visibilityLevel' ORDER BY dt DESC";
    $messages = mysqli_query($conn, $sql);

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
