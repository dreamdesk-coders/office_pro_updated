<?php 
if(isset($_SESSION['save_status'])){
	$save_status = $_SESSION['save_status'];
	$transaction_id = $_SESSION['transaction_id'];
	$action = $_SESSION['action'];

	if($save_status == "1"){
		if($action == "create" or $action == "update"){
			echo "<script> alert_('Info','Slip ID : $transaction_id is successfully saved.');</script>";
		}
		elseif($action == "delete"){
			echo "<script> alert_('Info','Slip ID : $transaction_id is successfully deleted.');</script>";
		}
	}
	elseif($save_status == "0"){
		if($action == "create" or $action == "update"){
			echo "<script> alert_('Info','An error occurred while saving transaction.');</script>";
		}
		elseif($action == "delete"){
			echo "<script> alert_('Info','An error occurred while deleting transaction.');</script>";
		}
	}
	$_SESSION['save_status'] = "";
	$_SESSION['transaction_id'] = "";
	$_SESSION['action'] = "";
}

$inventory_module = $_SESSION['inventory_module'];
if($inventory_module == "0"){
    echo "<script> window.location.href = '$common_form_route?frm=not_activated&m=inventory'; </script>";
}
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else { 
$role = $_SESSION['role'];
if($role == "Management Admin"){
	$sql = "Select * From repacking order by slip_id asc";
	$query = $dbh -> prepare($sql);
}
else{
	$office_id = $_SESSION['office_id'];
	$sql = "Select * From repacking where office_id=:office_id order by slip_id asc";
	$query = $dbh -> prepare($sql);
	$query->bindParam(':office_id', $office_id, PDO::PARAM_STR);

}
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$count = 1;
	?>
    <style type="text/css">
    
        ol{
            padding: 0px !important;
        }
        li{
           float: right;
        }

    </style>


<script type="text/javascript" src="assets/js/inventory/repacking/repacking.js"></script>
<div class="main-content">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include("forms/common/alerts.php"); ?>
            </div>
        </div>
    </div>


	<div class="container">
		<div class="row">
			<div class="col-md-12">
                  <a href="<?php echo $common_form_route."?frm=repacking_add" ?>" class="btn btn-primary">Add New Stock Repacking</a>
				<br><br>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" style="background-color: #fff;">
				<br>
				<h4>Stock Repacking Transactions</h4>
				<br>
				<div class="res-table">
				<table class="table table-striped" id="repacking-table">
				  <thead>
				    <tr>
				      <td scope="col">No</td>
				      <td scope="col">Slip ID</td>
				      <td scope="col">Date</td>
				      <td scope="col">Office ID</td>
				      <td scope="col">Staff ID</td>
                      <td scope="col">From Stock ID</td>
                      <td scope="col">From Unit Id</td>
                      <td scope="col">From Quantity</td>
                      <td scope="col">Action</td>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php	
				  	foreach($results as $result){
						$slip_id = $result->slip_id;
						$slip_date = $result->slip_date;
						$office_id = $result->office_id;
						$staff_id = $result->staff_id;
						$from_stock_id = $result->from_stock_id;
                        $from_unit_id = $result->from_unit_id;
                        $from_quantity = $result->from_quantity; ?>

					<tr>
						<td><?php echo $count; ?></td>
						<td><?php echo $slip_id; ?></td>
						<td><?php echo $slip_date; ?></td>
						<td><?php echo $office_id; ?></td>
						<td><?php echo $staff_id; ?></td>
						<td><?php echo $from_stock_id; ?></td>
						<td><?php echo $from_unit_id; ?></td>
                        <td><?php echo $from_quantity; ?></td>
						<td><a href="<?php echo $common_form_route."?frm=repacking_update&id=".$slip_id ?>" class="btn btn-info">View</a></td>
					</tr>

					<?php
					$count =  $count + 1;
				}?>
				  </tbody>
				</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {

	    active_route("inventory_");

	});
</script>
<?php } ?>

