<?php


function userLogged()
//Si usuari no esta loguejat redirigeix a la pagina principal
{
    if (isset($_SESSION['user_logged'])) {
        return true;
    } else {
        header('Location: /user/index');
        exit();
    }
}

function adminLogged()
{
    if ($_SESSION['user_logged']['admin'] == false) {
        $_SESSION['error'] = "No tens permisos";
        header('Location: /cart/showProducts');
        exit();
    }
}

function validateMail($mail)
//comprova si el mail es correcte
{
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        return false;
    } else {
        return true;
    }
}

function validatePassword($pass)
//la contrasenya ha de tenir com a mínim
//8 caràcters
//una lletra minúscula
//una lletra majúscula
//un número
{
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/';
    if (!preg_match($pattern, $pass)) {
        return false;
    } else {
        return true;
    }
}

function validateUsername($username)
//el nom d'usuari ha de tenir com a mínim
//5 caràcters
//només pot contenir lletres i números
{
    $pattern = '/^[a-zA-Z0-9]{5,}$/';
    if (!preg_match($pattern, $username)) {
        return false;
    } else {
        return true;
    }
}

function imageTypeOk($file, $folder)
//comprova si el tipus de la imatge es correcte i crea el directori si no existeix
{
    $allowed =  array('gif', 'png', 'jpg');
    $filename = $file['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (!in_array($ext, $allowed)) {
        return false;
    } else {
        $path = __DIR__ . "/../../public/" . $folder;
        if (!is_dir($path)) {
            mkdir($path, 077);
        }
        return true;
    }
}

function getImage($file, $username, $dir)
{
    $img_default = false; //variable per saber si s'assigna imatge per defecte
    //si no es passa imatge de perfil s'assigna la per defecte
    if (!isset($file) || $file['size'] == 0) {
        copy(__DIR__ . "/../../Public/Assets/".$dir."/default.jpg", __DIR__ . "/../../Public/Assets/user/" . $username . ".jpg");
        $filename = $username . ".jpg";
        $img_default = true;
        return $filename;
    }

    //si es puja imatge es comprova si es valida
    if ($img_default == false) {
        //carreguem el nom de la imatge = nom usuari
        $extension = explode("/", $file['type']); //recuperem extensio del fitxer
        $filename = $username . "." . $extension[1]; //creem el nom del fitxer
        $path = __DIR__ . "/../../Public/Assets/" . $dir . "/"; //creem la ruta on es guardarà
        //si estem actulitzant una imatge borra l'antiga abans de desar la nova
        if (file_exists($path . $filename)) {
            unlink($path . $filename);
        }
        if (move_uploaded_file($file['tmp_name'], $path . $filename)) {
            return $filename;
        } else {
            $_SESSION['error'] = "Error al pujar la imatge";
            return false;
        }
    }
}

function validateUserInput($userInfo)
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



    $u = new User();
    if (isset($_SESSION['user_logged']) && $_SESSION['user_logged']['admin'] == false) {
        //si estem eidtant usuari comporva 
        //comprova si s'ha modificat el nom d'usuari i que el nou nom d'usuari no existeixi
        //comprova si s'ha modificat el mail i que el nou mail no existeixi
        if ($userInfo['username'] != $_SESSION['user_logged']['username']) {
            if ($u->getUserByUsername($userInfo['username']) != null) {
                $_SESSION['error'] = "El nom d'usuari ja existeix 1";
                return false;
            }
        }
        if ($userInfo['mail'] != $_SESSION['user_logged']['mail']) {
            if ($u->getUserByMail($userInfo['mail']) != null) {
                $_SESSION['error'] = "El mail ja existeix";
                return false;
            }
        }
    }
    if (!isset($_SESSION['user_logged'])) {
        //si estem creant usuari comprova que el usuari i mail no existeixi
        if ($u->getUserByUsername($userInfo['username']) != null) {
            $_SESSION['error'] = "El nom d'usuari ja existeix 2";
            return false;
        }
        if (!validateMail($userInfo['mail'])) {
            $_SESSION['error'] = "El mail no és correcte";
            return false;
        }
    }
    if (isset($_SESSION['user_logged']) && $_SESSION['user_logged']['admin'] == true) {
        //si estem eidtant usuari com a admin
        //comprova si s'ha modificat el nom d'usuari i que el nou nom d'usuari no existeixi
        //comprova si s'ha modificat el mail i que el nou mail no existeixi
        $editUser = $u->getById($userInfo['id']);
        if ($editUser['username'] != $userInfo['username']) {
            if ($u->getUserByUsername($userInfo['username']) != null) {
                $_SESSION['error'] = "El nom d'usuari ja existeix 3";
                return false;
            }
        }
        if ($userInfo['mail'] != $_SESSION['user_logged']['mail']) {
            if ($u->getUserByMail($userInfo['mail']) != null) {
                $_SESSION['error'] = "El mail ja existeix";
                return false;
            }
        }
    }

    return true;
}
