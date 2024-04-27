<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta http-equiv="refresh" content="10">
    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <link rel="stylesheet" href="/css/waitroom.css" class="css">
    <title>Waitroom</title>
    <?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['userName'])) {
        echo "2";
        header("location:/home.php");
        exit();
    }

    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once($root . "/partials/_dbconnect.php");
    $userName = $_SESSION['userName'];


    ?>
</head>

<body>
    <?php
    // Function to update the countdown for a specific user in the waitroom_users table
    function storeTimeStamp() {
        global $conn, $userName;

        // Check if the user exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM waitroom_users WHERE username = ?");
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $stmt->bind_result($userCount);
        $stmt->fetch();
        $stmt->close();

        // If the user exists, update the last_timestamp
        if ($userCount > 0) {
            /* $stmt = $conn->prepare("UPDATE waitroom_users SET last_timestamp = ? WHERE userName = ?"); */
            /* $stmt->bind_param("is", $last_timestamp, $userName); */
            /* $stmt->execute(); */
            /* $stmt->close(); */
        } else {
            // If the user doesn't exist, insert a new row
            $stmt = $conn->prepare("INSERT INTO waitroom_users (username, last_timestamp) VALUES (?, NOW())");
            $stmt->bind_param("s", $userName);
            $stmt->execute();
            $stmt->close();
        }
    }


    // Function to retrieve the countdown for a specific user from the waitroom_users table
    function getWaitroomUserCountdown() {
        global $conn, $userName;

        $stmt = $conn->prepare("SELECT last_timestamp FROM waitroom_users WHERE username = ?");
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $stmt->bind_result($last_timestamp);
        $stmt->fetch(); // Fetch the result
        $stmt->close();

        return $last_timestamp;
    }

    // When the user enters the waitroom, store the current timestamp
    storeTimeStamp();

    // On subsequent requests, retrieve the stored timestamp
    $last_timestamp = getWaitroomUserCountdown($userName);

    // Calculate remaining time
    $currentTime = time();
    $countdownDuration = 60; // seconds
    $elapsedTime = $currentTime - strtotime($last_timestamp); // Convert last_timestamp to Unix timestamp

    echo "current time : " . date("Y-m-d H:i:s", $currentTime) . "<br>";
    echo "last time : " . date("Y-m-d H:i:s", strtotime($last_timestamp)) . "<br>";
    echo "elapsed_time : " . ($currentTime - strtotime($last_timestamp)) . " seconds<br>";

    $remainingTime = ($elapsedTime < $countdownDuration) ? $countdownDuration - $elapsedTime : 0;


    // Display countdown
    echo "Remaining time: $remainingTime seconds";

    // Handle expiry
    if ($remainingTime <= 0) {
        echo "we entered if here";
        $stmt = $conn->prepare("UPDATE users SET status='online' WHERE username = ?");
        $stmt->bind_param("s", $userName);
        $stmt->execute();

        $stmt = $conn->prepare("Delete from waitroom_users where username = ?");
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $stmt->close();
        header("location:/chat.php");
    }

    ?>



</body>
