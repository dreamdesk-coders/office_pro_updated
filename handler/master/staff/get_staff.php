
<?php 

include("../../common/connection_config.php");
$sql = "Select * From staff order by created_date desc";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

foreach($results as $result){ ?>
	<?php 

		$id = $result->staff_id;
		$name = $result->staff_name;
		$dob = $result->birthday;
		$f_name = $result->father_name;
		$nrc = $result->nrc_no;
		$position = $result->position;
		$gender = $result->gender;
		$ph_no = $result->phone_no;
		$email = $result->email;
		$address = $result->address;
		$address = trim(preg_replace('/\s+/', ' ', $address));
	?>

	<div class="col-md-2">
		<div class="staff-card light-card text-center">
			<div class="dropdown more">
				<a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="false" aria-expanded="true">
				<img src="assets/images/icons/more.svg">
				</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item text-info" onclick="update_datafill('<?php echo addslashes(htmlentities($id)) ?>','<?php echo addslashes(htmlentities($name)) ?>','<?php echo addslashes(htmlentities($dob)) ?>','<?php echo addslashes(htmlentities($f_name)) ?>','<?php echo addslashes(htmlentities($nrc)) ?>','<?php echo addslashes(htmlentities($position)) ?>','<?php echo addslashes(htmlentities($gender)) ?>','<?php echo addslashes(htmlentities($ph_no)) ?>','<?php echo addslashes(htmlentities($email)) ?>','<?php echo addslashes(htmlentities($address)) ?>')">Edit</a>
					<a class="dropdown-item text-danger" onclick="delete_staff('<?php echo addslashes(htmlentities($id)) ?>')">Delete</a>
				</div>
			</div>
			
			<?php 
			if ($gender == "Male") { ?>
				<img src="assets/images/master/male.svg">


			<?php }else{ ?>
				<img src="assets/images/master/female.svg">

			<?php }?>
			
			<h6 class="mb-0 mt-0"><?php echo htmlentities($result->staff_name);?></h6>
			<p><?php echo htmlentities($result->position);?></p>
			<!-- <p><?php echo htmlentities($result->phone_no);?></p> -->
			
		</div>
	</div>

<?php } ?>

  