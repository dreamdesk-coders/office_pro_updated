<?php 
session_start();
include("../../common/connection_config.php");
include("../../common/common_functions.php");

if(isset($_POST['action'])){

	$action = $_POST['action'];

	$login_id = $_SESSION['alogin'];
	$date = date("Y-m-d-h-i-s");
	$transaction_id = $_POST['staff_id'];
	$transaction = "Staff Master";
	$office_id = $_SESSION['office_id'];

	if($action == "create"){

		$staff_id = $_POST['staff_id'];
		$staff_name = $_POST['staff_name'];
		$dob = $_POST['dob'];
		$father_name = $_POST['father_name'];
		$nrc = $_POST['nrc'];
		$position = $_POST['position'];
		$gender = $_POST['gender'];
		$ph_no = $_POST['ph_no'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		$created_date = date("Y-m-d-h-i-s");
		$updated_date = date("Y-m-d-h-i-s");
		$sql="INSERT INTO staff(staff_id,staff_name,birthday,father_name,nrc_no,position,gender,phone_no,email,address,created_date,updated_date) VALUES(:staff_id,:staff_name,:dob,:father_name,:nrc,:position,:gender,:ph_no,:email,:address,:created_date,:updated_date)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':staff_id',$staff_id,PDO::PARAM_STR);
		$query->bindParam(':staff_name',$staff_name,PDO::PARAM_STR);
		$query->bindParam(':dob',$dob,PDO::PARAM_STR);
		$query->bindParam(':father_name',$father_name,PDO::PARAM_STR);
		$query->bindParam(':nrc',$nrc,PDO::PARAM_STR);
		$query->bindParam(':position',$position,PDO::PARAM_STR);
		$query->bindParam(':gender',$gender,PDO::PARAM_STR);
		$query->bindParam(':ph_no',$ph_no,PDO::PARAM_STR);
		$query->bindParam(':email',$email,PDO::PARAM_STR);
		$query->bindParam(':address',$address,PDO::PARAM_STR);

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

		$staff_id = $_POST['staff_id'];
		$staff_name = $_POST['staff_name'];
		$dob = $_POST['dob'];
		$father_name = $_POST['father_name'];
		$nrc = $_POST['nrc'];
		$position = $_POST['position'];
		$gender = $_POST['gender'];
		$ph_no = $_POST['ph_no'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		$updated_date = date("Y-m-d-h-i-s");

$sql="update staff set staff_name=:staff_name,birthday=:dob,father_name=:father_name,nrc_no=:nrc, position=:position, gender=:gender,phone_no=:ph_no,email=:email,address=:address, updated_date=:updated_date where staff_id=:staff_id";

		$query = $dbh->prepare($sql);

		$query->bindParam(':staff_id',$staff_id,PDO::PARAM_STR);
		$query->bindParam(':staff_name',$staff_name,PDO::PARAM_STR);
		$query->bindParam(':dob',$dob,PDO::PARAM_STR);
		$query->bindParam(':father_name',$father_name,PDO::PARAM_STR);
		$query->bindParam(':nrc',$nrc,PDO::PARAM_STR);
		$query->bindParam(':position',$position,PDO::PARAM_STR);
		$query->bindParam(':gender',$gender,PDO::PARAM_STR);
		$query->bindParam(':ph_no',$ph_no,PDO::PARAM_STR);
		$query->bindParam(':email',$email,PDO::PARAM_STR);
		$query->bindParam(':address',$address,PDO::PARAM_STR);
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

		$staff_id = $_POST['staff_id'];

		$sql="delete from staff WHERE staff_id=:staff_id";

		$query = $dbh->prepare($sql);
		$query->bindParam(':staff_id',$staff_id,PDO::PARAM_STR);

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

