<?php

require_once __DIR__ . '/../../model/chatservice.class.php';
require_once __DIR__ . '/../../model/channel.class.php';

$channels=ChatService::getAllChannels();

echo '<pre>';
print_r($channels);
echo '</pre>';

?>