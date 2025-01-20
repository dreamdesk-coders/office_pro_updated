<?php 
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {?>
<script type="text/javascript" src="assets/js/master/supplier/supplier.js"></script>
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
                <button class="btn btn-primary" onclick="create_template();">Add New supplier</button>
                <br><br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" style="background-color: #fff;">
                <br>
                <h4>Supplier</h4>
                <br>
                <div class="row bg-white">
                    <div class="col-md-8"></div>
                    <div class="col-md-2">
                        <form>
                            <label for="f_supplier_id">From Supplier ID<small><label
                                        id="l_f_supplier_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="f_supplier_id" name="f_supplier_id"
                                    onchange="check_data_exist('supplier','supplier_id',$('#f_supplier_id').val(), this.id,'l_f_supplier_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_f_supplier_id"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <form>
                            <label for="t_supplier_id">To Supplier ID<small><label
                                        id="l_t_supplier_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="t_supplier_id" name="t_supplier_id"
                                    onchange="check_data_exist('supplier','supplier_id',$('#t_supplier_id').val(), this.id,'l_f_supplier_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_t_supplier_id"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 d-flex flex-row-reverse">
                        <button class="btn btn-secondary mb-3 mt-3 ml-1 mr-1" onclick="get_supplier_()">Clear</button>
                        <button class="btn btn-info mb-3 mt-3"
                            onclick="get_supplier_filter($('#f_supplier_id').val(),$('#t_supplier_id').val())">Filter</button>
                        <button class="btn btn-primary mb-3 mt-3 ml-1 mr-1"
                            onclick="printPreview($('#f_supplier_id').val(),$('#t_supplier_id').val(),'supplier_view')">List
                            Preview</button>
                    </div>
                </div>
                <div style="overflow:auto">
                    <div id="supplier-table">
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
                    <h4>Create New Supplier</h4>
                    <div class="form-group">
                        <label for="supplier_id">Supplier ID</label>
                        <input type="text" class="form-control" id="supplier_id" name="supplier_id"
                            onchange="check_id_exist('supplier','supplier_id',this.id)" required>
                    </div>

                    <div class="form-group">
                        <label for="supplier_name">Supplier Name</label>
                        <input type="text" class="form-control" id="supplier_name" name="supplier_name" required>
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
                    <h4>Update Supplier</h4>
                    <div class="form-group">
                        <label for="u_supplier_id">Supplier ID</label>
                        <input type="text" class="form-control" id="u_supplier_id" name="u_supplier_id" required
                            readonly disabled>
                    </div>

                    <div class="form-group">
                        <label for="u_supplier_name">Supplier Name</label>
                        <input type="text" class="form-control" id="u_supplier_name" name="u_supplier_name" required>
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