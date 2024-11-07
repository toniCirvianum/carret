<?php

include('index.php');



use App\Models\Orm;
$db = new Orm('prova');
$item_prova=[
    'id'=>4,
    'item'=>'item actualitzat1',
    'description'=>'description actualitzat'
];
// var_dump($db->create($item_prova));

var_dump($db->getById(1));

var_dump($db->removeItemById(2));

echo "<pre>";
print_r($db->getAll());
echo "</pre>";

$db->updateItemById($item_prova);





//







