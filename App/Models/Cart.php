<?php
use App\Models\Orm;


class Cart extends Orm {
    public function __construct(){
        parent::__construct('cart');
        // Inicialitzem sino existeix
        if (!isset($_SESSION['id_cart'])) {
            $_SESSION['id_cart'] = 0;
        }
    }

    // Afegim productes
    public function add_product($product) {
        // Si el producte ja hi es augmentem la quantitat
        if (isset($_SESSION['cart'][$product['id']])) {
            $_SESSION['cart'][$product['id']]['qty'] += 1;
        } else {
            // Afegim el producte
            $_SESSION['cart'][$product['id']]= array(
                'name'  => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'image' => $product['image'],
                'qty'   => 1
            );

        }


    }

    // Calcula el total
    public function get_cart_total() {
        $total = 0;
        foreach ($_SESSION['cart'] as $product) {
            $total += $product['price'] * $product['qty'];
        }
        return $total;
    }

    public function get_product_qty($id) {
        return $_SESSION['cart'][$id]['qty'];
    }

    private function remove_product($id) {
        unset($_SESSION['cart'][$id]);
    }

    public function update_qty($id, $qty) {
        $_SESSION['cart'][$id]['qty'] += $qty;
        if ($_SESSION['cart'][$id]['qty'] <= 0) {
            $this->remove_product($id);
        }
    }

    public function get_cart_items() {
        $items = 0;
        foreach ($_SESSION['cart'] as $product) {
            $items += $product['qty'];
        }   
        return $items;
    }

    public function validateCart() {
        $date = date('Y-m-d H:i:s');
        
    }
}
