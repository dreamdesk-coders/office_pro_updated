<?php 
session_start();
include("../../../forms/common/processing.php");
include("../../common/connection_config.php");
include("../../common/common_functions.php");

	/* Variables for transaction log*/

	if(isset($_POST['save'])){
			$action = "create";	
			$transaction_id = $_POST['use_id'];
		}
	elseif(isset($_POST['update'])){
			$action = "update";
			$transaction_id = $_POST['use_id'];
		}
	elseif (isset($_GET['delete'])) {
			$action = "delete";
			$transaction_id = $_GET['use_id'];
	}

	$_SESSION['transaction_id'] = $transaction_id;
	$_SESSION['action'] = $action;
		
	$login_id = $_SESSION['alogin'];
	$date = date("Y-m-d-h-i-s");
	$transaction = "Office Use Transaction";
	$office_id = $_SESSION['office_id'];



if( isset($_POST['save']) || isset($_POST['update'])){

	/* use for looping through the grid*/
	$rownum = $_POST['rownum'];

	/* variables for office use transcation header */ 
	$use_id = $_POST['use_id'];
	$use_date = $_POST['use_date'];
	$staff_id = $_POST['staff_id'];
	$currency_id = $_POST['currency_id'];
	$exchange_rate = $_POST['exchange_rate'];

	if(isset($_POST['remark'])){
		$remark = $_POST['remark'];
	}
	else{
		$remark = "";
	}
	$total_amount = $_POST['total_amount'];

	$updated_date = date("Y-m-d-h-i-s");

	/* variables for office use transaction details */ 

	$sr_no = "";
	$stock_id = "";
	$unit_id = "";
	$quantity = "";
	$price = "";
	$amount = "";

}


if(isset($_POST['save'])){

	/*Save to office use table*/

	$sql="INSERT INTO office_use(use_id,use_date,staff_id,currency_id,exchange_rate,office_id,total_amount,remark,updated_date)
 	VALUES(:use_id,:use_date,:staff_id, :currency_id,:exchange_rate,:office_id,:total_amount,:remark,:updated_date)";

 	$query = $dbh->prepare($sql);

	$query->bindParam(':use_id',$use_id,PDO::PARAM_STR);
	$query->bindParam(':use_date',$use_date,PDO::PARAM_STR);
	$query->bindParam(':staff_id',$staff_id,PDO::PARAM_STR);
	$query->bindParam(':currency_id',$currency_id,PDO::PARAM_STR);
	$query->bindParam(':exchange_rate',$exchange_rate,PDO::PARAM_STR);
	$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
	$query->bindParam(':total_amount',$total_amount,PDO::PARAM_STR);
	$query->bindParam(':remark',$remark,PDO::PARAM_STR);
	$query->bindParam(':updated_date',$updated_date,PDO::PARAM_STR);

	execute_query($dbh,$query);

	/*Insert into office use Details*/

	for ($x = 1; $x <= $rownum; $x++) {

		$sr_no = $x;
		$stock_id = "sid" . $x;
		$unit_id = "unit_id" . $x;
		$quantity = "quantity" . $x;
		$price = "price" . $x;
		$amount = "amount" . $x;

		if(isset($_POST[$stock_id])){

			$stock_id = $_POST[$stock_id];
			$unit_id = $_POST[$unit_id];
			$quantity = $_POST[$quantity];
			$price = $_POST[$price];
			$amount = $_POST[$amount];

		$sql="INSERT INTO office_use_details(sr_no,use_id,stock_id,unit_id,quantity,price,amount) VALUES(:sr_no,:use_id,:stock_id,:unit_id,:quantity,:price,:amount)";

		$query = $dbh->prepare($sql);

		$query->bindParam(':sr_no',$sr_no,PDO::PARAM_STR);
		$query->bindParam(':use_id',$use_id,PDO::PARAM_STR);
		$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
		$query->bindParam(':unit_id',$unit_id,PDO::PARAM_STR);
		$query->bindParam(':quantity',$quantity,PDO::PARAM_STR);
		$query->bindParam(':price',$price,PDO::PARAM_STR);
		$query->bindParam(':amount',$amount,PDO::PARAM_STR);

		execute_query($dbh,$query);

		/* Save Stock Balance*/ 

		$status = "-";

		$sql="INSERT INTO stock_balance(transaction_id,transaction_type,date,stock_id,unit_id,quantity,office_id,status) VALUES(:transaction_id,:transaction,:use_date,:stock_id,:unit_id,:quantity,:office_id,:status)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
		$query->bindParam(':transaction',$transaction,PDO::PARAM_STR);
		$query->bindParam(':use_date',$use_date,PDO::PARAM_STR);
		$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
		$query->bindParam(':unit_id',$unit_id,PDO::PARAM_STR);
		$query->bindParam(':quantity',$quantity,PDO::PARAM_STR);
		$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
		$query->bindParam(':status',$status,PDO::PARAM_STR);

		execute_query($dbh,$query);

		}

	}

	// $status = "-";
	// /* insert into cash balance*/
	// $sql="INSERT INTO cash_balance(transaction_id,transaction_type,date,office_id,currency_id,amount,status)VALUES(:transaction_id,:transaction,:use_date,:office_id,:currency_id,:total_amount,:status)";

	// $query = $dbh->prepare($sql);
	// $query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
	// $query->bindParam(':transaction',$transaction,PDO::PARAM_STR);
	// $query->bindParam(':use_date',$use_date,PDO::PARAM_STR);
	// $query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
	// $query->bindParam(':currency_id',$currency_id,PDO::PARAM_STR);
	// $query->bindParam(':total_amount',$total_amount,PDO::PARAM_STR);
	// $query->bindParam(':status',$status,PDO::PARAM_STR);

	// execute_query($dbh,$query);

}

if(isset($_POST['update'])) {
		
	$sql="update office_use set use_date=:use_date,staff_id=:staff_id,exchange_rate=:exchange_rate,currency_id=:currency_id,office_id=:office_id,total_amount=:total_amount,remark=:remark,updated_date=:updated_date where use_id=:use_id";

	$query = $dbh->prepare($sql);

	$query->bindParam(':use_id',$use_id,PDO::PARAM_STR);
	$query->bindParam(':use_date',$use_date,PDO::PARAM_STR);
	$query->bindParam(':staff_id',$staff_id,PDO::PARAM_STR);
	$query->bindParam(':exchange_rate',$exchange_rate,PDO::PARAM_STR);
	$query->bindParam(':currency_id',$currency_id,PDO::PARAM_STR);
	$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
	$query->bindParam(':total_amount',$total_amount,PDO::PARAM_STR);
	$query->bindParam(':remark',$remark,PDO::PARAM_STR);
	$query->bindParam(':updated_date',$updated_date,PDO::PARAM_STR);

	execute_query($dbh,$query);

	// //Update Cash Balance
	// $sql="update cash_balance set office_id=:office_id,currency_id=:currency_id,amount=:total_amount where transaction_id=:transaction_id";

	// $query = $dbh->prepare($sql);
	// $query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
	// $query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
	// $query->bindParam(':currency_id',$currency_id,PDO::PARAM_STR);
	// $query->bindParam(':total_amount',$total_amount,PDO::PARAM_STR);
	// execute_query($dbh,$query);

	$sql="delete from office_use_details WHERE use_id=:use_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':use_id',$use_id,PDO::PARAM_STR);
	execute_query($dbh,$query);

	$sql="delete from stock_balance WHERE transaction_id=:transaction_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
	execute_query($dbh,$query);

	/*Insert into Office Use Details*/

	for ($x = 1; $x <= $rownum; $x++) {

		$sr_no = $x;
		$stock_id = "sid" . $x;
		$unit_id = "unit_id" . $x;
		$quantity = "quantity" . $x;
		$price = "price" . $x;
		$amount = "amount" . $x;

		if(isset($_POST[$stock_id])){

			$stock_id = $_POST[$stock_id];
			$unit_id = $_POST[$unit_id];
			$quantity = $_POST[$quantity];
			$price = $_POST[$price];
			$amount = $_POST[$amount];

		$sql="INSERT INTO office_use_details(sr_no,use_id,stock_id,unit_id,quantity,price,amount) VALUES(:sr_no,:use_id,:stock_id,:unit_id,:quantity,:price,:amount)";

		$query = $dbh->prepare($sql);

		$query->bindParam(':sr_no',$sr_no,PDO::PARAM_STR);
		$query->bindParam(':use_id',$use_id,PDO::PARAM_STR);
		$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
		$query->bindParam(':unit_id',$unit_id,PDO::PARAM_STR);
		$query->bindParam(':quantity',$quantity,PDO::PARAM_STR);
		$query->bindParam(':price',$price,PDO::PARAM_STR);
		$query->bindParam(':amount',$amount,PDO::PARAM_STR);

		execute_query($dbh,$query);

		/* Save Stock Balance*/ 

		$status = "-";

		$sql="INSERT INTO stock_balance(transaction_id,transaction_type,date,stock_id,unit_id,quantity,office_id,status) VALUES(:transaction_id,:transaction,:use_date,:stock_id,:unit_id,:quantity,:office_id,:status)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
		$query->bindParam(':transaction',$transaction,PDO::PARAM_STR);
		$query->bindParam(':use_date',$use_date,PDO::PARAM_STR);
		$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
		$query->bindParam(':unit_id',$unit_id,PDO::PARAM_STR);
		$query->bindParam(':quantity',$quantity,PDO::PARAM_STR);
		$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
		$query->bindParam(':status',$status,PDO::PARAM_STR);

		execute_query($dbh,$query);

		}

	}

	
}
if (isset($_GET['delete'])) {

	$use_id = $_GET['use_id'];

    $sql="delete from office_use WHERE use_id=:use_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':use_id',$use_id,PDO::PARAM_STR);
	execute_query($dbh,$query);

	$sql="delete from office_use_details WHERE use_id=:use_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':use_id',$use_id,PDO::PARAM_STR);
	execute_query($dbh,$query);

	// $sql="delete from cash_balance WHERE transaction_id=:use_id";
	// $query = $dbh->prepare($sql);
	// $query->bindParam(':use_id',$use_id,PDO::PARAM_STR);
	// execute_query($dbh,$query);

	$sql="delete from stock_balance WHERE transaction_id=:use_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':use_id',$use_id,PDO::PARAM_STR);
	execute_query($dbh,$query);

}


if(isset($_POST['save']) || isset($_POST['update']) || isset($_GET['delete'])){

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

			case 'create':
				if(isset($_POST['invoice_print']) ) { 
					echo "<script type='text/javascript' language='Javascript'>setTimeout(function(){ location.replace('$common_form_route?frm=office_use_list')}, 100);</script>";
					echo "<script type='text/javascript' language='Javascript'>window.open('$common_form_route?frm=office_use_voucher&id=$transaction_id');</script>";
				}else{
					echo "<script> window.location.href = '$common_form_route?frm=office_use_list'; </script>";
				}
				break;

			case 'update':
				if(isset($_POST['invoice_print']) ) { 
					echo "<script type='text/javascript' language='Javascript'>setTimeout(function(){ location.replace('$common_form_route?frm=office_use_list')}, 100);</script>";
					echo "<script type='text/javascript' language='Javascript'>window.open('$common_form_route?frm=office_use_voucher&id=$transaction_id');</script>";
				}else{
					echo "<script> window.location.href = '$common_form_route?frm=office_use_list'; </script>";
				}
				break;

			case 'delete':
				echo "<script> window.location.href = '$common_form_route?frm=office_use_list'; </script>";
				break;
					
			default:
				echo "<script> window.location.href = '$common_form_route?frm=office_use_list'; </script>";
				break;
				
		}
		
	}