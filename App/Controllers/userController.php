<?php


class userController extends Controller
{

    public function index()
    {
        if (isset($_SESSION['user_logged']) && $_SESSION['user_logged'] != false) {
            $params['title'] = "My App";
            $this->render("user/user", $params, "site");
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
            if (empty($_POST['name']) || empty($_POST['username']) || empty($_POST['pass']) || empty($_POST['mail'])) {
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


            }
        }
    }

    public function view()
    {
        //carrega el user View
        $this->index();
        return;
    }

    public function logout()
    {
        //esborrem la variable de sessio user_logged i la posem a false
        unset($_SESSION['user_logged']);
        $_SESSION['user_logged'] = false;
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
}