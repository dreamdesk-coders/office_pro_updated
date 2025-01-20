<?php
$purchase_module = $_SESSION['purchase_module'];
if ($purchase_module == "0") {
	echo "<script> window.location.href = '$common_form_route?frm=not_activated&m=purchase'; </script>";
}
include("forms/common/side_menu.php");
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else { ?>
	<div class="main-content bg-white">
		<div class="container">
			<div class="row">
				<div class="col-md-12 mt-2">
					<h2>Purchase Transactions</h2>
				</div>
				<div class="col-lg-4 col-md-4">
					<div class="from-group mt-3 mb-4">
						<input type="form-control" placeholder="Type to search purchase transactions" id="myInput" class="form-control search">
					</div>
				</div>
				<div class="col-lg-8 col-md-8">
				</div>
			</div>
			<div class="row" id="myList">
				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=purchase_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Purchase Transaction"></div>
							<img src="assets/images/purchase/purchase.svg">
							<div class="text-holder">
								<p>Purchase</p>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=purchase_order_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Purchase Order Transaction"></div>
							<img src="assets/images/purchase/purchase_order.svg">
							<div class="text-holder">
								<p>Purchase Order</p>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=purchase_order_cancel_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Purchase Order Cancel Transaction"></div>
							<img src="assets/images/purchase/purchase_order_cancel.svg">
							<div class="text-holder">
								<p>Purchase Order Cancel</p>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=purchase_return_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Purchase Return Transaction"></div>
							<img src="assets/images/purchase/purchase_return.svg">
							<div class="text-holder">
								<p>Purchase Return</p>
							</div>
						</div>
					</a>
				</div>
				<!-- <div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=opening_purchase_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Opening Purchase Transaction"></div>
							<img src="assets/images/purchase/purchase.svg">
							<div class="text-holder">
								<p>Opening Purchase</p>
							</div>
						</div>
					</a>
				</div> -->
			</div>
			<div class="row">
				<div class="col-md-4 mb-3 mt-3">
					<h4>Portal</h4>
					<button type="button" class="btn btn-outline-primary" onclick="window.location.href='<?php echo $common_form_route ?>?frm=reports#purchase_reports'">Go To Purchase Reports</button>
				</div>
			</div>

		</div>
	</div>
	<script type="text/javascript">
		active_route("purchase_");
	</script>
<?php } ?>