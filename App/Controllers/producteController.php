<?php

use Google\Service\AdExchangeBuyerII\Product;

class producteController extends Controller
{

    public function index()
    //Carrega la vista per afegir productes
    {
        userLogged();
        adminLogged();
        $params['title'] = "Afegir producte";
        $params['user_image'] = $_SESSION['user_logged']['img_profile'];
        if (isset($_SESSION['error'])) { //si no hi ha error no fa falta passar res
            $params['error'] = $_SESSION['error'];
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['message'])) { //si no hi ha message no fa falta passar res
            $params['message'] = $_SESSION['message'];
            unset($_SESSION['message']);
        }
        $this->render("producte/add", $params, "admin");
    }


    public function addProducte()
    //afegeix productes a la llsita de productes 
    //els producrtes es guarden a la variable de sessio $_SESSION['products']
    {
        userLogged();
        adminLogged();
        //si no es post no fa res
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price']) || empty($_FILES['img_product'])) {
                $_SESSION['error'] = "Falten camps per omplir";
                $this->index();
                return;
            }
            $p = new Producte();
            $newProduct = [
                'id' => ++$_SESSION['id_product'],
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'image' => getImage($_FILES['img_product'], "sneaker" . $_SESSION['id_product'], 'img')
            ];

            $p->create($newProduct);
            $_SESSION['message'] = "Producte afegit";

            $this->index();
            return;
        }
    }

    public function deleteProducte($id = null)
    //elimina productes de la llista de productes
    {
        userLogged();
        adminLogged();
        $p = new Producte();
        $producte = $p->removeItemById($id[0]);
        if ($producte) {
            $_SESSION['message'] = "Producte eliminat";
        } else {
            $_SESSION['error'] = "Producte no eliminat";
        }
        header("Location: /cart/showProducts");
        exit();
    }

    public function UpdateProducte($id = null)
    {
        userLogged();
        adminLogged();
        $p = new Producte();
        $producte = $p->getItemById($id[0]);
        $params['producte'] = $producte;
        $params['title'] = "Editar producte";
        $params['user_image'] = $_SESSION['user_logged']['img_profile'];
        $this->render("producte/edit", $params, "admin");
    }
}
