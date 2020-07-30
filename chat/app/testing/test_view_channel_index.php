<?php

require_once __DIR__ . '/../../model/channel.class.php';

$title='All Channels';

$channelList=[];
$channelList[]=new Channel(1,12,'123456');
$channelList[]=new Channel(2,21,'321');
$channelList[]=new Channel(3,45,'23561');

require_once __DIR__ . '/../../view/channels_index.php'

?>