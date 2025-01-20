<?php 
	session_start();

	include("../../common/connection_config.php");
	include("../../common/common_functions.php");

if(isset($_POST['action'])){

	$action = $_POST['action'];

	$login_id_ = $_SESSION['alogin'];
	$date = date("Y-m-d-h-i-s");
	$transaction_id = $_POST['login_id'];
	$transaction = "User Master";
	$office_id = $_SESSION['office_id'];

	if($action == "create"){

		$login_id = $_POST['login_id'];
		$office_id = $_POST['office_id'];
		$password = $_POST['password'];
		$enc_pass = md5($password);
		$role = $_POST['role'];
		$created_date = date("Y-m-d-h-i-s");
		$updated_date = date("Y-m-d-h-i-s");

		$sql="INSERT INTO app_user(login_id, office_id, password, login_role, created_date, updated_date) VALUES(:login_id,:office_id,:enc_pass,:role, :created_date,:updated_date)";

		$query = $dbh_master->prepare($sql);
		$query->bindParam(':login_id',$login_id,PDO::PARAM_STR);
		$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
		$query->bindParam(':enc_pass',$enc_pass,PDO::PARAM_STR);
		$query->bindParam(':role',$role,PDO::PARAM_STR);
		$query->bindParam(':created_date',$created_date,PDO::PARAM_STR);
		$query->bindParam(':updated_date',$updated_date,PDO::PARAM_STR);

		execute_query($dbh_master,$query);

		$sql="INSERT INTO transaction_log(login_id,date,transaction_id,transaction,action,office_id) VALUES(:login_id_,:date,:transaction_id,:transaction,:action,:office_id)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':login_id_',$login_id_,PDO::PARAM_STR);
		$query->bindParam(':date',$date,PDO::PARAM_STR);
		$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
		$query->bindParam(':transaction',$transaction,PDO::PARAM_STR);
		$query->bindParam(':action',$action,PDO::PARAM_STR);
		$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);

		$query->execute();

	}

	elseif($action == "update"){

		$login_id = $_POST['login_id'];
		$office_id = $_POST['office_id'];
		$old_password = $_POST['old_password'];
		$new_password = $_POST['new_password'];
		$role = $_POST['role'];
		$updated_date = date("Y-m-d-h-i-s");

		if($old_password == ""){
			$sql="update app_user set office_id=:office_id,login_role=:role,updated_date=:updated_date where login_id=:login_id";


		$query = $dbh_master->prepare($sql);
		$query->bindParam(':login_id',$login_id,PDO::PARAM_STR);
		$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
		$query->bindParam(':role',$role,PDO::PARAM_STR);
		$query->bindParam(':updated_date',$updated_date,PDO::PARAM_STR);

		execute_query($dbh_master,$query);

		$sql="INSERT INTO transaction_log(login_id,date,transaction_id,transaction,action,office_id) VALUES(:login_id_,:date,:transaction_id,:transaction,:action,:office_id)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':login_id_',$login_id_,PDO::PARAM_STR);
		$query->bindParam(':date',$date,PDO::PARAM_STR);
		$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
		$query->bindParam(':transaction',$transaction,PDO::PARAM_STR);
		$query->bindParam(':action',$action,PDO::PARAM_STR);
		$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);

		$query->execute();

		}
		else{

			$enc_old_password = md5($old_password);

			$sql = "Select * From app_user where login_id=:login_id";
			$query = $dbh -> prepare($sql);
			$query->bindParam(':login_id',$login_id,PDO::PARAM_STR);
			$query->execute();
			$results=$query->fetchAll(PDO::FETCH_OBJ);

			foreach($results as $result){

				$db_pass = $result->password;
			}	

			if($db_pass == $enc_old_password){
				$enc_new_password = md5($new_password);
				$sql="update app_user set office_id=:office_id,password=:enc_new_password,login_role=:role,updated_date=:updated_date where login_id=:login_id";

				$query = $dbh_master->prepare($sql);
				$query->bindParam(':login_id',$login_id,PDO::PARAM_STR);
				$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
				$query->bindParam(':enc_new_password',$enc_new_password,PDO::PARAM_STR);
				$query->bindParam(':role',$role,PDO::PARAM_STR);
				$query->bindParam(':updated_date',$updated_date,PDO::PARAM_STR);

				execute_query($dbh_master,$query);

				$sql="INSERT INTO transaction_log(login_id,date,transaction_id,transaction,action,office_id) VALUES(:login_id_,:date,:transaction_id,:transaction,:action,:office_id)";

				$query = $dbh->prepare($sql);
				$query->bindParam(':login_id_',$login_id_,PDO::PARAM_STR);
				$query->bindParam(':date',$date,PDO::PARAM_STR);
				$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
				$query->bindParam(':transaction',$transaction,PDO::PARAM_STR);
				$query->bindParam(':action',$action,PDO::PARAM_STR);
				$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);

				$query->execute();
			}
			else{
				echo json_encode(array("statusCode"=>400));
			}

		}

	}

	elseif($action == "delete"){

		$login_id = $_POST['login_id'];

		$sql="delete from app_user WHERE login_id=:login_id";

		$query = $dbh_master->prepare($sql);
		$query->bindParam(':login_id',$login_id,PDO::PARAM_STR);

		execute_query($dbh_master,$query);

		$sql="INSERT INTO transaction_log(login_id,date,transaction_id,transaction,action,office_id) VALUES(:login_id_,:date,:transaction_id,:transaction,:action,:office_id)";

		$query = $dbh->prepare($sql);
		$query->bindParam(':login_id_',$login_id_,PDO::PARAM_STR);
		$query->bindParam(':date',$date,PDO::PARAM_STR);
		$query->bindParam(':transaction_id',$transaction_id,PDO::PARAM_STR);
		$query->bindParam(':transaction',$transaction,PDO::PARAM_STR);
		$query->bindParam(':action',$action,PDO::PARAM_STR);
		$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);

		$query->execute();

	}
}

