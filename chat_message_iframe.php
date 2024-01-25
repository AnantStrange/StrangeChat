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

function getStyle($conn, $userName) {
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


function getChannelIndicator($msgRow) {

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

function getMessages($conn) {
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
        $senderStyle = getStyle($conn, $msgRow['sender']);  // Style for the sender
        $dt = (new DateTime($msgRow['dt']))->format('m-d H:i:s');

        echo "<p class='user_messages'>";
        echo "<small class='msg-dt'>" . $dt . " || </small>";
        echo "<span class='msg-sender' $senderStyle> $channelIndicator </span>";

        // Check if the message is tagged
        if ($msgRow['tag'] == 1) {
            // Get the tagged username from message_tags
            $taggedUserName = getTaggedUserName($conn, $msgRow['id']);
            // If the tagged username is found, get the color from user_settings
            if ($taggedUserName) {
                $taggedUserColor = getUserColor($conn, $taggedUserName);

                // Split the message into parts: before, tagged username, and after
                $parts = explode('@' . $taggedUserName, $msgRow['text'], 2);
                $beforeTagged = $parts[0];  // Text before the tagged username
                $afterTagged = isset($parts[1]) ? $parts[1] : '';  // Text after the tagged username

                echo " => ";
                echo "<span class='msg-text' $senderStyle>$beforeTagged</span>"; // Text before the tagged username with sender's color
                echo "<span class='tagged-username' style='color: $taggedUserColor;'>@$taggedUserName</span>"; // Tagged username with tagged user's color
                echo "<span class='msg-text' $senderStyle>$afterTagged</span>"; // Text after the tagged username with sender's color
            }
        } else {
            echo " => ";
            echo "<span class='msg-text' $senderStyle>" . $msgRow['text'] . "</span>"; // Regular text with sender's color
        }

        echo "</p>";

        echo "<hr>";
    }
}

// Function to get the tagged username from message_tags
function getTaggedUserName($conn, $msgId) {
    $stmt = $conn->prepare("SELECT username FROM message_tags mt
                           JOIN users u ON mt.user_id = u.id
                           WHERE mt.msg_id = ?");
    $stmt->bind_param("i", $msgId);
    $stmt->execute();
    $result = $stmt->get_result();
    $taggedUserName = $result->fetch_assoc()['username'];
    $stmt->close();

    return $taggedUserName;
}

// Function to get the color from user_settings
function getUserColor($conn, $userName) {
    $stmt = $conn->prepare("SELECT JSON_UNQUOTE(JSON_EXTRACT(setting, '$.userColor')) AS userColor FROM user_settings WHERE username = ?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $result = $stmt->get_result();
    // Check if the row exists before accessing the result
    if ($row = $result->fetch_assoc()) {
        $userColor = $row['userColor'];
    } else {
        // Handle the case where the user row doesn't exist or 'userColor' is not present
        $userColor = 'default_color'; // Set a default color or handle as needed
    }

    $stmt->close();
    return $userColor;
}

?>



<body>

    <?php

    /* admin 0 staff 1 mod 2 member 3 guest 3 */
    getMessages($conn);

    ?>

</body>
