<?php
if(!isset($_SESSION)){
    session_start();
    // $_SESSION['user_logged']=false;
    $_SESSION['error']="";
    $_SESSION['message']="";
    $_SESSION['prod_id']="";
}

include_once("vendor/autoload.php");
include_once("config.php"); //Donarà error si no s'afegeix aquest fitxer a l'arrel del projecte
include_once("App/Helpers/functions.php");
include_once("App/Router.php");
include_once("App/Models/Orm.php");
include_once("App/Models/User.php");
include_once("App/Models/Cart.php");
include_once("App/Models/Producte.php");
include_once("App/Models/HistoryCart.php");

include_once("App/Core/Controller.php");
include_once("App/Core/Mailer.php");


use App\Router;





$myRouter = new Router();
$myRouter->run();