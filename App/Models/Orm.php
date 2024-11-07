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
        // foreach ($_SESSION[$this->model] as $key => $item) {
        //     if($item['id']==$id){
        //         unset($_SESSION[$this->model][$key]);
        //         return $item;
        //     }
        // }
        // return null;
        $sql = "DELETE FROM $this->model WHERE id = :id";
        $params = [":id" => $id];
        $result = $this->queryDataBase($sql, $params);
        return $result;

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
        $sql = "SELECT * FROM $this->model";
        $result = $this->queryDataBase($sql);
        $_SESSION[$this->model] = $result->fetchAll();
        return $_SESSION[$this->model];


    }

    public function updateItemById($itemUpdated){
        // foreach ($_SESSION[$this->model] as $key => $item) {
        //     if($item['id']==$itemUpdated['id']){
        //         $_SESSION[$this->model][$key]=$itemUpdated;
        //         return $itemUpdated;
        //     }
        // }
        // return null;
        // UPDATE $this->mdoel SET (item=:item,description=:desciption) WHERE id=:id
        $set="";
        foreach ($itemUpdated as $key => $value) {
            if ($key != 'id') {
                $set = $set . "$key=:$key, ";
            }
        }
        $set = substr($set,0,-2);
        $params=[];
        foreach ($itemUpdated as $key => $value) {
            $params[":$key"]=$value;
        }
        $sql ="UPDATE $this->model SET $set WHERE id=:id";
        $result = $this->queryDataBase($sql,$params);
        return $result;

        
    }

    public function reset(){
        unset($_SESSION[$this->model]);
    }

    

    


}


?>
