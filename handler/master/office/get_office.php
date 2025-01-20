<?php 
include("../../common/connection_config.php");
$num_of_offices = $_COOKIE['num_of_offices'];
$sql = "Select * From office order by created_date desc";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$office_count = $query->rowcount();
	if($num_of_offices == $office_count){
?>
<div class="col-md-6">
		<div class="alert alert-info" role="alert">
		<p class="mb-0">Office creation limit reached. <a href="#">Contact Support.</a> </p>
	</div>
</div>
<div class="col-md-6">
</div>
<?php }else{?>
  <div class="col-md-12">
      <br>
        <button class="btn btn-primary" onclick="create_template();">Add New Office</button>
      <br><br>
  </div>
<?php }
foreach($results as $result){ ?>
	<?php 
		$id = $result->office_id;
		$name = $result->office_name;
		$admin = $result->admin;
		$color = $result->color;
		$address = $result->address;
		$address = trim(preg_replace('/\s+/', ' ', $address));
	?>
	<div class="col-md-3">
		<div class="office-card light-card text-center">
			<div class="dropdown more">
				<a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="false" aria-expanded="true">
				<img src="assets/images/icons/more.svg">
				</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item text-info" onclick="update_datafill('<?php echo addslashes(htmlentities($id)) ?>','<?php echo addslashes(htmlentities($name)) ?>','<?php echo addslashes(htmlentities($admin)) ?>','<?php echo addslashes(htmlentities($color)) ?>','<?php echo addslashes(htmlentities($address)) ?>')">Edit</a>
					<a class="dropdown-item text-danger" onclick="delete_office('<?php echo addslashes(htmlentities($id)) ?>')">Delete</a>
				</div>
			</div>
			<div style="position: absolute;width: 25px;height: 50px;border-radius: 20px;background-color: <?php echo $color; ?>;display: inline-block;top: 20px;left: 25px;">
			</div>
			<br>
			<p class="mb-0"><?php echo htmlentities($id);?></p>
			<p class="mt-1 mb-0"><?php echo htmlentities($name);?></p>
			<!-- <p><?php echo htmlentities($address); ?></p> -->
			<p class="mt-1 pb-1">Admin - <?php echo htmlentities($admin);?></p>
		</div>
	</div>
<?php } ?>
