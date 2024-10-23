<?php
use App\Models\Orm;
class Cart extends Orm {
    public function __construct(){
        // Inicialitzem sino existeix
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
    }

    // Afegim productes
    public function add_product($product) {
        // Si el producte ja hi es augmentem la quantitat
        if (isset($_SESSION['cart'][$product['id']])) {
            $_SESSION['cart'][$product['id']]['qty'] += 1;
        } else {
            // Afegimel producte
            $_SESSION['cart'][$product['id']]= array(
                'name'  => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'image' => $product['image'],
                'qty'   => 1
            );

        }


    }

    // Retorna els productes
    public function get_cart_contents() {
        return $_SESSION['cart'];
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

    public function remove_product($id) {
        unset($_SESSION['cart'][$id]);
    }

    public function update_product($id, $qty) {
        $_SESSION['cart'][$id]['qty'] = $qty;
    }

    public function reset() {
        unset($_SESSION['cart']);
    }

    public function get_cart_items() {
        $items = 0;
        foreach ($_SESSION['cart'] as $product) {
            $items += $product['qty'];
        }   
        return $items;
    }
}
