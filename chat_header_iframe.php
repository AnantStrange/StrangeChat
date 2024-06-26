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
    if (isset($_SESSION['userName'])) {
        $userName = $_SESSION['userName'];
        $userRole = $_SESSION['userRole'];
    } else {
        /* echo "kicked"; */
        die();
    }
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
    checkAndUpdateActivity();
    ?>
</head>
<?php

function destroySession($session) {

    // save current admin session
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
    $_SESSION['kicked'] = 1;
    // save and close that session.
    session_write_close();
    // reload admin session id
    session_id($admin_session);
    // restart admin session. . ..
    session_start();
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

function handleKick() {
    global $conn;
    $userRole = $_SESSION['userRole'];
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
        $errorMessage = "Error executing statement: " . $stmt->error;
        error_log($errorMessage);
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
        $errorMessage = "Error executing statement: " . $kickStmt->error;
        error_log($errorMessage);
    }
    $kickStmt->close();

    $stmt = $conn->prepare("SELECT session_id FROM sessions WHERE username = ?");
    $stmt->bind_param("s", $toKick);
    $stmt->execute();

    if ($stmt->errno) {
        $errorMessage = "Error executing statement: " . $kickStmt->error;
        error_log($errorMessage);
    }

    $result = $stmt->get_result();
    $sessionId = $result->fetch_assoc()['session_id'];

    $stmt = $conn->prepare("delete from sessions where username = ?");
    $stmt->bind_param("s", $toKick);
    $stmt->execute();
    $stmt->close();

    destroySession($sessionId);

    if ($_POST['purge'] = "purge") {
        $stmt = $conn->prepare("delete from messages where sender=?");
        $stmt->bind_param("s", $toKick);
        $stmt->execute();
        if ($stmt->errno) {
            $errorMessage = "Error executing statement: " . $kickStmt->error;
            error_log($errorMessage);
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
                $errorMessage = "Error executing statement: " . $stmt->error;
                error_log($errorMessage);
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

    $stmt->close();
}

function usernameExistsInDatabase($username) {
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id);
    $stmt->fetch();
    $result = $stmt->num_rows > 0; // Store the result of the query
    $stmt->close(); // Close the statement
    return $result; // Return the stored result
}

// Function to check and update user activity
function checkAndUpdateActivity() {
    global $userName, $conn;
    $currentTime = time();
    $timeout = 15 * 60; // 15 minutes in seconds

    // Update last activity timestamp in the database
    $query = "UPDATE sessions SET last_activity = FROM_UNIXTIME(?) WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $currentTime, $userName);
    $stmt->execute();
    $stmt->close();

    // Check for inactive users
    /* $inactiveThreshold = $currentTime - $timeout; */
    /* $query = "DELETE FROM sessions WHERE last_activity < FROM_UNIXTIME(?)"; */
    /* $stmt = $conn->prepare($query); */
    /* $stmt->bind_param("i", $inactiveThreshold); */
    /* $stmt->execute(); */
    /* $stmt->close(); */
}

function handleMsg($sendTo = null, $message = null, $sendBy = null) {
    global $visibilityLevels;
    checkAndUpdateActivity();

    // If $sendTo, $message, and $sendBy are provided, use them directly
    if ($sendTo !== null && $message !== null) {
        // Process $sendTo, $message, and $sendBy as needed
    } else {
        // If not provided, fallback to $_POST values
        $sendTo = $sendTo ?? (isset($_POST['sendto']) ? $_POST['sendto'] : null);
        $message = $message ?? (isset($_POST['message']) ? $_POST['message'] : null);
    }
    if ($message == "") {
        return;
    }
    $allowedValues = array("everyone", "mod", "member", "staff", "admin");
    $isPm = 0;
    $isTag = 0;
    $tags = [];


    // Check for pms 
    if (!in_array($sendTo, $allowedValues)) {
        $isPm = 1;
    }

    // Check for @username tags
    // update this if statement to also check if he username is available in the db to set isTag = 1 
    if (preg_match_all('/@(\w+)/', $message, $tags)) {
        foreach ($tags[1] as $username) {
            if (usernameExistsInDatabase($username)) {
                $isTag = 1;
                break; // No need to continue if at least one valid username is found
            }
        }
    }

    // -1 visibilityLevel denotes a pm, 
    if (array_key_exists($sendTo, $visibilityLevels)) {
        $visibilityLevel = $visibilityLevels[$sendTo];
    } else {
        $visibilityLevel = -1;
    }

    if ($sendTo == "suggestion") {
        insertSuggestions($message);
    } else {
        insertMsg(
            $sendTo,
            $visibilityLevel,
            $isPm,
            $isTag,
            $message,
            $tags,
            $sendBy
        );
    }
}

function insertMsg(
    $sendTo,
    $visibilityLevel,
    $isPm,
    $isTag,
    $message,
    $tags,
    $sendBy
) {
    global $conn, $userName;

    $sender = $sendBy !== null ? $sendBy : $userName;

    $stmt = $conn->prepare("INSERT INTO messages (sender, receiver, visibility_level, pm, tag, text) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiis", $sender, $sendTo, $visibilityLevel, $isPm, $isTag, $message);
    $stmt->execute();
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

function insertSuggestions($message) {
    global $userName;

    $msg = "Suggestion Taken! Thank you @" . $userName . " :)";
    handleMsg($userName, $msg, "SuggestionBox");
    handleMsg("SuggestionBox", $message);
}


?>



<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require($root . "/partials/_dbconnect.php");

    $action = isset($_POST['action']) ? $_POST['action'] : '';
    switch ($action) {
        case 'sendto':
            if (isset($_POST['kick']) && $_POST["kick"] == "kick") {
                handleKick();
            } else {
                handleMsg();
            }
            break;

        case "delete_last_message":
            $sql = "DELETE FROM messages WHERE sender = ? ORDER BY dt DESC LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $userName);
            $stmt->execute();
            if ($stmt->errno) {
                $errorMessage = "Error executing statement: " . $kickStmt->error;
                error_log($errorMessage);
            }
            $stmt->close();
            break;

        case "delete_all_messages":
            $sql = "DELETE FROM messages WHERE sender = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $userName);
            $stmt->execute();
            if ($stmt->errno) {
                $errorMessage = "Error executing statement: " . $kickStmt->error;
                error_log($errorMessage);
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
                <option value="mod">-Mods only-</option>
                <option value="staff">-Staff only-</option>
                <option value="admin">-Admin only-</option>
                <option value="suggestion">Suggestion Box</option>
                <option value="void">void</option>
                <?php

                $sql = "SELECT username FROM sessions";
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
