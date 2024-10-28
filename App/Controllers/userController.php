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
            if(isset($_SESSION['user_image'])){ //si no hi ha imatge no fa falta passar res
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
            if ($this->validateUserInput($_POST) == false) {
                $this->create();
                return;
            }
            $img_default = false; //variable per saber si s'assigna imatge per defecte
            //si no es passa imatge de perfil s'assigna la per defecte
            if (!isset($_FILES['img_profile']) || $_FILES['img_profile']['size'] == 0) {
                $filename = "default.jpg";
                $img_default = true;
            }
            $name = $_POST['name'];
            $username = $_POST['username'];
            $pass = $_POST['pass'];
            $mail = $_POST['mail'];
            //si es puja imatge es comprova si es valida
            if (!$img_default) {
                //si hi ha un error al pujar la imatge torna a cridar al create
                $filename = $this->getImage($_FILES['img_profile'], $username,'user');
                echo "<pre>";
            echo "img_default: " . $img_default . "<br>";
            echo "filename al if: " . $filename . "<br>"; 
            echo "</pre>";
                if (!$filename) {
                    echo "error al pujar la imatge torno a cridar al create";
                    $this->create();
                    return;
                }
            }
            //si no hi ha error al pujar la imatge
            //la imatge te el nom d'usuari
            $filename = $img_default ? $filename : $this->getImage($_FILES['img_profile'], $username,'user');
            echo "<pre>";
            echo "img_default: " . $img_default . "<br>";
            echo "filename: " . $filename . "<br>"; 
            echo "filename metodo getImage: " . $this->getImage($_FILES['img_profile'], $username,'user') . "<br>";
            echo "</pre>";
            $user = new User(); //instanciem la classe User
            //Creem un nou usuari
            $newuser = [
                "id" => $_SESSION['id_user']++,
                "name" => $name,
                "username" => $username,
                "password" => $pass,
                "mail" => $mail,
                "admin" => false,
                "token" => $user->generaToken(), //Falta la funcio per generar token
                "verificat" => true,
                "img_profile" => $filename
            ];
            //Afegim l'usuari al model
            $user -> create($newuser);
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
            //comprovem user i password
            // echo "<pre>";
            // echo "username: " . $username . " pass: " . $pass. "<br>";
            // echo print_r($_SESSION['users']);
            // echo "</pre>";
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

    public function verify($values = null)
    //Funcio que rep el mail de verificacio
    {
        
        // echo "estic al verify";
        // echo "<pre>";
        // print_r($values);
        // echo "</pre>";
        //Gaurdme el parametres que envia el mail
        $username = $values[0];
        $token = $values[1];
        // si no arribem parametres
        if (is_null($username) || is_null($token)) {
            $_SESSION['error'] = "Error al verificar credencials per mail";
            $this->index();
            return;
        }
        //comprovem si els parametres que s'han enviat son correctes
        if ($username == $_SESSION['user_registered']['username'] && $token == $_SESSION['user_registered']['token']) {
            $_SESSION['user_registered']['verificat'] = true;
            //actualitzem el model amb l'usuari verificat
            $userModel = new User();
            $userModel->updateItemById($_SESSION['user_registered']);
            //esborrem la variable de sessio user_registered
            unset($_SESSION['user_registered']);
            //cridem a la vista d'usuari verificat
            $params['title'] = "Usuari verificat";
            $this->render("user/verified", $params, "main");
            return;
        } else {
            //si les credencials no son correctes
            $_SESSION['error'] = "Error al verificar credencials per mail";
            $this->index();
            return;
        }
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

    private function validateUserInput($userInfo)
    //metodes per valdia info usuari
    {
        if (!validateUsername($userInfo['username'])) {
            $_SESSION['error'] = "El nom d'usuari ha de tenir com a mínim 5 caràcters i només pot contenir lletres i números";
            return false;
        }

        if (!empty($userInfo['pass'])) {
            if (!validatePassword($userInfo['pass'])) {
                $_SESSION['error'] = "La contrasenya ha de tenir com a mínim 8 caràcters, una lletra minúscula, una lletra majúscula i un número";
                return false;
            }
        }
        if (!validatePassword($userInfo['pass'])) {
            $_SESSION['error'] = "La contrasenya ha de tenir com a mínim 8 caràcters, una lletra minúscula, una lletra majúscula i un número";
            return false;
        }

        if (!validateMail($userInfo['mail'])) {
            $_SESSION['error'] = "El mail no és correcte";
            return false;
        }

        $u = new User();
        if ($u->getUserByUsername($userInfo['username']) != null) {
            $_SESSION['error'] = "El nom d'usuari ja existeix";
            return false;
        }

        return true;
    }

    public function updateUser()
    //metode per actualitzar info d'usuari
    {
        //si no es post no fa res
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($this->validateUserInput($_POST) == false) {
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
                'img_profile' => empty($_POST['img_profile']) ? $_SESSION['user_logged']['img_profile'] : $_POST['img_profile']
            ];
            echo "<pre>";
            print_r($userUpdated);
            echo "</pre>";

            $user->updateItemById($userUpdated);
            $_SESSION['user_logged'] = $userUpdated;
            $_SESSION['message'] = "Usuari actualitzat";
            $this->edit();
            return;
        }
    }

    public function getImage($file,$name,$dir)
    {
        if (!imageTypeOk($file, $dir)) {
            Echo "<br> fitxer no valid </br>";
            $_SESSION['error'] = "Tipus de fitxer no vàlid";
            return false;
        }
        $extension = explode("/", $file['type']); //recuperem extensio del fitxer
        $filename = $name . "." . $extension[1]; //creem el nom del fitxer
        $path = __DIR__ . "/../../Public/Assets/".$dir."/"; //creem la ruta on es guardarà
        if (move_uploaded_file($file['tmp_name'], $path . $filename)) {
            echo "<pre>";
            echo "filename a getImage: " . $filename . "<br>";
            echo "</pre>";
            return "$filename";
        } else {
            $_SESSION['error'] = "Error al pujar la imatge";
            return false;
        }

    }
}
