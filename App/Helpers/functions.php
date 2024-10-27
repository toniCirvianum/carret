<?php

function hola()
{
    echo 'Hola';
}

function userLogged()
{
    if (isset($_SESSION['user_logged'])) {
        return true;
    } else {
        header('Location: /');
        exit();
    }
}

function validateMail($mail)
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
