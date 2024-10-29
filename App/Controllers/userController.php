<?php

class userController extends Controller
{

    public function index()
    {
        if (isset($_SESSION['user_logged'])) {
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

    public function store()
    //metode per crear o regsitrar un usuari
    {
        //si no es post no fa res
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //si no passem res mostra error
            if (empty($_POST['name']) || empty($_POST['username']) || empty($_POST['pass']) || empty($_POST['mail'])) {
                $_SESSION['error'] = "Falten dades";
                $this->create();
                return;
            }
            //validem dades
            if (validateUserInput($_POST) == false) {
                $this->create();
                return;
            }
            $name = $_POST['name'];
            $username = $_POST['username'];
            $pass = $_POST['pass'];
            $mail = $_POST['mail'];
            $image_profile = getImage($_FILES['img_profile'], $username, 'user');
            $user = new User(); //instanciem la classe User
            //Creem un nou usuari
            $newuser = [
                "id" => ++$_SESSION['id_user'],
                "name" => $name,
                "username" => $username,
                "password" => $pass,
                "mail" => $mail,
                "admin" => false,
                "token" => $user->generaToken(), //Falta la funcio per generar token
                "verificat" => true,
                "img_profile" => $image_profile
            ];
            //Afegim l'usuari al model
            $user->create($newuser);
            $this->view();
            return;
        }
    }



    public function create()
    //genera la vista per crear usuari
    {
        $params['title'] = "Nou usuari";
        if (isset($_SESSION['error'])) { //si no hi ha error no fa falta passar res
            $params['error'] = $_SESSION['error'];
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['message'])) { //si no hi ha error no fa falta passar res
            $params['message'] = $_SESSION['message'];
            unset($_SESSION['message']);
        }
        $this->render("user/create", $params, "main");
    }

    public function login()
    //comprova si les credencials son correctes
    {
        //si no es post no fa res
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //si no passem res mostra error
            if (empty($_POST['username']) || empty($_POST['pass'])) {
                $_SESSION['error'] = "Falten dades";
                $this->index();
                return;
            }
            $username = $_POST['username'];
            $pass = $_POST['pass'];

            $userModel = new User();
            $result = $userModel->loginOk($username, $pass);
            //Si les credencials no son correctes mostra error
            if (is_null($result)) {
                $_SESSION['error'] = "Credencials incorrectes";
                $this->index();
                return;
            }
            // Si arribem aqui les credencials son correctes
            //Per tant recuperem usuari del model
            $newUser = $userModel->getUserByUsername($username);
            //Comprovem si esta verificat
            if ($newUser['verificat'] == false) {
                $_SESSION['error'] = "Usuari no verificat";
                $this->index();
                return;
            } else {
                //Si esta verificat afegim a la variable de sessio user_logged
                $_SESSION['user_logged'] = $newUser;
                //Afegim la variable de sessio user_image per mostrar la imatge de perfil
                $_SESSION['user_image'] = $newUser['img_profile'];
                //carreguem la vista de l'usuari
                $this->view();
                return;
            }
        }
    }

    public function view()
    {
        //carrega el user View
        userLogged();
        $this->index();
        return;
    }

    public function logout()
    {
        //esborrem la variable de sessio user_logged i la posem a false
        unset($_SESSION['user_logged']);

        unset($_SESSION['cart']);
        unset($_SESSION['cart_items']);
        unset($_SESSION['cart_total']);
        //Esborrar altres variables de sessio
        $this->index();
    }

    public function edit()
    //genera la vista per editar usuari
    {
        userLogged();
        $params['title'] = "Edit User";
        $params['user'] = $_SESSION['user_logged'];
        $params['user_image'] = $_SESSION['user_logged']['img_profile'];
        $params['error'] = isset($_SESSION['error']) ? $_SESSION['error'] : null;
        unset($_SESSION['error']);
        $params['message'] = isset($_SESSION['message']) ? $_SESSION['message'] : null;
        unset($_SESSION['message']);
        $this->render("user/edit", $params, "site");
        return;
    }

    public function updateUser()
    //metode per actualitzar info d'usuari
    {
        //si no es post no fa res
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (validateUserInput($_POST) == false) {
                $this->edit();
                return;
            }
            $user = new User();
            $userUpdated = [
                'id' => $_SESSION['user_logged']['id'],
                'name' => $_POST['name'],
                'username' => $_POST['username'],
                'password' => empty($_POST['pass']) ? $_SESSION['user_logged']['password'] : $_POST['pass'],
                'mail' => $_POST['mail'],
                'admin' => $_SESSION['user_logged']['admin'],
                'token' => $_SESSION['user_logged']['token'],
                'verificat' => $_SESSION['user_logged']['verificat'],
                'img_profile' //sino es passa cap imatge es queda la que ja tenim i si es passa es guarda la nova
                => $_FILES['img_profile']['size']==0 ? $_SESSION['user_logged']['img_profile'] : getImage($_FILES['img_profile'], $_POST['username'], 'user')
            ];
            //Si es modifica el nom d'usuari també modifiquem el nom de la imatge de perfil
            if ($userUpdated['img_profile'] != $userUpdated['username']) {
                //si s'ha actualitzat la imatge de perfil esborrem la antiga
                rename(__DIR__ . "/../../Public/Assets/user/" . $userUpdated['img_profile'], __DIR__ . "/../../Public/Assets/user/" . $userUpdated['username'] . ".jpg");
                $userUpdated['img_profile'] = $userUpdated['username'] . ".jpg";
            }

            $user->updateItemById($userUpdated);
            $_SESSION['user_logged'] = $userUpdated;
            $_SESSION['message'] = "Usuari actualitzat";
            $this->edit();
            return;
        }
    }

    



}
