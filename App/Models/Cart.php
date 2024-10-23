<?php

class Cart {
    public function __construct(){
        // Inicialitzem sino existeix
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
    }

    // Afegim productes
    public function add_product($product_id, $product_name, $product_price, $product_qty, $atribute) {
        // Si el producte ja hi es augmentem la quantitat
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['qty'] += $product_qty;
        } else {
            // Afegimel producte
            $_SESSION['cart'][$product_id] = array(
                'name'  => $product_name,
                'price' => $product_price,
                'qty'   => $product_qty,
                'atribute' => $atribute
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
}
