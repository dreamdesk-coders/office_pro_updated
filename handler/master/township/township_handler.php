<?php 
session_start();

include("../../common/connection_config.php");
include("../../common/common_functions.php");

if(isset($_POST['action'])){

	$action = $_POST['action'];

	$login_id = $_SESSION['alogin'];
	$date = date("Y-m-d-h-i-s");
	$transaction_id = $_POST['township_id'];
	$transaction = "Township Master";
	$office_id = $_SESSION['office_id'];

	if($action == "create"){

		$township_id = $_POST['township_id'];
		$township_name = $_POST['township_name'];
		$created_date = date("Y-m-d-h-i-s");
		$updated_date = date("Y-m-d-h-i-s");

		$sql="INSERT INTO township(township_id,township_name,created_date,updated_date) VALUES(:township_id,:township_name,:created_date,:updated_date)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':township_id',$township_id,PDO::PARAM_STR);
		$query->bindParam(':township_name',$township_name,PDO::PARAM_STR);
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

		$township_id = $_POST['township_id'];
		$township_name = $_POST['township_name'];
		$updated_date = date("Y-m-d-h-i-s");

		$sql="update township set township_name=:township_name,updated_date=:updated_date where township_id=:township_id";

		$query = $dbh->prepare($sql);
		$query->bindParam(':township_id',$township_id,PDO::PARAM_STR);
		$query->bindParam(':township_name',$township_name,PDO::PARAM_STR);
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

		$township_id = $_POST['township_id'];

		$sql="delete from township WHERE township_id=:township_id";

		$query = $dbh->prepare($sql);
		$query->bindParam(':township_id',$township_id,PDO::PARAM_STR);

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

