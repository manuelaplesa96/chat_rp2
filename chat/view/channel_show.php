<?php require_once __DIR__ . '/_header.php'; ?>

<?php 

    foreach($messagesList as $message) 
    {   echo '<pre>';
        echo $usersList[$message->id_user] . ', ' . $message->date . '<br><br>';
        echo $message->content . '<br><br>'; 
        echo '<form action="chat.php?rt=channel/show&id_channel=' . $_SESSION['id_channel'] .'" method="post">';
        echo '<button type="submit" name="like" value="' . $message->id . '">Like: ' . $message->thumbs_up . '</button><br>';
        echo '</form>';
        echo '<br><br>';
        echo '</pre>';
    }
?>
    <form action="chat.php?rt=channel/show&id_channel=<?php echo $_SESSION['id_channel'] ; ?>" method="post">
        <textarea name="new_message" rows="3" cols="50">Write to <?php echo $title ?></textarea>
        <button type="submit" name="submit">Submit</button>
    </form>    
    

<?php require_once __DIR__ . '/_footer.php'; ?>