<?php 
if(isset($_SESSION['save_status'])){
	$save_status = $_SESSION['save_status'];
	$transaction_id = $_SESSION['transaction_id'];
	$action = $_SESSION['action'];

	if($save_status == "1"){
		if($action == "create" or $action == "update"){
			echo "<script> alert_('Info','Invoice ID : $transaction_id is successfully saved.');</script>";
		}
		elseif($action == "delete"){
			if($_SESSION['del_fail'] == "0"){
				echo "<script> alert_('Info','Invoice ID : $transaction_id is successfully deleted.');</script>";
				
			}	
			elseif($_SESSION['del_fail'] == "1"){
				echo "<script> alert_('Info','Cannot delete credit or advance invoice.');</script>";
			}
			unset($_SESSION['del_fail']);
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
if(isset($_GET['purchase_type'])){
	$purchase_type_ = $_GET['purchase_type'];
}
else{
	$purchase_type_ = "credit";
}
if($role == "Management Admin"){

	switch ($purchase_type_) {
		case 'all':
			$sql = "Select * From purchase where status = 'old' order by invoice_date desc";
			break;

		case 'advance':
			$sql = "Select * From purchase where purchase_type ='advance' and status = 'old' order by invoice_date desc";
			break;
		
		case 'cash':
			$sql = "Select * From purchase where purchase_type = 'cash' and status = 'old' order by invoice_date desc";
			break;

		case 'credit':
			$sql = "Select * From purchase where purchase_type = 'credit' and status = 'old' order by invoice_date desc";
			break;
		
		default:
			$sql = "Select * From purchase where status = 'old' order by invoice_date desc";
			break;
	}

	$query = $dbh -> prepare($sql);

}
else{
	$office_id = $_SESSION['office_id'];

	switch ($purchase_type_) {
		case 'all':
			$sql = "Select * From purchase where office_id =:office_id and status = 'old' order by invoice_date desc";
			break;

		case 'advance':
			$sql = "Select * From purchase where purchase_type ='advance' and office_id =:office_id and status = 'old' order by invoice_date desc";
			break;
		
		case 'cash':
			$sql = "Select * From purchase where purchase_type = 'cash' and office_id =:office_id and status = 'old' order by invoice_date desc";
			break;

		case 'credit':
			$sql = "Select * From purchase where purchase_type = 'credit' and office_id =:office_id and status = 'old' order by invoice_date desc";
			break;
		
		default:
			$sql = "Select * From purchase where office_id =:office_id and status = 'old' order by invoice_date desc";
			break;
	}
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


<script type="text/javascript" src="assets/js/purchase/purchase/purchase.js"></script>
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
				<div class="d-flex flex-row pb-0 mb-0">
                 
				  	<select class="form-control w-25  ml-2" onchange="filter_purchase_list()" id='selectBox'>
						<option disabled>Filter</option>
						<option value='?frm=opening_purchase_list&purchase_type=all' <?php if($purchase_type_ === "all"){echo 'selected';} ?>>All</option>
						<option value='?frm=opening_purchase_list&purchase_type=advance' <?php if($purchase_type_ === "advance"){echo 'selected';} ?>>Advance</option>
						<option value='?frm=opening_purchase_list&purchase_type=cash' <?php if($purchase_type_ === "cash"){echo 'selected';} ?>>Cash</option>
						<option value='?frm=opening_purchase_list&purchase_type=credit' <?php if($purchase_type_ === "credit"){echo 'selected';} ?>>Credit</option>
					</select>
					</div>
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" style="background-color: #fff;overflow:hidden;">
				<br>
				<h4>Purchase Transactions</h4>
				<br>
				<div class="res-table">
				<table class="table table-striped" id="purchase-table">
				  <thead>
				    <tr>
				      <td scope="col">No</td>
				      <td>Invoice ID</td>
				      <td scope="col">Date</td>
				      <td scope="col">Office ID</td>
				      <td scope="col">Supplier ID</td>
					  <td scope="col">Supplier Name</td>
                      <td scope="col">Currency ID</td>
                      <td scope="col">Total</td>
					  <td scope="col">Grand Total</td>
                      <td scope="col">Purchase Type</td>
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
						$purchase_type = $result->purchase_type;
						
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
						<td><?php echo $purchase_type; ?></td>
						<td><a href="<?php echo $common_form_route."?frm=opening_purchase_update&id=".rawurlencode($invoice_id) ?>" class="btn btn-info">View</a></td>
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

