<?php require_once __DIR__ . '/_header.php'; ?>

<?php 

    foreach($messagesList as $message)
    {   
        echo '<pre>';
        echo $message->date . '<br>';
        echo $message->content . '<br><br>'; 
        echo '<form action="chat.php?rt=message/index" method="post">';
        echo '<button type="submit" name="like" value="' . $message->id . '">Like: ' . $message->thumbs_up . '</button><br>';
        echo '</form>';
        echo '<a href="chat.php?rt=channel/show&id_channel=' . $message->id_channel . '">' . $names[$message->id_channel] . '</a><br>';
        echo '<br><br>';
        echo '</pre>';
    }
?>  
    

<?php require_once __DIR__ . '/_footer.php'; ?>