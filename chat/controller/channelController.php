<?php
require_once __DIR__ . '/../model/chatservice.class.php';


class ChannelController
{
    //ispisuje kanale ulogiranog korisnika
    public function index()
    {
        $user=$_SESSION['username'];
        $ls=new ChatService();
        $title='My channels';
        $channelList=$ls->getChannelsByUser($user);
        
        require_once __DIR__ . '/../view/channel_index.php';
    }
    
    //ispisuje sve kanale
    public function allChannels()
    {
        $ls=new ChatService();
        $title='All channels';
        $channelList=$ls->getAllChannels();
        require_once __DIR__ . '/../view/channel_index.php';
    }
    

    public function show()
    {     
        $ls=new ChatService();
        $id_channel=(int)$_SESSION['id_channel'];
   
        //provjeri je li dobar id
        if($ls->idChannelOk($id_channel))
        {   
            $title=$ls->getChannelName($id_channel);
            
            //ako je korisnik stisnuo like
            if(isset($_POST['like']))
            {   echo $_POST['like'];
                $ls->thumbsUp($_POST['like']);
                $redirect='Location: chat.php?rt=channel/show&id_channel=' . $_SESSION['id_channel'];
                header($redirect);
            }

            //ako korisnik zeli unijeti novu poruku
            if(isset($_POST['new_message'])) 
            {
                if(preg_match('/^[@£$¥èéùìòÇ\fØø\nÅåΔ_ΦΓΛΩΠΨΣΘΞÆæßÉ !\"#¤%&()*+,-.0-9:;<=>\?¡A-ŽÄÖÑÜ§¿a-žäöñüà\^\{\}\[~\]|€]+$/', htmlspecialchars($_POST['new_message'])))
                {
                    $ls->newMessage($_SESSION['username'],$_SESSION['id_channel'],htmlspecialchars($_POST['new_message']));
                    $redirect='Location: chat.php?rt=channel/show&id_channel=' . $_SESSION['id_channel'];
                    header($redirect);
                }
                else
                {
                    $title='Input error!';
                    require_once __DIR__ . '/../view/channel_error.php';

                }
            }
            $messagesList=$ls->getMessagesByChannel($id_channel);
         
            $usersList=[];
            for($i=0;$i<sizeof($messagesList);$i++)
                $usersList[$messagesList[$i]->id_user]=$ls->getUserName($messagesList[$i]->id_user);

            require_once __DIR__ . '/../view/channel_show.php';
        }
        else
        {
            $title='Error!';
            require_once __DIR__ . '/../view/channel_error.php';
        }
    }

    public function new()
    {
        $title='Start a new channel';
        require_once __DIR__ . '/../view/channel_new.php';
    }

    public function newChannel()
    {
        if(isset($_POST['channel']) && preg_match('/^[A-Ža-ž0-9 .,-]+$/', $_POST['channel']))
        {   
            $ls=new ChatService();
            $name=$_POST['channel'];
            $ls->addNewChannel($_SESSION['username'],$name);
            $title='You started channel "' . $name . '"';

            require_once __DIR__ . '/../view/channel_new.php';
        }
        else
        {
            $title="Input error!";
            require_once __DIR__ . '/../view/channel_error.php';

        }
    }

}

?>