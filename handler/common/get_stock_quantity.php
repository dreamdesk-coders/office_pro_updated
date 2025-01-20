<?php
session_start();
include("connection_config.php");

$stock_id = $_POST['stock_id'];
$unit_id = $_POST['unit_id'];
$req_qty = $_POST['req_qty'];
$office_id = $_SESSION['office_id'];

/** For Transactions Edit */
if ($_POST['transaction_id'] != null) {
    $transaction_id = $_POST['transaction_id'];
    $sql = "SELECT SUM(CONCAT(status, quantity)) AS balance, unit_id, stock_id 
            FROM stock_balance 
            WHERE stock_id = :stock_id 
              AND unit_id = :unit_id 
              AND office_id = :office_id 
              AND transaction_id <> :transaction_id 
            GROUP BY stock_id, unit_id 
            ORDER BY stock_id ASC";
    $query = $dbh->prepare($sql);
    $query->bindParam(':transaction_id', $transaction_id, PDO::PARAM_STR);
} else {
    $sql = "SELECT SUM(CONCAT(status, quantity)) AS balance, unit_id, stock_id
            FROM stock_balance 
            WHERE stock_id = :stock_id 
              AND unit_id = :unit_id 
              AND office_id = :office_id 
            GROUP BY stock_id, unit_id";
    $query = $dbh->prepare($sql);
}

$query->bindParam(':stock_id', $stock_id, PDO::PARAM_STR);
$query->bindParam(':unit_id', $unit_id, PDO::PARAM_STR);
$query->bindParam(':office_id', $office_id, PDO::PARAM_STR);
$query->execute();

// Fetch all rows
$rows = $query->fetchAll(PDO::FETCH_OBJ);
$row_count = count($rows);

if($row_count > 0){
    $balance = $rows[0]->balance;
    $unit_id = $rows[0]->unit_id;
    $stock_id = $rows[0]->stock_id; 

    if($balance < $req_qty ){
        echo json_encode(array("statusCode"=>201,"balance"=>$balance , "count"=>$row_count));	
    }
    elseif($balance == $req_qty or $balance > $req_qty){
        echo json_encode(array("statusCode"=>200,"balance"=>$balance));	
    }

}
else{
    echo json_encode(array("statusCode"=>201));	
}
