<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Features to Implement</title>
    <?php
    session_start();

    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once($root . "/partials/_navbar.php");
    ?>

    <link rel="stylesheet" href="/css/todo.css" class="css">
</head>

<body>
    <h1 align="center">Features to Implement & Bugs to kill</h1>
    <div class="container">
        <ul>
            <li>
                Admin needs the ability to be invisible
                <blockquote>
                    <ul>
                        <li>Also add SStaf that can go invis and have bit more control than staff</li>
                        <li>(only admin level people but not me)</li>
                    </ul>
                </blockquote>
            </li>
            <li>
                Let staff Delete Messages.
            </li>
            <li>
                Rooms?
            </li>
            <li>
                Add a SuggestionBox user to collect suggestions.
                <blockquote>
                    <ul>
                        <li>Send his received messages to suggestion_box</li>
                        <li>Allow anon suggestions and named suggestions</li>
                    </ul>
                </blockquote>
            </li>
            <li>
                Figure out cookies?
            </li>
            <li>
                Check kick is working and set pages to respond appropriately
            </li>
            <li>
                Message parsing to allow :thumbsup: emojis
            </li>
            <li>
                Set up encryption of db and everything
            </li>
            <li>
                Add personal notes, staff notes, admin notes, public notes, and other notes
                <blockquote>
                    <ul>
                        <li>(auto translate?)</li>
                    </ul>
                </blockquote>
            </li>
            <li>
                Add function to backup the whole db for admin use
            </li>
            <li>
                Add a way for staff+ to add filters (regex matching parser)
            </li>
            <li>
                Filter messages (fuzzy find).
            </li>
            <li>
                Ignore username list.
            </li>
            <li>
                A User Bookmarks Page for users to submit their bookmarks
                <blockquote>
                    <ul>
                        <li>Will need some way for them to make a request to submit link</li>
                        <li>Way to approve them.</li>
                    </ul>
                </blockquote>
            </li>
            <li>
                How to deal with spam (attack)g
                <blockquote>
                    <ul>
                        <li>Setup a waiting room with default time allow in and explicit allow in only</li>
                        <li>Setup 2FA with GPG (optional)</li>
                    </ul>
                </blockquote>
            </li>
            <li>
                Start adding Commandsg
                <blockquote>
                    <ul>
                        <li>!about</li>
                        <li>!help</li>
                        <li>!rules</li>
                    </ul>
                </blockquote>
            </li>
            <li>Canned answers for stupid questions like Red Rooms?</li>
            <blockquote>
                <ul>
                    <li>How to hack?</li>
                    <li>Need hacker</li>
                    <li>Need btc</li>
                    <li>(? how to parse. ml>advanced lul ?)</li>
                </ul>
            </blockquote>
            <li>
                Admin Settings
                <blockquote>
                    <ul>
                        <li>Change to Mod only chat and member only chat.</li>
                        <li>Backup DB</li>
                        <li>Mass hierarchy kick</li>
                    </ul>
                </blockquote>
            </li>
        </ul>

    </div>
</body>

</html>
