<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <link rel="stylesheet" href="/css/header.css" class="css">
    <title>Home Page</title>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once($root . "/partials/_dbconnect.php");
    $userName = $_SESSION['userName'];
    $userRole = $_SESSION['userRole'];

    $visibilityLevels = [
        'admin'  => 0,
        'staff'  => 1,
        'mod'    => 2,
        'everyone' => 3,
    ];

    $defaultVisibility = 3;
    $visibilityThreshold = isset($visibilityLevels[$userRole]) ? $visibilityLevels[$userRole] : $defaultVisibility;
    ?>
</head>
<?php

function getUserIdByUsername($conn, $userName) {
    $userId = "";
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $stmt->bind_result($userId);

    if ($stmt->fetch()) {
        $stmt->close();
        return $userId;
    } else {
        $stmt->close();
        return false;
    }
}

function handleMsg($conn) {
    global $visibilityLevels;
    global $userName;

    $sendTo = $_POST['sendto'];
    $message = $_POST['message'];
echo "message : ". $message;
    $allowedValues = array("everyone", "mod", "member", "staff", "admin");

    $isPm = 0;
    $isTag = 0;
    $tags = [];

    if (!in_array($sendTo, $allowedValues)) {
        $isPm = 1;
    }

    /* $commands = []; */
    /* preg_match_all('/[\/!](\w+)/', $message, $commands); */

    // Check for @username tags
    if (preg_match_all('/@(\w+)/', $message, $tags)) {
        $isTag = 1;
    }

    /* echo "Commands: "; */
    /* print_r($commands[1]); */

    echo "\nTags : ";
    print_r($tags[1]);

    if (array_key_exists($sendTo, $visibilityLevels)) {
        $visibilityLevel = $visibilityLevels[$sendTo];
    } else {
        $visibilityLevel = -1;
    }

    $stmt = $conn->prepare("INSERT INTO messages (sender, receiver, visibility_level, pm, tag, text) VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssiis", $userName, $sendTo, $visibilityLevel, $isPm, $isTag, $message);
    
    $stmt->execute();
    $stmt->close();

    $msgId = $conn->insert_id;

    // Insert tags into the message_tags table
    foreach ($tags[1] as $taggedUser) {
        $taggedUserId = getUserIdByUsername($conn, $taggedUser);

        if ($taggedUserId !== false) {
            $stmt = $conn->prepare("INSERT INTO message_tags (message_id, user_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $msgId, $taggedUserId);
            $stmt->execute();
            $stmt->close();
        }
    }
}

?>



<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require($root . "/partials/_dbconnect.php");

    $action = isset($_POST['action']) ? $_POST['action'] : '';
    switch ($action) {
        case 'sendto':
            handleMsg($conn);
            break;

        case "delete_last_message":
            $sql = "DELETE FROM messages WHERE sender = ? ORDER BY dt DESC LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $userName);
            $stmt->execute();
            $stmt->close();
            break;

        case "delete_all_messages":
            $sql = "DELETE FROM messages WHERE sender = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $userName);
            $stmt->execute();
            $stmt->close();
            break;

        default:
            break;
    }
}

?>

<header>
    <form action="chat_header_iframe.php" method="post">
        <div id="header_sec1">
            <?php echo $_SESSION["userName"] . ":"; ?>
            <input type="text" name="message" placeholder="Message">
            <button type="submit" name="action" value="sendto">Send to</button>
            <select name="sendto" size="1">
                <option value="everyone">-All chatters-</option>
                <option value="member">-Member only-</option>
                <option value="mod">-Mods only-</option>
                <option value="staff">-Staff only-</option>
                <option value="admin">-Admin only-</option>
                <?php


                $sql = "SELECT username FROM users";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $userName = $row['username'];
                        echo "<option value='$userName'>$userName</option>";
                    }
                }

                ?>
            </select>
            <label><input type="checkbox" name="kick" value="kick">Kick</label>
            <label><input type="checkbox" name="what" value="purge" checked>Also purge messages</label>
        </div>
        <div id="header_sec2">
            <button type="submit" name="action" value="delete_last_message" class="delbutton">Delete Last Message</button>
            <button type="submit" name="action" value="delete_all_messages" class="delbutton">Delete All Messages</button>
            <button type="submit" name="action" value="switch_to_multi-line">Switch to Multi-line</button>
        </div>
    </form>
</header>
