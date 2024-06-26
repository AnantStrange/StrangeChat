<!doctype html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <link rel="stylesheet" href="/css/chat_aside_iframe.css" class="css">
    <title>Home Page</title>
    <?php

    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once($root . "/partials/_dbconnect.php");
    $userRoles = ['admin', 'staff', 'mod', 'member', 'guest'];

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $userName = $_SESSION['userName'];
    $userRole = $_SESSION['userRole'];

    if (isset($_SESSION['kicked']) && $_SESSION['kicked'] == 1){
        die("YOu have been Kicked");
    }

    $isKicked = '';
    $stmt = $conn->prepare("SELECT status FROM users WHERE username = ?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $stmt->bind_result($isKicked);
    if ($isKicked) {
        die("YOu have been Kicked");
    }
    $stmt->close();

    $refreshRate = getRefreshRate();
    echo '<meta http-equiv="refresh" content="' . $refreshRate . '">';
    ?>
</head>

<?php

function getRefreshRate() {
    global $conn, $userName;

    $stmt = $conn->prepare("SELECT JSON_UNQUOTE(JSON_EXTRACT(setting, '$.refreshRate')) as refreshRate FROM user_settings WHERE username = ?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();

    $result = null;
    $stmt->bind_result($result);

    if ($stmt->fetch()) {
        return $result;
    } else {
        return 10;
    }

    $stmt->close();
    return $result;
}

function getColor($userName) {
    global $conn;
    $stmt = $conn->prepare("SELECT JSON_UNQUOTE(JSON_EXTRACT(setting, '$.userColor')) as userColor FROM user_settings WHERE username = ?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();

    $result = null;
    $stmt->bind_result($result);

    if ($stmt->fetch()) {
        return $result;
    } else {
        return "white";
    }

    $stmt->close();
    return $result;
}

function printUserListByRole($conn, $userRole) {
    $query = "SELECT u.username, us.hide_enabled
              FROM users u
              JOIN sessions uli ON u.username = uli.username
              LEFT JOIN user_settings us ON u.username = us.username
              WHERE u.userRole = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $userRole);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if (mysqli_num_rows($result) > 0) {
        echo "<h3>" . ucfirst($userRole) . "s</h3>";
        while ($row = $result->fetch_assoc()) {
            $color = getColor($row['username']);

            if (!$row['hide_enabled']) {
                echo "<p class='user_list_p' style='color: $color;'>" . $row['username'] . "</p>";
            }

            echo "<hr>";
        }
        echo "<br><br>";
    }
}

?>

<aside>
    <?php

    foreach ($userRoles as $userRole) {
        printUserListByRole($conn, $userRole);
    }

    ?>
</aside>
