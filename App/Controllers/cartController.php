<?php

class cartController extends Controller
{

    public function index()
    //carrega la vista de productes si estas logejat
    //sino el redirigeix a la pagina principal
    {
        if ($this->userLogged()) {
            $this->showProducts();
            return;
        }
    }

    private function userLogged()
    //comnprova si l'usuari esta logejat sino et retorna a la pagina 
    //principal
    {
        if (isset($_SESSION['user_logged'])) {
            return true;
        } else {
            header('Location: /');
            exit();
        }
    }
    public function showProducts()
    //mostra la vista de productes
    {
        $this->userLogged();
        //carreega la imatge de perfil de l'usuari
        $params['user_image'] = $_SESSION['user_logged']['img_profile'];

        if (!$_SESSION['products'] && empty($_SESSION['products'])) {
            //mostra missatge dient que no hi ha productes
            $params['title'] = "Products";
            $this->render('carret/empty', $params, 'site');
        } else {
            //si tot es correcte carrega els parametres de la vista
            $params['error'] = $_SESSION['error'];
            unset($_SESSION['error']);
            $params['prod_id'] = $_SESSION['prod_id'];
            unset($_SESSION['prod_id']);
            isset($_SESSION['cart_items']) ? $params['cart_items'] = $_SESSION['cart_items'] : $params['cart_items'] = 0;
            $params['title'] = "Products";
            $params['products'] = $_SESSION['products'];
            $params['message'] = $_SESSION['message'];
            unset($_SESSION['message']);
            if ($_SESSION['user_logged']['admin'] == true) {
                $params['admin'] = true;
                $this->render('carret/products', $params, 'admin');
            } else {
                $params['admin'] = false;
                $this->render('carret/products', $params, 'site');
            }
        }
    }

    function addItemsToCart()
    //afegeix productes seleccionats al carret
    {
        $this->userLogged();

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
    //mostra el contingut del carret
    {
        $this->userLogged();

        $c = new Cart();
        $params['cart'] = $c->getAll();
        $params['cart_total'] = $c->get_cart_total();
        $params['title'] = "Carret";
        $params['cart_items'] = $c->get_cart_items();
        $params['message'] = $_SESSION['message'];
        unset($_SESSION['message']);
        $params['user_image'] = $_SESSION['user_logged']['img_profile'];
        if ($_SESSION['user_logged']['admin'] == true) {
            $this->render('carret/items', $params, 'admin');
        } else {
            $this->render('carret/items', $params, 'site');
        }
    }

    public function updateCarret()
    //Actualitza el carret si augmentem o disminuim la quantitat
    {
        $this->userLogged();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $c = new Cart();
            if (isset($_POST['add']) && !empty($_POST['add'])) {
                $c->update_qty($_POST['product_id'], 1);
            }
            if (isset($_POST['remove']) && !empty($_POST['remove'])) {
                $c->update_qty($_POST['product_id'], -1);
            }
            $_SESSION['message'] = "Carret actualitzat";
            $this->showCarret();
            return;
        }
    }

    public function validateCarret()
    //Valida el carret i el guarda a la taula history_cart
    //L'històric es desa a la variable de sessió $_SESSION['history_cart']
    {
        $this->userLogged();
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            $_SESSION['message'] = "No es pot validar elcarret perquè esta buit";
            $this->showCarret();
            return;
        }
        $hc = new HistoryCart();
        $hc->addElement($_SESSION['cart'], $_SESSION['user_logged']['id']);
        unset($_SESSION['cart']);
        unset($_SESSION['cart_items']);
        unset($_SESSION['cart_total']);
        $_SESSION['message'] = "Carret validat";

        $this->showCarret();
        return;
    }

    public function history()
    //carrega la vista per mostrar l'historial de compres
    {
        $this->userLogged();
        $hc = new HistoryCart();
        $params['history'] = $hc->getHistoricalByUserId($_SESSION['user_logged']['id']);
        if (empty($params['history']) || is_null($params['history'])) {
            $_SESSION['message'] = "No hi ha historial de compres";
            $this->showProducts();
            return;
        }
        $params['user_image'] = $_SESSION['user_logged']['img_profile'];
        $params['title'] = "Historial de compres";
        if ($_SESSION['user_logged']['admin'] == true) {
            $this->render('carret/historical', $params, 'admin');
        } else {
            $this->render('carret/historical', $params, 'site');
        }
    }
}
