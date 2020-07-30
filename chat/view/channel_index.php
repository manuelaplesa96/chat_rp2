<?php require_once __DIR__ . '/_header.php'; ?>

<?php foreach($channelList as $channel) 
    echo '<a href="chat.php?rt=channel/show&id_channel=' . $channel->id . '">' . $channel->name . '</a><br>';
?>
<?php require_once __DIR__ . '/_footer.php'; ?>
