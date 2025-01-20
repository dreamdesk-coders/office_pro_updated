<?php 



function create_notification($title,$description,$noti_date,$notify_to){
	
	$sql="INSERT INTO notification(notification_id,title,description,noti_date,notify_to) VALUES(:login_id,:date,:transaction_id,:type,:action,:office_id)";

	$query = $dbh->prepare($sql);
	$query->bindParam(':title',$title,PDO::PARAM_STR);
	$query->bindParam(':description',$description,PDO::PARAM_STR);
	$query->bindParam(':noti_date',$noti_date,PDO::PARAM_STR);
	$query->bindParam(':notify_to',$notify_to,PDO::PARAM_STR);
	execute_query($dbh,$query);

	
}

function execute_query($dbh,$query){

		$dbh->beginTransaction();
		try {
			if ($query->execute())
			{
			  echo json_encode(array("statusCode"=>200));
			  $_SESSION['save_status'] = "1";
			}
			else
			{
			  echo json_encode(array("statusCode"=>201));
			  $_SESSION['save_status'] = "0";
			}
		} catch(Throwable $e) {

		    $dbh->rollBack();
		    throw $e;

		}
		
		$dbh->commit();

	}




