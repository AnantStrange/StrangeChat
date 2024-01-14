<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <link rel="stylesheet" href="/css/home.css" class="css">
    <title>Home Page</title>
</head>

<body>
    <?php

    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once($root . "/partials/_navbar.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        require_once($root . "/partials/_dbconnect.php");
        $username = $_POST["username"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        $role = $_POST["role"];

        if ($entered_captcha != $captcha) {
            echo '<div class="alert alert-danger" role="alert">
                Captcha Wrong!
                </div>';
        } else {

            if ($password != $cpassword) {
                echo '<div class="alert alert-danger" role="alert">
            Passwords do not match !
            </div>';
            } else {
                $user_exist = "select username from users where username='$username'";
                $result = mysqli_query($conn, $user_exist);
                if (mysqli_num_rows($result) > 0) {
                    echo '<div class="alert alert-danger" role="alert">
                User Already exists
                </div>';
                } else {
                    $pass_hash = password_hash($password, PASSWORD_BCRYPT, [21]);
                    $sql = "insert into users (username,password,role,dt) values('$username','$pass_hash','$role',current_timestamp())";
                    $sql_result = mysqli_query($conn, $sql);
                    if ($sql_result) {
                        echo '<div class="alert alert-success" role="alert">
                    User Registered. You can now login
                    </div>';
                        echo '<meta http-equiv="refresh" content="3;url=/home.php">';
                        header("location:/home.php");
                    } else {
                        echo '<div class="alert alert-danger" role="alert">
                        Error: Unable to register user. Please try again. ' . mysqli_error($conn) . '
                      </div>';
                    }
                }
            }
        }
    }

    ?>
    <header>
        <h1>StrangeChat</h1>
    </header>
    <form action="./signup.php" method="post">
        <div class="box">
            <label for="username">Nickname :</label>
            <input type="text" id="username" name="username" placeholder="Enter UserName" autocomplete="username"></input>

            <label for="password">Password :</label>
            <input type="password" id="password" name="password" placeholder="Enter Password" autocomplete="current-password"></input>

            <label for="cpassword">Renter Password :</label>
            <input type="password" id="cpassword" name="cpassword" placeholder="Enter Password" autocomplete="current-password"></input>

            <label for="role">role :</label>
            <input type="text" id="role" name="role" placeholder="Enter Role" autocomplete="username"></input>

            <?php

            $directory = "./crackme/level-1/";
            $files = glob($directory . "*.gif");

            if ($files === false) {
                die("Error while trying to access the directory.");
            }


            if (!empty($files)) {
                $randomFile = $files[array_rand($files)];
                $captha_value = pathinfo($randomFile, PATHINFO_FILENAME);
                $_SESSION['captcha'] = $captha_value;
                echo "<img src='$randomFile' alt='Captcha Image'>";
            } else {
                echo "No GIF files found in the directory.";
            }

            ?>
            <input type="text" id="captcha" name="captcha" placeholder="Enter Captcha"></input>

            <p id="pickColor" class="grid-col-span-2">Pick a Color</p>
            <select name="cars" id="cars" class="grid-col-span-2 margin-auto">
                <option value="volvo">color1</option>
                <option value="saab">color2</option>
                <option value="mercedes">color3</option>
                <option value="audi">color4</option>
            </select>
            <button type="submit" class="grid-col-span-2 margin-auto">Enter Chat</button>

        </div>
    </form>







</body>

</html>
