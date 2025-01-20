<?php 
session_start();
error_reporting(0);
include("connection_config.php");

$login_id = $_SESSION['alogin'];
$office_id = $_SESSION['office_id'];

$sql = "SELECT * FROM `notifications` WHERE noti_id not in (SELECT noti_id FROM notifications_read WHERE login_id =:login_id) and noti_to =:office_id";
$query = $dbh -> prepare($sql);
// $query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
$query->bindParam(':login_id',$login_id,PDO::PARAM_STR);
$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
$query->execute();

$count = $query->rowcount();
		
		if($count > 0 && $count <= 9){
			echo "$count";
		}
		elseif($count === 0){
			echo "";
		}
		elseif($count > 9){
			echo "9+";
		}
		

		