<?php 
session_start();

include("../../common/connection_config.php");
include("../../common/common_functions.php");

if(isset($_POST['action'])){

	$action = $_POST['action'];

	$login_id = $_SESSION['alogin'];
	$date = date("Y-m-d-h-i-s");
	$transaction_id = $_POST['customer_id'];
	$transaction = "Customer Master";
	$office_id = $_SESSION['office_id'];

	if($action == "create"){

		$customer_id = $_POST['customer_id'];
		$customer_name = $_POST['customer_name'];
		$address = $_POST['address'];
		$ph_no = $_POST['ph_no'];
		$email = $_POST['email'];
		$remark = $_POST['remark'];
		$created_date = date("Y-m-d-h-i-s");
		$updated_date = date("Y-m-d-h-i-s");

		$sql="INSERT INTO customer(customer_id,customer_name,address,phone_no,email,remark,created_date,updated_date) VALUES(:customer_id,:customer_name,:address,:ph_no,:email,:remark,:created_date,:updated_date)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':customer_id',$customer_id,PDO::PARAM_STR);
		$query->bindParam(':customer_name',$customer_name,PDO::PARAM_STR);
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

		
		$customer_id = $_POST['customer_id'];
		$customer_name = $_POST['customer_name'];
		$address = $_POST['address'];
		$ph_no = $_POST['ph_no'];
		$email = $_POST['email'];
		$remark = $_POST['remark'];
		$updated_date = date("Y-m-d-h-i-s");

$sql="update customer set customer_name=:customer_name,address=:address ,phone_no=:ph_no,email=:email,remark=:remark, updated_date=:updated_date where customer_id=:customer_id";

		$query = $dbh->prepare($sql);

		$query->bindParam(':customer_id',$customer_id,PDO::PARAM_STR);
		$query->bindParam(':customer_name',$customer_name,PDO::PARAM_STR);
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

		$customer_id = $_POST['customer_id'];

		$sql="delete from customer WHERE customer_id=:customer_id";

		$query = $dbh->prepare($sql);
		$query->bindParam(':customer_id',$customer_id,PDO::PARAM_STR);

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

