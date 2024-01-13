<?php
$root = $_SERVER['DOCUMENT_ROOT'];


$servername = "localhost";  // Replace with your database server host
$username = "StrangeChat";  // Replace with your database username
$password = "StrangeChat";  // Replace with your database password

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sqlFile = $root.'/StrangeChat.sql';
$sqlContent = file_get_contents($sqlFile);

if ($conn->multi_query($sqlContent)) {
    echo "Setup completed successfully!";
} else {
    echo "Error during setup: " . $conn->error;
}

?>
