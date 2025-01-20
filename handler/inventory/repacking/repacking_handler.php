<?php 
session_start();
include("../../../forms/common/processing.php");
include("../../common/connection_config.php");
include("../../common/common_functions.php");

	/* Variables for transaction log*/

	if(isset($_POST['save'])){
			$action = "create";	
			$transaction_id = $_POST['slip_id'];
		}
	elseif(isset($_POST['update'])){
			$action = "update";
			$transaction_id = $_POST['slip_id'];
		}
	elseif (isset($_GET['delete'])) {
			$action = "delete";
			$transaction_id = $_GET['slip_id'];
	}

	$_SESSION['transaction_id'] = $transaction_id;
	$_SESSION['action'] = $action;
		
	$login_id = $_SESSION['alogin'];
	$date = date("Y-m-d-h-i-s");
	$transaction = "Stock Repacking Transaction";
	$office_id = $_SESSION['office_id'];



if( isset($_POST['save']) || isset($_POST['update'])){

	/* use for looping through the grid*/
	$rownum = $_POST['rownum'];

	/* variables for office use transcation header */ 
	$slip_id = $_POST['slip_id'];
	$slip_date = $_POST['slip_date'];
	$staff_id = $_POST['staff_id'];
	$from_stock_id = $_POST['from_stock_id'];
    $from_unit_id = $_POST['from_unit_id'];
    $from_quantity = $_POST['from_quantity'];

	if(isset($_POST['remark'])){
		$remark = $_POST['remark'];
	}
	else{
		$remark = "";
	}

	$updated_date = date("Y-m-d-h-i-s");

	/* variables for office use transaction details */ 

	$sr_no = "";
	$stock_id = "";
	$unit_id = "";
	$quantity = "";
	$price = "";

}


if(isset($_POST['save'])){

	/*Save to office use table*/

	$sql="INSERT INTO repacking(slip_id,slip_date,staff_id,office_id,from_stock_id,from_unit_id,from_quantity,remark,updated_date)
 	VALUES(:slip_id,:slip_date,:staff_id,:office_id, :from_stock_id,:from_unit_id,:from_quantity,:remark,:updated_date)";

 	$query = $dbh->prepare($sql);

	$query->bindParam(':slip_id',$slip_id,PDO::PARAM_STR);
	$query->bindParam(':slip_date',$slip_date,PDO::PARAM_STR);
	$query->bindParam(':staff_id',$staff_id,PDO::PARAM_STR);
	$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
	$query->bindParam(':from_stock_id',$from_stock_id,PDO::PARAM_STR);
	$query->bindParam(':from_unit_id',$from_unit_id,PDO::PARAM_STR);
	$query->bindParam(':from_quantity',$from_quantity,PDO::PARAM_STR);
	$query->bindParam(':remark',$remark,PDO::PARAM_STR);
	$query->bindParam(':updated_date',$updated_date,PDO::PARAM_STR);

    execute_query($dbh,$query);

    /* Substract the from stock balance*/
    
    $status = "-";

    $sql="INSERT INTO stock_balance(transaction_id,transaction_type,date,stock_id,unit_id,quantity,office_id,status) VALUES(:transaction_id,:transaction,:slip_date,:from_stock_id,:from_unit_id,:from_quantity,:office_id,:status)";

	$query = $dbh->prepare($sql);
	$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
	$query->bindParam(':transaction',$transaction,PDO::PARAM_STR);
	$query->bindParam(':slip_date',$slip_date,PDO::PARAM_STR);
	$query->bindParam(':from_stock_id',$from_stock_id,PDO::PARAM_STR);
	$query->bindParam(':from_unit_id',$from_unit_id,PDO::PARAM_STR);
	$query->bindParam(':from_quantity',$from_quantity,PDO::PARAM_STR);
	$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
	$query->bindParam(':status',$status,PDO::PARAM_STR);

	execute_query($dbh,$query);

	/*Insert into repacking Details*/

	for ($x = 1; $x <= $rownum; $x++) {

		$sr_no = $x;
		$stock_id = "sid" . $x;
		$unit_id = "unit_id" . $x;
		$quantity = "quantity" . $x;
		$price = "price" . $x;

		if(isset($_POST[$stock_id])){

			$stock_id = $_POST[$stock_id];
			$unit_id = $_POST[$unit_id];
			$quantity = $_POST[$quantity];
			$price = $_POST[$price];

		$sql="INSERT INTO repacking_details(sr_no,slip_id,to_stock_id,to_unit_id,quantity,price) VALUES(:sr_no,:slip_id,:stock_id,:unit_id,:quantity,:price)";

		$query = $dbh->prepare($sql);

		$query->bindParam(':sr_no',$sr_no,PDO::PARAM_STR);
		$query->bindParam(':slip_id',$slip_id,PDO::PARAM_STR);
		$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
		$query->bindParam(':unit_id',$unit_id,PDO::PARAM_STR);
		$query->bindParam(':quantity',$quantity,PDO::PARAM_STR);
		$query->bindParam(':price',$price,PDO::PARAM_STR);

		execute_query($dbh,$query);

        /* Save Stock Balance*/ 

		$status = "+";

		$sql="INSERT INTO stock_balance(transaction_id,transaction_type,date,stock_id,unit_id,quantity,office_id,status) VALUES(:transaction_id,:transaction,:slip_date,:stock_id,:unit_id,:quantity,:office_id,:status)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
		$query->bindParam(':transaction',$transaction,PDO::PARAM_STR);
		$query->bindParam(':slip_date',$slip_date,PDO::PARAM_STR);
		$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
		$query->bindParam(':unit_id',$unit_id,PDO::PARAM_STR);
		$query->bindParam(':quantity',$quantity,PDO::PARAM_STR);
		$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
		$query->bindParam(':status',$status,PDO::PARAM_STR);

		execute_query($dbh,$query);

		}

	}

}

if(isset($_POST['update'])) {
		
	$sql="update repacking set slip_date=:slip_date,staff_id=:staff_id,office_id=:office_id,from_stock_id=:from_stock_id,from_unit_id=:from_unit_id,from_quantity=:from_quantity,remark=:remark,updated_date=:updated_date where slip_id=:slip_id";

	$query = $dbh->prepare($sql);

	$query->bindParam(':slip_id',$slip_id,PDO::PARAM_STR);
	$query->bindParam(':slip_date',$slip_date,PDO::PARAM_STR);
	$query->bindParam(':staff_id',$staff_id,PDO::PARAM_STR);
	$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
	$query->bindParam(':from_stock_id',$from_stock_id,PDO::PARAM_STR);
	$query->bindParam(':from_unit_id',$from_unit_id,PDO::PARAM_STR);
	$query->bindParam(':from_quantity',$from_quantity,PDO::PARAM_STR);
	$query->bindParam(':remark',$remark,PDO::PARAM_STR);
	$query->bindParam(':updated_date',$updated_date,PDO::PARAM_STR);

	execute_query($dbh,$query);

	$sql="delete from repacking_details WHERE slip_id=:slip_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':slip_id',$slip_id,PDO::PARAM_STR);
	execute_query($dbh,$query);

	$sql="delete from stock_balance WHERE transaction_id=:transaction_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
    execute_query($dbh,$query);

     /* Substract the from stock balance*/
    
    $status = "-";

    $sql="INSERT INTO stock_balance(transaction_id,transaction_type,date,stock_id,unit_id,quantity,office_id,status) VALUES(:transaction_id,:transaction,:slip_date,:from_stock_id,:from_unit_id,:from_quantity,:office_id,:status)";

	$query = $dbh->prepare($sql);
	$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
	$query->bindParam(':transaction',$transaction,PDO::PARAM_STR);
	$query->bindParam(':slip_date',$slip_date,PDO::PARAM_STR);
	$query->bindParam(':from_stock_id',$from_stock_id,PDO::PARAM_STR);
	$query->bindParam(':from_unit_id',$from_unit_id,PDO::PARAM_STR);
	$query->bindParam(':from_quantity',$from_quantity,PDO::PARAM_STR);
	$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
	$query->bindParam(':status',$status,PDO::PARAM_STR);

	execute_query($dbh,$query);
    
	/*Insert into Repacking Details*/

	for ($x = 1; $x <= $rownum; $x++) {

		$sr_no = $x;
		$stock_id = "sid" . $x;
		$unit_id = "unit_id" . $x;
		$quantity = "quantity" . $x;
		$price = "price" . $x;

		if(isset($_POST[$stock_id])){

			$stock_id = $_POST[$stock_id];
			$unit_id = $_POST[$unit_id];
			$quantity = $_POST[$quantity];
			$price = $_POST[$price];

		$sql="INSERT INTO repacking_details(sr_no,slip_id,to_stock_id,to_unit_id,quantity,price) VALUES(:sr_no,:slip_id,:stock_id,:unit_id,:quantity,:price)";

		$query = $dbh->prepare($sql);

		$query->bindParam(':sr_no',$sr_no,PDO::PARAM_STR);
		$query->bindParam(':slip_id',$slip_id,PDO::PARAM_STR);
		$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
		$query->bindParam(':unit_id',$unit_id,PDO::PARAM_STR);
		$query->bindParam(':quantity',$quantity,PDO::PARAM_STR);
		$query->bindParam(':price',$price,PDO::PARAM_STR);

		execute_query($dbh,$query);

        /* Save Stock Balance*/ 

		$status = "+";

		$sql="INSERT INTO stock_balance(transaction_id,transaction_type,date,stock_id,unit_id,quantity,office_id,status) VALUES(:transaction_id,:transaction,:slip_date,:stock_id,:unit_id,:quantity,:office_id,:status)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
		$query->bindParam(':transaction',$transaction,PDO::PARAM_STR);
		$query->bindParam(':slip_date',$slip_date,PDO::PARAM_STR);
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

	$slip_id = $_GET['slip_id'];

    $sql="delete from repacking WHERE slip_id=:slip_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':slip_id',$slip_id,PDO::PARAM_STR);
	execute_query($dbh,$query);

	$sql="delete from repacking_details WHERE slip_id=:slip_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':slip_id',$slip_id,PDO::PARAM_STR);
	execute_query($dbh,$query);

	$sql="delete from stock_balance WHERE transaction_id=:slip_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':slip_id',$slip_id,PDO::PARAM_STR);
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
					echo "<script type='text/javascript' language='Javascript'>setTimeout(function(){ location.replace('$common_form_route?frm=repacking_list')}, 100);</script>";
					echo "<script type='text/javascript' language='Javascript'>window.open('$common_form_route?frm=repacking_voucher&id=$transaction_id');</script>";
				}else{

					echo "<script> window.location.href = '$common_form_route?frm=repacking_list'; </script>";
				}
				break;

			case 'update':
				if(isset($_POST['invoice_print']) ) { 
					echo "<script type='text/javascript' language='Javascript'>setTimeout(function(){ location.replace('$common_form_route?frm=repacking_list')}, 100);</script>";
					echo "<script type='text/javascript' language='Javascript'>window.open('$common_form_route?frm=repacking_voucher&id=$transaction_id');</script>";
				}else{
					echo "<script> window.location.href = '$common_form_route?frm=repacking_list'; </script>";
				}
				break;

			case 'delete':
				echo "<script> window.location.href = '$common_form_route?frm=repacking_list'; </script>";
				break;
					
			default:
				echo "<script> window.location.href = '$common_form_route?frm=repacking_list'; </script>";
				break;
				
		}
		
	}