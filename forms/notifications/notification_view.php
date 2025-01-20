<?php 
include("forms/common/side_menu.php");
include("handler/common/common_functions.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
	echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

		if(isset($_GET['id'])){

			$id = $_GET['id'];

				$sql = "SELECT * FROM `notifications` WHERE noti_id =:id ";
				$query = $dbh -> prepare($sql);
				$query->bindParam(':id',$id,PDO::PARAM_STR);
				$query->execute();
        		$result= $query->fetch(PDO::FETCH_OBJ);

        		$id = $result->noti_id;
				$title = $result->title;
			    $noti_from = $result->noti_from;
			    $noti_to = $result->noti_to;
			    $description = $result->description;
			    $date = $result->date;
			    $date = date( "Y-m-d", strtotime($date));
			    $type = $result->type;
			    $link = $result->link;

			    $me = $_SESSION['alogin'];

			    $current_date = date("Y-m-d-h-i-s");

			    $sql="INSERT INTO notifications_read(noti_id, login_id, date) VALUES(:id,:me,:current_date)";

				$query = $dbh->prepare($sql);
				$query->bindParam(':id',$id,PDO::PARAM_STR);
				$query->bindParam(':me',$me,PDO::PARAM_STR);
				$query->bindParam(':current_date',$current_date,PDO::PARAM_STR);

				execute_query($dbh,$query);


		}

    ?>
    <style type="text/css">
    	.noti-board{
    		width: 100%;
    		height: auto;
    		/*min-height: 70vh;*/
    		border: 1px solid rgba(0,0,0,.125);
    		border-radius: 5px;
    		padding: 20px;
    	}
    	.noti-board .icon{
    		width: 50px;
    		height: 50px;
    		border-radius: 50px;
    		background-color: #f5f5f5;
    		border: 2px solid #b3b3b3;
    		padding: 3px;
    	}
    	summary:focus{
    		outline: none !important;
    	}
    </style>
<div class="main-content bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="noti-board">
					
					<div class="icon">
						<img src="favicon.ico" style="width: 40px;height: 40px;">
					</div>
					<br>
					<details>
					  <summary>Noti Info</summary>
					  	<p>From : <?php echo htmlentities($noti_from); ?></p>
						<p>To : <?php echo htmlentities($me); ?></p>
						<p>Date : <?php echo htmlentities($date); ?></p>
					</details>

					<br>
					<h4 style="display: inline-block;"><?php echo htmlentities($title); ?></h4>
					<p><?php echo htmlentities($description); ?></p>
					<?php if(strlen($link) > 0) {?>
						<button onclick="window.location.href = '<?php echo $link ?>'" class="btn btn-info">View Noti Source</button>
					<?php } ?>

					
				</div>
				<br>
				<a href="<?php echo $common_form_route ?>?frm=notifications" class="btn btn-light">Back to notifications</a>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	active_route("notifications_");
	get_notifications();
</script>
<?php } ?>