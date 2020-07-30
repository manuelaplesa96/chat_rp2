<?php
require_once __DIR__ . '/../model/chatservice.class.php';


class MessageController
{
    //ispisuje kanale ulogiranog korisnika
    public function index()
    {
        $user=$_SESSION['username'];
        $ls=new ChatService();
        $title='My messages';
        //ako je korisnik stisnuo like
        if(isset($_POST['like']))
        {   echo $_POST['like'];
            $ls->thumbsUp($_POST['like']);
            $redirect='Location: chat.php?rt=message/index';
            header($redirect);
        }
        $messagesList=$ls->getMessagesByUser($user);
        
        $names=[];
        for($i=0;$i<sizeof($messagesList);$i++)
            $names[$messagesList[$i]->id_channel]=$ls->getChannelName($messagesList[$i]->id_channel);
        
        require_once __DIR__ . '/../view/message_index.php';
    }
}

?>