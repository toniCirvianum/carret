<?php

if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [
        [
            'id'=>0,
            'name' => 'Toni F',
            'username'=>'admin',
            'password'=>'123',
            'mail' => "mail@mail.com",
            'admin'=>true,
            'token'=>"",
            'verificat'=> true,
            'img_profile'=>"admin.jpg"
        ],
        [
            'id'=>1,
            'name' => 'Raquel F',
            'username'=>'raquel',
            'password'=>'123',
            'mail' => "mail@mail.com",
            'admin'=>false,
            'token'=>"",
            'verificat'=> true,
            'img_profile'=>"raquel.jpg"
    
        ]
    ];
}

if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [
        [
            'id' => 1,
            'name' => 'Producte 1',
            'description' => 'Descripció del producte 1',
            'price' => 10.00,
            'image'=> 'sneaker01.jpg'
        ],
        [
            'id' => 2,
            'name' => 'Producte 2',
            'description' => 'Descripció del producte 2',
            'price' => 20.00,
            'image'=> 'sneaker02.jpg'
        ],
        [
            'id' => 3,
            'name' => 'Producte 3',
            'description' => 'Descripció del producte 3',
            'price' => 30.00,
            'image'=> 'sneaker03.jpg'
        ],
        [
            'id' => 4,
            'name' => 'Producte 4',
            'description' => 'Descripció del producte 4',
            'price' => 10.00,
            'image'=> 'sneaker04.jpg'
        ],
        [
            'id' => 5,
            'name' => 'Producte 5',
            'description' => 'Descripció del producte 5',
            'price' => 20.00,
            'image'=> 'sneaker05.jpg'
        ],
        [
            'id' => 6,
            'name' => 'Producte 6',
            'description' => 'Descripció del producte 6',
            'price' => 30.00,
            'image'=> 'sneaker06.jpg'
        ],
        [
            'id' => 7,
            'name' => 'Producte 7',
            'description' => 'Descripció del producte 7',
            'price' => 10.00,
            'image'=> 'sneaker07.jpg'
        ],
        [
            'id' => 8,
            'name' => 'Producte 8',
            'description' => 'Descripció del producte 8',
            'price' => 20.00,
            'image'=> 'sneaker08.jpg'
        ],
        [
            'id' => 9,
            'name' => 'Producte 9',
            'description' => 'Descripció del producte 9',
            'price' => 30.00,
            'image'=> 'sneaker09.jpg'
        ]
    ];
    
}


