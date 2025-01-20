<?php

include("../../common/connection_config.php");

$sql = "Select * From office order by created_date asc";
    $query = $dbh -> prepare($sql);
    $query->bindParam(':invoice_id',$invoice_id,PDO::PARAM_STR);
    $query->execute();

    $results= $query->fetchAll(PDO::FETCH_OBJ);
    $office_count = $query->rowcount();

    $today = date("Y-m-d");  

    $sql1 = "Select * From sale";
    $query1 = $dbh -> prepare($sql1);
    $query1->execute();
    $sale_count = $query1->rowcount();

    $sql2 = "Select * From purchase";
    $query2 = $dbh -> prepare($sql2);
    $query2->execute();
    $purchase_count = $query2->rowcount();

    $sql3 = "Select * From sale where invoice_date=:today";
    $query3 = $dbh -> prepare($sql3);
    $query3->bindParam(':today',$today,PDO::PARAM_STR);
    $query3->execute();
    $sale_today_count = $query3->rowcount();

    $sql4 = "Select * From purchase where invoice_date=:today";
    $query4 = $dbh -> prepare($sql4);
    $query4->bindParam(':today',$today,PDO::PARAM_STR);
    $query4->execute();
	$purchase_today_count = $query4->rowcount();
	
	$sqlstock = "Select * From stock";
    $querystock = $dbh -> prepare($sqlstock);
	$querystock->execute();
	$stockcount = $querystock->rowcount();

	$sqlsupplier = "Select * From supplier";
    $querysupplier = $dbh -> prepare($sqlsupplier);
	$querysupplier->execute();
	$suppliercount = $querysupplier->rowcount();

	$sqlcustomer = "Select * From customer";
    $querycustomer = $dbh -> prepare($sqlcustomer);
	$querycustomer->execute();
    $customercount = $querycustomer->rowcount();

    $sqlstaff = "Select * From staff";
    $querystaff = $dbh -> prepare($sqlstaff);
	$querystaff->execute();
    $staffcount = $querystaff->rowcount();
    
    $sqlfoundation = "Select * From foundation";
    $queryfoundation = $dbh -> prepare($sqlfoundation);
    $queryfoundation->execute();

    $foundationresult= $queryfoundation->fetch(PDO::FETCH_OBJ);