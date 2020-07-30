<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <style>
        h1,h2,h3 { color: #ecb613; font-family: courier;}
    </style>

</head>
<body>
    <h1>Chat</h1>
    <form action="chat.php" method="post">
        username:
        <input type="text" name="username"><br><br>
        password:
        <input type="password" name="password"><br><br>
        <button type="submit">Login</button>
    </form>
    <h3><?php echo $title; ?></h3>