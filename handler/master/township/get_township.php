
<table class="table table-striped" id="township_list">
	<thead>
		<tr>
			<th scope="col">No</th>
				<th scope="col" class="print">Township ID</th>
				<th scope="col" class="print">Township Name</th>
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
	$sql = "Select * From township where township_id between :min and :max order by township_id asc";
	$query = $dbh -> prepare($sql);
	$query->bindParam(':min',$min,PDO::PARAM_STR);
	$query->bindParam(':max',$max,PDO::PARAM_STR);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$count = 1;
}else{
	$sql = "Select * From township order by township_id asc";
	$query = $dbh -> prepare($sql);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$count = 1;
}

		foreach($results as $result){

			$township_id = $result->township_id;
			$township_name = $result->township_name;

			?>
		<tr>
			<td><?php echo $count ?></td>
			<td><?php echo htmlentities($township_id);?></td>
			<td><?php echo htmlentities($township_name);?></td>
			<td><button class="btn btn-primary" onclick="update_datafill('<?php echo addslashes(htmlentities($township_id)) ?>','<?php echo addslashes(htmlentities($township_name)) ?>')">Edit</button></td>
			<td><button class="btn btn-danger" onclick="delete_township('<?php echo addslashes(htmlentities($township_id)) ?>')">Delete</button></td>
		</tr>

<?php 

$count =  $count + 1;

} ?>

  