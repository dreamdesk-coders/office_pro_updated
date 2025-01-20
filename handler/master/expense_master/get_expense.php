

<table class="table table-striped" id="expense_list">
	<thead>
		 <tr>
			<th scope="col" class="print">No</th>
			<th scope="col" class="print">Expense Master ID</th>
			<th scope="col" class="print">Description</th>
			<th scope="col">Edit</th>
			<th scope="col">Delete</th>
		</tr>
	</thead>
	<tbody id="table">
<?php 

include("../../common/connection_config.php");

if(isset($_POST['min']) and isset($_POST['max'])){
	$min = $_POST['min'];
	$max = $_POST['max'];
	$sql = "Select * From expense_master where expense_id between :min and :max order by expense_id asc";
	$query = $dbh -> prepare($sql);
	$query->bindParam(':min',$min,PDO::PARAM_STR);
	$query->bindParam(':max',$max,PDO::PARAM_STR);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$count = 1;
}else{
	$sql = "Select * From expense_master order by expense_id asc";
	$query = $dbh -> prepare($sql);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$count = 1;
}


		foreach($results as $result){

			$expense_id = $result->expense_id;
			$desc = $result->description;

			?>
		<tr>
			<td><?php echo $count ?></td>
			<td><?php echo htmlentities($expense_id);?></td>
			<td><?php echo htmlentities($desc);?></td>
			<td><button class="btn btn-primary" onclick="update_datafill('<?php echo addslashes(htmlentities($expense_id)) ?>','<?php echo addslashes(htmlentities($desc)) ?>')">Edit</button></td>
			<td><button class="btn btn-danger" onclick="delete_expense('<?php echo addslashes(htmlentities($expense_id)) ?>')">Delete</button></td>
		</tr>

<?php 

$count =  $count + 1;

} ?>

  