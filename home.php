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

    class UserNotExistException extends Exception {
    }
    class InvalidPasswordException extends Exception {
    }
    class InvalidCaptchaException extends Exception {
    }
    class UserNotAllowedException extends Exception {
    }
    ?>
</head>

<?php

function showErrorAlert($message) {
    echo '<div class="alert alert-danger" role="alert"><h3>' . $message . '</h3></div>';
}

function showSuccessAlert($message) {
    echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
}

function validateCaptcha($enteredCaptcha, $expectedCaptcha) {
    if ($enteredCaptcha != $expectedCaptcha) {
        throw new InvalidCaptchaException('Captcha Wrong!');
    }
    return true;
}

function getHash($conn, $userName) {
    $userExistSql = "SELECT password FROM users WHERE username=?";
    $stmt = mysqli_prepare($conn, $userExistSql);
    mysqli_stmt_bind_param($stmt, "s", $userName);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 0) {
        // User does not exist
        mysqli_stmt_close($stmt);
        throw new UserNotExistException();
    }

    mysqli_stmt_bind_result($stmt, $passHash);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $passHash;
}

function validatePassword($password, $passHash) {
    if (!password_verify($password, $passHash)) {
        throw new InvalidPasswordException('Wrong Password');
    }
    return true;
}



function addUserLogIn($conn, $userName) {

    $user_check_sql = "SELECT * FROM `users_logged_in` WHERE `username` = ?";
    $stmt = mysqli_prepare($conn, $user_check_sql);
    mysqli_stmt_bind_param($stmt, "s", $userName);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    $sessionId = session_id();
    if (mysqli_stmt_num_rows($stmt) == 0) {
        $user_insert_sql = "INSERT INTO `users_logged_in` (`username`, `session_id`) VALUES (?,?)";
        $stmt_insert = mysqli_prepare($conn, $user_insert_sql);
        mysqli_stmt_bind_param($stmt_insert, "ss", $userName, $sessionId);
        mysqli_stmt_execute($stmt_insert);
        mysqli_stmt_close($stmt_insert);
    }

    mysqli_stmt_close($stmt);
}

function setSession($conn, $userName) {
    $visibilityLevels = [
        'admin'  => 0,
        'staff'  => 1,
        'mod'    => 2,
        'member' => 3,
        'guest' => 3,
    ];

    $stmt = $conn->prepare("SELECT userrole FROM users WHERE username = ?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $result = $stmt->get_result();
    $userRole = $result->fetch_assoc()['userrole'];


    $stmt->close();
    $_SESSION['userName'] = $userName;
    $_SESSION['userRole'] = $userRole;
    $_SESSION['visibilityLevel'] = $visibilityLevels[$userRole];
    $_SESSION['in_waitroom'] = false;
}

function setColor($conn, $userName, $userColor) {
    // Check if the fontColor key exists in the setting column
    $sqlCheckColor = "
        SELECT JSON_CONTAINS_PATH(setting, 'one', '$.fontColor') AS color_exists
        FROM user_settings
        WHERE username = ?
    ";

    $colorExists = false;
    $stmtCheck = $conn->prepare($sqlCheckColor);
    $stmtCheck->bind_param("s", $userName);
    $stmtCheck->execute();
    $stmtCheck->bind_result($colorExists);
    $stmtCheck->fetch();
    $stmtCheck->close();

    // If fontColor key doesn't exist, perform the update
    if (!$colorExists) {
        $sqlUpdateColor = "
            INSERT INTO user_settings (username, setting)
            VALUES (?, JSON_SET('{}', '$.fontColor', ?))
            ON DUPLICATE KEY UPDATE setting = JSON_SET(setting, '$.fontColor', ?)
        ";

        $stmt = $conn->prepare($sqlUpdateColor);
        $stmt->bind_param("sss", $userName, $userColor, $userColor);
        $stmt->execute();
        $stmt->close();
    }
}

function validateUser($conn, $userName) {
    $stmt = $conn->prepare("select status from users where username = ?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_assoc()['status'];
    if ($result == "kicked") {
        throw new  UserNotAllowedException("User is Kicked");
    }
    return true;
}

function waitroom() {
    global $conn;
    $stmt = $conn->prepare("select waitroom from server_settings");
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_assoc()['waitroom'];
    if ($result == 1) {
        return true;
    }
    return false;
}

?>


<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        require_once($root . "/partials/_dbconnect.php");
        $userName = $_POST["userName"];
        $password = $_POST["password"];
        $userColor = $_POST["userColor"];
        $entered_captcha  = $_POST['captcha'];
        $captcha = $_SESSION['captcha'];


        try {
            validateCaptcha($entered_captcha, $captcha);
            $pass_hash = getHash($conn, $userName);
            validatePassword($password, $pass_hash);
            validateUser($conn, $userName);

            setSession($conn, $userName);
            setColor($conn, $userName, $userColor, $availableColors);
            addUserLogIn($conn, $userName);

            if (waitroom()) {
                $_SESSION['in_waitroom'] = true;
                header("location:/waitroom.php");
            } else {
                $_SESSION['in_waitroom'] = false;
                header("location:/chat.php");
            }
        } catch (InvalidCaptchaException $e) {
            showErrorAlert("Captcha validation failed");
        } catch (UserNotExistException $e) {
            showErrorAlert("User does not exist. Validation stopped.");
        } catch (InvalidPasswordException $e) {
            showErrorAlert("Password validation failed");
        } catch (UserNotAllowedException $e) {
            showErrorAlert("User is Kicked");
        } catch (Exception $e) {
            echo "An unexpected error occurred. Response for other errors.";
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
            <?php
            $randomColor = '#' . substr(md5(rand()), 0, 6);
            echo '<input type="color" name="userColor" id="userColor" class="grid-col-span-2 margin-auto" value="' . $randomColor . '">';
            ?>
            <button type="submit" class="grid-col-span-2 margin-auto">Enter Chat</button>

        </div>
    </form>







</body>

</html>
