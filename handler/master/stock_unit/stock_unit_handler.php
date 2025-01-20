<?php 
session_start();

include("../../common/connection_config.php");
include("../../common/common_functions.php");

if(isset($_POST['action'])){

	$action = $_POST['action'];
	$login_id = $_SESSION['alogin'];
	$date = date("Y-m-d-h-i-s");
	$transaction_id = $_POST['stock_unit_id'];
	$transaction = "Stock Unit Master";
	$office_id = $_SESSION['office_id'];

	if($action == "create"){
		$stock_unit_id = $_POST['stock_unit_id'];
		$unit_id = $_POST['unit_id'];
		$stock_id = $_POST['stock_id'];
		$quantity = $_POST['quantity'];
		$pprice = $_POST['pprice'];
		$sprice = $_POST['sprice'];
		$created_date = date("Y-m-d-h-i-s");
		$updated_date = date("Y-m-d-h-i-s");

		$sql="INSERT INTO stock_unit(stock_unit_id ,unit_id,stock_id,qty,purchase_price,sale_price,created_date,updated_date) VALUES(:stock_unit_id ,:unit_id,:stock_id,:quantity,:pprice,:sprice,:created_date,:updated_date)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':stock_unit_id',$stock_unit_id,PDO::PARAM_STR);
		$query->bindParam(':unit_id',$unit_id,PDO::PARAM_STR);
		$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
		$query->bindParam(':quantity',$quantity,PDO::PARAM_STR);
		$query->bindParam(':pprice',$pprice,PDO::PARAM_STR);
		$query->bindParam(':sprice',$sprice,PDO::PARAM_STR);
		$query->bindParam(':created_date',$created_date,PDO::PARAM_STR);
		$query->bindParam(':updated_date',$updated_date,PDO::PARAM_STR);

		execute_query($dbh,$query);

		$sql="INSERT INTO transaction_log(login_id,date,transaction_id,transaction,action,office_id) VALUES(:login_id,:date,:transaction_id,:transaction,:action,:office_id)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':login_id',$login_id,PDO::PARAM_STR);
		$query->bindParam(':date',$date,PDO::PARAM_STR);
		$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
		$query->bindParam(':transaction',$transaction,PDO::PARAM_STR);
		$query->bindParam(':action',$action,PDO::PARAM_STR);
		$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);

		$query->execute();

	}

	elseif($action == "update"){

		$stock_unit_id = $_POST['stock_unit_id'];
		$unit_id = $_POST['unit_id'];
		$stock_id = $_POST['stock_id'];
		$quantity = $_POST['quantity'];
		$pprice = $_POST['pprice'];
		$sprice = $_POST['sprice'];
		$updated_date = date("Y-m-d-h-i-s");

		$sql="update stock_unit set unit_id=:unit_id ,stock_id =:stock_id , qty=:quantity,purchase_price=:pprice, sale_price =:sprice,  updated_date=:updated_date where stock_unit_id=:stock_unit_id";

		$query = $dbh->prepare($sql);
		$query->bindParam(':stock_unit_id',$stock_unit_id,PDO::PARAM_STR);
		$query->bindParam(':unit_id',$unit_id,PDO::PARAM_STR);
		$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
		$query->bindParam(':quantity',$quantity,PDO::PARAM_STR);
		$query->bindParam(':pprice',$pprice,PDO::PARAM_STR);
		$query->bindParam(':sprice',$sprice,PDO::PARAM_STR);
		$query->bindParam(':updated_date',$updated_date,PDO::PARAM_STR);

		execute_query($dbh,$query);

		$sql="INSERT INTO transaction_log(login_id,date,transaction_id,transaction,action,office_id) VALUES(:login_id,:date,:transaction_id,:transaction,:action,:office_id)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':login_id',$login_id,PDO::PARAM_STR);
		$query->bindParam(':date',$date,PDO::PARAM_STR);
		$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
		$query->bindParam(':transaction',$transaction,PDO::PARAM_STR);
		$query->bindParam(':action',$action,PDO::PARAM_STR);
		$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);

		$query->execute();

	}

	elseif($action == "delete"){

		$stock_unit_id = $_POST['stock_unit_id'];

		$sql="delete from stock_unit WHERE stock_unit_id=:stock_unit_id";

		$query = $dbh->prepare($sql);
		$query->bindParam(':stock_unit_id',$stock_unit_id,PDO::PARAM_STR);

		execute_query($dbh,$query);

		$sql="INSERT INTO transaction_log(login_id,date,transaction_id,transaction,action,office_id) VALUES(:login_id,:date,:transaction_id,:transaction,:action,:office_id)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':login_id',$login_id,PDO::PARAM_STR);
		$query->bindParam(':date',$date,PDO::PARAM_STR);
		$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
		$query->bindParam(':transaction',$transaction,PDO::PARAM_STR);
		$query->bindParam(':action',$action,PDO::PARAM_STR);
		$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);

		$query->execute();

	}
}

