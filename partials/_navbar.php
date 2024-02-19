<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    header("Location: /home.php");
    exit();
}

$root = $_SERVER['DOCUMENT_ROOT'];
$currentUrl = $_SERVER['REQUEST_URI'];
$currentPage = basename($currentUrl, '.php'); // Get the filename without the extension

?>

<head>
    <link rel="stylesheet" href="/css/css_reset.css">
    <link rel="stylesheet" href="/css/navbar.css">
</head>

<body>
    <nav>
        <ul>
            <li><a href="/home.php">
                    <h3>StrangeChat</h3>
                </a></li>
            <?php

            echo '<li><a href="/home.php" class="' . ($currentPage == 'home' ? 'active' : '') . '">Home</a></li>';

            if (!isset($_SESSION['userName'])) {
                echo '<li><a href="/signup.php" class="' . ($currentPage == 'signup' ? 'active' : '') . '">Sign Up</a></li>';
            } elseif (isset($_SESSION['userName'])) {
                echo '
                <li><a href="/chat.php" class="' . ($currentPage == 'chat' ? 'active' : '') . '">Chat</a></li>
            <li><a href="/notes.php" class="' . ($currentPage == 'notes' ? 'active' : '') . '">Notes</a></li>
            <li><a href="/settings.php" class="' . ($currentPage == 'settings' ? 'active' : '') . '">Settings</a></li>';
            }

            echo '<li><a href="/rulez.php" class="' . ($currentPage == 'rulez' ? 'active' : '') . '">Rulez</a></li>';
            if (isset($_SESSION['userName'])) {
                echo '<li><a href="/logout.php" class="' . ($currentPage == 'logout' ? 'active' : '') . '">Log Out</a></li>';
            }

            ?>
        </ul>
    </nav>
</body>
