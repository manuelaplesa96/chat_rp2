<?php

require_once __DIR__ . '/../../model/chatservice.class.php';
require_once __DIR__ . '/../../model/message.class.php';

$messages=ChatService::getMessagesByChannel(1);

echo '<pre>';
print_r($messages);
echo '</pre>';

?>