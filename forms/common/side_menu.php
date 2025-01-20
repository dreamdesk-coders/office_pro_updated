<div class="nav-bar" id="nav-bar">
	<img src="assets/images/icons/nav-bar-icon.png" class="nav-controller" id="nav-open" title="Open Side Menu">

	<p class="text-center text-light" style="margin-top:14px;"><?php echo $_COOKIE['client_name'] ?></p>
	
    	<!-- <input type="text" class="nav-search" id="aaa" placeholder="Type to search Office Pro"> -->
  	
	<p class="user-name"><img src="assets/images/icons/user.svg" style="display:inline;width: 20px;margin-right: 5px;" id="profile"></p>
	<a href="<?php echo $common_form_route ?>?frm=notifications" title="Notifications">
		<img src="assets/images/icons/bell.svg" class="noti-icon">
		<h6 class="badge badge-danger noti-badge" id="noti"></h6>
	</a>
	<a href="<?php echo $common_form_route ?>?frm=settings" title="Settings">
		<img src="assets/images/icons/settings.svg" class="cog-icon">
	</a>
	
</div>

<div class="side-menu" id="side-menu">

	<div class="nav-close-parent" id="nav-close">
		<img src="assets/images/icons/nav-close.png" class="nav-close" title="Close Side Menu">
	</div>
		
	<div class="menu-item">
		<img src="favicon.ico" class="icon">
		<p>Office Pro</p>
	</div>

	<div class="menu-item" title="Dashboard - Quick Data Previews">
		<a href="<?php echo $common_form_route ?>?frm=dashboard" id="dashboard_"><img src="assets/images/icons/dashboard.svg"> Dashboard</a>
	</div>

	<div class="menu-item" title="Master Entries">
		<a href="<?php echo $common_form_route ?>?frm=master" id="mas_"><img src="assets/images/icons/master.svg"> Master</a>
	</div>

	<div class="menu-item" title="Inventory Control Transactions">
		<a href="<?php echo $common_form_route ?>?frm=inventory_master" id="inventory_"><img src="assets/images/icons/inventory.svg"> Inventory</a>
	</div>

	<div class="menu-item" title="Sale Control Transactions">
		<a href="<?php echo $common_form_route ?>?frm=sale_master" id="sale_"><img src="assets/images/icons/sale.svg"> Sale</a>
	</div>
	
	<div class="menu-item" title="Purchase Control Transactions">
		<a href="<?php echo $common_form_route ?>?frm=purchase_master" id="purchase_"><img src="assets/images/icons/purchase.svg"> Purchase</a>
	</div>

	<div class="menu-item" title="Expenses Transactions">
		<a href="<?php echo $common_form_route ?>?frm=expenses_master" id="expenses_"><img src="assets/images/icons/expenses.svg"> Expense</a>
	</div>

	<div class="menu-item" title="Reports">
		<a href="<?php echo $common_form_route ?>?frm=reports" id="reports_"><img src="assets/images/icons/report.svg"> Reports</a>
	</div>

	<div class="menu-item"  title="Management - User Permissions & App Analysis">
		<a href="<?php echo $common_form_route ?>?frm=management_master" id="manage_"><img src="assets/images/icons/management.svg"> Management</a>
	</div>

	<!-- <div class="menu-item"  title="My Tasks">
		<a href="<?php echo $common_form_route ?>?frm=features/my_tasks" id="tasks_"><img src="assets/images/icons/tasks.svg"> My Tasks <h6 class="badge badge-info" id="my_tasks">New</h6></a>
	</div> -->

	<!-- <div class="menu-item" title="Notifications">
		<a href="<?php echo $common_form_route ?>?frm=notifications" id="notifications_"><img src="assets/images/icons/noti_bell.svg"> Notifications <h6 class="badge badge-danger" id="noti_side"></h6></a>
	</div>

	<div class="menu-item" title="Settings">
		<a href="<?php echo $common_form_route ?>?frm=settings" id="settings_"><img src="assets/images/icons/cog.svg"> Settings</a>
	</div>

	<div class="menu-item" title="Logout">
		<a href="<?php echo $common_form_route ?>?frm=logout"><img src="assets/images/icons/signout.svg"> Logout</a>
	</div> -->

	<div class="menu-account" id="menu-account">
		<div class="account-close-parent" id="account-close">
			<img src="assets/images/icons/nav-close.png" class="account-close" title="Close Menu">
		</div>
		<img src="assets/images/icons/user.svg" style="display:block;width: 60px;margin:auto;" class="mb-2">
		<p class="text-center mt-2 mb-2"><?php echo $_SESSION['staff_name']; ?></p>
		<p class="text-center mt-0 mb-2"><?php echo $_SESSION['office_name']; ?></p>
		<p class="text-center mt-0 mb-2"><?php echo $_SESSION['role']; ?></p>
		<div class="menu-account-item">
		<a href="https://www.fast.com/" target="_blank"><img src="assets/images/icons/wifi.svg"> Internet Speed Test</a>
		</div>
		<div class="menu-account-item">
		<a href="<?php echo $common_form_route ?>?frm=selection">
			<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="#6c757d" class="bi bi-server" viewBox="0 0 16 16">
				<path d="M1.333 2.667C1.333 1.194 4.318 0 8 0s6.667 1.194 6.667 2.667V4c0 1.473-2.985 2.667-6.667 2.667S1.333 5.473 1.333 4V2.667z"/>
				<path d="M1.333 6.334v3C1.333 10.805 4.318 12 8 12s6.667-1.194 6.667-2.667V6.334a6.51 6.51 0 0 1-1.458.79C11.81 7.684 9.967 8 8 8c-1.966 0-3.809-.317-5.208-.876a6.508 6.508 0 0 1-1.458-.79z"/>
				<path d="M14.667 11.668a6.51 6.51 0 0 1-1.458.789c-1.4.56-3.242.876-5.21.876-1.966 0-3.809-.316-5.208-.876a6.51 6.51 0 0 1-1.458-.79v1.666C1.333 14.806 4.318 16 8 16s6.667-1.194 6.667-2.667v-1.665z"/>
			</svg> Company Selection
		</a>
		</div>
		<div class="menu-account-item">
		<a href="<?php echo $common_form_route ?>?frm=logout"><img src="assets/images/icons/signout.svg"> Logout</a>
		</div>
	</div>

	<!-- <div class="menu-tool">
		<img src="assets/images/icons/tools.svg">
	</div> -->

</div>

<div class="mobile-splash">
	<h2>Office Pro</h2>
	<h3>need a larger display</h3>
	<img src="favicon.ico">
</div>

