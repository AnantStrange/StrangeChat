<head>
    <link rel="stylesheet" href="/css/settings.css" class="css">

    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once($root . "/partials/_navbar.php");
    require_once($root . "/partials/_dbconnect.php");
    $userName = $_SESSION['userName'];
    $userRole = $_SESSION['userRole'];

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

function refreshRateSetting() {
    $refreshRate = getRefreshRate();
    echo '<form action="settings.php" method="post">';
    echo "<label for='refreshRate'>RefreshRate(s) :</label>";
    echo '<input type="number" name="refreshRate" size="3" min="5" max="150" value="' . $refreshRate . '">';
    echo '<button type="submit" name="action" value="refreshUpdate">Update</button>';
    echo '</form>';
}

function fontColorSetting($conn, $userName) {
    $setting = '';
    $stmt = $conn->prepare("SELECT setting FROM user_settings WHERE
username=?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $stmt->bind_result($setting);
    if ($stmt->fetch()) {
        $userSettings = json_decode($setting, true);
        if (isset($userSettings['userColor'])) {
            $userColor = $userSettings['userColor'];
        }
    }

    $availableColors = [$userColor => $userColor];
    for ($i = 0; $i < 20; $i++) {
        $hexColor = "#" . dechex(mt_rand(0, 0xFFFFFF));
        $availableColors[$hexColor] = $hexColor;
    }

    echo '<form action="settings.php" method="post">';
    echo "<label for='username'>Font Color :</label>";
    echo '<input type="color" name="customFontColor" id="userColor" value="' . $userColor . '">';

    echo "or";
    echo '<select name="fontColor" id="userColor" class="grid-col-span-2 margin-auto">';
    foreach ($availableColors as $value => $label) :
        echo '<option value="' . $value . '">' . $label . '</option>';
    endforeach;
    echo '</select>';
    echo '<button type="submit" name="action" value="fontUpdate">Update</button>';
    echo '</form>';
};

function roleUpdateSetting($conn) {
    echo '<form action="settings.php" method="post">';
    echo "<label for='userName'>Role Update</label>";
    echo "<select name='userName' size='1'>";

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

    echo '
    </select>
    <select name="userRole">
        <option value="guest">Guest</option>
        <option value="members">Member</option>
        <option value="mod">Mod</option>
        <option value="staff">Staff</option>
        <option value="admin">Admin</option>
    </select>
    ';
    echo '<button type="submit" name="action" value="roleUpdate">Update</button>';
    echo '</form>';
}

function guests_settings($conn) {
    global $userName;
    refreshRateSetting($conn);
    echo "<hr><br>";
    fontColorSetting($conn, $userName);
    echo "<hr><br>";
}

function mods_settings($conn) {
}

function staff_settings($conn) {
    roleUpdateSetting($conn);
    echo "<hr>";
}

function admin_settings($conn) {
}

?>


<body>

    <div class="box">

        <?php
        switch ($userRole) {
            case "admin":
                admin_settings($conn);

            case "staff":
                staff_settings($conn);

            case "mod":
                mods_settings($conn);

            default:
                guests_settings($conn);
        }



        ?>


    </div>


</body>


<?php

function roleUpdate($userName, $userRole) {
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET userrole = ? WHERE username = ?");
    $stmt->bind_param("ss", $userRole, $userName);
    $stmt->execute();
}

function refreshUpdate($refreshRate) {
    global $conn;
    $userName = $_SESSION['userName'];

    $stmt = $conn->prepare("UPDATE user_settings SET setting = JSON_SET(setting, '$.refreshRate', ?) WHERE username = ?");
    $stmt->bind_param("ss", $refreshRate, $userName);
    $stmt->execute();
}

function colorUpdate($newFontColor) {
    global $conn;
    $userName = $_SESSION['userName'];

    $stmt = $conn->prepare("UPDATE user_settings SET setting = JSON_SET(setting, '$.userColor', ?) WHERE username = ?");
    $stmt->bind_param("ss", $newFontColor, $userName);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return "Font color updated successfully";
    } else {
        return "Failed to update font color";
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {

        case "roleUpdate":
            $userName = $_POST['userName'];
            $userRole = $_POST['userRole'];
            roleUpdate($userName, $userRole);
            break;
        case "refreshUpdate":
            $refreshRate = $_POST['refreshRate'];
            refreshUpdate($refreshRate);
            break;
        case "fontUpdate":
            if ($_POST['customFontColor'] !== "") {
                $newFontColor = $_POST['customFontColor'];
            } else {
                $newFontColor = $_POST['fontColor'];
            }
            echo "Font Color: " . $newFontColor;
            colorUpdate($newFontColor);
            break;
    }
}




?>
