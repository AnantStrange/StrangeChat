<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/css_reset.css" class="css">
    <link rel="stylesheet" href="/css/notes.css" class="css">
    <title>Notes</title>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once($root . "/partials/_navbar.php");
    require_once($root . "/partials/_dbconnect.php");

    ?>
</head>
<?php

$personal_stmt = $conn->prepare("SELECT * FROM personal_notes WHERE username = ?");
$personal_stmt->bind_param("s", $_SESSION['userName']);
$personal_stmt->execute();
$personal_result = $personal_stmt->get_result();
if ($personal_result->num_rows > 0) {
    $personal_notes = $personal_result->fetch_assoc()['note'];
} else {
    $personal_notes = "No personal notes found";
}


$public_stmt = $conn->prepare("SELECT * FROM public_notes");
$public_stmt->execute();
$personal_result = $public_stmt->get_result();

?>

<?php
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



?>


<body>


    <form action="notes.php">
        <div id="section1">
            <button type="submit" name="action" value="getPersonalNotes">Personal Notes</button>
            <button type="submit" name="action" value="getPublicNotes">Public Notes</button>
        </div>

        <div id="section2">

            <?php
            echo '<div id="personal_notes">';
            echo '<textarea name="message" placeholder="' . htmlspecialchars($personal_notes) . '"></textarea>';
            echo '</div>';

            /* while ($public_notes = $public_result->fetch_assoc()['note']) { */
            /*     echo '<textarea name="message" placeholder="{$personal_notes}"></textarea>'; */
            /* } */
            ?>
        </div>
        <div id="footer">
            <button type="submit" name="action" value="save">Save</button>
        </div>
    </form>


</body>
