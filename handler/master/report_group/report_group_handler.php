<?php 
session_start();

include("../../common/connection_config.php");
include("../../common/common_functions.php");


if(isset($_POST['action'])){

	$action = $_POST['action'];

	$login_id = $_SESSION['alogin'];
	$date = date("Y-m-d-h-i-s");
	$transaction_id = $_POST['rg_id'];
	$transaction = "Report Group Master";
	$office_id = $_SESSION['office_id'];

	if($action == "create"){

		$rg_id = $_POST['rg_id'];
		$description = $_POST['description'];
		$created_date = date("Y-m-d-h-i-s");
		$updated_date = date("Y-m-d-h-i-s");

		$sql="INSERT INTO report_group(rg_id,description,created_date,updated_date) VALUES(:rg_id,:description,:created_date,:updated_date)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':rg_id',$rg_id,PDO::PARAM_STR);
		$query->bindParam(':description',$description,PDO::PARAM_STR);
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

		$rg_id = $_POST['rg_id'];
		$description = $_POST['description'];
		$updated_date = date("Y-m-d-h-i-s");

		$sql="update report_group set description=:description,updated_date=:updated_date where rg_id=:rg_id";

		$query = $dbh->prepare($sql);
		$query->bindParam(':rg_id',$rg_id,PDO::PARAM_STR);
		$query->bindParam(':description',$description,PDO::PARAM_STR);
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

		$rg_id = $_POST['rg_id'];

		$sql="delete from report_group WHERE rg_id=:rg_id";

		$query = $dbh->prepare($sql);
		$query->bindParam(':rg_id',$rg_id,PDO::PARAM_STR);

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

