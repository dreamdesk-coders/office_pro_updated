<?php 
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {?>
<script type="text/javascript" src="assets/js/management/user/user.js"></script>

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
                <button class="btn btn-primary" onclick="create_template();">Create New User Account</button>
                <br><br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="background-color: #fff;">
                <br>
                <h4>User Accounts</h4>
                <br>
                <div style="overflow:auto">
                    <div id="user-table">
                        <div class="ajax-loading">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="create_">
        <div class="row">
            <div class="col-md-6">
                <form method="POST" class="frm_">
                    <h4>Create New User Account</h4>
                    <label for="login_id">Login ID</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="login_id" name="login_id" readonly required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary lookup-btn" type="button"
                                id="btn_login_id"></button>
                        </div>
                    </div>

                    <label for="office_id">Office ID</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="office_id" name="office_id" required readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary lookup-btn" type="button"
                                id="btn_office_id"></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="login_role">Example select</label>
                        <select class="form-control" id="login_role" required>
                            <option>Staff</option>
                            <option>Office Admin</option>
                            <option>Management Admin</option>
                        </select>
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
                    <h4>Update User Account</h4>
                    <div class="form-group">
                        <label for="u_login_id">Staff Login ID</label>
                        <input type="text" class="form-control" id="u_login_id" name="u_login_id" required readonly>
                    </div>

                    <label for="u_office_id">Office ID</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="u_office_id" name="u_office_id" required readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary lookup-btn" type="button"
                                id="btn_u_office_id"></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="old_password">Old Password</label>
                        <input type="password" class="form-control" id="old_password" name="old_password">
                    </div>

                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password">
                    </div>

                    <div class="form-group">
                        <label for="u_login_role">Login Role</label>
                        <select class="form-control" id="u_login_role" required>
                            <option>Staff</option>
                            <option>Office Admin</option>
                            <option>Management Admin</option>
                        </select>
                    </div>

                    <button type="button" class="btn btn-primary" name="update" id="update">Update</button>
                    <button type="button" class="btn btn-secondary" onclick="list_template();">Cancel</button>

                </form>
            </div>
        </div>
    </div>

</div>


<script type="text/javascript">
$(document).ready(function() {

    $("#btn_login_id").click(function() {

        $('.lookup-container').show();
        $('.lookup').show();
        get_lookup_data('staff', 'staff_id', 'staff_name', 'Staff ID', 'Staff Name', 'login_id');
    });

    $("#btn_office_id").click(function() {

        $('.lookup-container').show();
        $('.lookup').show();
        get_lookup_data('office', 'office_id', 'office_name', 'Office ID', 'Office Name', 'office_id');
    });


    $("#btn_u_office_id").click(function() {

        $('.lookup-container').show();
        $('.lookup').show();
        get_lookup_data('office', 'office_id', 'office_name', 'Office ID', 'Office Name',
        'u_office_id');
    });

});
</script>


<?php } ?>