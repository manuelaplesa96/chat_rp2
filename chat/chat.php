<?php
require_once __DIR__ . '/app/database/db.class.php';

session_start();
//https://pr2.studenti.math.hr/~username/library/index.php?rt=con/action
//https://pr2.studenti.math.hr/~username/library/index.php?rt=

if(!isset($_GET['rt']) && (!isset($_POST['username']) || !isset($_POST['password'])))
{
    $controller='login';
    $action='index';
}
elseif(isset($_POST['username']) && isset($_POST['password']) && !isset($_GET['rt']))
{

    $username=$_POST['username'];
    $password=$_POST['password'];

    $db=DB::getConnection();

    $st=$db->prepare('SELECT username,password_hash FROM dz2_users WHERE username=:user');
    $st->execute(['user'=>$username]);
    
    if($st->rowCount()!==1)
    {
        //echo 'Taj korisnik ne postoji! <br>';
        $_SESSION['wrong']=true;
        $controller='login';
        $action='index';
    }
    else
    {
        $row=$st->fetch();
        $password_hash=$row['password_hash'];
        if( password_verify( $password, $password_hash ) )
        {
            $_SESSION['username']=$username;
            $controller='channel';
            $action='index';
        }
        else
        {
            //echo 'Password nije ispravan!<br>';
            $_SESSION['wrong']=true;
            $controller='login';
            $action='index';
        }   
    }
}
elseif(isset($_GET['rt']))
{    
    $parts=explode('/',$_GET['rt']);

    if(isset($parts[0]) && preg_match('/^[a-z]+$/',$parts[0]))
        $controller=$parts[0];
    else
        $controller='channel';

    if(isset($parts[1]) && preg_match('/^[A-Za-z0-9]+$/',$parts[1]))
    {   
        if(isset($_GET['id_channel']))
        {   
            $action='show';
            $_SESSION['id_channel']=$_GET['id_channel'];
        }
        else
            $action=$parts[1];
    }
    else
        $action='index'; 
}

$controllerName=$controller . 'Controller';
//echo $controllerName . ' ' . $action;
if(!file_exists(__DIR__ . '/controller/' . $controllerName . '.php'))
    error_404();
require_once __DIR__ . '/controller/' . $controllerName . '.php';

if(!class_exists($controllerName))
    error_404();

$con=new $controllerName();

if(!method_exists($con,$action))
    error_404();

$con->$action();
exit(0);


//---------------------------------------


function error_404()
{
    require_once __DIR__ . '/controller/_404Controller.php';
    $con=new _404Controller();
    $con->index();
    exit(0);
}


?>