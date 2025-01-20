
<?php

	include("connection_config.php");
	$table = $_POST['table'];
	$id = $_POST['id'];
	$req_input = $_POST['req_input'];

	$sql = "Select * From $table where $id=:req_input";
	$query = $dbh -> prepare($sql);
	$query->bindParam(':req_input',$req_input,PDO::PARAM_STR);
	$query->execute();
	$result=$query->fetch(PDO::FETCH_OBJ);

	$count = $query->rowCount();

	// $did = $result->$id;

	if($count > 0){

		switch ($table) {
			case 'staff':
			echo json_encode(array("statusCode"=>200,"desc"=>$result->staff_name));
			break;

		case 'currency':
			echo json_encode(array("statusCode"=>200,"desc"=>$result->currency_name));
			break;

		case 'supplier':
			echo json_encode(array("statusCode"=>200,"desc"=>$result->supplier_name));
			break;

		case 'customer':
			echo json_encode(array("statusCode"=>200,"desc"=>$result->customer_name));
			break;

		case 'stock':
			echo json_encode(array("statusCode"=>200,"desc"=>$result->stock_name));
			break;

		case 'office':
			echo json_encode(array("statusCode"=>200,"desc"=>$result->office_name));
			break;

		case 'expense_master':
				echo json_encode(array("statusCode"=>200,"desc"=>$result->description));
				break;

		default:
			echo json_encode(array("statusCode"=>200,"desc"=>''));
			break;
		}
					
	}
	else{
		echo json_encode(array("statusCode"=>201));
	}


	// echo json_encode(array("statusCode"=>200));


	


?>