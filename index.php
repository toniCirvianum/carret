<?php


if (!isset($_SESSION)) {
    session_start();


}
use App\Router;
require_once('App/Router.php');
require_once('App/Core/Controller.php');
// require_once('App/Core/Mailer.php');
// require_once('App/Model/Orm.php');
// require_once('App/Model/Mp.php');
// require_once('App/Model/User.php');
require_once('App/config.php');


$_SESSION['user_looged']=$users[0];




$myRouter = new Router();
$myRouter->run();