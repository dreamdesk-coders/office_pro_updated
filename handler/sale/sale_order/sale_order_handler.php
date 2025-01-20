<?php 
session_start();
include("../../../forms/common/processing.php");
include("../../common/connection_config.php");
include("../../common/common_functions.php");

	/* Variables for transaction log*/

	if(isset($_POST['save'])){
			$action = "create";	
				$transaction_id = $_POST['order_id'];
		}
	elseif(isset($_POST['update'])){
			$action = "update";
				$transaction_id = $_POST['order_id'];
		}
	elseif (isset($_GET['delete'])) {
			$action = "delete";
				$transaction_id = $_GET['order_id'];
	}
	elseif (isset($_GET['cancel'])) {
			$action = "cancel";
			$transaction_id = $_GET['order_id'];
			$order_id = $_GET['order_id'];
	}

	$_SESSION['transaction_id'] = $transaction_id;
	$_SESSION['action'] = $action;
		
	$login_id = $_SESSION['alogin'];
	$date = date("Y-m-d-h-i-s");
	$transaction = "Sale Order Transaction";
	$office_id = $_SESSION['office_id'];



if( isset($_POST['save']) || isset($_POST['update'])){

	/* use for looping through the grid*/
	$rownum = $_POST['rownum'];

	/* variables for sale order transcation header */ 
	$order_id = $_POST['order_id'];
	$order_date = $_POST['order_date'];
	$staff_id = $_POST['staff_id'];
	$currency_id = $_POST['currency_id'];
	$customer_id = $_POST['customer_id'];

	if(isset($_POST['remark'])){
		$remark = $_POST['remark'];
	}
	else{
		$remark = "";
	}
	$total_amount = $_POST['total_amount'];

	$tax = $_POST['tax'];
	$updated_date = date("Y-m-d-h-i-s");

	/* variables for sale order transaction details */ 

	$sr_no = "";
	$stock_id = "";
	$unit_id = "";
	$quantity = "";
	$price = "";
	$amount = "";

}


if(isset($_POST['save'])){

	/*Save to sale order table*/
	$status = "Active";

	$sql="INSERT INTO sale_order(order_id,order_date,staff_id,customer_id,currency_id,office_id,status,total_amount,tax,remark,updated_date)
 	VALUES(:order_id,:order_date,:staff_id,:customer_id, :currency_id,:office_id,:status,:total_amount,:tax,:remark,:updated_date)";

 	$query = $dbh->prepare($sql);

	$query->bindParam(':order_id',$order_id,PDO::PARAM_STR);
	$query->bindParam(':order_date',$order_date,PDO::PARAM_STR);
	$query->bindParam(':staff_id',$staff_id,PDO::PARAM_STR);
	$query->bindParam(':customer_id',$customer_id,PDO::PARAM_STR);
	$query->bindParam(':currency_id',$currency_id,PDO::PARAM_STR);
	$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
	$query->bindParam(':status',$status,PDO::PARAM_STR);
	$query->bindParam(':total_amount',$total_amount,PDO::PARAM_STR);
	$query->bindParam(':tax',$tax,PDO::PARAM_STR);
	$query->bindParam(':remark',$remark,PDO::PARAM_STR);
	$query->bindParam(':updated_date',$updated_date,PDO::PARAM_STR);

	execute_query($dbh,$query);

	/*Insert into Sale order Details*/

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

		$sql="INSERT INTO sale_order_details(sr_no,order_id,stock_id,unit_id,quantity,price,amount) VALUES(:sr_no,:order_id,:stock_id,:unit_id,:quantity,:price,:amount)";

		$query = $dbh->prepare($sql);

		$query->bindParam(':sr_no',$sr_no,PDO::PARAM_STR);
		$query->bindParam(':order_id',$order_id,PDO::PARAM_STR);
		$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
		$query->bindParam(':unit_id',$unit_id,PDO::PARAM_STR);
		$query->bindParam(':quantity',$quantity,PDO::PARAM_STR);
		$query->bindParam(':price',$price,PDO::PARAM_STR);
		$query->bindParam(':amount',$amount,PDO::PARAM_STR);

		execute_query($dbh,$query);

		}

	}

}

if(isset($_POST['update'])) {
		
	$sql="update sale_order set order_date=:order_date,staff_id=:staff_id,customer_id=:customer_id,currency_id=:currency_id,office_id=:office_id,total_amount=:total_amount,tax=:tax,remark=:remark,updated_date=:updated_date where order_id=:order_id";

	$query = $dbh->prepare($sql);

	$query->bindParam(':order_id',$order_id,PDO::PARAM_STR);
	$query->bindParam(':order_date',$order_date,PDO::PARAM_STR);
	$query->bindParam(':staff_id',$staff_id,PDO::PARAM_STR);
	$query->bindParam(':customer_id',$customer_id,PDO::PARAM_STR);
	$query->bindParam(':currency_id',$currency_id,PDO::PARAM_STR);
	$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
	$query->bindParam(':total_amount',$total_amount,PDO::PARAM_STR);
	$query->bindParam(':tax',$tax,PDO::PARAM_STR);
	$query->bindParam(':remark',$remark,PDO::PARAM_STR);
	$query->bindParam(':updated_date',$updated_date,PDO::PARAM_STR);

	execute_query($dbh,$query);

	$sql="delete from sale_order_details WHERE order_id=:order_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':order_id',$order_id,PDO::PARAM_STR);
	execute_query($dbh,$query);

	/*Insert into Sale order Details*/

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

		$sql="INSERT INTO sale_order_details(sr_no,order_id,stock_id,unit_id,quantity,price,amount) VALUES(:sr_no,:order_id,:stock_id,:unit_id,:quantity,:price,:amount)";

		$query = $dbh->prepare($sql);

		$query->bindParam(':sr_no',$sr_no,PDO::PARAM_STR);
		$query->bindParam(':order_id',$order_id,PDO::PARAM_STR);
		$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
		$query->bindParam(':unit_id',$unit_id,PDO::PARAM_STR);
		$query->bindParam(':quantity',$quantity,PDO::PARAM_STR);
		$query->bindParam(':price',$price,PDO::PARAM_STR);
		$query->bindParam(':amount',$amount,PDO::PARAM_STR);

		execute_query($dbh,$query);

		}

	}

	
}
if (isset($_GET['delete'])) {

	$order_id = $_GET['order_id'];

	$sql = "Select * From sale WHERE order_id=:order_id";
        $query = $dbh -> prepare($sql);
        $query->bindParam(':order_id',$order_id,PDO::PARAM_STR);
        $query->execute();

        $count = $query->rowCount();

		if($count == 0){

        	$sql="delete from sale_order_details WHERE order_id=:order_id";
			$query = $dbh->prepare($sql);
			$query->bindParam(':order_id',$order_id,PDO::PARAM_STR);
			execute_query($dbh,$query);

			$sql="delete from sale_order WHERE order_id=:order_id";
			$query = $dbh->prepare($sql);
			$query->bindParam(':order_id',$order_id,PDO::PARAM_STR);
			execute_query($dbh,$query);

        }
        else{
			echo "<script> window.location.href = '$common_form_route?frm=sale_order_list&del=fail'; </script>";
        }

}

if (isset($_GET['cancel'])) {

	$status = "Inactive";

	$sql="update sale_order set status=:status,cancel_date=:date where order_id=:order_id";

	$query = $dbh->prepare($sql);

	$query->bindParam(':order_id',$order_id,PDO::PARAM_STR);
	$query->bindParam(':status',$status,PDO::PARAM_STR);
	$query->bindParam(':date',$date,PDO::PARAM_STR);

	execute_query($dbh,$query);

}

if(isset($_POST['save']) || isset($_POST['update']) || isset($_GET['delete']) || isset($_GET['cancel'])){

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
					echo "<script type='text/javascript' language='Javascript'>setTimeout(function(){ location.replace('$common_form_route?frm=sale_order_list')}, 100);</script>";
					echo "<script type='text/javascript' language='Javascript'>window.open('$common_form_route?frm=sale_order_voucher&id=$transaction_id');</script>";
				}else{
					echo "<script> window.location.href = '$common_form_route?frm=sale_order_list'; </script>";
				}
				break;

			case 'update':
				if(isset($_POST['invoice_print']) ) { 
					echo "<script type='text/javascript' language='Javascript'>setTimeout(function(){ location.replace('$common_form_route?frm=sale_order_list')}, 100);</script>";
					echo "<script type='text/javascript' language='Javascript'>window.open('$common_form_route?frm=sale_order_voucher&id=$transaction_id');</script>";
				}else{
					echo "<script> window.location.href = '$common_form_route?frm=sale_order_list'; </script>";
				}
				break;

			case 'delete':
				echo "<script> window.location.href = '$common_form_route?frm=sale_order_list'; </script>";
				break;

			case 'cancel':
				echo "<script> window.location.href = '$common_form_route?frm=sale_order_cancel_list'; </script>";
				break;
					
			default:
				echo "<script> window.location.href = '$common_form_route?frm=sale_order_list'; </script>";
				break;
				
		}
		
	}