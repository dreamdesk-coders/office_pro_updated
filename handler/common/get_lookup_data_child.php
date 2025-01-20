<?php
session_start();
include("connection_config.php");
?>
<table class="table" id="lookup-list">
	<thead class="lth">
		<tr>
			<th scope="col">No</th>
			<th scope="col">ID</th>
			<th scope="col">Description</th>
		</tr>
	</thead>
	<tbody>
<?php 

$currenct_transaction = $_SESSION['current_transaction'];
$table = $_POST['table'];
$parent_id = $_POST['parent_id'];
$used_parent_id = $_POST['used_parent_id'];
$id = $_POST['id'];
$desc = $_POST['desc'];
$req_id = $_POST['req_id'];

if(isset($_POST['req_desc'])){
	$req_desc = $_POST['req_desc'];
}

$sql = "Select * From $table where $parent_id =:used_parent_id order by $id asc";
$query = $dbh -> prepare($sql);
$query->bindParam(':used_parent_id',$used_parent_id,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$count = 1;

		foreach($results as $result){

			$did = $result->$id;
			$dname = $result->$desc;

			?>
		<tr>
			<td><?php echo $count ?></td>

			<?php
	
			if(isset($_POST['req_desc'])){ ?>
				<td><a class="l_click" onclick="fill_lookup_data_two_col('<?php echo addslashes(htmlentities($req_id)) ?>','<?php echo addslashes(htmlentities($req_desc)) ?>','<?php echo $did ?>','<?php echo $dname ?>')"><?php echo htmlentities($did);?></a></td>

				<td><a class="l_click" onclick="fill_lookup_data_two_col('<?php echo addslashes(htmlentities($req_id)) ?>','<?php echo $req_desc ?>','<?php echo addslashes(htmlentities($did)) ?>','<?php echo $dname ?>')"><?php echo htmlentities($dname);?></a></td>

			<?php }else{?>

			<td><a class="l_click" onclick="fill_lookup_data('<?php echo addslashes(htmlentities($req_id)) ?>','<?php echo $did ?>');get_stock_price('<?php echo addslashes(htmlentities($req_id)) ?>','<?php if($currenct_transaction == 'P'){ echo 'P';}elseif($currenct_transaction == 'S'){ echo 'S'; }?>');"><?php echo addslashes(htmlentities($did));?></a></td>

			<td><a class="l_click" onclick="fill_lookup_data('<?php echo addslashes(htmlentities($req_id)) ?>','<?php echo $did ?>');get_stock_price('<?php echo addslashes(htmlentities($req_id)) ?>','<?php if($currenct_transaction == 'P'){ echo 'P';}elseif($currenct_transaction == 'S'){ echo 'S'; }?>');"><?php echo addslashes(htmlentities($dname));?></a></td>

			<?php  }?>

		</tr>

<?php 

$count =  $count + 1;

} ?>

</tbody>
</table>