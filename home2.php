<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="referrer" content="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="theme-color" content="#000000" />
    <meta name="msapplication-TileColor" content="#000000" />
    <title>RED HAT CHAT</title>
    <style>
        body,
        iframe {
            background-color: #000000;
            color: #ffffff;
            font-size: 14px;
            text-align: center;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            border: none;
        }
        a:visited {
            color: #b33cb4;
        }
        a:link {
            color: #00a2d4;
        }
        a:active {
            color: #55a2d4;
        }
        input,
        select,
        textarea {
            color: #ffffff;
            background-color: #000000;
        }
        .error {
            color: #ff0033;
            text-align: left;
        }
        .delbutton {
            background-color: #660000;
        }
        .backbutton {
            background-color: #004400;
        }
        #exitbutton {
            background-color: #aa0000;
        }
        .setup table table,
        .admin table table,
        .profile table table {
            width: 100%;
            text-align: left;
        }
        .alogin table,
        .init table,
        .destroy_chat table,
        .delete_account table,
        .sessions table,
        .filter table,
        .linkfilter table,
        .notes table,
        .approve_waiting table,
        .del_confirm table,
        .profile table,
        .admin table,
        .backup table,
        .setup table {
            margin-left: auto;
            margin-right: auto;
        }
        .setup table table table,
        .admin table table table,
        .profile table table table {
            border-spacing: 0px;
            margin-left: auto;
            margin-right: unset;
            width: unset;
        }
        .setup table table td,
        .backup #restoresubmit,
        .backup #backupsubmit,
        .admin table table td,
        .profile table table td,
        .login td + td,
        .alogin td + td {
            text-align: right;
        }
        .init td,
        .backup #restorecheck td,
        .admin #clean td,
        .admin #regnew td,
        .session td,
        .messages,
        .inbox,
        .approve_waiting td,
        .choose_messages,
        .greeting,
        .help,
        .login td,
        .alogin td {
            text-align: left;
        }
        .approve_waiting #action td:only-child,
        .help #backcredit,
        .login td:only-child,
        .alogin td:only-child,
        .init td:only-child {
            text-align: center;
        }
        .sessions td,
        .sessions th,
        .approve_waiting td,
        .approve_waiting th {
            padding: 5px;
        }
        .sessions td td {
            padding: 1px;
        }
        .notes textarea {
            height: 80vh;
            width: 80%;
        }
        .post table,
        .controls table,
        .login table {
            border-spacing: 0px;
            margin-left: auto;
            margin-right: auto;
        }
        .login table {
            border: 2px solid;
        }
        .controls {
            overflow-y: none;
        }
    </style>
    <style>
        .spacer {
            width: 10px;
        }
        #firstline {
            vertical-align: top;
        }
    </style>
    <style>
        body,
        iframe {
            background-color: #000000;
            color: #d73920;
        }
        .msg {
            padding: 0.5em 0;
            border-bottom: 1px solid #363636;
        }
        input,
        select,
        textarea,
        button {
            padding: 0.2em;
            border: 1px solid #ffffff;
            border-radius: 0.5em;
        }
        #messages small {
            color: #989898;
        }
        #messages {
            display: block;
            width: 79%;
        }
        .messages #topic {
            display: block;
            width: 79%;
        }
        .messages #chatters {
            display: block;
            float: right;
            width: 20%;
            overflow-y: auto;
            position: fixed;
            right: 0;
            max-height: 100%;
            bottom: 2em;
            top: 2em;
        }
        .messages #chatters td,
        #chatters tr,
        #chatters th {
            display: table-row;
            line-height: 0.8em;
        }
        .messages #chatters table a {
            display: table-row;
        }
        * {
            border-radius: 0.5em;
        }
        input:hover,
        select:hover {
            background: #034;
        }
        #exitbutton:hover {
            background: #909;
        }
    </style>
    <script>
        window.addEventListener("load", (_) => {
            window.top.postMessage("post_box_loaded", window.location.origin);
        });
    </script>
</head>
<body class="post">
    <table>
        <tbody>
            <tr>
                <td>
                    <form action="/index.php" enctype="multipart/form-data" method="post">
                        <input type="hidden" name="lang" value="en" /><input type="hidden" name="nc" value="614783" /><input type="hidden" name="action" value="post" />
                        <input type="hidden" name="session" value="99618195185de6801a90492c6e669953" /><input type="hidden" name="postid" value="ae7b46" />
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <table>
                                            <tbody>
                                                <tr id="firstline">
                                                    <td><span style="color: rgb(214, 14, 104); --darkreader-inline-color: #f2398c;" data-darkreader-inline-color="">Strange</span></td>
                                                    <td>:</td>
                                                    <td><input type="text" name="message" value="" size="40" style="color: rgb(214, 14, 104); --darkreader-inline-color: #f2398c;" autofocus="" data-darkreader-inline-color="" /></td>
                                                    <td><input type="submit" value="Send to" /></td>
                                                    <td>
                                                        <select name="sendto" size="1">
                                                            <option value="s *">-All chatters-</option>
                                                            <option value="Aera23" style="color: rgb(0, 255, 69); --darkreader-inline-color: #1aff58;" data-darkreader-inline-color="">Aera23 (offline)</option>
                                                            <option
                                                                value="BOSS"
                                                                style="color: rgb(212, 221, 228); font-family: 'Courier New', Courier, monospace; font-weight: bold; --darkreader-inline-color: #d2cec8;"
                                                                data-darkreader-inline-color=""
                                                            >
                                                                BOSS (offline)
                                                            </option>
                                                            <option value="mrduck123" style="color: rgb(138, 43, 226); --darkreader-inline-color: #943ee5;" data-darkreader-inline-color="">mrduck123 (offline)</option>
                                                            <option
                                                                value="Rosier"
                                                                style="color: rgb(206, 2, 2); font-family: 'Comic Sans MS', Papyrus, sans-serif; font-style: italic; font-weight: bold; --darkreader-inline-color: #fd3c3c;"
                                                                data-darkreader-inline-color=""
                                                            >
                                                                Rosier (offline)
                                                            </option>
                                                            <option value="sobachka228" style="color: rgb(144, 102, 197); --darkreader-inline-color: #966fc8;" data-darkreader-inline-color="">sobachka228</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="file" name="file" /><small>Max 1024 KB</small></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tbody>
                            <tr id="thirdline">
                                <td>
                                    <form action="/index.php" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="lang" value="en" /><input type="hidden" name="nc" value="614783" /><input type="hidden" name="action" value="delete" />
                                        <input type="hidden" name="session" value="99618195185de6801a90492c6e669953" /><input type="hidden" name="sendto" value="" /><input type="hidden" name="what" value="last" />
                                        <input type="submit" value="Delete last message" class="delbutton" />
                                    </form>
                                </td>
                                <td>
                                    <form action="/index.php" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="lang" value="en" /><input type="hidden" name="nc" value="614783" /><input type="hidden" name="action" value="delete" />
                                        <input type="hidden" name="session" value="99618195185de6801a90492c6e669953" /><input type="hidden" name="sendto" value="" /><input type="hidden" name="what" value="all" />
                                        <input type="submit" value="Delete all messages" class="delbutton" />
                                    </form>
                                </td>
                                <td class="spacer"></td>
                                <td>
                                    <form action="/index.php" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="lang" value="en" /><input type="hidden" name="nc" value="614783" /><input type="hidden" name="action" value="post" />
                                        <input type="hidden" name="session" value="99618195185de6801a90492c6e669953" /><input type="hidden" name="multi" value="on" /><input type="submit" value="Switch to multi-line" />
                                        <input type="hidden" name="sendto" value="" />
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

