<table class="table table-striped" id="category_list">
	<thead>
		<tr>
			<th scope="col" class="print">No</th>
			<th scope="col" class="print">Category ID</th>
			<th scope="col" class="print">Category Name</th>
			<th scope="col">Edit</th>
			<th scope="col">Delete</th>
		</tr>
	</thead>
	<tbody id="category-table">
<?php 

include("../../common/connection_config.php");

if(isset($_POST['min']) and isset($_POST['max'])){
	$min = $_POST['min'];
	$max = $_POST['max'];
	$sql = "Select * From category where category_id between :min and :max order by category_id asc";
	$query = $dbh -> prepare($sql);
	$query->bindParam(':min',$min,PDO::PARAM_STR);
	$query->bindParam(':max',$max,PDO::PARAM_STR);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$count = 1;
}else{
	$sql = "Select * From category order by category_id asc";
	$query = $dbh -> prepare($sql);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$count = 1;
}

		foreach($results as $result){

			$category_id = $result->category_id;
			$category_name = $result->category_name;

			?>
		<tr>
			<td><?php echo $count ?></td>
			<td><?php echo htmlentities($category_id);?></td>
			<td><?php echo htmlentities($category_name);?></td>
			<td><button class="btn btn-primary" data-toggle="modal" data-target="#myModal1" onclick="update_datafill('<?php echo addslashes(htmlentities($category_id)) ?>','<?php echo addslashes(htmlentities($category_name)) ?>')">Edit</button></td>
			<td><button class="btn btn-danger" onclick="delete_category('<?php echo addslashes(htmlentities($category_id)) ?>')">Delete</button></td>
		</tr>

<?php 

$count =  $count + 1;

} ?>

  