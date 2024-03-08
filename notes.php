<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/notes.css" class="css">
    <title>Notes</title>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['userName'])) {
        header("Location: /home.php");
    }
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once($root . "/partials/_navbar.php");
    require_once($root . "/partials/_dbconnect.php");
    $noteV = 0;

    ?>
</head>
<?php

$personal_stmt = $conn->prepare("SELECT * FROM personal_notes WHERE username = ?");
$personal_stmt->bind_param("s", $_SESSION['userName']);
$personal_stmt->execute();
$personal_result = $personal_stmt->get_result();
if ($personal_result->num_rows > 0) {
    $personal_note = $personal_result->fetch_assoc()['note'];
} else {
    $personal_note = "No personal notes found :(";
}


$public_stmt = $conn->prepare("SELECT * FROM public_notes WHERE username = ?");
$public_stmt->bind_param("s", $_SESSION['userName']);
$public_stmt->execute();
$public_result = $public_stmt->get_result();
if ($public_result->num_rows > 0) {
    $public_note = $public_result->fetch_assoc()['note'];
} else {
    $public_note = "No public note found :(";
}


$publics_stmt = $conn->prepare("SELECT * FROM public_notes");
$publics_stmt->execute();
$publics_result = $publics_stmt->get_result();

?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {

        case "getPersonalNote":
            $noteV = 0;
            break;
        case "getPublicNote":
            $noteV = 1;
            break;
        case "getPublicNotes":
            $noteV = 2;
            break;
        case "save":
            saveNote();
            break;
        default:
            break;
    }
}

function saveNote() {
    global $conn;
    if (isset($_POST['personal_note'])) {
        $note = $_POST['personal_note'];
        $stmt = $conn->prepare("INSERT INTO personal_notes (username, note) VALUES (?, ?) ON DUPLICATE KEY UPDATE note = VALUES(note)");
        $stmt->bind_param("ss", $_SESSION['userName'], $note);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['public_note'])) {
        $note = $_POST['public_note'];
        $stmt = $conn->prepare("INSERT INTO public_notes (username, note) VALUES (?, ?) ON DUPLICATE KEY UPDATE note = VALUES(note)");
        $stmt->bind_param("ss", $_SESSION['userName'], $note);
        $stmt->execute();
        $stmt->close();
    }
}


?>


<body>
    <form action="notes.php" method="post">
        <div id="section1">
            <button type="submit" name="action" value="getPersonalNote">My Personal Note</button>
            <button type="submit" name="action" value="getPublicNote">My Public Note</button>
            <button type="submit" name="action" value="getPublicNotes">Show Public Notes</button>

        </div>

        <div id="section2">

            <?php


            if ($noteV == 0) {
                echo '<div id="personal_notes" class="notes">';
                echo '<textarea name="personal_note">' . htmlspecialchars($personal_note) . '</textarea>';
                echo '</div>';
            } elseif ($noteV == 1) {
                echo '<div id="public_notes" class="notes">';
                echo '<textarea name="public_note">' . htmlspecialchars($public_note) . '</textarea>';
                echo '</div>';
            } elseif ($noteV == 2) {
                if ($publics_result && $publics_result->num_rows > 0) {
                    while ($publics_notes = $publics_result->fetch_assoc()) {
                        echo '<div id="publics_notes" class="notes">';
                        echo '<p id="username">' . $publics_notes['username'] . '</p>';
                        echo '<textarea name="message">' . htmlspecialchars($publics_notes['note']) . '</textarea>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No Public Notes Yet :(</p>';
                }
            }


            ?>

        </div>

        <div id="footer">
            <button type="submit" name="action" value="save">Save</button>
        </div>
    </form>


</body>
