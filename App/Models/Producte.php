<?php

use App\Models\Orm;


class Producte extends Orm
{

    public function __construct()
    {
        parent::__construct('products');
        if (!isset($_SESSION['id_product'])) {
            $_SESSION['id_product'] = 10;
        }
    }

    public function getProductName($id)
    {
        return $this -> getById($id)['name'];
    }



}
