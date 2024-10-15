<?php

define('URL',$_SERVER['REQUEST_URI']);

$products = [
    [
        'id' => 1,
        'name' => 'Producto 1',
        'image' => 'imagen1.jpg',
        'description' => 'Descripción del producto 1',
        'price' => 10.00,
        'image'=> 'img01.jpg'
    ],
    [
        'id' => 2,
        'name' => 'Producto 2',
        'image' => 'imagen2.jpg',
        'description' => 'Descripción del producto 2',
        'price' => 20.00,
        'image'=> 'img02.jpg'
    ],
    [
        'id' => 3,
        'name' => 'Producto 3',
        'image' => 'imagen3.jpg',
        'description' => 'Descripción del producto 3',
        'price' => 30.00,
        'image'=> 'img03.jpg'
    ],
    [
        'id' => 4,
        'name' => 'Producto 4',
        'image' => 'imagen4.jpg',
        'description' => 'Descripción del producto 4',
        'price' => 10.00,
        'image'=> 'img04.jpg'
    ],
    [
        'id' => 5,
        'name' => 'Producto 5',
        'image' => 'imagen5.jpg',
        'description' => 'Descripción del producto 5',
        'price' => 20.00,
        'image'=> 'img05.jpg'
    ],
    [
        'id' => 6,
        'name' => 'Producto 6',
        'image' => 'imagen6.jpg',
        'description' => 'Descripción del producto 6',
        'price' => 30.00,
        'image'=> 'img06.jpg'
    ],
    [
        'id' => 7,
        'name' => 'Producto 7',
        'image' => 'imagen7.jpg',
        'description' => 'Descripción del producto 7',
        'price' => 10.00,
        'image'=> 'img07.jpg'
    ],
    [
        'id' => 8,
        'name' => 'Producto 8',
        'image' => 'imagen8.jpg',
        'description' => 'Descripción del producto 8',
        'price' => 20.00,
        'image'=> 'img08.jpg'
    ],
    [
        'id' => 9,
        'name' => 'Producto 9',
        'image' => 'imagen9.jpg',
        'description' => 'Descripción del producto 9',
        'price' => 30.00,
        'image'=> 'img09.jpg'
    ]
];

$users = [
    [
        'id' => 0,
        'username' => 'admin',
        'password' => '123',
        'mail' => 'mail@mail.es',
        'token' => 'EREDTRTGTFF',
        'verified' => true,
        'admin' => true
    ],
    [
        'id' => 0,
        'username' => 'raquel',
        'password' => '123',
        'mail' => 'mail@mail.es',
        'token' => 'EREDTRTGTFF',
        'verified' => true,
        'admin' => false
    ]
];


if (!isset($_SESSION['users'])) $_SESSION['users'] = $users;

if (!isset($_SESSION['products'])) $_SESSION['products'] = $products;
