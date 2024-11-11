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
        $sql = "CREATE TABLE IF NOT EXISTS history_cart (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            date VARCHAR(100) NOT NULL,
            product_id INT NOT NULL,
            name VARCHAR(100) NOT NULL,
            description VARCHAR(255),
            price DECIMAL(10, 2) NOT NULL,
            image VARCHAR(255) NOT NULL,
            qty INT NOT NULL,
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
        // Insereix l'element a la base de dades
        $this->addToDatabase($userId, $element, $date);
        // Actualizar la variable de sesión amb el hsitorial de l'usuari
        $_SESSION['history_cart'][$userId] = $this->getHistoricalByUserIdFromDatabase($userId);
        

        // if (isset($_SESSION['history_cart'])) {
        //     $arrayCart = $_SESSION['history_cart'];
        //     if (isset($arrayCart[$userId])) {
        //         $arrayCart[$userId][$date] = $element;
        //     } else {
        //         $arrayCart[$userId] = [
        //             $date => $element
        //         ];
        //     }
        //     $_SESSION['history_cart'] = $arrayCart;

        // }
    }

    private function addToDatabase($userId, $element, $date)
    //Afegeix a la base de dadea el producte amb el usuariId i la data
    {
        $sql = "INSERT INTO history_cart (user_id, date, product_id, name, description, price, image, qty) VALUES (:user_id, :date, :product_id, :name, :description, :price, :image, :qty)";
        foreach ($element as $key => $value) {
            $params = [
                ':user_id' => $userId,
                ':date' => $date,
                ':product_id' => $key,
                ':name' => $value['name'],
                ':description' => $value['description'] ?? null,
                ':price' => $value['price'],
                ':image' => $value['image'] ?? null,
                ':qty' => $value['qty']
            ];
    
            $this->queryDataBase($sql, $params);
        }

       
    }

    public function getHistoricalByUserId($userId)
    //Obte l'historic de l'usuari
    {
        //ANTIC CODI
        // $arrayCart = $_SESSION['history_cart'];
        // if (isset($arrayCart[$idUser])) {
        //     return $arrayCart[$idUser];
        // }
        // return null;

        // Si el historial ya es a la sessió, retornar-lo
        if (isset($_SESSION['history_cart'][$userId])) {
            return $_SESSION['history_cart'][$userId];
        } 

        // Obtener el hsitoric de la BBDD
        $history = $this->getHistoricalByUserIdFromDatabase($userId);

        // Guardar el hsitorica la variable de sessió i el retorna
        if ($history) {
            $_SESSION['history_cart'][$userId] = $history;
        }
        return $history;
    }

    private function getHistoricalByUserIdFromDatabase($userId)
    //Obte el historial de l'usuari de la base de dades
    {
        $sql = "SELECT * FROM $this->model WHERE user_id = :user_id ORDER BY date DESC";
        $params = [':user_id' => $userId];

        $result = $this->queryDataBase($sql, $params)->fetchAll();
        //Un cop obte el resultat, cal treballar la logica de la variable de session
        //$_SESSION['history_cart'] es un array on la clau es el usuari ID i el valor es un array
        //formar per la data com a clau i un array de productes com a valo
        //Exemple
        // $_SESSION['history_cart'] = [
        //     1 => [ **A l'usuari amb id 1**
        //         '2021-09-01 12:00:00' => [
        //             1 => [ **Producte amb id 1**
        //                 'name' => 'Producte 1',
        //                 'description' => 'Descripció del producte 1',
        //                 'price' => 10.00,
        //                 'image' => 'producte1.jpg',
        //                 'qty' => 2
        //             ]
        unset($_SESSION['history_cart'][$userId]);
        foreach ($result as $row) {
            $_SESSION['history_cart'][$userId][$row['date']][$row['product_id']] = [
                'name' => $row['name'],
                'description' => $row['description'],
                'price' => $row['price'],
                'image' => $row['image'],
                'qty' => $row['qty']
            ];
        }
        //retorna l'historic de l'usuari
        return $_SESSION['history_cart'][$userId];
    }
}
