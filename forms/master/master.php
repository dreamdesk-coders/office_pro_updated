<?php
include("forms/common/side_menu.php");
error_reporting(0);
if (strlen($_SESSION['alogin']) == 0) {
	echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else { ?>
	<script type="text/javascript" src="assets/js/master/category/category.js"></script>
	<div class="main-content bg-white">
		<div class="container">
			<div class="row">
				<div class="col-md-12 mt-2">
					<h2>Master Entries</h2>
				</div>
				<div class="col-lg-4 col-md-4">
					<div class="from-group mt-3 mb-4">
						<input type="form-control" placeholder="Type to search master entries" id="myInput" class="form-control search">
					</div>
				</div>
				<div class="col-lg-8 col-md-8">

				</div>
			</div>
			<div class="row" id="myList">
				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=category" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Category master entry"></div>
							<img src="assets/images/master/category.svg">
							<div class="text-holder">
								<p>Category</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=currency" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Currency master entry"></div>
							<img src="assets/images/master/currency.svg">
							<div class="text-holder">
								<p>Currency</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=customer" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Customer master entry"></div>
							<img src="assets/images/master/customer.svg">
							<div class="text-holder">
								<p>Customer</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=expense_master" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Expense master entry"></div>
							<img src="assets/images/master/expense_master.svg">
							<div class="text-holder">
								<p>Expense Master</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=office" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Office master entry"></div>
							<img src="assets/images/master/office.svg">
							<div class="text-holder">
								<p>Office</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=report_group" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Report Group master entry"></div>
							<img src="assets/images/master/report_group.svg">
							<div class="text-holder">
								<p>Report Group</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=staff" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Staff master entry"></div>
							<img src="assets/images/master/staff.svg">
							<div class="text-holder">
								<p>Staff</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=stock" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Stock master entry"></div>
							<img src="assets/images/master/stock.svg">
							<div class="text-holder">
								<p>Stock</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=stock_unit" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Stock Unit Price master entry"></div>
							<img src="assets/images/master/stock_unit.svg">
							<div class="text-holder">
								<p>Stock Unit Price</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=supplier" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Supplier master entry"></div>
							<img src="assets/images/master/supplier.svg">
							<div class="text-holder">
								<p>Supplier</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=units_of_measurement" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Units of Measurement master entry"></div>
							<img src="assets/images/master/units_of_measaurement.svg">
							<div class="text-holder">
								<p>Units of Measurement</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=township" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Township master entry"></div>
							<img src="assets/images/master/township.png">
							<div class="text-holder">
								<p>Township</p>
							</div>
						</div>
					</a>
				</div>

				<!-- <div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=units_of_measurement" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Units of Measurement master entry"></div>
							<img src="assets/images/master/ingredients.svg">
							<div class="text-holder">
								<p>Stock Recipe</p>
							</div>
						</div>
					</a>
				</div> -->
			</div>
			<div class="row mb-3 mt-3">
				<div class="col-md-12 ">
					<h4 class="mb-4">Portal</h4>
				</div>
				<div class="col-md-2">
				<button type="button" class="btn btn-outline-primary" onclick="window.location.href='<?php echo $common_form_route ?>?frm=sale_master'">Go To Sale Transactions</button>
				</div>
				<div class="col-md-2">
				<button type="button" class="btn btn-outline-primary" onclick="window.location.href='<?php echo $common_form_route ?>?frm=purchase_master'">Go To Purchase Transactions</button>
				</div>
				<div class="col-md-2">
				<button type="button" class="btn btn-outline-primary" onclick="window.location.href='<?php echo $common_form_route ?>?frm=inventory_master'">Go To Inventory Transactions</button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		active_route("mas_");
	</script>
<?php } ?>