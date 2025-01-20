<?php

	include("connection_config.php");
	$table = $_POST['table'];
	$parent_id = $_POST['parent_id'];
	$used_parent_id = $_POST['used_parent_id'];
	$child_id = $_POST['child_id'];
	$used_child_id = $_POST['used_child_id'];

	$sql = "Select * From $table where $parent_id=:used_parent_id and $child_id=:used_child_id";
	$query = $dbh -> prepare($sql);
	$query->bindParam(':used_parent_id',$used_parent_id,PDO::PARAM_STR);
	$query->bindParam(':used_child_id',$used_child_id,PDO::PARAM_STR);

	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);

	$count = $query->rowCount();

		if($count > 0){
			echo json_encode(array("statusCode"=>200));
		}
		else{
			echo json_encode(array("statusCode"=>201));
		}


?>