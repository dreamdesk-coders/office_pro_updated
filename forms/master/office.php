<?php 
include("forms/common/side_menu.php");
include("forms/common/lookup.php");

$role = $_SESSION['role'];
if($role == "Staff" or $role == "Office Admin"){
    echo "<script> window.location.href = '$common_form_route?frm=no_permission'; </script>";
}

error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {?>
<script type="text/javascript" src="assets/js/master/office/office.js"></script>
<div class="main-content">

	<div class="container-fluid">
		<div class="col-md-12">
			<?php 
			
			include("forms/common/alerts.php");
			
			
			?>
		</div>
	</div>

	<div class="container-fluid" id="list_">
        
        <div class="row" id="table">

        </div>
    </div>

	<div class="container-fluid" id="create_">
		<div class="row">
			<div class="col-md-6">
				<form method="POST" class="frm_">
					<h4>Create New Office</h4>
					<div class="form-group">
                        <label for="office_id">Office ID</label>
                        <input type="text" class="form-control" id="office_id" name="office_id" onchange="check_id_exist('office','office_id',this.id)" required>
                    </div>

                    <div class="form-group">
                        <label for="office_name">Office Name</label>
                        <input type="text" class="form-control" id="office_name" name="office_name" required>
                    </div>

                    <label for="admin">Office Admin</label>
                    <div class="input-group mb-3">
  						<input type="text" class="form-control" id="admin" name="admin" required readonly>
  						<div class="input-group-append">
    						<button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_admin"></button>
  						</div>
					</div>

                    <div class="form-group">
                        <label for="color">Pick a color</label>
                        <input type="color" class="form-control" id="color" name="color" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" rows="3" id="address" name="address" required>
                        </textarea>
                    </div>

                     <button type="button" class="btn btn-primary" name="save" id="save">Save</button>
                    <button type="button" class="btn btn-secondary" onclick="list_template();">Cancel</button>

				</form>
			</div>
		</div>
	</div>

	<div class="container-fluid" id="update_">
		<div class="row">
			<div class="col-md-6">
				<form method="POST" class="frm_">
					<h4>Update Office</h4>
					<div class="form-group">
                        <label for="u_office_id">Office ID</label>
                        <input type="text" class="form-control" id="u_office_id" name="u_office_id" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="u_office_name">Office Name</label>
                        <input type="text" class="form-control" id="u_office_name" name="u_office_name" required>
                    </div>

                    <label for="u_admin">Office Admin</label>
                    <div class="input-group mb-3">
  						<input type="text" class="form-control" id="u_admin" name="u_admin" required readonly>
  						<div class="input-group-append">
    						<button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_u_admin"></button>
  						</div>
					</div>

                    <div class="form-group">
                        <label for="u_color">Pick a color</label>
                        <input type="color" class="form-control" id="u_color" name="u_color" required>
                    </div>

                    <div class="form-group">
                        <label for="u_address">Address</label>
                        <textarea class="form-control" rows="3" id="u_address" name="u_address" required>
                        </textarea>
                    </div>

                    <button type="button" class="btn btn-primary" name="update" id="update">Update</button>
                    <button type="button" class="btn btn-secondary" onclick="list_template();">Cancel</button> 

				</form>
				
			</div>
		</div>
	</div>

</div>

<script type="text/javascript">

$(document).ready(function(){

$("#btn_admin").click(function(){
        get_lookup_data('staff','staff_id','staff_name','Staff ID','Staff Name','admin');
  });

$("#btn_u_admin").click(function(){
        get_lookup_data('staff','staff_id','staff_name','Staff ID','Staff Name','u_admin');
  });
    
});
</script>

<?php } ?>