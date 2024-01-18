<?php
$root = $_SERVER['DOCUMENT_ROOT'];


$servername = "localhost";  // Replace with your database server host
$username = "StrangeChat";  // Replace with your database username
$password = "StrangeChat";  // Replace with your database password

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sqlFile = $root . '/StrangeChat.sql';
$sqlContent = file_get_contents($sqlFile);

// Explode the SQL content into individual statements
$sqlStatements = explode(';', $sqlContent);

foreach ($sqlStatements as $sql) {
    // Trim each statement to remove leading/trailing spaces
    $sql = trim($sql);

    // Skip empty statements
    if ($sql === '') {
        continue;
    }

    // Execute each SQL statement using a prepared statement
    if ($conn->query($sql) === FALSE) {
        echo "Error during setup: " . $conn->error;
        break;
    }
}

echo "Setup completed successfully!";
