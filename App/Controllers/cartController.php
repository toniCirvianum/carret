<?php

class cartController extends Controller
{

    public function index()
    {
        if ($this->userLogged()) {
            $this->showProducts();
            return;
        } else {
            header('Location: /');
            exit();
        }
    }
    private function userLogged() {
        if (isset($_SESSION['user_logged'])) {
            return true;
        } else {
            return false;
        }
    }
    public function showProducts()
    {
        // echo "<pre>";
        // print_r($_SESSION['cart_items']);
        // echo "</pre>";
        if (!$this->userLogged()) {
            header('Location: /');
            exit();
        }
        
        if (!$_SESSION['products'] && empty($_SESSION['products'])) {
            //mostra missatge dient que no hi ha productes
            $params['title'] = "Products";
            $this->render('carret/empty', $params, 'site');
        } else {
            $params['error'] = $_SESSION['error'];
            unset($_SESSION['error']);
            $params['prod_id'] = $_SESSION['prod_id'];
            unset($_SESSION['prod_id']);
            isset($_SESSION['cart_items']) ? $params['cart_items'] = $_SESSION['cart_items'] : $params['cart_items'] = 0;
            $params['title'] = "Products";
            $params['products'] = $_SESSION['products'];
            $params['message'] = $_SESSION['message'];
            unset($_SESSION['message']);
            $this->render('carret/products', $params, 'site');
        }
    }

    function addItemsToCart()
    {
        if (!$this->userLogged()) {
            header('Location: /');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['id'])) {
                $_SESSION['prod_id'] = $_POST['id'];
                $_SESSION['error'] = "Error al afegir el producte al carret";
                $this->showProducts();
                return;
            }

            $p = new Producte();
            $productToAdd = $p->getById($_POST['id']);
            if (!$productToAdd) {
                $_SESSION['prod_id'] = $_POST['id'];
                $_SESSION['error'] = "Error al afegir el producte al carret " . $productToAdd['name'];
                $this->showProducts();
                return;
            }
            $c = new Cart();
            $c->add_product($productToAdd);
            $_SESSION['message'] = "El producte " . $productToAdd['name'] . " s'ha afegit correctament";
            $_SESSION['cart_items'] = $c->get_cart_items();
            $this->showProducts();
            return;
        }
    }

    public function showCarret()
    {
        if (!$this->userLogged()) {
            header('Location: /');
            exit();
        }
        $c = new Cart();
        $params['cart'] = $c->getAll();
        $params['cart_total'] = $c->get_cart_total();
        $params['title'] = "Carret";
        $params['cart_items'] = $c->get_cart_items();
        $params['message'] = $_SESSION['message'];
        unset($_SESSION['message']);
        $this->render('carret/items', $params, 'site');
    }

    public function updateCarret( )
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $c = new Cart();
            if (isset($_POST['add']) && !empty($_POST['add'])) {
                $c-> update_qty($_POST['product_id'], 1);
            }
            if (isset($_POST['remove']) && !empty($_POST['remove'])) {
                $c-> update_qty($_POST['product_id'], -1);
            }
            $_SESSION['message'] = "Carret actualitzat";
            $this->showCarret();
            return;
        }
    }
}
