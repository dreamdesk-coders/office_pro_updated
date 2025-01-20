<?php 
session_start();
include("../../../forms/common/processing.php");
include("../../common/connection_config.php");
include("../../common/common_functions.php");

	/* Variables for transaction log*/

	if(isset($_POST['save'])){
			$action = "create";	
				$transaction_id = $_POST['transfer_id'];
		}
	elseif(isset($_POST['update'])){
			$action = "update";
				$transaction_id = $_POST['transfer_id'];
		}
	elseif (isset($_GET['delete'])) {
			$action = "delete";
				$transaction_id = $_GET['transfer_id'];
	}

	$_SESSION['transaction_id'] = $transaction_id;
	$_SESSION['action'] = $action;
		
	$login_id = $_SESSION['alogin'];
	$date = date("Y-m-d-h-i-s");
	$transaction = "Stock Transfer Transaction";
	$office_id = $_SESSION['office_id'];



if( isset($_POST['save']) || isset($_POST['update'])){

	/* use for looping through the grid*/
	$rownum = $_POST['rownum'];

	/* variables for stock_transfer transcation header */ 
	$transfer_id = $_POST['transfer_id'];
	$transfer_date = $_POST['transfer_date'];

	
	$staff_id = $_POST['staff_id'];
	$currency_id = $_POST['currency_id'];
	$exchange_rate = $_POST['exchange_rate'];
	$to_office_id = $_POST['to_office_id'];

	if(isset($_POST['remark'])){
		$remark = $_POST['remark'];
	}
	else{
		$remark = "";
	}

	$total_amount = $_POST['total_amount'];
	$updated_date = date("Y-m-d-h-i-s");

	/* variables for stock_transfer transaction details */ 

	$sr_no = "";
	$stock_id = "";
	$unit_id = "";
	$quantity = "";
	$price = "";
	$amount = "";

}




if(isset($_POST['save'])){

	/*Save to stock_transfer table*/

	$sql="INSERT INTO stock_transfer(transfer_id,transfer_date,staff_id,currency_id,office_id,to_office_id,exchange_rate,total_amount,remark,updated_date)
 	VALUES(:transfer_id,:transfer_date,:staff_id,:currency_id,:office_id,:to_office_id,:exchange_rate,:total_amount,:remark,:updated_date)";

 	$query = $dbh->prepare($sql);

	$query->bindParam(':transfer_id',$transfer_id,PDO::PARAM_STR);
	$query->bindParam(':transfer_date',$transfer_date,PDO::PARAM_STR);
	$query->bindParam(':staff_id',$staff_id,PDO::PARAM_STR);
	$query->bindParam(':currency_id',$currency_id,PDO::PARAM_STR);
	$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
	$query->bindParam(':to_office_id',$to_office_id,PDO::PARAM_STR);
	$query->bindParam(':exchange_rate',$exchange_rate,PDO::PARAM_STR);
	$query->bindParam(':total_amount',$total_amount,PDO::PARAM_STR);
	$query->bindParam(':remark',$remark,PDO::PARAM_STR);
	$query->bindParam(':updated_date',$updated_date,PDO::PARAM_STR);

	execute_query($dbh,$query);

	/*Insert into stock_transfer Details*/

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

		$sql="INSERT INTO stock_transfer_details(sr_no,transfer_id,stock_id,unit_id,quantity,price,amount) VALUES(:sr_no,:transfer_id,:stock_id,:unit_id,:quantity,:price,:amount)";

		$query = $dbh->prepare($sql);

		$query->bindParam(':sr_no',$sr_no,PDO::PARAM_STR);
		$query->bindParam(':transfer_id',$transfer_id,PDO::PARAM_STR);
		$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
		$query->bindParam(':unit_id',$unit_id,PDO::PARAM_STR);
		$query->bindParam(':quantity',$quantity,PDO::PARAM_STR);
		$query->bindParam(':price',$price,PDO::PARAM_STR);
		$query->bindParam(':amount',$amount,PDO::PARAM_STR);

		execute_query($dbh,$query);


		/* Save Stock Balance*/ 

		$status = "-";

		$sql="INSERT INTO stock_balance(transaction_id,transaction_type,date,stock_id,unit_id,quantity,office_id,status) VALUES(:transaction_id,:transaction,:transfer_date,:stock_id,:unit_id,:quantity,:office_id,:status)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
		$query->bindParam(':transaction',$transaction,PDO::PARAM_STR);
		$query->bindParam(':transfer_date',$transfer_date,PDO::PARAM_STR);
		$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
		$query->bindParam(':unit_id',$unit_id,PDO::PARAM_STR);
		$query->bindParam(':quantity',$quantity,PDO::PARAM_STR);
		$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
		$query->bindParam(':status',$status,PDO::PARAM_STR);

		execute_query($dbh,$query);



		}

	}

	/* Create New Notification */

	$title = "New Transfer Complete";
	$noti_from = "Office Pro";
	$noti_to = $office_id;
	$description = "New stock transfer transaction successfully complete.";
	$type = "all";
	$link = $common_form_route . "?frm=stock_transfer_update&id=" . $transfer_id;

	$sql="INSERT INTO notifications(title,noti_from,noti_to,description,date,type,link) VALUES(:title,:noti_from,:noti_to,:description,:date,:type,:link)";

	$query = $dbh->prepare($sql);
	$query->bindParam(':title',$title,PDO::PARAM_STR);
	$query->bindParam(':noti_from',$noti_from,PDO::PARAM_STR);
	$query->bindParam(':noti_to',$noti_to,PDO::PARAM_STR);
	$query->bindParam(':description',$description,PDO::PARAM_STR);
	$query->bindParam(':date',$date,PDO::PARAM_STR);
	$query->bindParam(':type',$type,PDO::PARAM_STR);
	$query->bindParam(':link',$link,PDO::PARAM_STR);

	$query->execute();

	/* Create New Notification */

	$title = "New Transfer Complete";
	$noti_from = "Office Pro";
	$noti_to = $to_office_id;
	$description = "New stock transfer transaction successfully complete.";
	$type = "all";
	$link = $common_form_route . "?frm=stock_transfer_update&id=" . $transfer_id;

	$sql="INSERT INTO notifications(title,noti_from,noti_to,description,date,type,link) VALUES(:title,:noti_from,:noti_to,:description,:date,:type,:link)";

	$query = $dbh->prepare($sql);
	$query->bindParam(':title',$title,PDO::PARAM_STR);
	$query->bindParam(':noti_from',$noti_from,PDO::PARAM_STR);
	$query->bindParam(':noti_to',$noti_to,PDO::PARAM_STR);
	$query->bindParam(':description',$description,PDO::PARAM_STR);
	$query->bindParam(':date',$date,PDO::PARAM_STR);
	$query->bindParam(':type',$type,PDO::PARAM_STR);
	$query->bindParam(':link',$link,PDO::PARAM_STR);

	$query->execute();



}

if(isset($_POST['update'])) {
		
	$sql="update stock_transfer set transfer_date=:transfer_date,staff_id=:staff_id,currency_id=:currency_id,office_id=:office_id,to_office_id=:to_office_id,exchange_rate=:exchange_rate,total_amount=:total_amount,remark=:remark,updated_date=:updated_date where transfer_id=:transfer_id";

	$query = $dbh->prepare($sql);

	$query->bindParam(':transfer_id',$transfer_id,PDO::PARAM_STR);
	$query->bindParam(':transfer_date',$transfer_date,PDO::PARAM_STR);
	$query->bindParam(':staff_id',$staff_id,PDO::PARAM_STR);
	$query->bindParam(':currency_id',$currency_id,PDO::PARAM_STR);
	$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
	$query->bindParam(':to_office_id',$to_office_id,PDO::PARAM_STR);
	$query->bindParam(':exchange_rate',$exchange_rate,PDO::PARAM_STR);
	$query->bindParam(':total_amount',$total_amount,PDO::PARAM_STR);
	$query->bindParam(':remark',$remark,PDO::PARAM_STR);
	$query->bindParam(':updated_date',$updated_date,PDO::PARAM_STR);

	execute_query($dbh,$query);

	$sql="delete from stock_transfer_details WHERE transfer_id=:transfer_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':transfer_id',$transfer_id,PDO::PARAM_STR);
	execute_query($dbh,$query);

	$sql="delete from stock_balance WHERE transaction_id=:transaction_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
	execute_query($dbh,$query);

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


			$sql="INSERT INTO stock_transfer_details(sr_no,transfer_id,stock_id,unit_id,quantity,price,amount) VALUES(:sr_no,:transfer_id,:stock_id,:unit_id,:quantity,:price,:amount)";

			$query = $dbh->prepare($sql);

			$query->bindParam(':sr_no',$sr_no,PDO::PARAM_STR);
			$query->bindParam(':transfer_id',$transfer_id,PDO::PARAM_STR);
			$query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
			$query->bindParam(':unit_id',$unit_id,PDO::PARAM_STR);
			$query->bindParam(':quantity',$quantity,PDO::PARAM_STR);
			$query->bindParam(':price',$price,PDO::PARAM_STR);
			$query->bindParam(':amount',$amount,PDO::PARAM_STR);

			execute_query($dbh,$query);

			/* Save Stock Balance*/ 

			$status = "-";

			$sql="INSERT INTO stock_balance(transaction_id,transaction_type,date,stock_id,unit_id,quantity,office_id,status) VALUES(:transaction_id,:transaction,:transfer_date,:stock_id,:unit_id,:quantity,:office_id,:status)";

			$query = $dbh->prepare($sql);
			$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
			$query->bindParam(':transaction',$transaction,PDO::PARAM_STR);
			$query->bindParam(':transfer_date',$transfer_date,PDO::PARAM_STR);
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

	$transfer_id = $_GET['transfer_id'];


        if(1==1){
			$sql="delete from stock_balance WHERE transaction_id=:transfer_id";
			$query = $dbh->prepare($sql);
			$query->bindParam(':transfer_id',$transfer_id,PDO::PARAM_STR);
			execute_query($dbh,$query);

			$sql="delete from stock_transfer_details WHERE transfer_id=:transfer_id";
			$query = $dbh->prepare($sql);
			$query->bindParam(':transfer_id',$transfer_id,PDO::PARAM_STR);
			execute_query($dbh,$query);

			$sql="delete from stock_transfer WHERE transfer_id=:transfer_id";
			$query = $dbh->prepare($sql);
			$query->bindParam(':transfer_id',$transfer_id,PDO::PARAM_STR);
			execute_query($dbh,$query);

        }
        else{
			echo "<script> window.location.href = '$common_form_route?frm=stock_transfer_list&del=fail'; </script>";
        }
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
					echo "<script type='text/javascript' language='Javascript'>setTimeout(function(){ location.replace('$common_form_route?frm=stock_transfer_list')}, 100);</script>";
					echo "<script type='text/javascript' language='Javascript'>window.open('$common_form_route?frm=stock_transfer_voucher&id=$transaction_id');</script>";
				}else{
					echo "<script> window.location.href = '$common_form_route?frm=stock_transfer_list'; </script>";
				}
				break;

			case 'update':
				if(isset($_POST['invoice_print']) ) { 
					echo "<script type='text/javascript' language='Javascript'>setTimeout(function(){ location.replace('$common_form_route?frm=stock_transfer_list')}, 100);</script>";
					echo "<script type='text/javascript' language='Javascript'>window.open('$common_form_route?frm=stock_transfer_voucher&id=$transaction_id');</script>";
				}else{
					echo "<script> window.location.href = '$common_form_route?frm=stock_transfer_list'; </script>";
				}
				break;

			case 'delete':
				echo "<script> window.location.href = '$common_form_route?frm=stock_transfer_list'; </script>";
				break;
					
			default:
				echo "<script> window.location.href = '$common_form_route?frm=stock_transfer_list'; </script>";
				break;
				
		}
		
	}