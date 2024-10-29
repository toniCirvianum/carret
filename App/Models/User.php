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

    public function getUserByMail($mail){
        foreach ($_SESSION[$this->model] as $user) {
            if($user['username'] == $mail){
                return $user;
            }
            
        } return null;
    }

    public function getAllExceptAdmin(){
        $users = [];
        foreach ($_SESSION[$this->model] as $user) {
            if($user['id']!=0){
                $users[] = $user;
            }
        }
        return $users;
    }

    public function changeUserRol($id){
        //change user role
        $user = $this->getById($id);
        if ($user['admin'] == true) {
            $user['admin'] = false;
            $this->updateItemById($user);
            echo "User is not admin";
            return;
        } else {
            $user['admin'] = true;
            $this->updateItemById($user);
            echo "User is admin";
            return;
        }
    }

    


}