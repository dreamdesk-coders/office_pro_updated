<table class="table table-striped" id="report_group_list">
	<thead>
		<tr>
			<th scope="col" class="print">No</th>
			<th scope="col" class="print">Report Group ID</th>
			<th scope="col" class="print">Description</th>
			<th scope="col">Edit</th>
			<th scope="col">Delete</th>
		</tr>
	</thead>
	<tbody id="report-group-table">
<?php 

include("../../common/connection_config.php");

if(isset($_POST['min']) and isset($_POST['max'])){
	$min = $_POST['min'];
	$max = $_POST['max'];
	$sql = "Select * From report_group where rg_id between :min and :max order by rg_id asc";
	$query = $dbh -> prepare($sql);
	$query->bindParam(':min',$min,PDO::PARAM_STR);
	$query->bindParam(':max',$max,PDO::PARAM_STR);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$count = 1;
}else{
	$sql = "Select * From report_group order by rg_id asc";
	$query = $dbh -> prepare($sql);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$count = 1;
}

		foreach($results as $result){

			$rg_id = $result->rg_id;
			$description = $result->description;

			?>
		<tr>
			<td><?php echo $count ?></td>
			<td><?php echo htmlentities($rg_id);?></td>
			<td><?php echo htmlentities($description);?></td>
			<td><button class="btn btn-primary" data-toggle="modal" data-target="#myModal1" onclick="update_datafill('<?php echo addslashes(htmlentities($rg_id)) ?>','<?php echo addslashes(htmlentities($description)) ?>')">Edit</button></td>
			<td><button class="btn btn-danger" onclick="delete_report_group('<?php echo addslashes(htmlentities($rg_id)) ?>')">Delete</button></td>
		</tr>

<?php 

$count =  $count + 1;

} ?>

  