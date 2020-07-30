<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <style>
        h1,h2 { color: #ecb613; font-family: courier;}
        a { color: #4d4d4d; font-family: courier; text-decoration: none }
    </style>

</head>
<body>
    <h1>Chat</h1>

    <hr>
        <ul>
            <li>
                <a href='chat.php?rt=channel/index'>My channels</a>
            </li>
            <li>
                <a href='chat.php?rt=channel/allChannels'>All channels</a>
            </li>
            <li>
                <a href='chat.php?rt=channel/new'>Start a new Channel</a>
            </li>
            <li>
                <a href='chat.php?rt=message/index'>My messages</a>
            </li>
            <li>
                <a href='chat.php?rt=logout/index'>Logout</a>
            </li>

        </ul>
    <hr>

    <h2><?php echo $title; ?></h2>
