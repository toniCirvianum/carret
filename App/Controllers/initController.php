<?php

use App\Helpers\Database;

class initController 
{
    public function index(){
        $this->loadData();
    }

    private function loadData(){

        session_unset();

        $db= new Database();
        $sql = "DROP TABLE IF EXISTS history_cart, products, users";
        $db->queryDataBase($sql);
        // $sql = "DROP TABLE IF EXISTS products,users";
        // $db->queryDataBase($sql);


        $user = new User();
        $product = new Producte();
        $historyCart = new HistoryCart();

        $pepper = $_ENV['PEPPER'];
        $salt = bin2hex(random_bytes(16));
        $passClear = '123';
        $passWithPepperAndSalt = $pepper . $passClear . $salt;
        $passHashed = password_hash($passWithPepperAndSalt, PASSWORD_BCRYPT);
        $user = [
            'id'=>0,
            'name' => 'Toni F',
            'username'=>'admin',
            'password'=>$passHashed,
            'mail' => "mail@mail.com",
            'admin'=>1,
            'token'=>"",
            'verificat'=> 1,
            'salt'=>$salt,
            'img_profile'=>"admin.jpg"
        ];

        $newUswer = new User();
        $newUswer->create($user);

        $pepper = $_ENV['PEPPER'];
        $salt = bin2hex(random_bytes(16));
        $passClear = '123';
        $passWithPepperAndSalt = $pepper . $passClear . $salt;
        $passHashed = password_hash($passWithPepperAndSalt, PASSWORD_BCRYPT);
        $user = [
            'id'=>0,
            'name' => 'Raquel Boronat',
            'username'=>'raquel',
            'password'=>$passHashed,
            'mail' => "raquel@mail.com",
            'admin'=>0,
            'token'=>"",
            'verificat'=> 1,
            'salt'=>$salt,
            'img_profile'=>"raquel.jpg"
        ];

        $newUswer = new User();
        $newUswer->create($user);

        $product = [
            'id' => 1,
            'name' => 'Sneaker 01',
            'description' => 'Descripció del sneaker 01',
            'price' => 10,
            'image' => 'sneaker01.jpg'
        ];
        $newProduct = new Producte();
        $newProduct->create($product);

        $product = [
            'id' => 2,
            'name' => 'Sneaker 02',
            'description' => 'Descripció del sneaker 02',
            'price' => 20,
            'image' => 'sneaker02.jpg'
        ];
        $newProduct = new Producte();    
        $newProduct->create($product);

        $product = [
            'id' => 3,
            'name' => 'Sneaker 03',
            'description' => 'Descripció del sneaker 03',
            'price' => 30,
            'image' => 'sneaker03.jpg'
        ];  

        $newProduct = new Producte();
        $newProduct->create($product);

        $product = [
            'id' => 4,
            'name' => 'Sneaker 04',
            'description' => 'Descripció del sneaker 04',
            'price' => 40,
            'image' => 'sneaker04.jpg'
        ];
        $newProduct = new Producte();
        $newProduct->create($product);

        $product = [
            'id' => 5,
            'name' => 'Sneaker 05',
            'description' => 'Descripció del sneaker 05',
            'price' => 50,
            'image' => 'sneaker05.jpg'
        ];
        $newProduct = new Producte();
        $newProduct->create($product);

        $product = [
            'id' => 6,
            'name' => 'Sneaker 06',
            'description' => 'Descripció del sneaker 06',
            'price' => 60,
            'image' => 'sneaker06.jpg'
        ];
        $newProduct = new Producte();
        $newProduct->create($product);

        $product = [
            'id' => 7,
            'name' => 'Sneaker 07',
            'description' => 'Descripció del sneaker 07',
            'price' => 70,
            'image' => 'sneaker07.jpg'
        ];
        $newProduct = new Producte();
        $newProduct->create($product);

        $product = [
            'id' => 8,
            'name' => 'Sneaker 08',
            'description' => 'Descripció del sneaker 08',
            'price' => 80,
            'image' => 'sneaker08.jpg'
        ];
        $newProduct = new Producte();
        $newProduct->create($product);

        $u = new User();
        $users = $u->getAll();

        $_SESSION['users'] = $users;

        $p = new Producte();
        $products = $p->getAll();
        $_SESSION['products'] = $products;  

        header("Location: /home/index");



    }
}
