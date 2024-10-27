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
            if (isset($_SESSION['message'])) { //si no hi ha error no fa falta passar res
                $params['message'] = $_SESSION['message'];
                unset($_SESSION['message']);
            }
            $this->render("user/login", $params, "main");
        }
    }

    public function store()
    {
        //si no es post no fa res
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //si no passem res mostra error
            if (empty($userInfo['name']) || empty($userInfo['username']) || empty($userInfo['pass']) || empty($userInfo['mail'])) {
                $_SESSION['error'] = "Falten dades";
                $this->create();
                return;
            }

            //falta comprovar si l'usuari ja existeix
            //falta comprovar el format del mail
            //falta comprovar el format de la contrasenya

            $name = $_POST['name'];
            $username = $_POST['username'];
            $pass = $_POST['pass'];
            $mail = $_POST['mail'];

            $user = new User(); //instanciem la classe User
            $newuser = [
                "id" => $_SESSION['id_user']++,
                "name" => $name,
                "username" => $username,
                "password" => $pass,
                "mail" => $mail,
                "admin" => false,
                "token" => $user->generaToken(), //Falta la funcio per generar token
                "verificat" => false,
                "img_profile" => "A.jpg"
            ];


            //Afegim l'usuari al model
            $user->create($newuser);
            //variable per desar el nou usuari registrat
            $_SESSION['user_registered'] = $newuser;

            //generem el missatge per enviar al mail
            $mailer = new Mailer();
            $mailer->mailServerSetup();
            $mailer->addRec($mail, $name);
            $mailer->addVerifyContent($newuser);
            $mailer->send();

            //passem a la vista el missatge per verificar el compte
            $_SESSION['message'] = "Verifica el mail per activar el compte";
            $this->create();
            return;
        }
    }


    public function create()
    //genera la vista per crear usuari
    {
        userLogged();
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
    {
        //Funcio que rep el mail de verificacio
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
}
