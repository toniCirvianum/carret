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
        $this->createTable();
    }

    public function createTable()
    {
        $sql="CREATE TABLE IF NOT EXISTS history_cart (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            product_id INT NOT NULL,
            product_name VARCHAR(100) NOT NULL,
            description VARCHAR(255),
            price DECIMAL(10, 2) NOT NULL,
            quantity INT NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            modified_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id),
            FOREIGN KEY (product_id) REFERENCES products(id)
        ) ENGINE = InnoDB;";
        $this->queryDataBase($sql);
    }

    public function addElement($element, $userId)
    {
        $date = date('Y-m-d H:i:s');

        if (isset($_SESSION['history_cart'])) {
            $arrayCart = $_SESSION['history_cart'];
            if (isset($arrayCart[$userId])) {
                $arrayCart[$userId][$date] = $element;
            } else {
                $arrayCart[$userId] = [
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
