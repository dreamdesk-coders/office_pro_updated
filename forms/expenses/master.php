<?php 

include("forms/common/side_menu.php");

error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
	echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {?>
<div class="main-content bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2>Expense Transactions</h2>
			</div>

			<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=daily_expense_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Daily Expense Transaction"></div>
							<img src="assets/images/expenses/expense.svg">
							<div class="text-holder">
							<p>Daily Expense</p>
							</div>
						</div>
					</a>
				</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	active_route("expenses_");
</script>
<?php } ?>