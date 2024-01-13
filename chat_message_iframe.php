<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="refresh" content="10"> 
    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <link rel="stylesheet" href="/css/chat_message_iframe.css" class="css">
    <title>chat_iframe</title>
</head>



<body>

    <?php
    session_start();

    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once($root . "/partials/_dbconnect.php");


    $userName = $_SESSION['userName'];
    $userRole = $_SESSION['role'];
    /* $specialChannel = ($userRole == 'admin') ? 'EVERYONE' : $userRole; */


    $visibilityLevels = [
        'admin'  => 0,
        'staff'  => 1,
        'mod'    => 2,
        'everyone' => 3,
    ];

    $defaultVisibility = 3;
    $visibilityLevel = isset($visibilityLevels[$userRole]) ? $visibilityLevels[$userRole] : $defaultVisibility;

    /* $sql = "SELECT * FROM messages WHERE reciever = ? OR reciever = 'EVERYONE' ORDER BY dt DESC"; */
    /* 
            admin 0 
            staff 1
            mod 2
            member 3
            guest 3

        
         */
    $sql = "SELECT * FROM messages WHERE reciever = '$userName' OR visibility_level >= '$visibilityLevel' ORDER BY dt DESC";

    $messages = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($messages)) {

        $sql = "SELECT * FROM user_settings WHERE username='" . $row["sender"] . "'";

        $result = mysqli_query($conn, $sql);
        $color = "";
        if (mysqli_num_rows($result) == 1) {
            $result = $result->fetch_assoc();
            $color = $result['color'];
        }

        $style = ($color !== '') ? "style='color: $color;'" : ''; // Apply user-specific color if available


        $channelIndicator = "";
        $pm = false;
        switch ($row['reciever']) {
            case "admin":
                $channelIndicator = "[A] ";
                break;
            case "staff":
                $channelIndicator = "[S] ";
                break;
            case "mod":
                $channelIndicator = "[M] ";
                break;
            case "everyone":
                $channelIndicator = "";
                break;
            default:
                $pm = true;
                break;
        }
        $dt = (new DateTime($row['dt']))->format('m-d H:i:s');

        echo "<p class='user_messages'>";
        echo "<span class='msg-dt'>" . $dt . " || </span>";
        if ($pm) {
            echo "<span class='msg-sender' $style> [{$row['sender']} to {$row['reciever']}] => </span>";
        } else {
            echo "<span class='msg-sender' $style>" . $channelIndicator . $row['sender'] . " => </span>";
        }
        echo "<span class='msg-text'>" . $row['text'] . "</span>";
        echo "</p>";

        echo "<hr>";
    }



    ?>

</body>
