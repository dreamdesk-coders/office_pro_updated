<?php

	include("connection_config.php");
	$table = $_POST['table'];
	$id = $_POST['id'];
	$req_value = $_POST['req_value'];


	$sql = "Select * From $table where $id=:req_value";
	$query = $dbh -> prepare($sql);
	$query->bindParam(':req_value',$req_value,PDO::PARAM_STR);

	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);

	$count = $query->rowCount();

		if($count > 0){
			echo json_encode(array("data"=>1));
		}
		else{
			echo json_encode(array("data"=>0));
		}


?>