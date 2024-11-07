<?php

include('index.php');



use App\Models\Orm;
$db = new Orm('prova');
$item_prova=[
    'item'=>'item1',
    'description'=>'description 1'
];
var_dump($db->create($item_prova));


//







