
<table class="table table-striped" id="customer_list">
	<thead>
		<tr>
			<th scope="col" class="print">No</th>
			<th scope="col"  class="print">Customer ID</th>
			<th scope="col"  class="print">Customer Name</th>
			<th scope="col"  class="print">Address</th>
			<th scope="col"  class="print">Phone</th>
			<th scope="col"  class="print">Email</th>
			<th scope="col"  class="print">Remark</th>
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
	$sql = "Select * From customer where customer_id between :min and :max order by customer_id asc";
	$query = $dbh -> prepare($sql);
	$query->bindParam(':min',$min,PDO::PARAM_STR);
	$query->bindParam(':max',$max,PDO::PARAM_STR);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$count = 1;
}else{
	$sql = "Select * From customer order by customer_id asc";
	$query = $dbh -> prepare($sql);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$count = 1;
}


		foreach($results as $result){

			$customer_id = $result->customer_id;
			$customer_name = $result->customer_name;
			$address = $result->address;
			$address = trim(preg_replace('/\s+/', ' ', $address));
			$phone_no = $result->phone_no;
			$email = $result->email;
			$remark = $result->remark;
			$remark = trim(preg_replace('/\s+/', ' ', $remark));

			?>
		<tr>
			<td><?php echo $count ?></td>
			<td><?php echo htmlentities($customer_id);?></td>
			<td><?php echo htmlentities($customer_name);?></td>
			<td><?php echo htmlentities($address);?></td>
			<td><?php echo htmlentities($phone_no);?></td>
			<td><?php echo htmlentities($email);?></td>
			<td><?php echo htmlentities($remark);?></td>
			<td><button class="btn btn-primary" data-toggle="modal" data-target="#myModal1" onclick="update_datafill('<?php echo addslashes(htmlentities($customer_id)) ?>','<?php echo addslashes(htmlentities($customer_name)) ?>','<?php echo addslashes(htmlentities($address)) ?>','<?php echo addslashes(htmlentities($phone_no)) ?>','<?php echo addslashes(htmlentities($email)) ?>','<?php echo addslashes(htmlentities($remark)) ?>')">Edit</button></td>
			<td><button class="btn btn-danger" onclick="delete_customer('<?php echo addslashes(htmlentities($customer_id)) ?>')">Delete</button></td>
		</tr>

<?php 

$count =  $count + 1;

} ?>

  