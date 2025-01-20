<?php 
if(isset($_SESSION['save_status'])){
	$save_status = $_SESSION['save_status'];
	$transaction_id = $_SESSION['transaction_id'];
	$action = $_SESSION['action'];

	if($save_status == "1"){
		if($action == "create" or $action == "update"){
			echo "<script> alert_('Info','Return ID : $transaction_id is successfully saved.');</script>";
		}
		elseif($action == "delete"){
			echo "<script> alert_('Info','Return ID : $transaction_id is successfully deleted.');</script>";
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


$purchase_module = $_SESSION['purchase_module'];
if($purchase_module == "0"){
    echo "<script> window.location.href = '$common_form_route?frm=not_activated&m=purchase'; </script>";
}
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else { 
$role = $_SESSION['role'];
if($role == "Management Admin"){
	$sql = "Select * From purchase_return order by invoice_date desc";
	$query = $dbh -> prepare($sql);

}
else{
	$office_id = $_SESSION['office_id'];
	$sql = "Select * From purchase_return where office_id=:office_id order by invoice_date desc";
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


<script type="text/javascript" src="assets/js/purchase/purchase_return/purchase_return.js"></script>
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
				  <!-- <button class="btn btn-primary" onclick="">Add New Purchase</button> -->
                  <a href="<?php echo $common_form_route."?frm=purchase_return_add" ?>" class="btn btn-primary">Add New Purchase Return</a>
				<br><br>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" style="background-color: #fff;">
				<br>
				<h4>Purchase Return Transactions</h4>
				<br>
				<div class="res-table">
				<table class="table table-striped" id="purchase-return-table">
				  <thead>
				    <tr>
				      <td scope="col">No</td>
				      <td scope="col">Return ID</td>
				      <td scope="col">Date</td>
				      <td scope="col">Office ID</td>
				      <td scope="col">Supplier ID</td>
					  <td scope="col">Supplier Name</td>
                      <td scope="col">Currency ID</td>
                      <td scope="col">Total Amount</td>
					  <td scope="col">Grand Total Amount</td>
                      <td scope="col">Action</td>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php	
				  	foreach($results as $result){
						$invoice_id = $result->invoice_id;
						$invoice_date = $result->invoice_date;
						$order_id = $result->order_id;
						$office_id = $result->office_id;
						$supplier_id = $result->supplier_id;
						$currency_id = $result->currency_id;
						$total_amount = $result->total_amount;
						$grand_total_amount = $result->grand_total_amount;
						
						$sql_supplier = "Select * From supplier where supplier_id = :supplier_id";
                        $query_supplier = $dbh->prepare($sql_supplier);
                        $query_supplier->bindParam(':supplier_id', $supplier_id, PDO::PARAM_STR);
                        $query_supplier->execute();
						$result_supplier = $query_supplier->fetch(PDO::FETCH_OBJ);
						
						$supplier_name = $result_supplier->supplier_name;

						?>

					<tr>
						<td><?php echo $count; ?></td>
						<td><?php echo $invoice_id; ?></td>
						<td><?php echo $invoice_date; ?></td>
						<td><?php echo $office_id; ?></td>
						<td><?php echo $supplier_id; ?></td>
						<td><?php echo $supplier_name; ?></td>
						<td><?php echo $currency_id; ?></td>
						<td><?php echo $total_amount; ?></td>
						<td><?php echo $grand_total_amount; ?></td>
						<td><a href="<?php echo $common_form_route."?frm=purchase_return_update&id=".rawurlencode($invoice_id) ?>" class="btn btn-info">View</a></td>

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

	    active_route("purchase_");

	});
</script>
<?php } ?>

