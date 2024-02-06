<!doctype html>
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
    $multiLine = false;

    $visibilityLevels = [
        'admin'  => 0,
        'staff'  => 1,
        'mod'    => 2,
        'member'    => 3,
        'everyone' => 4,
    ];

    $defaultVisibility = 3;
    $visibilityThreshold = isset($visibilityLevels[$userRole]) ? $visibilityLevels[$userRole] : $defaultVisibility;
    ?>
</head>
<?php

function back_to_home($session) {
    /* mysqli_close($db); */

    // save current admin session (optional).
    $admin_session = session_id();
    // get target id.
    $session_id_to_destroy = $session;
    // close the current session.
    session_write_close();
    // load the specified target session 
    session_id($session_id_to_destroy);
    // start the target session.
    session_start();
    // clean all session data in target session.
    $_SESSION = [];
    // save and close that session.
    session_write_close();

    // Optional if you need to resume admin session:

    // reload admin session id
    session_id($admin_session);
    // restart admin session. . ..
    session_start();

    // header should go to a specific file. 
    /* header('Location: ../index.php'); */
    exit;
}

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

function handleKick($conn) {
    $userRole = $_SESSION['userRole'];
    /* $userName = $_SESSION['userRole']; */
    global $visibilityLevels;
    if (in_array($userRole, ["guest", "member"])) {
        return;
    }

    $toKick = $_POST['sendto'];
    $stmt = $conn->prepare("select userrole from users where username = ?");
    $stmt->bind_param("s", $toKick);
    $stmt->execute();
    $result = $stmt->get_result();
    $toKickUserRole = $result->fetch_assoc()['userrole'];
    if ($stmt->errno) {
        echo "Error executing statement: " . $stmt->error;
    } else {
        /* echo "Insert successful"; */
    }
    $stmt->close();


    $userLevel = $visibilityLevels[$userRole];
    $toKickUserLevel = $visibilityLevels[$toKickUserRole];

    if ($userLevel >= $toKickUserLevel) {
        return;
    }

    $kickStmt = $conn->prepare("UPDATE users SET status = 'kicked' WHERE username = ?");
    $kickStmt->bind_param("s", $toKick);
    $kickStmt->execute();
    if ($kickStmt->errno) {
        echo "Error executing statement: " . $stmt->error;
    } else {
        /* echo "user kicked bool set in users table"; */
    }
    $kickStmt->close();
    /* echo "user to kick :" . $toKick . "\n"; */

    $stmt = $conn->prepare("SELECT session_id FROM users_logged_in WHERE username = ?");
    $stmt->bind_param("s", $toKick);
    $stmt->execute();

    if ($stmt->errno) {
        echo "Error executing statement: " . $stmt->error;
    } else {
        /* echo "purged messages"; */
    }

    $result = $stmt->get_result();
    $sessionId = $result->fetch_assoc()['session_id'];
    $stmt->close();

    back_to_home($sessionId);

    if ($_POST['purge'] = "purge") {
        $stmt = $conn->prepare("delete from messages where sender=?");
        $stmt->bind_param("s", $toKick);
        $stmt->execute();
        if ($stmt->errno) {
            echo "Error executing statement: " . $stmt->error;
        } else {
            echo "purged messages";
        }
        $stmt->close();
    }
}

function insertTags($conn, $msgId, $tags) {
    foreach ($tags[1] as $taggedUser) {
        $taggedUserId = getUserIdByUsername($conn, $taggedUser);
        if ($taggedUserId !== false) {
            $stmt = $conn->prepare("INSERT INTO message_tags (msg_id, user_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $msgId, $taggedUserId);
            $stmt->execute();

            if ($stmt->errno) {
                echo "Error executing statement: " . $stmt->error;
            } else {
                /* echo "Insert successful"; */
            }
            $stmt->close();
        }
    }
}

function insertPms($conn, $msgId, $pmedUser) {

    $pmedUserId = getUserIdByUsername($conn, $pmedUser);
    $stmt = $conn->prepare("INSERT INTO message_pms (msg_id, user_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $msgId, $pmedUserId);
    $stmt->execute();

    if ($stmt->errno) {
        echo "Error executing statement: " . $stmt->error;
    } else {
        /* echo "Insert successful"; */
    }
    $stmt->close();
}

function handleMsg($conn) {
    global $visibilityLevels;
    global $userName;

    $sendTo = $_POST['sendto'];
    $message = $_POST['message'];
    $allowedValues = array("everyone", "mod", "member", "staff", "admin");
    $isPm = 0;
    $isTag = 0;
    $tags = [];

    // Check for pms 
    if (!in_array($sendTo, $allowedValues)) {
        $isPm = 1;
    }

    // Check for @username tags
    if (preg_match_all('/@(\w+)/', $message, $tags)) {
        $isTag = 1;
    }

    // -1 visibilityLevel denotes a pm, 
    if (array_key_exists($sendTo, $visibilityLevels)) {
        $visibilityLevel = $visibilityLevels[$sendTo];
    } else {
        $visibilityLevel = -1;
    }

    $stmt = $conn->prepare("INSERT INTO messages (sender, receiver, visibility_level, pm, tag, text) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiis", $userName, $sendTo, $visibilityLevel, $isPm, $isTag, $message);
    $stmt->execute();
    if ($stmt->errno) {
        echo "Error executing statement: " . $stmt->error;
    } else {
        /* echo "Insert successful"; */
    }
    $stmt->close();

    $msgId = $conn->insert_id;
    // Insert tags into the message_tags table
    if ($isTag) {
        insertTags($conn, $msgId, $tags);
    }

    // Insert PM into the message_pms table
    else if ($isPm) {
        insertPms($conn, $msgId, $sendTo);
    }
}

?>



<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require($root . "/partials/_dbconnect.php");

    $action = isset($_POST['action']) ? $_POST['action'] : '';
    switch ($action) {
        case 'sendto':
            if (isset($_POST['kick']) && $_POST["kick"] == "kick") {
                handleKick($conn);
            } else {
                handleMsg($conn);
            }
            break;

        case "delete_last_message":
            $sql = "DELETE FROM messages WHERE sender = ? ORDER BY dt DESC LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $userName);
            $stmt->execute();
            if ($stmt->errno) {
                echo "Error executing statement: " . $stmt->error;
            } else {
                /* echo "Insert successful"; */
            }

            $stmt->close();
            break;

        case "delete_all_messages":
            $sql = "DELETE FROM messages WHERE sender = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $userName);
            $stmt->execute();
            if ($stmt->errno) {
                echo "Error executing statement: " . $stmt->error;
            } else {
                /* echo "Insert successful"; */
            }
            $stmt->close();
            break;

        case "switch_to_single-line":
            $multiLine = false;
            break;
        case "switch_to_multi-line":
            $multiLine = true;
            break;
        default:
            break;
    }
}

?>

<header>
    <form action="chat_header_iframe.php" method="post">
        <div id="header_sec1">
            <?php
            echo $_SESSION["userName"] . ":";
            if (!$multiLine) {
                echo '<input type="text" name="message" placeholder="Message">';
            } else {
                echo '<textarea name="message" placeholder="Message"></textarea>';
            }
            ?>

            <button type="submit" name="action" value="sendto">Send to</button>
            <select name="sendto" size="1">
                <option value="everyone">-All chatters-</option>
                <option value="member">-Member only-</option>
                <option value="mod">-Mods only-</option>
                <option value="staff">-Staff only-</option>
                <option value="admin">-Admin only-</option>
                <?php

                $sql = "SELECT username FROM users_logged_in";
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
            <?php
            if (!$multiLine) {
                echo '<button type="submit" name="action" value="switch_to_multi-line">Switch to Multi-line</button>';
            } else {
                echo '<button type="submit" name="action" value="switch_to_single-line">Switch to Single-line</button>';
            }

            ?>
        </div>
    </form>
</header>
