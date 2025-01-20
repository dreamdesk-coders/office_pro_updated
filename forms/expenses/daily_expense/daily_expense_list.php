<?php 
if(isset($_SESSION['save_status'])){
	$save_status = $_SESSION['save_status'];
	$transaction_id = $_SESSION['transaction_id'];
	$action = $_SESSION['action'];

	if($save_status == "1"){
		if($action == "create" or $action == "update"){
			echo "<script> alert_('Info','Expense ID : $transaction_id is successfully saved.');</script>";
		}
		elseif($action == "delete"){
			echo "<script> alert_('Info','Expense ID : $transaction_id is successfully deleted.');</script>";
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
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else { 

$sql = "Select * From expenses order by expense_date desc";
$query = $dbh -> prepare($sql);
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


<script type="text/javascript" src="assets/js/expenses/daily_expense/daily_expense.js"></script>
<div class="main-content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php include("forms/common/alerts.php"); ?>
            </div>
        </div>
    </div>


	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
                  <a href="<?php echo $common_form_route."?frm=daily_expense_add" ?>" class="btn btn-primary">Add New Daily Expense</a>
				<br><br>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" style="background-color: #fff;">
				<br>
				<h4>Daily Expense Transactions</h4>
				<br>
				<div class="res-table">
				<table class="table table-striped" id="daily-expense-table">
				  <thead>
				    <tr>
				      <td scope="col">No</td>
				      <td scope="col">Expense ID</td>
				      <td scope="col">Date</td>
                      <td scope="col">Amount</td>
				      <td scope="col">Currency ID</td>
				      <td scope="col">Exchange Rate</td>
                      <td scope="col">Staff ID</td>
                      <td scope="col">Office ID</td>
                      <td scope="col">Action</td>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php	
				  	foreach($results as $result){
						$expense_id = $result->expense_id;
                        $expense_date = $result->expense_date;
                        $total_amount = $result->total_amount;
                        $currency_id = $result->currency_id;
                        $exchange_rate = $result->exchange_rate;
						$staff_id = $result->staff_id;
						$office_id = $result->office_id; ?>

					<tr>
						<td><?php echo $count; ?></td>
						<td><?php echo $expense_id; ?></td>
						<td><?php echo $expense_date; ?></td>
						<td><?php echo $total_amount; ?></td>
						<td><?php echo $currency_id; ?></td>
						<td><?php echo $exchange_rate; ?></td>
						<td><?php echo $staff_id; ?></td>
                        <td><?php echo $office_id; ?></td>
						<td><a href="<?php echo $common_form_route."?frm=daily_expense_update&id=".$expense_id ?>" class="btn btn-info">View</a></td>
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

	    active_route("expenses_");

	});
</script>
<?php } ?>

