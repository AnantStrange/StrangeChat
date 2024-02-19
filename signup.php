<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <link rel="stylesheet" href="/css/home.css" class="css">
    <title>Home Page</title>
    <?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
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

    class InvalidUsernameException extends Exception {
    }
    class InvalidCaptchaException extends Exception {
    }
    class PasswordMismatchException extends Exception {
    }
    class UserAlreadyExistsException extends Exception {
    }


    ?>
</head>

<?php

function setColor($conn, $userName, $userColor, $availableColors) {
    if ($userColor === 'random') {
        $userColor = $availableColors[array_rand($availableColors)];
    }

    $sqlUpdateColor = "
        INSERT INTO user_settings (username, setting)
        VALUES (?, JSON_SET('{}', '$.userColor', ?))
        ON DUPLICATE KEY UPDATE setting = JSON_SET(setting, '$.userColor', ?)
    ";

    $stmt = $conn->prepare($sqlUpdateColor);
    $stmt->bind_param("sss", $userName, $userColor, $userColor);
    $stmt->execute();
    $stmt->close();
}

function validateUserName($username) {
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        throw new InvalidUsernameException("Username should not contain any special characters or spaces!");
    }
}

function validateCaptcha($enteredCaptcha, $captcha) {
    if ($enteredCaptcha != $captcha) {
        throw new InvalidCaptchaException("Captcha wrong!");
    }
}

function validatePassword($password, $cpassword) {
    if ($password != $cpassword) {
        throw new PasswordMismatchException("Passwords do not match!");
    }
}

function validateUser($conn, $username) {
    $user_exist_query = "SELECT username FROM users WHERE username=?";
    $stmt = $conn->prepare($user_exist_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        throw new UserAlreadyExistsException("User already exists!");
    }

    $stmt->close();
}

function addUser($conn, $userName, $password, $userRole) {
    $pass_hash = password_hash($password, PASSWORD_BCRYPT, [21]);
    $sql = "INSERT INTO users (username, password, userRole, dt) VALUES (?, ?, ?, current_timestamp())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $userName, $pass_hash, $userRole);
    $stmt->execute();
    $stmt->close();
}
?>

<body>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        require_once($root . "/partials/_dbconnect.php");
        $userName = $_POST["username"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        $userRole = $_POST["userRole"];
        $userColor = $_POST["userColor"];
        $entered_captcha  = $_POST['captcha'];
        $captcha = $_SESSION['captcha'];

        try {
            validateUser($conn, $userName);
            validateUserName($userName);
            validateCaptcha($entered_captcha, $captcha);
            validatePassword($password, $cpassword);

            addUser($conn, $userName, $password, $userRole);
            setColor($conn, $userName, $userColor, $availableColors);

            header("location:/home.php");
        } catch (Exception $e) {
            echo "An unexpected error occurred. Response for other errors.";
            // Print or log details of the caught exception
            echo "\nException Details:\n";
            echo "Message: " . $e->getMessage() . "\n";
            echo "Code: " . $e->getCode() . "\n";
            echo "File: " . $e->getFile() . "\n";
            echo "Line: " . $e->getLine() . "\n";
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

            <label for="userRole">role :</label>

            <select name="userRole" id="userRole">
                <option value="guest">guest</option>
                <option value="member">member</option>
                <option value="mod">mod</option>
                <option value="staff">staff</option>
            </select>

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

            <select name="userColor" id="userColor" class="grid-col-span-2 margin-auto">
                <?php foreach ($availableColors as $value => $label) : ?>
                    <option value="<?= $value ?>"><?= $label ?></option>
                <?php endforeach; ?>
            </select>


            <button type="submit" class="grid-col-span-2 margin-auto">Register</button>

        </div>
    </form>







</body>

</html>
