<?php 
session_start();

include("../../common/connection_config.php");
include("../../common/common_functions.php");


if(isset($_POST['action'])){

	$action = $_POST['action'];

	$login_id = $_SESSION['alogin'];
	$date = date("Y-m-d-h-i-s");
	$transaction_id = $_POST['category_id'];
	$transaction = "Category Master";
	$office_id = $_SESSION['office_id'];

	if($action == "create"){

		$category_id = $_POST['category_id'];
		$category_name = $_POST['category_name'];
		$created_date = date("Y-m-d-h-i-s");
		$updated_date = date("Y-m-d-h-i-s");

		$sql="INSERT INTO category(category_id,category_name,created_date,updated_date) VALUES(:category_id,:category_name,:created_date,:updated_date)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':category_id',$category_id,PDO::PARAM_STR);
		$query->bindParam(':category_name',$category_name,PDO::PARAM_STR);
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

		$category_id = $_POST['category_id'];
		$category_name = $_POST['category_name'];
		$updated_date = date("Y-m-d-h-i-s");

		$sql="update category set category_name=:category_name,updated_date=:updated_date where category_id=:category_id";

		$query = $dbh->prepare($sql);
		$query->bindParam(':category_id',$category_id,PDO::PARAM_STR);
		$query->bindParam(':category_name',$category_name,PDO::PARAM_STR);
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

		$category_id = $_POST['category_id'];

		$sql="delete from category WHERE category_id=:category_id";

		$query = $dbh->prepare($sql);
		$query->bindParam(':category_id',$category_id,PDO::PARAM_STR);

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

