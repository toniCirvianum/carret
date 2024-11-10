<?php


if(!isset($_SESSION)){
    session_start();
    // $_SESSION['user_logged']=false;
    $_SESSION['error']="";
    $_SESSION['message']="";
    $_SESSION['prod_id']="";
}

define ('ROOT_PATH',$_SERVER['DOCUMENT_ROOT']);
include_once("vendor/autoload.php");
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();


include_once("App/Helpers/database.php");
include_once("App/Helpers/functions.php");
include_once("App/Router.php");
include_once("App/Models/Orm.php");
include_once("App/Models/User.php");
include_once("App/Models/Cart.php");
include_once("App/Models/Producte.php");
include_once("App/Models/HistoryCart.php");
include_once("App/Core/Controller.php");
// include_once("config.php");


use App\Router;





$myRouter = new Router();
$myRouter->run();