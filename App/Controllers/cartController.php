<?php
if (!isset($_SESSION)) {
    session_start();
}
class cartController extends Controller {

    public function index()
    {

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

    public function showProducts() {
        
        if (!$_SESSION['products'] || empty($_SESSION['products']))
        {
            echo "anar a una vista per dir que no hi ha productes";
        } else {
            $params['error'] = $_SESSION['error'];
            unset($_SESSION['error']);
            $params['prod_id'] = $_SESSION['prod_id'];
            unset($_SESSION['prod_id']);
            $params['cart_items'] = $_SESSION['cart_items'];
            unset($_SESSION['cart_items']);
            $params['title']="Products";
            $params['products'] = $_SESSION['products'];
            $this -> render ('carret/products', $params, 'site');
        }
    }

    function addItemsToCart(){
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            if (empty($_POST['id'])) {
                $_SESSION['error'] = "Error al afegir el producte al carret";
                $_SESSION['prod_id'] = $_POST['id'];
                $this->showProducts();
                return;
            }
            foreach ($_SESSION['products'] as $product) {
                if ($product['id'] == $_POST['id']) {
                    $cart = new Cart();
                    $cart->add_product($product);
                    $_SESSION['cart_items'] = $cart->get_cart_items();
                    echo "<pre>";
                    print_r($_SESSION['cart']);
                    echo "</pre>";
                    $this->showProducts();
                    return;
                }
            }



        }
    }

}