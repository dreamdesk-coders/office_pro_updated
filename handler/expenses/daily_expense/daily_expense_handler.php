<?php
session_start();
include("../../../forms/common/processing.php");
include("../../common/connection_config.php");
include("../../common/common_functions.php");

/* Variables for transaction log*/

if (isset($_POST['save'])) {
	$action = "create";
	$transaction_id = $_POST['expense_id'];
} elseif (isset($_POST['update'])) {
	$action = "update";
	$transaction_id = $_POST['expense_id'];
} elseif (isset($_GET['delete'])) {
	$action = "delete";
	$transaction_id = $_GET['expense_id'];
}

$_SESSION['transaction_id'] = $transaction_id;
$_SESSION['action'] = $action;

$login_id = $_SESSION['alogin'];
$date = date("Y-m-d-h-i-s");
$transaction = "Daily Expense Transaction";
$office_id = $_SESSION['office_id'];

if (isset($_POST['save']) || isset($_POST['update'])) {

	/* use for looping through the grid*/
	$rownum = $_POST['rownum'];

	/* variables for daily expense transcation header */
	$expense_id = $_POST['expense_id'];
	$expense_date = $_POST['expense_date'];
	$currency_id = $_POST['currency_id'];
	$exchange_rate = $_POST['exchange_rate'];
	$staff_id = $_POST['staff_id'];

	if (isset($_POST['remark'])) {
		$remark = $_POST['remark'];
	} else {
		$remark = "";
	}

	$total_amount = $_POST['total_amount'];

	$updated_date = date("Y-m-d-h-i-s");

	/* variables for daily expense transaction details */

	$sr_no = "";
	$emid = "";
	$amount = "";
}

/* For General Ledger*/

$home_currency = $_SESSION['home_currency'];

if ($currency_id == $home_currency) {
	$home_amount = $total_amount;
	$source_amount = $total_amount;
} else {

	$home_amount = $exchange_rate * $total_amount;
	$source_amount = $total_amount;
}
$transaction_status = "DE";


if (isset($_POST['save'])) {

	/*Save to expenses table*/

	$sql = "INSERT INTO expenses(expense_id,expense_date,currency_id,exchange_rate,staff_id,office_id,total_amount,remark,updated_date)
 	VALUES(:expense_id,:expense_date,:currency_id, :exchange_rate,:staff_id,:office_id,:total_amount,:remark,:updated_date)";

	$query = $dbh->prepare($sql);

	$query->bindParam(':expense_id', $expense_id, PDO::PARAM_STR);
	$query->bindParam(':expense_date', $expense_date, PDO::PARAM_STR);
	$query->bindParam(':currency_id', $currency_id, PDO::PARAM_STR);
	$query->bindParam(':exchange_rate', $exchange_rate, PDO::PARAM_STR);
	$query->bindParam(':staff_id', $staff_id, PDO::PARAM_STR);
	$query->bindParam(':office_id', $office_id, PDO::PARAM_STR);
	$query->bindParam(':total_amount', $total_amount, PDO::PARAM_STR);
	$query->bindParam(':remark', $remark, PDO::PARAM_STR);
	$query->bindParam(':updated_date', $updated_date, PDO::PARAM_STR);

	execute_query($dbh, $query);

	$save_err = $_SESSION['save_err'];

	if ($save_err == "1") {
		echo "<script> window.location.href = '$common_form_route?frm=daily_expense_list&err=1'; </script>";
	} elseif ($save_err == "0") {
		echo "Success";
	}


	/*Insert into daily expense Details*/

	for ($x = 1; $x <= $rownum; $x++) {

		$sr_no = $x;
		$emid = "emid" . $x;
		$amount = "amount" . $x;

		if (isset($_POST[$emid])) {

			$emid = $_POST[$emid];
			$amount = $_POST[$amount];

			$sql = "INSERT INTO expenses_details(sr_no,expense_id,exp_master_id,amount) VALUES(:sr_no,:expense_id,:emid,:amount)";

			$query = $dbh->prepare($sql);

			$query->bindParam(':sr_no', $sr_no, PDO::PARAM_STR);
			$query->bindParam(':expense_id', $expense_id, PDO::PARAM_STR);
			$query->bindParam(':emid', $emid, PDO::PARAM_STR);
			$query->bindParam(':amount', $amount, PDO::PARAM_STR);

			execute_query($dbh, $query);
		}
	}

	$status = "-";
	/* insert into cash balance*/
	$sql = "INSERT INTO cash_balance(transaction_id,transaction_type,date,office_id,currency_id,amount,status)VALUES(:transaction_id,:transaction,:expense_date,:office_id,:currency_id,:total_amount,:status)";

	$query = $dbh->prepare($sql);
	$query->bindParam(':transaction_id', $transaction_id, PDO::PARAM_STR);
	$query->bindParam(':transaction', $transaction, PDO::PARAM_STR);
	$query->bindParam(':expense_date', $expense_date, PDO::PARAM_STR);
	$query->bindParam(':office_id', $office_id, PDO::PARAM_STR);
	$query->bindParam(':currency_id', $currency_id, PDO::PARAM_STR);
	$query->bindParam(':total_amount', $total_amount, PDO::PARAM_STR);
	$query->bindParam(':status', $status, PDO::PARAM_STR);

	execute_query($dbh, $query);

	/** Save to general ledger */

	$sql = "INSERT INTO general_ledger(slip_id,slip_date,transaction_status,office_id,currency_id,exchange_rate,home_amount,source_amount,remark,updated_date) 
	VALUES(:expense_id,:expense_date,:transaction_status,:office_id,:currency_id,:exchange_rate,:home_amount,:source_amount,:remark,:updated_date)";

	$query = $dbh->prepare($sql);
	$query->bindParam(':expense_id', $expense_id, PDO::PARAM_STR);
	$query->bindParam(':expense_date', $expense_date, PDO::PARAM_STR);
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

	$sql = "update expenses set expense_date=:expense_date,currency_id=:currency_id,staff_id=:staff_id,exchange_rate=:exchange_rate,office_id=:office_id,total_amount=:total_amount,remark=:remark,updated_date=:updated_date where expense_id=:expense_id";

	$query = $dbh->prepare($sql);

	$query->bindParam(':expense_id', $expense_id, PDO::PARAM_STR);
	$query->bindParam(':expense_date', $expense_date, PDO::PARAM_STR);
	$query->bindParam(':currency_id', $currency_id, PDO::PARAM_STR);
	$query->bindParam(':exchange_rate', $exchange_rate, PDO::PARAM_STR);
	$query->bindParam(':staff_id', $staff_id, PDO::PARAM_STR);
	$query->bindParam(':office_id', $office_id, PDO::PARAM_STR);
	$query->bindParam(':total_amount', $total_amount, PDO::PARAM_STR);
	$query->bindParam(':remark', $remark, PDO::PARAM_STR);
	$query->bindParam(':updated_date', $updated_date, PDO::PARAM_STR);

	execute_query($dbh, $query);

	//Update Cash Balance
	$sql = "update cash_balance set office_id=:office_id,currency_id=:currency_id,amount=:total_amount where transaction_id=:transaction_id";

	$query = $dbh->prepare($sql);
	$query->bindParam(':transaction_id', $transaction_id, PDO::PARAM_STR);
	$query->bindParam(':office_id', $office_id, PDO::PARAM_STR);
	$query->bindParam(':currency_id', $currency_id, PDO::PARAM_STR);
	$query->bindParam(':total_amount', $total_amount, PDO::PARAM_STR);
	execute_query($dbh, $query);

	$sql = "delete from expenses_details WHERE expense_id=:expense_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':expense_id', $expense_id, PDO::PARAM_STR);
	execute_query($dbh, $query);

	/*Insert into office use Details*/

	for ($x = 1; $x <= $rownum; $x++) {

		$sr_no = $x;
		$emid = "emid" . $x;
		$amount = "amount" . $x;

		if (isset($_POST[$emid])) {

			$emid = $_POST[$emid];
			$amount = $_POST[$amount];

			$sql = "INSERT INTO expenses_details(sr_no,expense_id,exp_master_id,amount) VALUES(:sr_no,:expense_id,:emid,:amount)";

			$query = $dbh->prepare($sql);

			$query->bindParam(':sr_no', $sr_no, PDO::PARAM_STR);
			$query->bindParam(':expense_id', $expense_id, PDO::PARAM_STR);
			$query->bindParam(':emid', $emid, PDO::PARAM_STR);
			$query->bindParam(':amount', $amount, PDO::PARAM_STR);

			execute_query($dbh, $query);
		}
	}

	/** Update General Ledger Transaction */

	$sql = "update general_ledger set slip_date=:expense_date,office_id=:office_id,currency_id=:currency_id,exchange_rate=:exchange_rate,home_amount=:home_amount,source_amount=:source_amount,remark=:remark,updated_date=:updated_date where slip_id=:expense_id";
	$query = $dbh->prepare($sql);

	$query->bindParam(':expense_id', $expense_id, PDO::PARAM_STR);
	$query->bindParam(':expense_date', $expense_date, PDO::PARAM_STR);

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

	$expense_id = $_GET['expense_id'];

	$sql = "delete from expenses_details WHERE expense_id=:expense_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':expense_id', $expense_id, PDO::PARAM_STR);
	execute_query($dbh, $query);

	$sql = "delete from expenses WHERE expense_id=:expense_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':expense_id', $expense_id, PDO::PARAM_STR);
	execute_query($dbh, $query);

	$sql = "delete from cash_balance WHERE transaction_id=:expense_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':expense_id', $expense_id, PDO::PARAM_STR);
	execute_query($dbh, $query);

	$sql = "delete from general_ledger WHERE slip_id=:expense_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':expense_id', $expense_id, PDO::PARAM_STR);
	execute_query($dbh, $query);
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
				echo "<script type='text/javascript' language='Javascript'>setTimeout(function(){ location.replace('$common_form_route?frm=daily_expense_list')}, 100);</script>";
				echo "<script type='text/javascript' language='Javascript'>window.open('$common_form_route?frm=daily_expense_voucher&id=$transaction_id');</script>";
			} else {
				echo "<script> window.location.href = '$common_form_route?frm=daily_expense_list'; </script>";
			}
			break;

		case 'update':
			if (isset($_POST['invoice_print'])) {
				echo "<script type='text/javascript' language='Javascript'>setTimeout(function(){ location.replace('$common_form_route?frm=daily_expense_list')}, 100);</script>";
				echo "<script type='text/javascript' language='Javascript'>window.open('$common_form_route?frm=daily_expense_voucher&id=$transaction_id');</script>";
			} else {
				echo "<script> window.location.href = '$common_form_route?frm=daily_expense_list'; </script>";
			}
			break;

		case 'delete':
			echo "<script> window.location.href = '$common_form_route?frm=daily_expense_list'; </script>";
			break;

		default:
			echo "<script> window.location.href = '$common_form_route?frm=daily_expense_list'; </script>";
			break;
	}
}