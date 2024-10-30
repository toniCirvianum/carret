<?php

use Google\Service\MyBusinessAccountManagement\Admin;

class adminController extends Controller {

    public function index()
    //carrega la vista de productes si ets admin
    //en cas contrari envia al login i mostra els errors corresponents
    {
        if (isset($_SESSION['user_logged']) && $_SESSION['user_logged']['admin'] == 1) {
            header("Location: /cart/showProducts");
            exit();
        } else {
            $params['title'] = "Login";
            if (isset($_SESSION['error'])) { //si no hi ha error no fa falta passar res
                $params['error'] = $_SESSION['error'];
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['message'])) { //si no hi ha missatge no fa falta passar res
                $params['message'] = $_SESSION['message'];
                unset($_SESSION['message']);
            }
            if (isset($_SESSION['user_image'])) { //si no hi ha imatge no fa falta passar res
                $params['user_image'] = $_SESSION['user_image'];
            }
            $this->render("user/login", $params, "main");
        }
    }
    
    public function list()
    //mostra la llista d'usuaris per actualitzar
    {
        userLogged();
        adminLogged();
        $params['title'] = "Llista d'usuaris";
        $u = new User();
        $params['users'] = $u->getAllExceptAdmin();
        $params['user_image'] = $_SESSION['user_logged']['img_profile'];
        $this->render("user/list", $params, "admin");
    }

    public function changeRol() 
    {
        //canvia el rol d'usari
        //Admin -> user i de ser user -> admin
        userLogged();
        adminLogged();

        $u = new User();
        $u->changeUserRol($_POST['id']);
        $this->list();
        return;
    }

    
    public function editUser() {
        //mostra la vista per editar l'usuari
        userLogged();
        adminLogged();
        $params['title'] = "Editar Usuari";
        $u = new User();
        $params['user'] = $u->getById($_POST['id']);
        $params['user_image'] = $_SESSION['user_logged']['img_profile'];
        if (isset($_SESSION['error'])) { //si no hi ha error no fa falta passar res
            $params['error'] = $_SESSION['error'];
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['message'])) { //si no hi ha message no fa falta passar res
            $params['message'] = $_SESSION['message'];
            unset($_SESSION['message']);
        }
        $this->render("user/edit.admin", $params, "admin");

    }

    public function updateUser()
     //metode per actualitzar info d'usuari
     {
        //si no es post no fa res
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (validateUserInput($_POST) == false) {
                $this->editUser();
                return;
            }
            $u = new User();
            $userUpdated = $u->getById($_POST['id']);
            $userUpdated = [
                'id' => $userUpdated['id'],
                'name' => $_POST['name'],
                'username' => $_POST['username'],
                'password' => empty($_POST['pass']) ? $userUpdated['password'] : $_POST['pass'],
                'mail' => $_POST['mail'],
                'admin' => $userUpdated['admin'],
                'token' => $userUpdated['token'],
                'verificat' => $userUpdated['verificat'],
                'img_profile' //sino es passa cap imatge es queda la que ja tenim i si es passa es guarda la nova
                => $_FILES['img_profile']['size']==0 ? $userUpdated['img_profile'] : getImage($_FILES['img_profile'], $_POST['username'], 'user')
            ];
            //Ajusta el nom de la imatge perque sigui el mateix que el nom d'usuari
            if ($userUpdated['img_profile'] != $userUpdated['username']) {
                rename(__DIR__ . "/../../Public/Assets/user/" . $userUpdated['img_profile'], __DIR__ . "/../../Public/Assets/user/" . $userUpdated['username'] . ".jpg");
                $userUpdated['img_profile'] = $userUpdated['username'] . ".jpg";
            }
            $u->updateItemById($userUpdated);
            $_SESSION['message'] = "Usuari actualitzat";
            $this->editUser();
            return;
        }
    }

}