<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/home.css">
    <title>Home Page</title>
</head>

<body>
    <?php

    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once($root . "/components/navbar.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        require_once($root . "/login_system/dbconnect.php");
        $username = $_POST["username"];
        $password = $_POST["password"];
        $user_exist_sql = "select password from users where username='$username'";
        $pass_hash = mysqli_query($conn, $user_exist_sql);
        if (mysqli_num_rows($pass_hash) == 0) {
            echo '<div class="alert alert-danger" role="alert">
                User Does Not exists
                </div>';
        }
        else {
            $pass_hash = $pass_hash->fetch_assoc()['password'];
            if(password_verify($password,$pass_hash)){
                echo '<div class="alert alert-success" role="alert">
                    User Registered
                    </div>';
                session_start();
                $_SESSION['userName'] = $username;
                header("location:chat.php");
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
