<?php
session_start();
include("connection_config.php");
$stock_id = $_POST['sid'];
$unit_id = $_POST['uid'];
$type = $_POST['type'];
if($type == "P"){
    $sql= "Select purchase_price from stock_unit where stock_id =:stock_id and unit_id=:unit_id order by stock_id asc limit 1";
}
elseif($type == "S"){
    $sql= "Select sale_price from stock_unit where stock_id =:stock_id and unit_id=:unit_id order by stock_id asc limit 1";
}

$query = $dbh->prepare($sql);
$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
$query->bindParam(':unit_id',$unit_id,PDO::PARAM_STR);
$query->execute();
$result=$query->fetch(PDO::FETCH_OBJ);

$count = $query->rowcount();
if($count > 0){

    switch ($type) {

        case 'P':
            $price = $result->purchase_price;
            break;

        case 'S':
            $price = $result->sale_price;
            break;   
    }

    if($price > 0 ){
        echo json_encode(array("price"=>$price));	
    }
    elseif($price = 0 or $price == null){
        echo json_encode(array("price"=>0));	
    }

}
else{
    echo json_encode(array("price"=>0));	
}