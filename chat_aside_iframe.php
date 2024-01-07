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

?>

<aside>
    <h3>Users:</h3>
    <?php
    require_once($root . "/partials/_dbconnect.php");
    $msg_query = "select username from users_logged_in";
    $result = mysqli_query($conn, $msg_query);
    while ($row = $result->fetch_assoc()) {
        echo "<p class='user_list_p'>" . $row['username'] . "</p>";
        echo "<hr>";
    }
    ?>
</aside>
