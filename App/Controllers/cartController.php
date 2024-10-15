<?php

class cartController extends Controller {

    public function index()
    {
        echo URL;

        if (!$_SESSION['user_looged']) {
            echo "redirigir al login";
        } else {
            $this->showProducts();
        }

        // //si usuari nologejat mostra login
        // if (!isset($_SESSION['user'])) {
        //     $params['title'] = 'Login';
        //     $this->render('user/login', $params, 'site');
        // } else {
        //     //usuari logejat mostra moduls
        //     $mpModel = new Mp();
        //     $params['title'] = 'Mps';
        //     $params['llista'] = $mpModel->getAll();
        //     $this->render('mp/index', $params, 'main');
        // }


    }

    private function showProducts() {
        
        if (!$_SESSION['products'] || empty($_SESSION['products']))
        {
            echo "anar a una vista per dir que no hi ha productes";
        } else {
            $params['title']="Products";
            $params['products'] = $_SESSION['products'];
            $this -> render ('carret/products', $params, 'main');
        }
    }

    function addItemsToCart(){
        echo "afegeixo un item al carret";
    }

}