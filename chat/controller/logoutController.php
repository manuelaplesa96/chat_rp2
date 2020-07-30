<?php
require_once __DIR__ . '/../model/chatservice.class.php';

class LogoutController
{
    public function index()
    {   
        session_destroy();
        session_unset();
        require_once __DIR__ . '/../view/logout_index.php';
    }
}
?>