<?php require_once __DIR__ . '/_header.php'; ?>

<form action="chat.php?rt=channel/newChannel" method="post">
    New channel:
    <input type="text" name="channel">
    <button type="submit" name="create">Create!</button>
</form>
<?php require_once __DIR__ . '/_footer.php'; ?>
