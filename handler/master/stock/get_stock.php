
<table class="table table-striped" id="stock_list">
	<thead>
		<tr>
			<th scope="col" class="print">No</th>
			<th scope="col"  class="print">Stock ID</th>
			<th scope="col"  class="print">Stock Name</th>
			<th scope="col"  class="print">Stocking Unit ID</th>
			<th scope="col"  class="print">Category ID</th>
			<th scope="col"  class="print">Report Group ID</th>
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
	$sql = "Select * From stock where stock_id between :min and :max order by stock_id asc";
	$query = $dbh -> prepare($sql);
	$query->bindParam(':min',$min,PDO::PARAM_STR);
	$query->bindParam(':max',$max,PDO::PARAM_STR);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$count = 1;
}else{
	$sql = "Select * From stock order by stock_id asc";
	$query = $dbh -> prepare($sql);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$count = 1;
}


		foreach($results as $result){

			$stock_id = $result->stock_id;
			$stock_name = $result->stock_name;
			$stocking_unit_id = $result->stocking_unit_id;
			$category_id = $result->category_id;
			$rg_id = $result->rg_id;

			?>
		<tr>
			<td><?php echo $count ?></td>
			<td><?php echo htmlentities($stock_id);?></td>
			<td><?php echo htmlentities($stock_name);?></td>
			<td><?php echo htmlentities($stocking_unit_id);?></td>
			<td><?php echo htmlentities($category_id);?></td>
			<td><?php echo htmlentities($rg_id);?></td>
			<td><button class="btn btn-primary" data-toggle="modal" data-target="#myModal1" onclick="update_datafill('<?php echo addslashes(htmlentities($stock_id)) ?>','<?php echo addslashes(htmlentities($stock_name)) ?>','<?php echo addslashes(htmlentities($stocking_unit_id)) ?>','<?php echo addslashes(htmlentities($category_id)) ?>','<?php echo addslashes(htmlentities($rg_id)) ?>')">Edit</button></td>
			<td><button class="btn btn-danger" onclick="delete_stock('<?php echo addslashes(htmlentities($stock_id)) ?>')">Delete</button></td>
		</tr>

<?php 

$count =  $count + 1;

} ?>

  