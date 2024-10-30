<?php

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

            if ($newProduct['image'] == false) {
                $_SESSION['error'] = "Error al pujar la imatge";
                $this->index();
                return;
            }
            $p->create($newProduct);
            $_SESSION['message'] = "Producte afegit";

            $this->index();
            return;
        }
    }

    public function deleteProducte($id = null)
    //metode per eliminar productes. Si estan al carret també els elimina del carret
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

    public function editarProducte($id = null)
    //crea la vista per editar producte
    {
        userLogged();
        adminLogged();
        $p = new Producte();
        $producte = $p->getById($id[0]);
        $params['producte'] = $producte;
        $params['title'] = "Editar producte";
        $params['user_image'] = $_SESSION['user_logged']['img_profile'];
        if (isset($_SESSION['error'])) { //si no hi ha error no fa falta passar res
            $params['error'] = $_SESSION['error'];
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['message'])) { //si no hi ha message no fa falta passar res
            $params['message'] = $_SESSION['message'];
            unset($_SESSION['message']);
        }
        $this->render("producte/editarProducte", $params, "admin");
        return;
    }

    public function desarProducte()
    //metode per desar els canvis d'un producte després d'editar-lo
    {
        userLogged();
        adminLogged();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price'])) {
                $_SESSION['error'] = "Falten camps per omplir";
                $this->editarProducte();
                return;
            }
            $p = new Producte();
            $producte = $p->getById($_POST['id']);
            $producte['name'] = empty($_POST['name']) ? $producte['name'] : $_POST['name'];
            $producte['description'] = empty($_POST['description']) ? $producte['description'] : $_POST['description'];
            $producte['price'] = empty($_POST['price']) ? $producte['price'] : $_POST['price'];
            $producte['image'] = $_FILES['img_product']['size'] == 0 ? $producte['image'] : getImage($_FILES['img_product'], "sneaker" . $_POST['id'], 'img');

            $p->updateItemById($producte);
            $_SESSION['message'] = "Producte actualitzat";
            $this->editarProducte($_POST['id']);
            return;
        }
    }
}
