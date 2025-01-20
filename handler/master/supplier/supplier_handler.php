<?php 
session_start();
include("../../common/connection_config.php");
include("../../common/common_functions.php");

if(isset($_POST['action'])){

	$action = $_POST['action'];

	$login_id = $_SESSION['alogin'];
	$date = date("Y-m-d-h-i-s");
	$transaction_id = $_POST['supplier_id'];
	$transaction = "Supplier Master";
	$office_id = $_SESSION['office_id'];

	if($action == "create"){

		$supplier_id = $_POST['supplier_id'];
		$supplier_name = $_POST['supplier_name'];
		$address = $_POST['address'];
		$ph_no = $_POST['ph_no'];
		$email = $_POST['email'];
		$remark = $_POST['remark'];
		$created_date = date("Y-m-d-h-i-s");
		$updated_date = date("Y-m-d-h-i-s");

		$sql="INSERT INTO supplier(supplier_id,supplier_name,address,phone_no,email,remark,created_date,updated_date) VALUES(:supplier_id,:supplier_name,:address,:ph_no,:email,:remark,:created_date,:updated_date)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':supplier_id',$supplier_id,PDO::PARAM_STR);
		$query->bindParam(':supplier_name',$supplier_name,PDO::PARAM_STR);
		$query->bindParam(':address',$address,PDO::PARAM_STR);
		$query->bindParam(':ph_no',$ph_no,PDO::PARAM_STR);
		$query->bindParam(':email',$email,PDO::PARAM_STR);
		$query->bindParam(':remark',$remark,PDO::PARAM_STR);
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

		
		$supplier_id = $_POST['supplier_id'];
		$supplier_name = $_POST['supplier_name'];
		$address = $_POST['address'];
		$ph_no = $_POST['ph_no'];
		$email = $_POST['email'];
		$remark = $_POST['remark'];
		$updated_date = date("Y-m-d-h-i-s");

$sql="update supplier set supplier_name=:supplier_name,address=:address ,phone_no=:ph_no,email=:email,remark=:remark, updated_date=:updated_date where supplier_id=:supplier_id";

		$query = $dbh->prepare($sql);

		$query->bindParam(':supplier_id',$supplier_id,PDO::PARAM_STR);
		$query->bindParam(':supplier_name',$supplier_name,PDO::PARAM_STR);
		$query->bindParam(':address',$address,PDO::PARAM_STR);
		$query->bindParam(':ph_no',$ph_no,PDO::PARAM_STR);
		$query->bindParam(':email',$email,PDO::PARAM_STR);
		$query->bindParam(':remark',$remark,PDO::PARAM_STR);
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

		$supplier_id = $_POST['supplier_id'];

		$sql="delete from supplier WHERE supplier_id=:supplier_id";

		$query = $dbh->prepare($sql);
		$query->bindParam(':supplier_id',$supplier_id,PDO::PARAM_STR);

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

