<head>
    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <link rel="stylesheet" href="/css/settings.css" class="css">

    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once($root . "/partials/_navbar.php");
    require_once($root . "/partials/_dbconnect.php");

    ?>

</head>

<?php

function refreshRate()
{
    echo "<label for='refreshRate'>RefreshRate(s) :</label>";
    echo '<input type="number" name="refresh" size="3" min="5" max="150" value="10">';
}

function fontColor()
{
    echo "<label for='username'>Font :</label>";
    echo '<input type="text" name="fontColor" placeholder="Font Color"></input>';
};

function roleSelect($conn)
{
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
    <select name="role">
        <option value="admin">Admin</option>
        <option value="staff">Staff</option>
        <option value="mod">Mod</option>
        <option value="members">Member</option>
        <option value="guest">Guest</option>
    </select>
    ';
}

?>


<body>

    <div class="box">

        <?php

        refreshRate($conn);
        echo "<hr><br>";
        fontColor($conn);
        echo "<hr><br>";
        roleSelect($conn);
        echo "<hr>";

        ?>


    </div>


</body>
