<table class="table table-striped" id="measurement_list">
	<thead>
		<tr>
			<th scope="col" class="print">No</th>
			<th scope="col" class="print">Measurement ID</th>
			<th scope="col" class="print">Description</th>
			<th scope="col">Edit</th>
			<th scope="col">Delete</th>
		</tr>
	</thead>
	<tbody id="measurement-table">
<?php 

include("../../common/connection_config.php");

if(isset($_POST['min']) and isset($_POST['max'])){
	$min = $_POST['min'];
	$max = $_POST['max'];
	$sql = "Select * From units_of_measurement where unit_id between :min and :max order by unit_id asc";
	$query = $dbh -> prepare($sql);
	$query->bindParam(':min',$min,PDO::PARAM_STR);
	$query->bindParam(':max',$max,PDO::PARAM_STR);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$count = 1;
}else{
	$sql = "Select * From units_of_measurement order by unit_id asc";
	$query = $dbh -> prepare($sql);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$count = 1;
}

		foreach($results as $result){

			$unit_id = $result->unit_id;
			$description = $result->description;

			?>
		<tr>
			<td><?php echo $count ?></td>
			<td><?php echo htmlentities($unit_id);?></td>
			<td><?php echo htmlentities($description);?></td>
			<td><button class="btn btn-primary" data-toggle="modal" data-target="#myModal1" onclick="update_datafill('<?php echo addslashes(htmlentities($unit_id)) ?>','<?php echo addslashes(htmlentities($description)) ?>')">Edit</button></td>
			<td><button class="btn btn-danger" onclick="delete_measurement('<?php echo addslashes(htmlentities($unit_id)) ?>')">Delete</button></td>
		</tr>

<?php 

$count =  $count + 1;

} ?>

  