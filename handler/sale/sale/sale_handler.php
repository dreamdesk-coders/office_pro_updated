<?php
session_start();
include("../../../forms/common/processing.php");
include("../../common/connection_config.php");
include("../../common/common_functions.php");

/* Variables for transaction log*/

if (isset($_POST['save'])) {
	$action = "create";
	$transaction_id = $_POST['invoice_id'];
} elseif (isset($_POST['update'])) {
	$action = "update";
	$transaction_id = $_POST['invoice_id'];
} elseif (isset($_GET['delete'])) {
	$action = "delete";
	$transaction_id = $_GET['invoice_id'];
}

$_SESSION['transaction_id'] = $transaction_id;
$_SESSION['action'] = $action;

$login_id = $_SESSION['alogin'];
$date = date("Y-m-d-h-i-s");
$transaction = "Sale Transaction";
$office_id = $_SESSION['office_id'];



if (isset($_POST['save']) || isset($_POST['update'])) {

	/* use for looping through the grid*/
	$rownum = $_POST['rownum'];

	/* variables for sale transcation header */
	$invoice_id = $_POST['invoice_id'];
	$invoice_date = $_POST['invoice_date'];
	if (isset($_POST['order_id'])) {
		$order_id = $_POST['order_id'];
	} else {
		$order_id = "";
	}

	$staff_id = $_POST['staff_id'];
	$currency_id = $_POST['currency_id'];
	$exchange_rate = $_POST['exchange_rate'];
	$customer_id = $_POST['customer_id'];

	if (isset($_POST['remark'])) {
		$remark = $_POST['remark'];
	} else {
		$remark = "";
	}

	$total_amount = $_POST['total_amount'];
	$paid_amount = $_POST['paid_amount'];
	$discount = $_POST['discount'];
	$discount_percent = $_POST['discount_percent'];
	$tax = $_POST['tax'];
	$expense = $_POST['expense'];
	$grand_total = $_POST['grand_total'];
	$net_amount = $_POST['net_amount'];

	if (isset($_POST['advance'])) {
		$sale_type = "Advance";
	} else {
		if ($grand_total - $paid_amount == 0) {
			$sale_type = "Cash";
		} else {
			$sale_type = "Credit";
		}
	}


	$updated_date = date("Y-m-d-h-i-s");
	$sale_status = "new";

	/* variables for sale transaction details */

	$sr_no = "";
	$stock_id = "";
	$unit_id = "";
	$quantity = "";
	$price = "";
	$amount = "";

	/* For General Ledger*/

	$home_currency = $_SESSION['home_currency'];

	if ($currency_id == $home_currency) {
		$home_amount = $grand_total;
		$source_amount = $grand_total;
	} else {

		$home_amount = $exchange_rate * $grand_total;
		$source_amount = $grand_total;
	}

	$transaction_status = "DS";
}

if (isset($_POST['save'])) {

	/*Save to sale table*/

	$sql = "INSERT INTO sale(invoice_id,invoice_date,order_id,staff_id,customer_id,currency_id,office_id,exchange_rate,total_amount,grand_total_amount, paid_amount,discount,discount_percent,tax,expense,net_amount,sale_type,remark,updated_date,status)
 	VALUES(:invoice_id,:invoice_date,:order_id,:staff_id,:customer_id, :currency_id,:office_id,:exchange_rate,:total_amount,:grand_total,:paid_amount,:discount,:discount_percent,:tax,:expense,:net_amount,:sale_type,:remark,:updated_date,:sale_status)";

	$query = $dbh->prepare($sql);

	$query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
	$query->bindParam(':invoice_date', $invoice_date, PDO::PARAM_STR);
	$query->bindParam(':order_id', $order_id, PDO::PARAM_STR);
	$query->bindParam(':staff_id', $staff_id, PDO::PARAM_STR);
	$query->bindParam(':customer_id', $customer_id, PDO::PARAM_STR);
	$query->bindParam(':currency_id', $currency_id, PDO::PARAM_STR);
	$query->bindParam(':office_id', $office_id, PDO::PARAM_STR);
	$query->bindParam(':exchange_rate', $exchange_rate, PDO::PARAM_STR);
	$query->bindParam(':total_amount', $total_amount, PDO::PARAM_STR);
	$query->bindParam(':grand_total', $grand_total, PDO::PARAM_STR);
	$query->bindParam(':paid_amount', $paid_amount, PDO::PARAM_STR);
	$query->bindParam(':discount', $discount, PDO::PARAM_STR);
	$query->bindParam(':discount_percent', $discount_percent, PDO::PARAM_STR);
	$query->bindParam(':tax', $tax, PDO::PARAM_STR);
	$query->bindParam(':expense', $expense, PDO::PARAM_STR);
	$query->bindParam(':net_amount', $net_amount, PDO::PARAM_STR);
	$query->bindParam(':sale_type', $sale_type, PDO::PARAM_STR);
	$query->bindParam(':remark', $remark, PDO::PARAM_STR);
	$query->bindParam(':updated_date', $updated_date, PDO::PARAM_STR);
	$query->bindParam(':sale_status', $sale_status, PDO::PARAM_STR);

	execute_query($dbh, $query);

	/*Insert into customer credit*/

	$sql = "INSERT INTO customer_credit(invoice_id,type,customer_id,credit_amount,currency_id)VALUES(:invoice_id,:transaction,:customer_id,:net_amount,:currency_id)";
	$query = $dbh->prepare($sql);

	$query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
	$query->bindParam(':transaction', $transaction, PDO::PARAM_STR);
	$query->bindParam(':customer_id', $customer_id, PDO::PARAM_STR);
	$query->bindParam(':net_amount', $net_amount, PDO::PARAM_STR);
	$query->bindParam(':currency_id', $currency_id, PDO::PARAM_STR);

	execute_query($dbh, $query);

	$status = "+";

	/* insert into cash balance*/
	$sql = "INSERT INTO cash_balance(transaction_id,transaction_type,date,office_id,currency_id,amount,status)VALUES(:transaction_id,:transaction,:invoice_date,:office_id,:currency_id,:paid_amount,:status)";

	$query = $dbh->prepare($sql);
	$query->bindParam(':transaction_id', $transaction_id, PDO::PARAM_STR);
	$query->bindParam(':transaction', $transaction, PDO::PARAM_STR);
	$query->bindParam(':invoice_date', $invoice_date, PDO::PARAM_STR);
	$query->bindParam(':office_id', $office_id, PDO::PARAM_STR);
	$query->bindParam(':currency_id', $currency_id, PDO::PARAM_STR);
	$query->bindParam(':paid_amount', $paid_amount, PDO::PARAM_STR);
	$query->bindParam(':status', $status, PDO::PARAM_STR);

	execute_query($dbh, $query);

	/*Insert into Sale Details*/

	for ($x = 1; $x <= $rownum; $x++) {

		$sr_no = $x;
		$stock_id = "sid" . $x;
		$unit_id = "unit_id" . $x;
		$quantity = "quantity" . $x;
		$price = "price" . $x;
		$amount = "amount" . $x;

		if (isset($_POST[$stock_id])) {

			$stock_id = $_POST[$stock_id];
			$unit_id = $_POST[$unit_id];
			$quantity = $_POST[$quantity];
			$price = $_POST[$price];
			$amount = $_POST[$amount];

			$sql = "INSERT INTO sale_details(sr_no,invoice_id,stock_id,unit_id,quantity,price,amount) VALUES(:sr_no,:invoice_id,:stock_id,:unit_id,:quantity,:price,:amount)";

			$query = $dbh->prepare($sql);

			$query->bindParam(':sr_no', $sr_no, PDO::PARAM_STR);
			$query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
			$query->bindParam(':stock_id', $stock_id, PDO::PARAM_STR);
			$query->bindParam(':unit_id', $unit_id, PDO::PARAM_STR);
			$query->bindParam(':quantity', $quantity, PDO::PARAM_STR);
			$query->bindParam(':price', $price, PDO::PARAM_STR);
			$query->bindParam(':amount', $amount, PDO::PARAM_STR);

			execute_query($dbh, $query);

			/* Save Stock Balance*/

			if ($sale_type !== "Advance") {

				$status = "-";

				$sql = "INSERT INTO stock_balance(transaction_id,transaction_type,date,stock_id,unit_id,quantity,office_id,status) VALUES(:transaction_id,:transaction,:invoice_date,:stock_id,:unit_id,:quantity,:office_id,:status)";

				$query = $dbh->prepare($sql);
				$query->bindParam(':transaction_id', $transaction_id, PDO::PARAM_STR);
				$query->bindParam(':transaction', $transaction, PDO::PARAM_STR);
				$query->bindParam(':invoice_date', $invoice_date, PDO::PARAM_STR);
				$query->bindParam(':stock_id', $stock_id, PDO::PARAM_STR);
				$query->bindParam(':unit_id', $unit_id, PDO::PARAM_STR);
				$query->bindParam(':quantity', $quantity, PDO::PARAM_STR);
				$query->bindParam(':office_id', $office_id, PDO::PARAM_STR);
				$query->bindParam(':status', $status, PDO::PARAM_STR);

				execute_query($dbh, $query);
			}
		}
	}

	/** Save to general ledger */

	$sql = "INSERT INTO general_ledger(slip_id,slip_date,transaction_status,office_id,currency_id,exchange_rate,home_amount,source_amount,remark,updated_date) 
	VALUES(:invoice_id,:invoice_date,:transaction_status,:office_id,:currency_id,:exchange_rate,:home_amount,:source_amount,:remark,:updated_date)";

	$query = $dbh->prepare($sql);
	$query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
	$query->bindParam(':invoice_date', $invoice_date, PDO::PARAM_STR);
	$query->bindParam(':transaction_status', $transaction_status, PDO::PARAM_STR);
	$query->bindParam(':office_id', $office_id, PDO::PARAM_STR);
	$query->bindParam(':currency_id', $currency_id, PDO::PARAM_STR);
	$query->bindParam(':exchange_rate', $exchange_rate, PDO::PARAM_STR);
	$query->bindParam(':home_amount', $home_amount, PDO::PARAM_STR);
	$query->bindParam(':source_amount', $source_amount, PDO::PARAM_STR);
	$query->bindParam(':remark', $remark, PDO::PARAM_STR);
	$query->bindParam(':updated_date', $updated_date, PDO::PARAM_STR);

	execute_query($dbh, $query);
}

if (isset($_POST['update'])) {

	$sql = "update sale set invoice_date=:invoice_date,order_id=:order_id,staff_id=:staff_id,customer_id=:customer_id,currency_id=:currency_id,office_id=:office_id,exchange_rate=:exchange_rate,total_amount=:total_amount,grand_total_amount=:grand_total,paid_amount=:paid_amount,discount=:discount,discount_percent=:discount_percent,tax=:tax,expense=:expense,net_amount=:net_amount,sale_type=:sale_type,remark=:remark,updated_date=:updated_date where invoice_id=:invoice_id";

	$query = $dbh->prepare($sql);

	$query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
	$query->bindParam(':invoice_date', $invoice_date, PDO::PARAM_STR);
	$query->bindParam(':order_id', $order_id, PDO::PARAM_STR);
	$query->bindParam(':staff_id', $staff_id, PDO::PARAM_STR);
	$query->bindParam(':customer_id', $customer_id, PDO::PARAM_STR);
	$query->bindParam(':currency_id', $currency_id, PDO::PARAM_STR);
	$query->bindParam(':office_id', $office_id, PDO::PARAM_STR);
	$query->bindParam(':exchange_rate', $exchange_rate, PDO::PARAM_STR);
	$query->bindParam(':total_amount', $total_amount, PDO::PARAM_STR);
	$query->bindParam(':grand_total', $grand_total, PDO::PARAM_STR);
	$query->bindParam(':paid_amount', $paid_amount, PDO::PARAM_STR);
	$query->bindParam(':discount', $discount, PDO::PARAM_STR);
	$query->bindParam(':discount_percent', $discount_percent, PDO::PARAM_STR);
	$query->bindParam(':tax', $tax, PDO::PARAM_STR);
	$query->bindParam(':expense', $expense, PDO::PARAM_STR);
	$query->bindParam(':net_amount', $net_amount, PDO::PARAM_STR);
	$query->bindParam(':sale_type', $sale_type, PDO::PARAM_STR);
	$query->bindParam(':remark', $remark, PDO::PARAM_STR);
	$query->bindParam(':updated_date', $updated_date, PDO::PARAM_STR);

	execute_query($dbh, $query);

	/*Customer credit*/
	$sql = "update customer_credit set customer_id=:customer_id,credit_amount=:net_amount,currency_id=:currency_id where invoice_id=:invoice_id";

	$query = $dbh->prepare($sql);

	$query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
	$query->bindParam(':customer_id', $customer_id, PDO::PARAM_STR);
	$query->bindParam(':net_amount', $net_amount, PDO::PARAM_STR);
	$query->bindParam(':currency_id', $currency_id, PDO::PARAM_STR);

	execute_query($dbh, $query);

	// $sql="INSERT INTO cash_balance(transaction_id,transaction_type,date,office_id,currency_id,amount,status)VALUES(:transaction_id,:transaction,:invoice_date,:office_id,:currency_id,:net_amount,:status)";

	$sql = "update cash_balance set office_id=:office_id,currency_id=:currency_id,amount=:paid_amount where transaction_id=:transaction_id";

	$query = $dbh->prepare($sql);

	$query->bindParam(':transaction_id', $transaction_id, PDO::PARAM_STR);
	$query->bindParam(':office_id', $office_id, PDO::PARAM_STR);
	$query->bindParam(':currency_id', $currency_id, PDO::PARAM_STR);
	$query->bindParam(':paid_amount', $paid_amount, PDO::PARAM_STR);

	execute_query($dbh, $query);

	$sql = "delete from sale_details WHERE invoice_id=:invoice_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
	execute_query($dbh, $query);

	$sql = "delete from stock_balance WHERE transaction_id=:transaction_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':transaction_id', $transaction_id, PDO::PARAM_STR);
	execute_query($dbh, $query);

	for ($x = 1; $x <= $rownum; $x++) {

		$sr_no = $x;
		$stock_id = "sid" . $x;
		$unit_id = "unit_id" . $x;
		$quantity = "quantity" . $x;
		$price = "price" . $x;
		$amount = "amount" . $x;

		if (isset($_POST[$stock_id])) {

			$stock_id = $_POST[$stock_id];
			$unit_id = $_POST[$unit_id];
			$quantity = $_POST[$quantity];
			$price = $_POST[$price];
			$amount = $_POST[$amount];

			$sql = "INSERT INTO sale_details(sr_no,invoice_id,stock_id,unit_id,quantity,price,amount) VALUES(:sr_no,:invoice_id,:stock_id,:unit_id,:quantity,:price,:amount)";

			$query = $dbh->prepare($sql);

			$query->bindParam(':sr_no', $sr_no, PDO::PARAM_STR);
			$query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
			$query->bindParam(':stock_id', $stock_id, PDO::PARAM_STR);
			$query->bindParam(':unit_id', $unit_id, PDO::PARAM_STR);
			$query->bindParam(':quantity', $quantity, PDO::PARAM_STR);
			$query->bindParam(':price', $price, PDO::PARAM_STR);
			$query->bindParam(':amount', $amount, PDO::PARAM_STR);

			execute_query($dbh, $query);

			if ($sale_type !== "Advance") {

				/* Save Stock Balance*/

				$status = "-";

				$sql = "INSERT INTO stock_balance(transaction_id,transaction_type,date,stock_id,unit_id,quantity,office_id,status) VALUES(:transaction_id,:transaction,:invoice_date,:stock_id,:unit_id,:quantity,:office_id,:status)";

				$query = $dbh->prepare($sql);
				$query->bindParam(':transaction_id', $transaction_id, PDO::PARAM_STR);
				$query->bindParam(':transaction', $transaction, PDO::PARAM_STR);
				$query->bindParam(':invoice_date', $invoice_date, PDO::PARAM_STR);
				$query->bindParam(':stock_id', $stock_id, PDO::PARAM_STR);
				$query->bindParam(':unit_id', $unit_id, PDO::PARAM_STR);
				$query->bindParam(':quantity', $quantity, PDO::PARAM_STR);
				$query->bindParam(':office_id', $office_id, PDO::PARAM_STR);
				$query->bindParam(':status', $status, PDO::PARAM_STR);

				execute_query($dbh, $query);
			}
		}
	}

	/** Update General Ledger Transaction */

	$sql = "update general_ledger set slip_date=:invoice_date,office_id=:office_id,currency_id=:currency_id,exchange_rate=:exchange_rate,home_amount=:home_amount,source_amount=:source_amount,remark=:remark,updated_date=:updated_date where slip_id=:invoice_id";
	$query = $dbh->prepare($sql);

	$query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
	$query->bindParam(':invoice_date', $invoice_date, PDO::PARAM_STR);

	$query->bindParam(':office_id', $office_id, PDO::PARAM_STR);
	$query->bindParam(':currency_id', $currency_id, PDO::PARAM_STR);
	$query->bindParam(':exchange_rate', $exchange_rate, PDO::PARAM_STR);
	$query->bindParam(':exchange_rate', $exchange_rate, PDO::PARAM_STR);
	$query->bindParam(':home_amount', $home_amount, PDO::PARAM_STR);
	$query->bindParam(':source_amount', $source_amount, PDO::PARAM_STR);
	$query->bindParam(':remark', $remark, PDO::PARAM_STR);
	$query->bindParam(':updated_date', $updated_date, PDO::PARAM_STR);
	execute_query($dbh, $query);
}
if (isset($_GET['delete'])) {

	$invoice_id = $_GET['invoice_id'];

	$sql = "Select * From customer_credit WHERE invoice_id=:invoice_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
	$query->execute();
	$result = $query->fetch(PDO::FETCH_OBJ);

	$sql1 = "Select * From Sale Where invoice_id=:invoice_id";
	$query = $dbh->prepare($sql1);
	$query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
	$query->execute();
	$sale_invoice = $query->fetch(PDO::FETCH_OBJ);

	$credit_amount = $result->credit_amount;
	$sale_type = $sale_invoice->sale_type;


	if ($credit_amount == 0 and $sale_type !== "Advance") {
		$sql = "delete from cash_balance WHERE transaction_id=:invoice_id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
		execute_query($dbh, $query);

		$sql = "delete from stock_balance WHERE transaction_id=:invoice_id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
		execute_query($dbh, $query);

		$sql = "delete from customer_credit WHERE invoice_id=:invoice_id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
		execute_query($dbh, $query);

		$sql = "delete from sale_details WHERE invoice_id=:invoice_id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
		execute_query($dbh, $query);

		$sql = "delete from sale WHERE invoice_id=:invoice_id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
		execute_query($dbh, $query);

		$sql = "delete from general_ledger WHERE slip_id=:invoice_id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
		execute_query($dbh, $query);
		$_SESSION['del_fail'] = "0";
	} else {
		$_SESSION['save_status'] = "1";
		$_SESSION['del_fail'] = "1";
	}
}

if (isset($_POST['save']) || isset($_POST['update']) || isset($_GET['delete'])) {

	$sql = "INSERT INTO transaction_log(login_id,date,transaction_id,transaction,action,office_id) VALUES(:login_id,:date,:transaction_id,:transaction,:action,:office_id)";

	$query = $dbh->prepare($sql);
	$query->bindParam(':login_id', $login_id, PDO::PARAM_STR);
	$query->bindParam(':date', $date, PDO::PARAM_STR);
	$query->bindParam(':transaction_id', $transaction_id, PDO::PARAM_STR);
	$query->bindParam(':transaction', $transaction, PDO::PARAM_STR);
	$query->bindParam(':action', $action, PDO::PARAM_STR);
	$query->bindParam(':office_id', $office_id, PDO::PARAM_STR);

	$query->execute();

	switch ($action) {

		case 'create':
			if (isset($_POST['invoice_print'])) {
				echo "<script type='text/javascript' language='Javascript'>setTimeout(function(){ location.replace('$common_form_route?frm=sale_list')}, 100);</script>";
				echo "<script type='text/javascript' language='Javascript'>window.open('$common_form_route?frm=sale_voucher&id=$transaction_id');</script>";
			} else {
				echo "<script> window.location.href = '$common_form_route?frm=sale_list'; </script>";
			}
			break;

		case 'update':
			if (isset($_POST['invoice_print'])) {
				echo "<script type='text/javascript' language='Javascript'>setTimeout(function(){ location.replace('$common_form_route?frm=sale_list')}, 100);</script>";
				echo "<script type='text/javascript' language='Javascript'>window.open('$common_form_route?frm=sale_voucher&id=$transaction_id');</script>";
			} else {
				echo "<script> window.location.href = '$common_form_route?frm=sale_list'; </script>";
			}
			break;

		case 'delete':
			echo "<script> window.location.href = '$common_form_route?frm=sale_list'; </script>";
			break;

		default:
			echo "<script> window.location.href = '$common_form_route?frm=sale_list'; </script>";
			break;
	}
}