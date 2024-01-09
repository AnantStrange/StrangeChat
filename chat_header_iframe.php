<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <title>Home Page</title>
</head>


<style>
    body {
        background-color: #181a1b;
        color: white;
        height: fit-content;
        margin-top: 4px;
        margin-bottom: 4px;
    }

    #header_sec1,
    #header_sec2 {
        display: block;
        width: fit-content;
        margin: 0px auto;
    }

    input,button,select{
        color : black;
    }

    .delbutton {
        color: white;
        background-color: #660000
    }

</style>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$root = $_SERVER['DOCUMENT_ROOT'];
$username = $_SESSION['userName'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ob_end_flush();
    require($root . "/partials/_dbconnect.php");

    $action = isset($_POST['action']) ? $_POST['action'] : '';
    switch ($action) {
        case 'sendto':
            $msg_to = $_POST['sendto'];
            $message = mysqli_real_escape_string($conn, $_POST['message']);
            $sql = "INSERT INTO messages (sender, reciever, text, dt) VALUES ('$username', '$msg_to', '$message', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            break;

        case "delete_last_message":
            $sql = "DELETE FROM messages WHERE sender = '$username' ORDER BY dt DESC LIMIT 1";
            mysqli_query($conn, $sql);
            break;

        case "delete_all_messages":
            $sql = "DELETE FROM messages WHERE sender = '$username' ";
            mysqli_query($conn, $sql);
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
                <option value="members">-Members only-</option>
                <option value="staff">-Staff only-</option>
                <option value="admin">-Admin only-</option>
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
