<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <link rel="stylesheet" href="/css/header.css" class="css">
    <title>Home Page</title>
</head>


<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$root = $_SERVER['DOCUMENT_ROOT'];
$username = $_SESSION['userName'];
$userRole = $_SESSION['userRole'];

$visibilityLevels = [
    'admin'  => 0,
    'staff'  => 1,
    'mod'    => 2,
    'everyone' => 3,
];

$defaultVisibility = 3;
$visibilityThreshold = isset($visibilityLevels[$userRole]) ? $visibilityLevels[$userRole] : $defaultVisibility;



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ob_end_flush();
    require($root . "/partials/_dbconnect.php");

    $action = isset($_POST['action']) ? $_POST['action'] : '';
    switch ($action) {
        case 'sendto':
            $sendTo = $_POST['sendto'];
            $message = $_POST['message'];

            $commands = [];
            preg_match_all('/[\/!](\w+)/', $message, $commands);

            // Check for @username tags
            $usernames = [];
            preg_match_all('/@(\w+)/', $message, $usernames);

            // Output results
            /* echo "Commands: "; */
            /* print_r($commands[1]); */

            /* echo "Usernames: "; */
            /* print_r($usernames[1]); */



            if (array_key_exists($sendTo, $visibilityLevels)) {
                $visibilityLevel = $visibilityLevels[$sendTo];
            } else {
                $visibilityLevel = -1;
            }

            $stmt = $conn->prepare("INSERT INTO messages (sender, receiver, visibility_level, text, dt) VALUES (?, ?, ?, ?, UTC_TIMESTAMP())");
            $stmt->bind_param("ssss", $username, $sendTo, $visibilityLevel, $message);
            $stmt->execute();
            $stmt->close();
            break;

        case "delete_last_message":
            $sql = "DELETE FROM messages WHERE sender = ? ORDER BY dt DESC LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->close();
            break;

        case "delete_all_messages":
            $sql = "DELETE FROM messages WHERE sender = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
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
                <option value="mod">-Mods only-</option>
                <option value="staff">-Staff only-</option>
                <option value="admin">-Admin only-</option>
                <?php

                $root = $_SERVER['DOCUMENT_ROOT'];
                require_once($root . "/partials/_dbconnect.php");

                $sql = "SELECT username FROM users";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $username = $row['username'];
                        echo "<option value='$username'>$username</option>";
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
