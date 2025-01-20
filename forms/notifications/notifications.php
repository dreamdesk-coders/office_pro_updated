<?php 
include("forms/common/side_menu.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

        $login_id = $_SESSION['alogin'];
		$office_id = $_SESSION['office_id'];

		$sql = "SELECT * FROM `notifications` WHERE noti_id not in (SELECT noti_id FROM notifications_read WHERE login_id =:login_id) and noti_to =:office_id order by noti_id desc";
		$query = $dbh -> prepare($sql);
		$query->bindParam(':login_id',$login_id,PDO::PARAM_STR);
		$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
		$query->execute();

		$new_noti_count = $query->rowcount();

        $results=$query->fetchAll(PDO::FETCH_OBJ);

        $sql = "SELECT * FROM `notifications` WHERE noti_id in (SELECT noti_id FROM notifications_read WHERE login_id =:login_id) and noti_to =:office_id order by noti_id desc";
		$query = $dbh -> prepare($sql);
		$query->bindParam(':login_id',$login_id,PDO::PARAM_STR);
		$query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
		$query->execute();

		$results1=$query->fetchAll(PDO::FETCH_OBJ);



    ?>
    <style type="text/css">
    	.a{
    		cursor: pointer;
    		color: #555;
    		text-decoration: none;
    	}
    	.a:hover{
    		text-decoration: none;
    	}
    	.card{
    		cursor: pointer;
    		border-left: none;
    		border-right: none;
    		border-radius: 0px;
    	}

    	.noti_dot{
    		background-image: linear-gradient(to bottom, #497dff, #5383fd, #5c8afb, #6690f9, #6f96f6);
    		width: 10px;
    		height: 10px;
    		border-radius: 10px;
    		display: inline-block;
    		margin-right: 10px;
    	}
    	._{
    		background-color: #555;
    		background-image: none;
    	}
    </style>
<div class="main-content bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<br>
				<h2 class="text-center">Notifications</h2>

				<br>
				<?php if($new_noti_count > 0){ ?>
					<h3>New Notifications</h3>
				<?php }else{ ?>
					<h3>No New Notifications</h3>
				<?php } ?>
					<br>
				<?php	
				  	foreach($results as $result){
				  		$id = $result->noti_id;
						$title = $result->title;
			            $noti_from = $result->noti_from;
			            $noti_to = $result->noti_to;
			            $description = $result->description;
			            $date = $result->date;
			            $date = date( "Y-m-d", strtotime($date));
			            $type = $result->type; ?>

					

					<a href="<?php echo $common_form_route ?>?frm=notification_view&id=<?php echo htmlentities($id) ?>" class="a">
						<div class="card">
						  <div class="card-body">
						    <div class="noti_dot"></div>
						    <?php echo $title ?>
						    <small style="float: right;"><?php echo $date?></small>
						  </div>
						</div>
					</a>
						
				<?php } ?>
				<br>
				<h3>Old Notifications</h3>
					<br>
				<?php	
				  	foreach($results1 as $result){
				  		$id = $result->noti_id;
						$title = $result->title;
			            $noti_from = $result->noti_from;
			            $noti_to = $result->noti_to;
			            $description = $result->description;
			            $date = $result->date;
			            $date = date( "Y-m-d", strtotime($date));
			            $type = $result->type; ?>

					

					<a href="<?php echo $common_form_route ?>?frm=notification_view&id=<?php echo htmlentities($id) ?>" class="a">
						<div class="card">
						  <div class="card-body">
						    <div class="noti_dot _"></div>
						    <?php echo $title ?>
						    <small style="float: right;"><?php echo $date?></small>
						  </div>
						</div>
					</a>
				
	
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	active_route("notifications_");
</script>
<?php } ?>