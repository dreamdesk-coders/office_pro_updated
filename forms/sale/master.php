<?php
$sale_module = $_SESSION['sale_module'];
if ($sale_module == "0") {
	echo "<script> window.location.href = '$common_form_route?frm=not_activated&m=sale'; </script>";
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
					<h2>Sale Transactions</h2>
				</div>
				<div class="col-lg-4 col-md-4">
					<div class="from-group mt-3 mb-4">
						<input type="form-control" placeholder="Type to search sale transactions" id="myInput" class="form-control search">
					</div>
				</div>
				<div class="col-lg-8 col-md-8">
				</div>
			</div>
			<div class="row" id="myList">
				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=sale_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Sale Transaction"></div>
							<img src="assets/images/sale/sale.svg">
							<div class="text-holder">
								<p>Sale</p>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=sale_return_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Sale Return Transaction"></div>

							<img src="assets/images/sale/sale_return.svg">
							<div class="text-holder">
								<p>Sale Return</p>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=sale_order_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Sale Order Transaction"></div>

							<img src="assets/images/sale/sale_order.svg">
							<div class="text-holder">
								<p>Sale Order</p>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=sale_order_cancel_list" class="a">
						<div class="frm_ t-block">

							<div class="info" title="Sale Order Cancel Transaction"></div>

							<img src="assets/images/sale/sale_order_cancel.svg">
							<div class="text-holder">
								<p>Sale Order Cancel</p>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=delivery_order_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Delivery Order Transaction"></div>

							<img src="assets/images/sale/delivery_order.svg">
							<div class="text-holder">
								<p>Delivery Order</p>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=delivery_order_cancel_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Delivery Order Cancel Transaction"></div>

							<img src="assets/images/sale/delivery_order_cancel.svg">
							<div class="text-holder">
								<p class="px-1">Delivery Order Cancel</p>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=delivery_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Delivery Sale Transaction"></div>

							<img src="assets/images/sale/delivery.svg">
							<div class="text-holder">
								<p>Delivery Sale</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=opening_sale_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Opening Sale Transaction"></div>

							<img src="assets/images/sale/sale.svg">
							<div class="text-holder">
								<p>Opening Sale</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=opening_delivery_list" class="a">
						<div class="frm_ t-block">
							<div class="info" title="Opening Delivery Transaction"></div>

							<img src="assets/images/sale/delivery.svg">
							<div class="text-holder">
								<p>Opening Delivery Sale</p>
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 mb-3 mt-3">
					<h4 class="mb-4">Portal</h4>
					<button type="button" class="btn btn-outline-primary" onclick="window.location.href='<?php echo $common_form_route ?>?frm=reports#sale_reports'">Go To Sale Reports</button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		active_route("sale_");
	</script>
<?php } ?>