<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="referrer" content="no-referrer">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <meta name="theme-color" content="#000000">
    <meta name="msapplication-TileColor" content="#000000">
    <meta http-equiv="Refresh" content="6; URL=/index.php?action=view&session=e4ddbbf448f1c40bec308260bc4ab425&lang=en">
    <title>RED HAT CHAT </title>
    <style>
        body,
        iframe {
            background-color: #000000;
            color: #FFFFFF;
            font-size: 14px;
            text-align: center;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            border: none
        }

        a:visited {
            color: #B33CB4
        }

        a:link {
            color: #00A2D4
        }

        a:active {
            color: #55A2D4
        }

        input,
        select,
        textarea {
            color: #FFFFFF;
            background-color: #000000
        }

        .error {
            color: #FF0033;
            text-align: left
        }

        .delbutton {
            background-color: #660000
        }

        .backbutton {
            background-color: #004400
        }

        #exitbutton {
            background-color: #AA0000
        }

        .setup table table,
        .admin table table,
        .profile table table {
            width: 100%;
            text-align: left
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
            margin-right: auto
        }

        .setup table table table,
        .admin table table table,
        .profile table table table {
            border-spacing: 0px;
            margin-left: auto;
            margin-right: unset;
            width: unset
        }

        .setup table table td,
        .backup #restoresubmit,
        .backup #backupsubmit,
        .admin table table td,
        .profile table table td,
        .login td+td,
        .alogin td+td {
            text-align: right
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
            text-align: left
        }

        .approve_waiting #action td:only-child,
        .help #backcredit,
        .login td:only-child,
        .alogin td:only-child,
        .init td:only-child {
            text-align: center
        }

        .sessions td,
        .sessions th,
        .approve_waiting td,
        .approve_waiting th {
            padding: 5px
        }

        .sessions td td {
            padding: 1px
        }

        .notes textarea {
            height: 80vh;
            width: 80%
        }

        .post table,
        .controls table,
        .login table {
            border-spacing: 0px;
            margin-left: auto;
            margin-right: auto
        }

        .login table {
            border: 2px solid
        }

        .controls {
            overflow-y: none
        }
    </style>
    <style>
        .nicklink {
            text-decoration: none
        }

        .channellink {
            text-decoration: underline
        }

        #chatters {
            max-height: 100px;
            overflow-y: auto
        }

        #chatters,
        #chatters table {
            border-spacing: 0px
        }

        #manualrefresh {
            display: block;
            position: fixed;
            text-align: center;
            left: 25%;
            width: 50%;
            top: -200%;
            animation: timeout_messages 26s forwards;
            z-index: 2;
            background-color: #500000;
            border: 2px solid #ff0000
        }

        @keyframes timeout_messages {
            0% {
                top: -200%
            }

            99% {
                top: -200%
            }

            100% {
                top: 0%
            }
        }

        .msg {
            max-height: 180px;
            overflow-y: auto
        }

        #bottom_link {
            position: fixed;
            top: 0.5em;
            right: 0.5em
        }

        #top_link {
            position: fixed;
            bottom: 0.5em;
            right: 0.5em
        }

        #chatters th,
        #chatters td {
            vertical-align: top
        }

        a img {
            width: 15%
        }

        a:hover img {
            width: 35%
        }

        #messages {
            word-wrap: break-word
        }
    </style>
    <style>
        body,
        iframe {
            background-color: #000000;
            color: #d73920
        }

        .msg {
            padding: 0.5em 0;
            border-bottom: 1px solid #363636
        }

        input,
        select,
        textarea,
        button {
            padding: 0.2em;
            border: 1px solid #ffffff;
            border-radius: 0.5em
        }

        #messages small {
            color: #989898
        }

        #messages {
            display: block;
            width: 79%
        }

        .messages #topic {
            display: block;
            width: 79%
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
            border-radius: 0.5em
        }

        input:hover,
        select:hover {
            background: #034
        }

        #exitbutton:hover {
            background: #909
        }
    </style>
</head>

<body class="messages"><a id="top"></a><a id="bottom_link" href="#bottom">Bottom</a>
    <div id="manualrefresh"><br>Manual refresh required<br>
        <form action="/index.php" enctype="multipart/form-data" method="post"><input type="hidden" name="lang" value="en"><input type="hidden" name="nc" value="112081"><input type="hidden" name="action" value="view"><input type="hidden" name="session" value="e4ddbbf448f1c40bec308260bc4ab425"><input type="submit" value="Reload"></form><br>
    </div>
    <div id="topic">!help !rules | Generally idle messageboard. DO NOT TRUST RANDOM SELLERS / MEDIA | Giving users a second chance, no pedo stuff at ALL!</div>
    <div id="chatters">
        <table>
            <tr>
                <th>Admin:</th>
                <td>&nbsp;</td>
                <td></td>
                <th>Staff:</th>
                <td>&nbsp;</td>
                <td></td>
                <th>Members:</th>
                <td>&nbsp;</td>
                <td></td>
                <th><a class="channellink" href="/index.php?action=post&amp;session=e4ddbbf448f1c40bec308260bc4ab425&amp;lang=en&amp;nc=112081&amp;sendto=s *" target="post">Guests:</a></th>
                <td>&nbsp;</td>
                <td class="chattername"><a class="nicklink" href="/index.php?action=post&amp;session=e4ddbbf448f1c40bec308260bc4ab425&amp;lang=en&amp;nc=112081&amp;sendto=skske" target="post"><span style="color:#3A536A;">skske</span></a> &nbsp; <a class="nicklink" href="/index.php?action=post&amp;session=e4ddbbf448f1c40bec308260bc4ab425&amp;lang=en&amp;nc=112081&amp;sendto=Markeee" target="post"><span style="color:#E8003F;">Markeee</span></a> &nbsp; <a class="nicklink" href="/index.php?action=post&amp;session=e4ddbbf448f1c40bec308260bc4ab425&amp;lang=en&amp;nc=112081&amp;sendto=Strange" target="post"><span style="color:#83B9B7;">Strange</span></a> &nbsp; <a class="nicklink" href="/index.php?action=post&amp;session=e4ddbbf448f1c40bec308260bc4ab425&amp;lang=en&amp;nc=112081&amp;sendto=yetget" target="post"><span style="color:#008000;">yetget</span></a> &nbsp; <a class="nicklink" href="/index.php?action=post&amp;session=e4ddbbf448f1c40bec308260bc4ab425&amp;lang=en&amp;nc=112081&amp;sendto=yoyohoneySingh" target="post"><span style="color:#4BB48A;">yoyohoneySingh</span></a> &nbsp; <a class="nicklink" href="/index.php?action=post&amp;session=e4ddbbf448f1c40bec308260bc4ab425&amp;lang=en&amp;nc=112081&amp;sendto=Realis" target="post"><span style="color:#0B83B5;">Realis</span></a> &nbsp; <a class="nicklink" href="/index.php?action=post&amp;session=e4ddbbf448f1c40bec308260bc4ab425&amp;lang=en&amp;nc=112081&amp;sendto=hjk" target="post"><span style="color:#F8EC78;">hjk</span></a> &nbsp; <a class="nicklink" href="/index.php?action=post&amp;session=e4ddbbf448f1c40bec308260bc4ab425&amp;lang=en&amp;nc=112081&amp;sendto=baba" target="post"><span style="color:#C399FD;">baba</span></a></td>
            </tr>
        </table>
    </div><span id="notifications"></span>
    <div id="messages">
        <div class="msg"><small>01-01 12:22:43 - </small><span class="usermsg"><span style="color:#3A536A;">skske</span> - <span style="color:#3A536A;">ozan burda msın</span></span></div>
        <div class="msg"><small>01-01 12:12:34 - </small><span class="usermsg"><span style="color:#008000;">yetget</span> - <span style="color:#008000;">i have red room <a href="http://pse4djzqztl5ftwiytegvz2ypoas4cv5rn24kl2fu6yo6pvazb2uwfyd.onion/redroom.php" target="_blank" rel="noreferrer noopener">http://pse4djzqztl5ftwiytegvz2ypoas4cv5rn24kl2fu6yo6pvazb2uwfyd.onion/redroom.php</a></span></span></div>
        <div class="msg"><small>01-01 12:11:49 - </small><span class="usermsg"><span style="color:#4BB48A;">yoyohoneySingh</span> - <span style="color:#4BB48A;">someone have red room</span></span></div>
        <div class="msg"><small>01-01 12:08:13 - </small><span class="usermsg"><span style="color:#C399FD;">baba</span> - <span style="color:#C399FD;">ben oz</span></span></div>
        <div class="msg"><small>01-01 12:07:36 - </small><span class="usermsg"><span style="color:#C399FD;">baba</span> - <span style="color:#C399FD;">ekmem</span></span></div>
        <div class="msg"><small>01-01 12:02:24 - </small><span class="usermsg"><span style="color:#008000;">yetget</span> - <span style="color:#008000;">sa</span></span></div>
        <div class="msg"><small>01-01 11:47:53 - </small><span class="usermsg"><span style="color:#803A58;">RedRoom</span> - <span style="color:#803A58;">hi</span></span></div>
    </div><a id="bottom"></a><a id="top_link" href="#top">Top</a>
</body>

</html>
