<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <link rel="stylesheet" href="/css/home.css" class="css">
    <title>Home Page</title>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION['userName'])) {
        header("location:/chat.php");
        die();
    }

    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once($root . "/partials/_navbar.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        require_once($root . "/partials/_dbconnect.php");
        $username = $_POST["username"];
        $password = $_POST["password"];
        $user_exist_sql = "select password from users where username='$username'";
        $pass_hash = mysqli_query($conn, $user_exist_sql);
        if (mysqli_num_rows($pass_hash) == 0) {
            echo '<div class="alert alert-danger" role="alert">
                User Does Not exists
                </div>';
        } else {
            $pass_hash = $pass_hash->fetch_assoc()['password'];
            if (password_verify($password, $pass_hash)) {
                echo '<div class="alert alert-success" role="alert">
                    User Registered
                    </div>';
                $_SESSION['userName'] = $username;
                $_SESSION['loggedIn'] = true;

                $user_check_sql = "SELECT * FROM `users_logged_in` WHERE `username` = '$username'";
                $result = mysqli_query($conn, $user_check_sql);

                if (mysqli_num_rows($result) == 0) {
                    $user_insert_sql = "INSERT INTO `users_logged_in` (`username`) VALUES ('$username')";
                    mysqli_query($conn, $user_insert_sql);
                }
                header("location:/chat.php");
            } else {
                echo '<div class="alert alert-danger" role="alert">
                        Wrong Password
                        </div>';
            }
        }
    }

    ?>
    <header>
        <h1>StrangeChat</h1>
    </header>
    <form action="./home.php" method="post">
        <div class="box">
            <label for="username">Nickname :</label>
            <input type="text" id="username" name="username" placeholder="Enter UserName" autocomplete="username"></input>

            <label for="password">Password :</label>
            <input type="password" id="password" name="password" placeholder="Enter Password" autocomplete="current-password"></input>

            <label for="captcha">Captcha :</label>
            <input type="text" id="captcha" name="captcha" placeholder="Enter Captcha"></input>

            <p class="grid-col-span-2">Pick a Color</p>
            <select name="cars" id="cars" class="grid-col-span-2">
                <option value="volvo">color1</option>
                <option value="saab">color2</option>
                <option value="mercedes">color3</option>
                <option value="audi">color4</option>
            </select>
            <button type="submit" class="grid-col-span-2">Enter Chat</button>

        </div>
    </form>







    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
