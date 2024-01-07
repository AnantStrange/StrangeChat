<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="referrer" content="no-referrer">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <meta name="theme-color" content="#000000">
    <meta name="msapplication-TileColor" content="#000000">
    <title>Black Hat Chat</title>
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
            animation: timeout_messages 30s forwards;
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
            color: #ffffff
        }

        body {
            background-color: #000000;
            color: #ffffff;
            background-position: center;
            background-repeat: no-repeat;
            color: #ffffff;
            background-attachment: fixed;
        }

        .msg {
            max-height: 250px;
            overflow: auto;
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
            border-radius: 0.5em
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
            right: 0px;
            max-height: 100%;
            bottom: 2em;
            top: 2em;
        }

        .messages #chatters td,
        #chatters tr,
        #chatters th {
            display: table-row;
            width: 100% !important;
        }

        .messages #chatters table a {
            display: table-row;
            line-height: 0;
        }

        .messages #änderns {
            -webkit-animation: pulse 10s linear infinite;
            animation: pulse 10s linear infinite;
            font-weight: bold;
            color: #F00;
        }

        @-webkit-keyframes pulse {
            0% {
                color: #ed25e3;
            }

            25% {
                color: #9e2f03;
            }

            50% {
                color: #aaa208;
            }

            75% {
                color: #9e2f03;
            }

            100% {
                color: #ed25e3;
            }
        }

        @keyframes pulse {
            0% {
                color: #ed25e3;
            }

            25% {
                color: #9e2f03;
            }

            50% {
                color: #aaa208;
            }

            75% {
                color: #9e2f03;
            }

            100% {
                color: #ed25e3;
            }
        }

        .messages #topic {
            padding-top: 2px;
            padding-bottom: 15px;
            text-align: center;
            font-family: Helvetica;
            font-size: 18px;
            font-weight: bold;
            color: rgb(88, 163, 62);
            text-shadow: 1px 1px 2px black, 0 0 1em gold, 1px 0 1px black, 0 1px 1px black, -1px 0 1px black, 0 -1px 1px black;
            filter: saturate(50%) sepia(60%) contrast(200%);
        }

        .login {
            background-image: url('background.jpg');
            font-family: "Courier New", Courier, monospace;
        }

        .messages {
            background-image: url('chat2.jpg');
        }

        .post {
            background-image: url('chat.jpg');
        }

        .controls {
            background-image: url('chat2.jpg');
        }

        .rules {
            background-image: url('chat2.jpg');
        }

        .waitingroom {
            background-image: url('chat2.jpg');
        }

        /*.logout {	background-image:url('logout.jpg');	background-position:top;    font-family: "Courier New", Courier, monospace;}*/
        .inbox {
            background-image: url('inbox.png');
        }

        .msg {
            padding: 0.5em 0;
            border-bottom: 1px solid #363636;
            font-family: "Courier New", Courier, monospace;
            font-size: 13px;
        }

        input,
        select,
        textarea {
            color: white;
            background-color: black;
            border: 1px solid #397CAE;
            border-radius: 2px;
        }

        input:focus,
        select:focus,
        textarea:focus {
            box-shadow: 0px 0px 4px #5498CB
        }

        a:link,
        a:visited {
            color: #5F86E4;
        }

        a:hover {
            text-decoration: none;
        }

        a:active {
            text-decoration: none;
            color: #9DB3E7;
        }

        #exitbutton {
            background-color: black;
            border: 1px solid;
        }

        label:hover,
        input[type="checkbox"]:hover,
        input[type="submit"]:hover {
            color: white;
            background-color: #0018FF;
        }

        /* fun animations from EvilChat ;) */
        .glitch {
            position: relative;
        }

        @keyframes glitch-anim-1 {
            0% {
                clip: rect(3px, 1084px, 8px, 0);
            }

            5.88235% {
                clip: rect(72px, 1084px, 18px, 0);
            }

            11.76471% {
                clip: rect(63px, 1084px, 84px, 0);
            }

            17.64706% {
                clip: rect(83px, 1084px, 1px, 0);
            }

            23.52941% {
                clip: rect(100px, 1084px, 69px, 0);
            }

            29.41176% {
                clip: rect(77px, 1084px, 55px, 0);
            }

            35.29412% {
                clip: rect(88px, 1084px, 59px, 0);
            }

            41.17647% {
                clip: rect(84px, 1084px, 59px, 0);
            }

            47.05882% {
                clip: rect(21px, 1084px, 74px, 0);
            }

            52.94118% {
                clip: rect(93px, 1084px, 46px, 0);
            }

            58.82353% {
                clip: rect(32px, 1084px, 47px, 0);
            }

            64.70588% {
                clip: rect(97px, 1084px, 4px, 0);
            }

            70.58824% {
                clip: rect(69px, 1084px, 59px, 0);
            }

            76.47059% {
                clip: rect(67px, 1084px, 58px, 0);
            }

            82.35294% {
                clip: rect(87px, 1084px, 95px, 0);
            }

            88.23529% {
                clip: rect(83px, 1084px, 33px, 0);
            }

            94.11765% {
                clip: rect(102px, 1084px, 61px, 0);
            }

            100% {
                clip: rect(31px, 1084px, 64px, 0);
            }
        }

        @keyframes glitch-anim-2 {
            0% {
                clip: rect(47px, 1084px, 69px, 0);
            }

            5.88235% {
                clip: rect(4px, 1084px, 8px, 0);
            }

            11.76471% {
                clip: rect(22px, 1084px, 61px, 0);
            }

            17.64706% {
                clip: rect(108px, 1084px, 59px, 0);
            }

            23.52941% {
                clip: rect(66px, 1084px, 19px, 0);
            }

            29.41176% {
                clip: rect(114px, 1084px, 30px, 0);
            }

            35.29412% {
                clip: rect(34px, 1084px, 111px, 0);
            }

            41.17647% {
                clip: rect(26px, 1084px, 82px, 0);
            }

            47.05882% {
                clip: rect(39px, 1084px, 52px, 0);
            }

            52.94118% {
                clip: rect(21px, 1084px, 17px, 0);
            }

            58.82353% {
                clip: rect(29px, 1084px, 73px, 0);
            }

            64.70588% {
                clip: rect(13px, 1084px, 31px, 0);
            }

            70.58824% {
                clip: rect(16px, 1084px, 78px, 0);
            }

            76.47059% {
                clip: rect(81px, 1084px, 20px, 0);
            }

            82.35294% {
                clip: rect(76px, 1084px, 51px, 0);
            }

            88.23529% {
                clip: rect(55px, 1084px, 47px, 0);
            }

            94.11765% {
                clip: rect(91px, 1084px, 81px, 0);
            }

            100% {
                clip: rect(43px, 1084px, 15px, 0);
            }
        }

        .glitch:before,
        .glitch:after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            background: black;
            clip: rect(0, 0, 0, 0);
        }

        .glitch:after {
            left: 2px;
            text-shadow: -1px 0 red;
            animation: glitch-anim-1 2s infinite linear alternate-reverse;
        }

        .glitch:before {
            left: -2px;
            text-shadow: 2px 0 blue;
            animation: glitch-anim-2 3s infinite linear alternate-reverse;
        }

        .puff {
            animation: puff 2s infinite linear;
        }

        @keyframes puff {
            0% {
                opacity: 1;
                font-weight: 200;
                text-shadow: 0px 0px #555;
            }

            75% {
                opacity: 1;
                font-weight: 200;
                text-shadow: 0px 0px #555;
            }

            90% {
                opacity: 0;
                font-weight: 800;
                text-shadow: 1px 0px #555;
            }

            100% {
                opacity: 0;
                font-weight: 800;
                text-shadow: 1px 0px #555;
            }
        }

        .iamevil {
            animation-name: blink;
            animation-duration: 2s;
            animation-iteration-count: infinite;
            animation-direction: alternate;
            font-family: ChelseaSmile;
            font-size: 15px;
        }

        @font-face {
            font-family: ChelseaSmile;
            src: url('/fonts/ChelseaSmile.otf');
        }

        @font-face {
            font-family: EmojiSymbols;
            src: url('/fonts/Symbola.ttf');
        }

        @keyframes blink {
            from {
                color: red;
            }

            to {
                color: #ff8000;
            }
        }

        .emoji {
            font-family: EmojiSymbols, sans-serif;
            color: #FFF34A;
            font-size: 18px;
            font-weight: normal !important;
            /*http://unicode.org/emoji/charts/full-emoji-list.html*/
        }

        .publicnotes textarea {
            width: 800px;
            height: 800px;
        }

        .channellink {
            text-decoration: none;
            font-weight: bold;
        }

        .messages #chatters table {
            border-spacing: 3px;
        }

        .messages #chatters table a {
            color: #FFFFFF;
        }

        .captcha {
            opacity: 0;
        }

        .captcha:hover {
            opacity: 1;
        }
    </style>
    <link rel="icon" type="image/icon" sizes"32x32" href="favicon.ico">
</head>

<body class="messages"><a id="top"></a><a id="bottom_link" href="#bottom">Bottom</a>
    <div id="manualrefresh"><br>Manual refresh required<br>
        <form action="/chat.php" enctype="multipart/form-data" method="post"><input type="hidden" name="lang" value="en"><input type="hidden" name="nc" value="178702"><input type="hidden" name="action" value="view"><input type="hidden" name="session" value="8c2170be7c73711757aa5b324329ef34"><input type="submit" value="Reload"></form><br>
    </div>
    <div id="topic">Welcome to Black Hat Chat. Try !rules or !help. Send suggestions to @SuggestionBox ☝️</div>
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
                <td><a class="nicklink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=Strange" target="post"><span style="color:#813d9c;font-family:'Comic Sans MS',Papyrus,sans-serif;font-style:italic;font-weight:bold;">Strange</span></a> &nbsp; <a class="nicklink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=Enterprise" target="post"><span style="color:#4169e1;">Enterprise</span></a></td>
                <th><a class="channellink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=s *" target="post">Guests:</a></th>
                <td>&nbsp;</td>
                <td class="chattername"><a class="nicklink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=Operator" target="post"><span style="color:#70CD96;">Operator</span></a> &nbsp; <a class="nicklink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=glock" target="post"><span style="color:#235BB9;">glock</span></a> &nbsp; <a class="nicklink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=J0ha1" target="post"><span style="color:#FF0000;">J0ha1</span></a> &nbsp; <a class="nicklink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=potat" target="post"><span style="color:#F18B82;">potat</span></a> &nbsp; <a class="nicklink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=Cracker0009" target="post"><span style="color:#008080;">Cracker0009</span></a> &nbsp; <a class="nicklink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=yash" target="post"><span style="color:#FFA500;">yash</span></a> &nbsp; <a class="nicklink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=dealthstalker0" target="post"><span style="color:#40c4ce;">dealthstalker0</span></a> &nbsp; <a class="nicklink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=gilga" target="post"><span style="color:#DC68F8;">gilga</span></a> &nbsp; <a class="nicklink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=Jonathan" target="post"><span style="color:#75A42F;">Jonathan</span></a> &nbsp; <a class="nicklink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=lookingforthestuff" target="post"><span style="color:#4FEBBC;">lookingforthestuff</span></a> &nbsp; <a class="nicklink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=Solomon" target="post"><span style="color:#0BB02A;">Solomon</span></a> &nbsp; <a class="nicklink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=IG" target="post"><span style="color:#00BFFF;">IG</span></a> &nbsp; <a class="nicklink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=freebirds" target="post"><span style="color:#4169E1;">freebirds</span></a> &nbsp; <a class="nicklink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=deondeon" target="post"><span style="color:#9F6330;">deondeon</span></a> &nbsp; <a class="nicklink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=devil" target="post"><span style="color:#48D705;">devil</span></a> &nbsp; <a class="nicklink" href="/chat.php?action=post&amp;session=8c2170be7c73711757aa5b324329ef34&amp;lang=en&amp;nc=178702&amp;sendto=crox" target="post"><span style="color:#00BFFF;">crox</span></a></td>
            </tr>
        </table>
    </div><span id="notifications"></span>
    <div id="messages">
        <div class="msg"><small>01-02 06:57:21 - </small><span class="usermsg"><span style="color:#70CD96;">Operator</span> - <span style="color:#70CD96;">@J0hal I dont really but I have a template.</span></span></div>
        <div class="msg"><small>01-02 06:57:16 - </small><span class="usermsg"><span style="color:#235BB9;">glock</span> - <span style="color:#235BB9;">wasted my time</span></span></div>
        <div class="msg"><small>01-02 04:23:58 - </small><span class="sysmsg" title="system message"><span style="color:#00ffff;font-family:Verdana,Geneva,Arial,Helvetica,sans-serif;">Aera23</span> left the chat.</span></div>
        <div class="msg"><small>01-02 04:23:39 - </small><span class="usermsg"><span style="color:#00ffff;font-family:Verdana,Geneva,Arial,Helvetica,sans-serif;">Aera23</span> - <span style="color:#00ffff;font-family:Verdana,Geneva,Arial,Helvetica,sans-serif;"><!--Aera23 Short link PLMM--><a href="http://forwhoallvglhpsx6dhycfb4fu4a2lqkvxtwlivruw765qxofyns7wqd.onion/Aera23.html" target="_blank" rel="noreferrer noopener">forwhoallvglhpsx6dhycfb4fu4a2lqkvxtwlivruw765qxofyns7wqd.onion/Aera23.html</a> CSS :)</span></span></div>
        <div class="msg"><small>01-02 01:28:44 - </small><span class="usermsg"><span style="color:#00bfff;font-family:Arial,Helvetica,sans-serif;font-size:smaller;font-weight:bold;">apt</span> - <span style="color:#00bfff;font-family:Arial,Helvetica,sans-serif;font-size:smaller;font-weight:bold;">stux is afk</span></span></div>
        <div class="msg"><small>01-02 01:27:58 - </small><span class="usermsg"><span style="color:#FF69B4;">Bunny</span> - <span style="color:#FF69B4;">is <span style="color:#00ff00;"><span class="sysmsg">
        <div class="msg"><small>01-02 01:27:46 - </small><span class="usermsg"><span style="color:#FF69B4;">Bunny</span> - <span style="color:#FF69B4;">Well fristly happy new year to everyone.</span></span></div>
        <div class="msg"><small>01-02 01:26:56 - </small><span class="usermsg"><span style="color:#FF69B4;">Bunny</span> - <span style="color:#FF69B4;">hii</span></span></div>
        <div class="msg"><small>01-02 01:25:27 - </small><span class="usermsg"><span style="color:#D173DD;">dwayne</span> - <span style="color:#D173DD;">anyone know about null chat in darkweb?? do you peeps have link</span></span></div>
        <div class="msg"><small>01-02 01:23:39 - </small><span class="usermsg"><span style="color:#D173DD;">dwayne</span> - <span style="color:#D173DD;">is there 5$ crypto guy here??</span></span></div>
    </div><a id="bottom"></a><a id="top_link" href="#top">Top</a>
</body>

</html>
