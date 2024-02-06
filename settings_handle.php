<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root . "/partials/_dbconnect.php");

function roleUpdate($userName, $userRole) {
    global $conn;
    $stmt = $conn->prepare("set role = ? where username = ?");
    $stmt->bind_param("ss", $userRole, $userName);
    $stmt->execute();
}

function refreshUpdate() {
    global $conn;
    $stmt = $conn->prepare("set role = ? where username = ?");
    $stmt->bind_param("ss", $userRole, $userName);
    $stmt->execute();
}

function colorUpdate($newFontColor) {
    global $conn;
    $userName = $_SESSION['userName'];

    $stmt = $conn->prepare("UPDATE user_settings SET setting = JSON_SET(setting, '$.userColor', ?) WHERE username = ?");
    $stmt->bind_param("ss", $newFontColor, $userName);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return "Font color updated successfully";
    } else {
        return "Failed to update font color";
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {

        case "roleUpdate":
            $userName = $_POST['userName'];
            $userRole = $_POST['userRole'];
            roleUpdate($userName, $userRole);
            break;
        case "refreshUpdate":
            $refreshRate = $_POST['refreshRate'];
            refreshUpdate($refreshRate);
            break;
        case "fontUpdate":
            if ($_POST['customFontColor'] !== "") {
                $newFontColor = $_POST['customFontColor'];
            } else {
                $newFontColor = $_POST['fontColor'];
            }
            echo "Font Color: " . $newFontColor;
            colorUpdate($newFontColor);
            break;
    }
}
