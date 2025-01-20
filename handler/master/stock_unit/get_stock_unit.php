

<table class="table table-striped" id="stock_unit_list">
	<thead>
		 <tr>
			<th scope="col" class="print">No</th>
			<th scope="col" class="print">Stock Unit ID</th>
			<th scope="col" class="print">Unit ID</th>
			<th scope="col" class="print">Stock ID</th>
			<th scope="col" class="print">Quantity</th>
			<th scope="col" class="print">Purchase Price</th>
			<th scope="col" class="print">Sale Price</th>
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
	$sql = "Select * From stock_unit where stock_unit_id between :min and :max order by stock_unit_id asc";
	$query = $dbh -> prepare($sql);
	$query->bindParam(':min',$min,PDO::PARAM_STR);
	$query->bindParam(':max',$max,PDO::PARAM_STR);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$count = 1;
}else{
	$sql = "Select * From stock_unit order by stock_unit_id asc";
	$query = $dbh -> prepare($sql);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$count = 1;
}

		foreach($results as $result){
			$stock_unit_id = $result->stock_unit_id;
			$unit_id = $result->unit_id;
			$stock_id = $result->stock_id;
			$quantity = $result->qty;
			$purchase_price = $result->purchase_price;
			$sale_price= $result->sale_price;

			?>
		<tr>
			<td><?php echo $count ?></td>
			<td><?php echo htmlentities($stock_unit_id);?></td>
			<td><?php echo htmlentities($unit_id);?></td>
			<td><?php echo htmlentities($stock_id);?></td>
			<td><?php echo htmlentities($quantity);?></td>
			<td><?php echo htmlentities($purchase_price);?></td>
			<td><?php echo htmlentities($sale_price);?></td>
			<td><button class="btn btn-primary" onclick="update_datafill('<?php echo addslashes(htmlentities($stock_unit_id)) ?>','<?php echo addslashes(htmlentities($unit_id)) ?>','<?php echo addslashes(htmlentities($stock_id)) ?>','<?php echo addslashes(htmlentities($quantity)) ?>','<?php echo addslashes(htmlentities($purchase_price)) ?>','<?php echo addslashes(htmlentities($sale_price)) ?>')">Edit</button></td>
			<td><button class="btn btn-danger" onclick="delete_stock_unit('<?php echo addslashes(htmlentities($stock_unit_id)) ?>')">Delete</button></td>
		</tr>

<?php 

$count =  $count + 1;

} ?>

  