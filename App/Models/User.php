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
        $this->createTable();
    }

    public function createTable()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS users(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(250) NOT NULL,
            username VARCHAR(250) NOT NULL,
            password VARCHAR(250) NOT NULL,
            mail VARCHAR(250) NOT NULL,
            admin BOOLEAN NOT NULL DEFAULT 0,
            token VARCHAR(250) NOT NULL,
            verificat BOOLEAN NOT NULL DEFAULT 0,
            salt VARCHAR(250) NOT NULL,
            img_profile VARCHAR(250) NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            modified_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE = InnoDB;';
        $this->queryDataBase($sql);
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
        // foreach ($_SESSION[$this->model] as $user) {
        //     if($user['username'] == $username){
        //         return $user;
        //     }
            
        // } return null;
        $sql = "SELECT * FROM $this->model WHERE username=:username";
        $params = [
            ':username' =>$username
        ];
        $result = $this->queryDataBase($sql,$params);
        if ($result != null) $result;
        return $result;

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