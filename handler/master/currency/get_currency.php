
<table class="table table-striped" id="currency_list">
	<thead>
		<tr>
			<th scope="col">No</th>
				<th scope="col" class="print">Currency ID</th>
				<th scope="col" class="print">Currency Name</th>
				<th scope="col">Edit</th>
				<th scope="col">Delete</th>
			</tr>
	</thead>
	<tbody>
<?php 

include("../../common/connection_config.php");

if(isset($_POST['min']) and isset($_POST['max'])){
	$min = $_POST['min'];
	$max = $_POST['max'];
	$sql = "Select * From currency where currency_id between :min and :max order by currency_id asc";
	$query = $dbh -> prepare($sql);
	$query->bindParam(':min',$min,PDO::PARAM_STR);
	$query->bindParam(':max',$max,PDO::PARAM_STR);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$count = 1;
}else{
	$sql = "Select * From currency order by currency_id asc";
	$query = $dbh -> prepare($sql);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$count = 1;
}

		foreach($results as $result){

			$currency_id = $result->currency_id;
			$currency_name = $result->currency_name;

			?>
		<tr>
			<td><?php echo $count ?></td>
			<td><?php echo htmlentities($currency_id);?></td>
			<td><?php echo htmlentities($currency_name);?></td>
			<td><button class="btn btn-primary" onclick="update_datafill('<?php echo addslashes(htmlentities($currency_id)) ?>','<?php echo addslashes(htmlentities($currency_name)) ?>')">Edit</button></td>
			<td><button class="btn btn-danger" onclick="delete_currency('<?php echo addslashes(htmlentities($currency_id)) ?>')">Delete</button></td>
		</tr>

<?php 

$count =  $count + 1;

} ?>

  