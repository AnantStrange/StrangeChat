<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="refresh" content="10">
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

function printUserListByRole($conn, $userRole)
{
    $query = "SELECT u.username FROM users u JOIN users_logged_in uli ON u.username = uli.username WHERE u.userRole = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $userRole);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();


    if (mysqli_num_rows($result) > 0) {
        echo "<h3>" . ucfirst($userRole) . "s</h3>";
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
    $userRoles = ['admin', 'staff', 'mod', 'member', 'guest'];

    foreach ($userRoles as $userRole) {
        printUserListByRole($conn, $userRole);
    }

    ?>
</aside>
