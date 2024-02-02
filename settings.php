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

function refreshRate() {
    echo '<form action="/settings_handle/php" method="post">';
    echo "<label for='refreshRate'>RefreshRate(s) :</label>";
    echo '<input type="number" name="refresh" size="3" min="5" max="150" value="10">';
    echo '<button type="submit" name="action" value="refreshUpdate">Update</button>';
    echo '</form>';
}

function fontColor($conn, $userName) {
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

    echo '<form action="/settings_handle.php" method="post">';
    echo "<label for='username'>Font :</label>";
    echo '<input type="text" name="fontColor" placeholder="Enter Color Hex"></input>';
    echo "or";
    echo '<select name="userColor" id="userColor" class="grid-col-span-2 margin-auto">';
    foreach ($availableColors as $value => $label) :
        echo '<option value="' . $value . '">' . $label . '</option>';
    endforeach;
    echo '</select>';
    echo '<button type="submit" name="action" value="fontUpdate">Update</button>';
    echo '</form>';
};

function roleUpdate($conn) {
    echo '<form action="/settings_handle.php" method="post">';
    echo "<label for='username'>Role Update</label>";
    echo "<select name='username' size='1'>";

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
    refreshRate($conn);
    echo "<hr><br>";
    fontColor($conn, $userName);
    echo "<hr><br>";
}

function mods_settings($conn) {
}

function staff_settings($conn) {
    roleUpdate($conn);
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
