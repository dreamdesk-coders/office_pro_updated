<?php 
if(isset($_SESSION['save_status'])){
	$save_status = $_SESSION['save_status'];
	$transaction_id = $_SESSION['transaction_id'];
	$action = $_SESSION['action'];

	if($save_status == "1"){
		if($action == "create" or $action == "update"){
			echo "<script> alert_('Info','Cancel ID : $transaction_id is successfully saved.');</script>";
		}
		elseif($action == "delete"){
			echo "<script> alert_('Info','Cancel ID : $transaction_id is successfully deleted.');</script>";
		}
		elseif($action == "cancel"){
			echo "<script> alert_('Info','Order ID : $transaction_id is cancelled.');</script>";
		}
	}
	elseif($save_status == "0"){
		if($action == "create" or $action == "update"){
			echo "<script> alert_('Info','An error occurred while saving transaction.');</script>";
		}
		elseif($action == "delete"){
			echo "<script> alert_('Info','An error occurred while deleting transaction.');</script>";
		}
		elseif($action == "cancel"){
			echo "<script> alert_('Info','An error occurred while cancelling transaction.');</script>";
		}
	}
	$_SESSION['save_status'] = "";
	$_SESSION['transaction_id'] = "";
	$_SESSION['action'] = "";
}

$sale_module = $_SESSION['sale_module'];
if($sale_module == "0"){
    echo "<script> window.location.href = '$common_form_route?frm=not_activated&m=sale'; </script>";
}
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else { 
$role = $_SESSION['role'];
if($role == "Management Admin"){
	$sql = "Select * From sale_order where status = 'Inactive' order by order_date desc";
	$query = $dbh -> prepare($sql);
}
else{
	$office_id = $_SESSION['office_id'];
	$sql = "Select * From sale_order where status = 'Inactive' and office_id=:office_id order by order_date desc";
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


<script type="text/javascript" src="assets/js/sale/sale_order/sale_order.js"></script>
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
			<div class="col-md-12" style="background-color: #fff;">
				<br>
				<h4>Sale Order Cancel Transactions</h4>
				<br>
				<div class="res-table">
				<table class="table table-striped" id="sale-order-cancel-table">
				  <thead>
				    <tr>
				      <td scope="col">No</td>
				      <td scope="col">Order ID</td>
					  <td scope="col">Order Date</td>
					  <td scope="col">Cancel Date</td>
				      <td scope="col">Office ID</td>
				      <td scope="col">Customer ID</td>
					  <td scope="col">Customer Name</td>
                      <td scope="col">Currency ID</td>
                      <td scope="col">Total Amount</td>
                      <td scope="col">Status</td>
                      <td scope="col">Action</td>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php	
				  	foreach($results as $result){
						$order_id = $result->order_id;
						$order_date = $result->order_date;
						$cancel_date = $result->cancel_date;
						$office_id = $result->office_id;
						$customer_id = $result->customer_id;
						$currency_id = $result->currency_id;
						$total_amount = $result->total_amount;
						$status = $result->status;

						$sql_customer = "Select * From customer where customer_id = :customer_id";
                        $query_customer = $dbh->prepare($sql_customer);
                        $query_customer->bindParam(':customer_id', $customer_id, PDO::PARAM_STR);
                        $query_customer->execute();
						$result_customer = $query_customer->fetch(PDO::FETCH_OBJ);
						
						$customer_name = $result_customer->customer_name;
						
						?>

					<tr>
						<td><?php echo $count; ?></td>
						<td><?php echo $order_id; ?></td>
						<td><?php echo $order_date; ?></td>
						<td><?php echo $cancel_date; ?></td>
						<td><?php echo $office_id; ?></td>
						<td><?php echo $customer_id; ?></td>
						<td><?php echo $customer_name; ?></td>
						<td><?php echo $currency_id; ?></td>
						<td><?php echo $total_amount; ?></td>
						<td><?php echo $status; ?></td>
						<td><a href="<?php echo $common_form_route."?frm=sale_order_cancel_view&id=".$order_id ?>" class="btn btn-info">View</a></td>
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

	    active_route("sale_");

	});
</script>
<?php } ?>

