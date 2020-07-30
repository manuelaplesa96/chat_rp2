<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/user.class.php';
require_once __DIR__ . '/channel.class.php';
require_once __DIR__ . '/message.class.php';


class ChatService
{
    public function getAllUsers()
    {   
        $users=[];

        $db=DB::getConnection();
        $st=$db->prepare('SELECT * FROM dz2_users');
        $st->execute();

        while($row=$st->fetch())
            $users[]=new User($row['id'],$row['username'],$row['password_hash'],$row['email'],
                    $row['registration_sequence'],$row['has_registered']);

        return $users;
    }

    public function getAllChannels()
    {   
        $channels=[];

        $db=DB::getConnection();
        $st=$db->prepare('SELECT * FROM dz2_channels');
        $st->execute();
        while($row=$st->fetch())
            $channels[]=new Channel($row['id'],$row['id_user'],$row['name']);

        return $channels;
    }

    //popis kanala korisnika
    public function getChannelsByUser($user)
    {   
        $channels=[];
        $db=DB::getConnection();

        //dobavimo id korisnika koji se ulogirao
        $st=$db->prepare('SELECT id FROM dz2_users WHERE username=:user');
        $st->execute(['user' => $user]);
        $row=$st->fetch();
        $id_user=$row['id'];

        //svi kanali koje je taj korisnik pokrenuo
        $st=$db->prepare('SELECT * FROM dz2_channels WHERE id_user=:id_user');
        $st->execute(['id_user' => $id_user]);
        
        while($row=$st->fetch())
            $channels[]=new Channel($row['id'],$row['id_user'],$row['name']);

        return $channels;
    }
    
    //provjera je li unesen dobar id
    public function idChannelOk($id)
    {
        $db=DB::getConnection();

        $st=$db->prepare('SELECT * FROM dz2_channels WHERE id=:id');
        $st->execute(['id'=>$id]);
   
        if($st->rowCount()===1)
            return true;

        return false;
    }

    //ime kanala prema id
    public function getChannelName($id_channel)
    {
        $ls=new ChatService();
        $channels=$ls->getAllChannels();
        return $channels[$id_channel-1]->name;
    }

    //ime korisnika prema id
    public function getUserName($id_user)
    {
        $ls=new ChatService();
        $users=$ls->getAllUsers();
        /*$names=[];
        for($i=0;$i<sizeof($users);$i++)
        {   
            for($j=0;$j<sizeof($messages);$j++)
                if($users[$i]->id===$messages[$j]->id_user) 
                    $names[$users[$i]->id]=$users[$i]->username;
        }
        return $names;*/
        return $users[$id_user-1]->username;
    }

    //popis poruka iz nekog kanala
    public function getMessagesByChannel($id_channel)
    {   
        $messages=[];
        $db=DB::getConnection();
        $st=$db->prepare('SELECT * FROM dz2_messages WHERE id_channel=:id_channel');
        $st->execute(['id_channel' => $id_channel]);
        
        while($row=$st->fetch())
        {
            $messages[]=new Message($row['id'],$row['id_user'],$row['id_channel'],$row['content'],
                    $row['thumbs_up'],$row['date']);
        }
        return $messages;
    }

    //mijenja stanje thumbs_up u bazi
    public function thumbsUp($id_message)
    {  
        $db=DB::getConnection();

        $st=$db->prepare("SELECT thumbs_up FROM dz2_messages  WHERE id=:id_message");
        $st->execute(['id_message' => $id_message]);
        $row=$st->fetch();
        $thumbs_up=$row['thumbs_up'];
        $thumbs_up+=1;

        $st=$db->prepare("UPDATE dz2_messages SET thumbs_up='$thumbs_up' WHERE id=:id_message");
        $st->execute(['id_message' => $id_message]);
    }

    //saznaje prvi slobodan id poruke
    public function getMessageId()
    {
        $id=[];

        $db=DB::getConnection();
        $st=$db->prepare('SELECT id FROM dz2_messages');
        $st->execute();

        while($row=$st->fetch())
            $id[]=$row['id'];
        
        $max=0;
        for($i=0;$i<sizeof($id);$i++)
            if($id[$i]>$max)
                $max=$id[$i];

        return $max+1;
    }

    //saznaje prvi slobodan id za kanal
    public function getChannelId()
    {
        $id=[];

        $db=DB::getConnection();
        $st=$db->prepare('SELECT id FROM dz2_channels');
        $st->execute();

        while($row=$st->fetch())
            $id[]=$row['id'];
        
        $max=0;
        for($i=0;$i<sizeof($id);$i++)
            if($id[$i]>$max)
                $max=$id[$i];

        return $max+1;
    }

    //vraca id korisnika prema username
    public function getUserId($username)
    {
        $id=[];

        $db=DB::getConnection();
        $st=$db->prepare('SELECT id,username FROM dz2_users');
        $st->execute();

        while($row=$st->fetch())
            $id[$row['username']]=$row['id'];

        return $id[$username];
    }

    //unosi novu poruku u trenutni kanal
    public function newMessage($user,$id_channel,$content)
    {
        $ls=new ChatService();
        $id=$ls->getMessageId();
        $id_user=$ls->getUserId($user);
        $thumbs_up=0;
        $date=date("Y-m-d H:i:s");
        $db=DB::getConnection();
        try{
            $st = $db->prepare( 'INSERT INTO dz2_messages (id,id_user,id_channel,content,thumbs_up,date) 
                                VALUES (:id,:id_user,:id_channel,:content,:thumbs_up,:date)' );
		    $st->execute( array( 'id' => $id, 'id_user' => $id_user, 'id_channel' => $id_channel,
                                'content' => $content, 'thumbs_up' => $thumbs_up,'date' => $date ) );
        }catch( PDOException $e ) { exit( "PDO error [dz2_channels]: " . $e->getMessage() ); }
    }
    
    //unos nove poruke
    public function addNewChannel($username,$name)
    {
        $ls=new chatService();
        $id=$ls->getChannelId();
        $id_user=$ls->getUserId($username);
   
        $db=DB::getConnection(); 
        try{
            $st = $db->prepare( 'INSERT INTO dz2_channels(id,id_user, name) VALUES (:id,:id_user, :name)' );
		    $st->execute( array( 'id' => $id, 'id_user' => $id_user, 'name' => $name ) );
        }catch( PDOException $e ) { exit( "PDO error [dz2_channels]: " . $e->getMessage() ); }
    }


    public function getMessagesByUser($user)
    {  
        $messages=[];
        $db=DB::getConnection();

        //dobavimo id korisnika koji se ulogirao
        $st=$db->prepare('SELECT id FROM dz2_users WHERE username=:user');
        $st->execute(['user' => $user]);
        $row=$st->fetch();
        $id_user=$row['id'];

        //sve poruke koje je taj korisnik poslao
        $st=$db->prepare('SELECT * FROM dz2_messages WHERE id_user=:id_user ORDER BY date DESC');
        $st->execute(['id_user' => $id_user]);
        while($row=$st->fetch())
            $messages[]=new Message($row['id'],$row['id_user'],$row['id_channel'],
                            $row['content'],$row['thumbs_up'],$row['date']);
        return $messages;
    }
}

?>