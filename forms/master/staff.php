<?php 
include("forms/common/side_menu.php");

error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
   echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {?>

<script type="text/javascript" src="assets/js/master/staff/staff.js"></script>
<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php include("forms/common/alerts.php"); ?>
            </div>
        </div>
    </div>

	<div class="container-fluid" id="list_">
		<div class="row">
			<div class="col-md-12">
				<br>
				  <button class="btn btn-primary" onclick="create_template();">Add New Staff</button>
				<br><br>
			</div>
		</div>
		<div class="row" id="table">

		</div>
	</div>

    <div class="container-fluid" id="create_">
        <div class="row">
            <div class="col-md-6">
                <form method="POST" class="frm_">     
                <h4>Create New Staff</h4>           
                    <div class="form-group">
                        <label for="sid">Staff ID</label>
                        <input type="text" class="form-control" id="sid" name="sid" onchange="check_id_exist('staff','staff_id',this.id)" required>
                    </div>
                                    
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="dob">Date of birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" required>
                    </div>

                    <div class="form-group">
                        <label for="father_name">Father name (Optional)</label>
                        <input type="text" class="form-control" id="father_name" name="father_name">
                    </div>

                    <div class="form-group">
                        <label for="nrc">NRC (Optional)</label>
                        <input type="text" class="form-control" id="nrc" name="nrc">
                    </div>

                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineradio" id="inlineRadio1" checked>
                            <label class="form-check-label" for="inlineradio">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineradio" id="inlineRadio2">
                            <label class="form-check-label" for="inlineradio">Female</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="text" class="form-control" id="position" name="position" required>
                    </div>
                                    
                    <div class="form-group">
                        <label for="ph_no">Phone Number</label>
                        <input type="number" class="form-control" id="ph_no" name="ph_no" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address (Optional)</label>
                        <input type="email" class="form-control" id="email" name="email" >
                    </div>

                    <div class="form-group">
                        <label for="address">Address (Optional)</label>
                        <textarea class="form-control" rows="4" id="address" name="address">
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
                    <h4>Update Staff</h4>
                    <div class="form-group">
                        <label for="sid">Staff ID</label>
                        <input type="text" class="form-control" id="u_sid" name="u_sid" required readonly disabled>
                    </div>
                                    
                    <div class="form-group">
                        <label for="u_name">Name</label>
                        <input type="text" class="form-control" id="u_name" name="u_name" required>
                    </div>

                    <div class="form-group">
                        <label for="u_dob">Date of birth</label>
                        <input type="date" class="form-control" id="u_dob" name="u_dob" required>
                    </div>

                    <div class="form-group">
                        <label for="father_name">Father name (Optional)</label>
                        <input type="text" class="form-control" id="u_father_name" name="u_father_name">
                    </div>

                    <div class="form-group">
                        <label for="u_nrc">NRC (Optional)</label>
                        <input type="text" class="form-control" id="u_nrc" name="u_nrc">
                    </div>

                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineradio" id="u_inlineRadio1">
                            <label class="form-check-label" for="inlineradio">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineradio" id="u_inlineRadio2">
                            <label class="form-check-label" for="inlineradio">Female</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="u_position">Position</label>
                        <input type="text" class="form-control" id="u_position" name="u_position" required>
                    </div>
                                    
                    <div class="form-group">
                        <label for="u_ph_no">Phone Number</label>
                        <input type="number" class="form-control" id="u_ph_no" name="u_ph_no" required>
                    </div>

                    <div class="form-group">
                        <label for="u_email">Email Address (Optional)</label>
                        <input type="email" class="form-control" id="u_email" name="u_email" >
                    </div>

                    <div class="form-group">
                        <label for="u_address">Address (Optional)</label>
                        <textarea class="form-control" rows="4" id="u_address" name="u_address">
                        </textarea>
                    </div>

                                   
                    <button type="button" class="btn btn-primary" name="update" id="update">Update</button>
                    <button type="button" class="btn btn-secondary" onclick="list_template();">Cancel</button>                
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>

