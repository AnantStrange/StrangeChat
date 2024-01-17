<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <link rel="stylesheet" href="/css/home.css" class="css">
    <title>Home Page</title>
    <?php

    session_start();
    if (isset($_SESSION['userName'])) {
        header("location:/chat.php");
        die();
    }

    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once($root . "/partials/_navbar.php");
    $visibilityLevels = [
        'admin'  => 0,
        'staff'  => 1,
        'mod'    => 2,
        'member' => 3,
        'guest' => 3,
    ];

    $availableColors = ["random" => "random"];
    for ($i = 0; $i < 20; $i++) {
        $hexColor = "#" . dechex(mt_rand(0, 0xFFFFFF));
        $availableColors[$hexColor] = $hexColor;
    }

    ?>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        require_once($root . "/partials/_dbconnect.php");
        $userName = $_POST["userName"];
        $password = $_POST["password"];
        $userColor = $_POST["userColor"];
        $entered_captcha  = $_POST['captcha'];
        $captcha = $_SESSION['captcha'];

        if ($entered_captcha != $captcha) {
            echo '<div class="alert alert-danger" role="alert">
                Captcha Wrong!
                </div>';
        } else {

            $user_exist_sql = "select password from users where username='$userName'";
            $pass_hash = mysqli_query($conn, $user_exist_sql);
            if (mysqli_num_rows($pass_hash) == 0) {
                echo '<div class="alert alert-danger" role="alert">
                User Does Not exists <a href="/signup.php">Sign in?</a>
                </div>';
            } else {
                $pass_hash = $pass_hash->fetch_assoc()['password'];
                if (password_verify($password, $pass_hash)) {
                    echo '<div class="alert alert-success" role="alert">
                    User Logged In
                    </div>';

                    $sql = "SELECT UserRole FROM users WHERE username = '$userName'";
                    $userRole = mysqli_query($conn, $sql)->fetch_assoc()['UserRole'];
                    $_SESSION['userName'] = $userName;
                    $_SESSION['userRole'] = $userRole;
                    $_SESSION['visibilityLevel'] = $visibilityLevels[$userRole];
                    $_SESSION['loggedIn'] = true;

                    $newSettings = json_encode(['userColor' => $newUserColor]);
                    $sqlUpdateSettings = "UPDATE user_setting SET settings = '$newSettings' WHERE username = '$userName'";
                    mysqli_query($conn, $sqlUpdateSettings);


                    $user_check_sql = "SELECT * FROM `users_logged_in` WHERE `username` = '$userName'";
                    $result = mysqli_query($conn, $user_check_sql);

                    if (mysqli_num_rows($result) == 0) {
                        $user_insert_sql = "INSERT INTO `users_logged_in` (`username`) VALUES ('$userName')";
                        mysqli_query($conn, $user_insert_sql);
                    }

                    $sql = "insert into settings (color) values ('$userColor')";

                    header("location:/chat.php");
                } else {
                    echo '<div class="alert alert-danger" role="alert">
                        Wrong Password
                        </div>';
                }
            }
        }
    }

    ?>
    <header>
        <h1>StrangeChat</h1>
    </header>
    <form action="./home.php" method="post">
        <div class="box">
            <label for="userName">Nickname :</label>
            <input type="text" id="userName" name="userName" placeholder="Enter UserName" autocomplete="username"></input>

            <label for="password">Password :</label>
            <input type="password" id="password" name="password" placeholder="Enter Password" autocomplete="current-password"></input>

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

            <p class="grid-col-span-2" id="pickColor">Pick a Color</p>
            <select name="userColor" id="userColor" class="grid-col-span-2 margin-auto">
                <?php foreach ($availableColors as $value => $label) : ?>
                    <option value="<?= $value ?>"><?= $label ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="grid-col-span-2 margin-auto">Enter Chat</button>

        </div>
    </form>







</body>

</html>
