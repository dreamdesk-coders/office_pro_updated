<?php 
session_start();
include("../../../forms/common/processing.php");
include("../../common/connection_config.php");
include("../../common/common_functions.php");

	/* Variables for transaction log*/

	if(isset($_POST['save'])){
			$action = "save";
			$transaction_id = $_POST['transaction_office_id'];
		}
	elseif (isset($_GET['delete'])) {
			$action = "delete";
			$transaction_id = $_GET['transaction_office_id'];
	}

	$_SESSION['transaction_id'] = $transaction_id;
	$_SESSION['action'] = $action;
		
	$login_id = $_SESSION['alogin'];
	$date = date("Y-m-d-h-i-s");
	$transaction = "Opening Stock Balance Transaction";
	$office_id = $_SESSION['office_id'];

if(isset($_POST['save'])){

	/* use for looping through the grid*/
	$rownum = $_POST['rownum'];

	/* variables for Opening Stock Balance Transaction */ 
	$sr_no = "";
	$transaction_office_id = $_POST['transaction_office_id'];
	$opening_date = $_POST['opening_date'];
	$currency_id = $_POST['currency_id'];
	$stock_id = "";
	$unit_id = "";
	$gquantity = "";
	$dquantity = "";
	$price = "";

}

if(isset($_POST['save'])) {
		
	$sql="delete from opening_stock_balance WHERE office_id=:transaction_office_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':transaction_office_id',$transaction_office_id,PDO::PARAM_STR);
	execute_query($dbh,$query);

	$sql="delete from stock_balance WHERE transaction_id=:transaction_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
	execute_query($dbh,$query);

	for ($x = 1; $x <= $rownum; $x++) {
		$sr_no = $x;
		$stock_id = "sid" . $x;
		$unit_id = "unit_id" . $x;
		$gquantity = "gquantity" . $x;
		$price = "price" . $x;

		if(isset($_POST[$stock_id])){

			$transaction_office_id = $_POST['transaction_office_id'];
			$stock_id = $_POST[$stock_id];
			$unit_id = $_POST[$unit_id];
			$gquantity = $_POST[$gquantity];
			$price = $_POST[$price];
			$currency_id = $_POST['currency_id'];
			$opening_date = $_POST['opening_date'];
			$sql="INSERT INTO opening_stock_balance(sr_no,office_id,stock_id,unit_id,good_quantity,currency_id,price,date) VALUES(:sr_no,:transaction_office_id,:stock_id,:unit_id,:gquantity,:currency_id,:price,:opening_date)";

			$query = $dbh->prepare($sql);

			$query->bindParam(':sr_no',$sr_no,PDO::PARAM_STR);
			$query->bindParam(':transaction_office_id',$transaction_office_id,PDO::PARAM_STR);
			$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
			$query->bindParam(':unit_id',$unit_id,PDO::PARAM_STR);
			$query->bindParam(':gquantity',$gquantity,PDO::PARAM_STR);
			$query->bindParam(':currency_id',$currency_id,PDO::PARAM_STR);
			$query->bindParam(':price',$price,PDO::PARAM_STR);
			$query->bindParam(':opening_date',$opening_date,PDO::PARAM_STR);

			execute_query($dbh,$query);

			/* Save Stock Balance for good stock quantity*/ 

			$status = "+";

			$sql="INSERT INTO stock_balance(transaction_id,transaction_type,date,stock_id,unit_id,quantity,office_id,status) VALUES(:transaction_id,:transaction,:opening_date,:stock_id,:unit_id,:gquantity,:transaction_office_id,:status)";

			$query = $dbh->prepare($sql);
			$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
			$query->bindParam(':transaction',$transaction,PDO::PARAM_STR);
			$query->bindParam(':opening_date',$opening_date,PDO::PARAM_STR);
			$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
			$query->bindParam(':unit_id',$unit_id,PDO::PARAM_STR);
			$query->bindParam(':gquantity',$gquantity,PDO::PARAM_STR);
			$query->bindParam(':transaction_office_id',$transaction_office_id,PDO::PARAM_STR);
			$query->bindParam(':status',$status,PDO::PARAM_STR);

			execute_query($dbh,$query);
	
		}
	}
}

if (isset($_GET['delete'])) {

	$transaction_office_id = $_GET['transaction_office_id'];

    $sql="delete from opening_stock_balance WHERE office_id=:transaction_office_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':transaction_office_id',$transaction_office_id,PDO::PARAM_STR);
	execute_query($dbh,$query);

	$sql="delete from stock_balance WHERE transaction_id=:transaction_office_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':transaction_office_id',$transaction_office_id,PDO::PARAM_STR);
	execute_query($dbh,$query);

}

if(isset($_POST['save']) || isset($_GET['delete'])){

		$sql="INSERT INTO transaction_log(login_id,date,transaction_id,transaction,action,office_id) VALUES(:login_id,:date,:transaction_id,:transaction,:action,:office_id)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':login_id',$login_id,PDO::PARAM_STR);
		$query->bindParam(':date',$date,PDO::PARAM_STR);
		$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
		$query->bindParam(':transaction',$transaction,PDO::PARAM_STR);
		$query->bindParam(':action',$action,PDO::PARAM_STR);
		$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);

		$query->execute();

		switch ($action) {

			case 'save':
				echo "<script> window.location.href = '$common_form_route?frm=opening_stock_list'; </script>";
				break;

			case 'delete':
				echo "<script> window.location.href = '$common_form_route?frm=opening_stock_list'; </script>";
				break;
					
			default:
				echo "<script> window.location.href = '$common_form_route?frm=opening_stock_list'; </script>";
				break;	
		}
	}