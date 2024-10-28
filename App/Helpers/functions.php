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

function imageTypeOk($file,$folder) 
//comprova si el tipus de la imatge es correcte i crea el directori si no existeix
{
    $allowed =  array('gif','png' ,'jpg');
    $filename = $file['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if(!in_array($ext,$allowed) ) {
        return false;
    } else {
        $path = __DIR__ . "/../../public/".$folder;
        if (!is_dir($path)) {
            mkdir($path,077);
        }
        return true;
    }

}
