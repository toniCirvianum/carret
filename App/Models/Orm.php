<?php

namespace App\Models;

use \App\Helpers\Database;

class Orm extends Database{

    protected $model;

    public function __construct($model){
        parent::__construct();
        $this->model = $model;
        if(!isset($_SESSION[$model])){
            $_SESSION[$model] = [];
        }

    }

    public function getById($id){
        // foreach ($_SESSION[$this->model] as $item) {
        //     if($item['id'] == $id){
        //         return $item;
        //     }
        // }
        $sql = "SELECT * FROM $this->model WHERE id = :id";
        $params = [":id" => $id];
        $result = $this->queryDataBase($sql, $params);
        $result = $result != null ? $result->fetch() : null;
        return $result;

    }

    public function removeItemById($id){
        foreach ($_SESSION[$this->model] as $key => $item) {
            if($item['id']==$id){
                unset($_SESSION[$this->model][$key]);
                return $item;
            }
        }
        return null;
    }

    public function create($item){
        //$_SESSION[$this->model][] = $item;
        
        $colums = implode(", ",array_keys($item));
        $values = ":".implode(", :",array_keys($item));
        $sql = "INSERT INTO $this->model ($colums) VALUES ($values)";
        $params=[];
        foreach ($item as $key => $value) {
            $params[":$key"]=$value;
        }
        $result = $this->queryDataBase($sql,$params,true);
        array_push($_SESSION[$this->model],$item);
        return $result;

    }

    public function getAll(){
        return $_SESSION[$this->model];
    }

    public function updateItemById($itemUpdated){
        foreach ($_SESSION[$this->model] as $key => $item) {
            if($item['id']==$itemUpdated['id']){
                $_SESSION[$this->model][$key]=$itemUpdated;
                return $itemUpdated;
            }
        }
        return null;
    }

    public function reset(){
        unset($_SESSION[$this->model]);
    }

    

    


}


?>
