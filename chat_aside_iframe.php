<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="refresh" content="10"> <!-- Refresh every 5 seconds -->
    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <link rel="stylesheet" href="/css/chat_aside_iframe.css" class="css">
    <title>Home Page</title>
</head>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$root = $_SERVER['DOCUMENT_ROOT'];
$username = $_SESSION['userName'];

function printUserListByRole($conn, $role)
{
    $query = "SELECT u.username FROM users u JOIN users_logged_in uli ON u.username = uli.username WHERE u.role = '$role'";
    $result = mysqli_query($conn, $query);


    if (mysqli_num_rows($result) > 0) {
        echo "<h3>". ucfirst($role) ."s</h3>";
        while ($row = $result->fetch_assoc()) {
            echo "<p class='user_list_p'>" . $row['username'] . "</p>";
            echo "<hr>";
        }
        echo "<br><br>";
    }
}

?>

<aside>
    <?php
    require_once($root . "/partials/_dbconnect.php");
    $roles = ['admin', 'staff', 'mod', 'member', 'guest'];

    foreach ($roles as $role) {
        printUserListByRole($conn, $role);
    }

    ?>
</aside>
