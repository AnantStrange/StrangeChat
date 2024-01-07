<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <title>Home Page</title>
</head>

<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$username = $_SESSION['userName'];

?>

<aside>
    Users:
    <?php
    require_once($root . "/partials/_dbconnect.php");
    $msg_query = "select username from users_logged_in";
    $result = mysqli_query($conn, $msg_query);
    while ($row = $result->fetch_assoc()) {
        echo "<p class='user_list_p'>" . $row['username'] . "</p>";
    }
    ?>
</aside>
