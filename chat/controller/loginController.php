<?php
require_once __DIR__ . '/../model/chatservice.class.php';

class LoginController
{
    public function index()
    {
        $title='';
        if(isset($_SESSION['wrong']))
            $title="Wrong username or password!";
        unset($_SESSION['wrong']);

        require_once __DIR__ . '/../view/login_index.php';
    }
}
?>