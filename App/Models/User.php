<?php
use App\Models\Orm;


class User extends Orm
{

    public function __construct()
    {
        parent::__construct('users');
        if (!isset($_SESSION['id_user'])) {
            $_SESSION['id_user'] = 1;
        }
    }


    public function loginOk($u, $p)
    {   
        foreach ($_SESSION[$this->model] as $user) {
            if ($user['username'] == $u) {
                if ($user['password'] == $p) {
                    return $user;
                }
            }
            
        }return null;
    }

    public function generaToken(){
        $token ="AWEFRGTYGRTYYY";
        return $token;
    }

    public function getUserByUsername($username){
        foreach ($_SESSION[$this->model] as $user) {
            if($user['username'] == $username){
                return $user;
            }
            
        } return null;
    }



}