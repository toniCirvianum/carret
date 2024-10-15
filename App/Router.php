<?php

namespace App;

class Router
{

    private $controller;
    private $method;
    private $values=[];

    public function __construct()
    {
        $this->matchRoute();
    }

    public function matchRoute()
    {
        $url_array = explode('/', $_SERVER['REQUEST_URI']); //guardem la url en un array

        $this->controller = !empty($url_array[1]) ? $url_array[1] : 'cart';
        $this->controller = $this->controller . "Controller"; //gaurdem el nom del controller
        $controllerPath = "App/Controllers/" . $this->controller . ".php"; //guardem la ruta del controller

        if (!file_exists($controllerPath)) {
            //si no existeix el controlador, reiniciem variables als valors per defecte
            $this->controller = "errorController";
            $controllerPath = "App/Controllers/" . $this->controller . ".php";;
        }
        require_once($controllerPath); //Carreguem el controller

        if (isset($url_array[2])) {
            //si tenim una segon valor a la url inicialitzem metode
            $this->method = !empty($url_array[2]) ? $url_array[2] : 'index';
        } else {
            $this->method = 'index';
        }


        $items = count($url_array);

        if ($items >3) {
            for ($i=3; $i < $items; $i++) { 
                $this->values[$i-3]=$url_array[$i];
            }
        }

        
    }

    public function run()
    {
        $controller = $this->controller;
        $c = new  $controller();
        if (!method_exists($controller, $this->method)) {
            //si no existeix el metode asociem el valor per defecte
            $this->method = 'index';
        }
        $method = $this->method;
        echo "metode: ".$method;
        echo "controller ".$controller;

        isset($this->values) ? $c->$method($this->values) : $c->$method();

        
    }
}