<?php
$inventory_module = $_SESSION['inventory_module'];
if ($inventory_module == "0") {
	echo "<script> window.location.href = '$common_form_route?frm=not_activated&m=inventory'; </script>";
}
include("forms/common/side_menu.php");

error_reporting(0);
if (strlen($_SESSION['alogin']) == 0) {
	echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else { ?>
	<div class="main-content bg-white">
		<div class="container">
			<div class="row">
				<div class="col-md-12 mt-2">
					<h2>Inventory Transactions</h2>
				</div>
				<div class="col-lg-4 col-md-4">
					<div class="from-group mt-3 mb-4">
						<input type="form-control" placeholder="Type to search inventory transactions" id="myInput" class="form-control search">
					</div>
				</div>
				<div class="col-lg-8 col-md-8">
				</div>
			</div>

			<div class="row" id="myList">
				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=stock_received_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Stock Receive Transaction"></div>
							<img src="assets/images/inventory/stock_receive.svg">
							<div class="text-holder">
								<p>Stock Receive</p>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=stock_issue_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Stock Issue Transaction"></div>
							<img src="assets/images/inventory/stock_issue.svg">
							<div class="text-holder">
								<p>Stock Issue</p>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=stock_transfer_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Stock Transfer Transaction"></div>
							<img src="assets/images/inventory/stock_transfer.svg">
							<div class="text-holder">
								<p>Stock Transfer</p>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=office_use_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Office Use Transaction"></div>
							<img src="assets/images/master/office.svg">
							<div class="text-holder">
								<p>Office Use</p>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=repacking_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Stock Repacking Transaction"></div>
							<img src="assets/images/inventory/repack.svg">
							<div class="text-holder">
								<p>Stock Repacking</p>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=stock_damage_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Damage Transaction"></div>
							<img src="assets/images/inventory/damage.svg">
							<div class="text-holder">
								<p>Damage</p>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=present_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Present Transaction"></div>
							<img src="assets/images/inventory/present.svg">
							<div class="text-holder">
								<p>Present</p>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=opening_stock_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Opening Stock Transaction"></div>
							<img src="assets/images/inventory/opening.svg">
							<div class="text-holder">
								<p>Opening Stock</p>
							</div>
						</div>
					</a>
				</div>

			</div>
			<div class="row">
				<div class="col-md-4 mb-3 mt-3">
					<h4 class="mb-4">Portal</h4>
					<button type="button" class="btn btn-outline-primary" onclick="window.location.href='<?php echo $common_form_route ?>?frm=reports#inventory_reports'">Go To Inventory Reports</button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		active_route("inventory_");
	</script>
<?php } ?>