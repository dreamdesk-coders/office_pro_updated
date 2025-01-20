<?php 
include("forms/common/side_menu.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {?>
<div class="main-content bg-white">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h2 class="text-center">App Management</h2>
			</div>

			<div class="col-md-2 col-sm-6">
					<a href="<?php echo $common_form_route ?>?frm=user" class="a">
						<div class="frm_ t-block">
							<div class="info" title="App User Control"></div>
							<img src="assets/images/management/user_management.svg">
							<div class="text-holder">
								<p>User Management</p>
							</div>
						</div>
					</a>
				</div>

		</div>
	</div>
</div>
<script type="text/javascript">
	active_route("manage_");
</script>
<?php } ?>