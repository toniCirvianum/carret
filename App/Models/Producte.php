<?php

use App\Models\Orm;


class Producte extends Orm
{

    public function __construct()
    {
        parent::__construct('products');
        if (!isset($_SESSION['id_product'])) {
            $_SESSION['id_product'] = 9;
        }
        $this->createTable();
    }

    public function createTable(){
        $sql = "CREATE TABLE IF NOT EXISTS products (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(30) NOT NULL,
            description VARCHAR(100) NOT NULL,
            price FLOAT(6,2) NOT NULL,
            image VARCHAR(100) NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            modified_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE = InnoDB;";
 
        $this->queryDataBase($sql);
    }

    public function getProductName($id)
    {
        return $this -> getById($id)['name'];
    }



}
