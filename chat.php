<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/css_reset.css" class="css">
    <link rel="stylesheet" href="/chat.css" class="css">
    <title>Home Page</title>
</head>


<body>

    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['userName'])) {
        header("location:/home.php");
        exit();
    }
    $root = $_SERVER['DOCUMENT_ROOT'];
    require($root . "/components/navbar.php");
    ?>


    <header>
        <div id="header_sec1">
            <?php echo $_SESSION['userName'] . ":"; ?>
            <input type="text" placeholder="Message"></input>
            <input type="submit" value="Send to"></button>
            <select name="sendto" size="1">
                <option value="s *">-All chatters-</option>
                <option value="s ?">-Members only-</option>
                <option value="s %">-Staff only-</option>
                <option value="s _">-Admin only-</option>
            </select>
            <label><input type="checkbox" name="kick" value="kick">Kick</label>
            <label><input type="checkbox" name="what" value="purge" checked="">Also purge messages</label>
        </div>
        <div id="header_sec2">
            <input type="submit" value="Delete last message" class="delbutton">
            <input type="submit" value="Delete all messages" class="delbutton">
            <input type="submit" value="Switch to multi-line">
        </div>
    </header>

    <div class="midsec">
        <div class="iframe">
            <iframe name="view" src="/chat_iframe.php"></iframe>
        </div>


        <aside>
            Users:
            <?php
            require_once($root . "/login_system/dbconnect.php");
            $msg_query = "select username from users_logged_in";
            $result = mysqli_query($conn, $msg_query);
            while ($row = $result->fetch_assoc()) {
                echo "<p class='user_list_p'>" . $row['username'] . "</p>";
            }
            ?>
        </aside>
    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="/bootstrap.min.css"></script>
</body>

</html>
