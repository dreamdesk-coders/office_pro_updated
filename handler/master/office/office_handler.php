<?php 
session_start();

include("../../common/connection_config.php");
include("../../common/common_functions.php");

if(isset($_POST['action'])){

	$action = $_POST['action'];

	$login_id = $_SESSION['alogin'];
	$date = date("Y-m-d-h-i-s");
	$transaction_id = $_POST['office_id'];
	$transaction = "Office Master";
	$office_id = $_SESSION['office_id'];

	if($action == "create"){

		$office_id = $_POST['office_id'];
		$office_name = $_POST['office_name'];
		$admin = $_POST['admin'];
		$color = $_POST['color'];
		$address = $_POST['address'];
		$created_date = date("Y-m-d-h-i-s");
		$updated_date = date("Y-m-d-h-i-s");

		$sql="INSERT INTO office(office_id,office_name,admin,color,address,created_date,updated_date) VALUES(:office_id,:office_name,:admin,:color,:address,:created_date,:updated_date)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
		$query->bindParam(':office_name',$office_name,PDO::PARAM_STR);
		$query->bindParam(':admin',$admin,PDO::PARAM_STR);
		$query->bindParam(':color',$color,PDO::PARAM_STR);
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

		/* Create New Notification */

		$title = "New Office Created";
		$noti_from = "Office Pro";
		$noti_to = $_SESSION['office_id'];
		$description = "New office have been successfully created on". " " . $date . ".";
		$type = "all";

		$sql="INSERT INTO notifications(title,noti_from,noti_to,description,date,type) VALUES(:title,:noti_from,:noti_to,:description,:date,:type)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':title',$title,PDO::PARAM_STR);
		$query->bindParam(':noti_from',$noti_from,PDO::PARAM_STR);
		$query->bindParam(':noti_to',$noti_to,PDO::PARAM_STR);
		$query->bindParam(':description',$description,PDO::PARAM_STR);
		$query->bindParam(':date',$date,PDO::PARAM_STR);
		$query->bindParam(':type',$type,PDO::PARAM_STR);

		$query->execute();














	}

	elseif($action == "update"){

		$office_id = $_POST['office_id'];
		$office_name = $_POST['office_name'];
		$admin = $_POST['admin'];
		$color = $_POST['color'];
		$address = $_POST['address'];
		$updated_date = date("Y-m-d-h-i-s");

		$sql="update office set office_name=:office_name,admin=:admin,color=:color,address=:address,updated_date=:updated_date where office_id=:office_id";

		$query = $dbh->prepare($sql);
		$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
		$query->bindParam(':office_name',$office_name,PDO::PARAM_STR);
		$query->bindParam(':admin',$admin,PDO::PARAM_STR);
		$query->bindParam(':color',$color,PDO::PARAM_STR);
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

		$office_id = $_POST['office_id'];

		$sql="delete from office WHERE office_id=:office_id";

		$query = $dbh->prepare($sql);
		$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);

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

