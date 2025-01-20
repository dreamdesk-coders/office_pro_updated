<?php 
session_start();


include("../../common/connection_config.php");
include("../../common/common_functions.php");

if(isset($_POST['action'])){

	$action = $_POST['action'];

	$login_id = $_SESSION['alogin'];
	$date = date("Y-m-d-h-i-s");
	$transaction_id = $_POST['stock_id'];
	$transaction = "Stock Master";
	$office_id = $_SESSION['office_id'];

	if($action == "create"){

		$stock_id = $_POST['stock_id'];
		$stock_name = $_POST['stock_name'];
		$stocking_unit_id = $_POST['stocking_unit_id'];
		$category_id = $_POST['category_id'];
		$rg_id = $_POST['rg_id'];
		$created_date = date("Y-m-d-h-i-s");
		$updated_date = date("Y-m-d-h-i-s");

		$sql="INSERT INTO stock(stock_id,stock_name,stocking_unit_id,category_id,rg_id,created_date,updated_date) VALUES(:stock_id,:stock_name,:stocking_unit_id,:category_id,:rg_id,:created_date,:updated_date)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
		$query->bindParam(':stock_name',$stock_name,PDO::PARAM_STR);
		$query->bindParam(':stocking_unit_id',$stocking_unit_id,PDO::PARAM_STR);
		$query->bindParam(':category_id',$category_id,PDO::PARAM_STR);
		$query->bindParam(':rg_id',$rg_id,PDO::PARAM_STR);
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

		$stock_id = $_POST['stock_id'];
		$stock_name = $_POST['stock_name'];
		$stocking_unit_id = $_POST['stocking_unit_id'];
		$category_id = $_POST['category_id'];
		$rg_id = $_POST['rg_id'];
		$updated_date = date("Y-m-d-h-i-s");

		$sql="update stock set stock_name=:stock_name, stocking_unit_id =:stocking_unit_id, category_id=:category_id,rg_id =:rg_id, updated_date=:updated_date where stock_id=:stock_id";

		$query = $dbh->prepare($sql);
		$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
		$query->bindParam(':stock_name',$stock_name,PDO::PARAM_STR);
		$query->bindParam(':stocking_unit_id',$stocking_unit_id,PDO::PARAM_STR);
		$query->bindParam(':category_id',$category_id,PDO::PARAM_STR);
		$query->bindParam(':rg_id',$rg_id,PDO::PARAM_STR);
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

		$stock_id = $_POST['stock_id'];

		$sql="delete from stock WHERE stock_id=:stock_id";

		$query = $dbh->prepare($sql);
		$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);

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

