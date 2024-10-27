<?php

use App\Models\Orm;


class HistoryCart extends Orm
{
    public function __construct()
    {
        parent::__construct('history_cart');
        // Inicialitzem sino existeix
        if (!isset($_SESSION['history_cart'])) {
            $_SESSION['history_cart'] = [];
        }
    }

    public function addElement($element, $username)
    {
        $date = date('Y-m-d H:i:s');

        if (isset($_SESSION['history_cart'])) {
            $arrayCart = $_SESSION['history_cart'];
            if (isset($arrayCart[$username])) {
                $arrayCart[$username][$date] = $element;
            } else {
                $arrayCart[$username] = [
                    $date => $element
                ];
            }
            $_SESSION['history_cart'] = $arrayCart;
        }
    }

    public function getHistoricalByUserId($idUser) {
        $arrayCart = $_SESSION['history_cart'];
        if (isset($arrayCart[$idUser])) {
            return $arrayCart[$idUser];
        }
        return null;
    }
}
