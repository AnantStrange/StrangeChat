<?php
session_start();
require_once($root . "/partials/_dbconnect.php");

function roleUpdate($userName,$userRole) {
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

function fontUpdate() {
    global $conn;
    $stmt = $conn->prepare("set role = ? where username = ?");
    $stmt->bind_param("ss", $userRole, $userName);
    $stmt->execute();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {

        case "roleUpdate":
            $userName = $_POST['username'];
            $userRole = $_POST['userRole'];
            roleUpdate($userName,$userRole);
            break;
        case "refreshUpdate":
            refreshUpdate($_POST['refreshRate']);
            break;
        case "fontUpdate":
            fontUpdate();
            break;
    }
}
