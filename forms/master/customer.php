<?php 
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {?>
<script type="text/javascript" src="assets/js/master/customer/customer.js"></script>
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
                <button class="btn btn-primary" onclick="create_template();">Add New Customer</button>
                <br><br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" style="background-color: #fff;">
                <br>
                <h4>Customer</h4>
                <br>
                <div class="row bg-white">
                    <div class="col-md-8"></div>
                    <div class="col-md-2">
                        <form>
                            <label for="f_customer_id">From Customer ID<small><label
                                        id="l_f_customer_id"></label></small>
                            </label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="f_customer_id" name="f_customer_id"
                                    onchange="check_data_exist('customer','customer_id',$('#f_customer_id').val(), this.id,'l_f_customer_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_f_customer_id"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <form>
                            <label for="t_customer_id">To Customer ID<small><label id="l_t_customer_id"></label></small>
                            </label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="t_customer_id" name="t_customer_id"
                                    onchange="check_data_exist('customer','customer_id',$('#t_customer_id').val(), this.id,'l_f_customer_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_t_customer_id"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 d-flex flex-row-reverse">
                        <button class="btn btn-secondary mb-3 mt-3 ml-1 mr-1" onclick="get_customer_()">Clear</button>
                        <button class="btn btn-info mb-3 mt-3"
                            onclick="get_customer_filter($('#f_customer_id').val(),$('#t_customer_id').val())">Filter</button>
                        <button class="btn btn-primary mb-3 mt-3 ml-1 mr-1"
                            onclick="printPreview($('#f_customer_id').val(),$('#t_customer_id').val(),'customer_view')">List
                            Preview</button>
                    </div>
                </div>
                <div style="overflow:auto">
                    <div id="customer-table">
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
                    <h4>Create New Customer</h4>
                    <div class="form-group">
                        <label for="customer_id">Customer ID</label>
                        <input type="text" class="form-control" id="customer_id" name="customer_id"
                            onchange="check_id_exist('customer','customer_id',this.id)" required>
                    </div>

                    <div class="form-group">
                        <label for="customer_name">Customer Name</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address (Optional)</label>
                        <textarea class="form-control" rows="4" id="address" name="address">
                        </textarea>
                    </div>

                    <div class="form-group">
                        <label for="ph_no">Phone Number</label>
                        <input type="text" class="form-control" id="ph_no" name="ph_no">
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address (Optional)</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>

                    <div class="form-group">
                        <label for="remark">Remark</label>
                        <textarea class="form-control" rows="2" id="remark" name="remark">
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
                    <h4>Update Customer</h4>
                    <div class="form-group">
                        <label for="u_customer_id">Customer ID</label>
                        <input type="text" class="form-control" id="u_customer_id" name="u_customer_id" required
                            readonly disabled>
                    </div>

                    <div class="form-group">
                        <label for="u_customer_name">Customer Name</label>
                        <input type="text" class="form-control" id="u_customer_name" name="u_customer_name" required>
                    </div>

                    <div class="form-group">
                        <label for="u_address">Address (Optional)</label>
                        <textarea class="form-control" rows="4" id="u_address" name="u_address">
                            </textarea>
                    </div>

                    <div class="form-group">
                        <label for="u_ph_no">Phone Number</label>
                        <input type="text" class="form-control" id="u_ph_no" name="u_ph_no">
                    </div>

                    <div class="form-group">
                        <label for="u_email">Email Address (Optional)</label>
                        <input type="email" class="form-control" id="u_email" name="u_email">
                    </div>

                    <div class="form-group">
                        <label for="u_remark">Remark</label>
                        <textarea class="form-control" rows="2" id="u_remark" name="u_remark">
                        </textarea>
                    </div>

                    <button type="button" class="btn btn-primary" name="update" id="update">Update</button>
                    <button type="button" class="btn btn-secondary" onclick="list_template()">Cancel</button>

                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>