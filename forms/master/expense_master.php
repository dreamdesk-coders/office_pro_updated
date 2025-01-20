<?php 
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {?>
<script type="text/javascript" src="assets/js/master/expense_master/expense_master.js"></script>
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
                <button class="btn btn-primary" onclick="create_template();">Add New Expense Master</button>
                <br><br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="background-color: #fff;">
                <br>
                <h4>Expense Master</h4>
                <br>
                <div class="row bg-white">
                    <div class="col-md-8"></div>
                    <div class="col-md-2">
                        <form>
                            <label for="f_expense_id">From Expanse ID<small><label
                                        id="l_f_expense_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="f_expense_id" name="f_expense_id"
                                    onchange="check_data_exist('expense','expense_id',$('#f_expense_id').val(), this.id,'l_f_expense_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_f_expense_id"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <form>
                            <label for="t_expense_id">To Expense ID<small><label
                                        id="l_t_expense_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="t_expense_id" name="t_expense_id"
                                    onchange="check_data_exist('expense','expense_id',$('#t_expense_id').val(), this.id,'l_f_expense_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_t_expense_id"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 d-flex flex-row-reverse">
                        <button class="btn btn-secondary mb-3 mt-3 ml-1 mr-1" onclick="get_expense_()">Clear</button>
                        <button class="btn btn-info mb-3 mt-3"
                            onclick="get_expense_filter($('#f_expense_id').val(),$('#t_expense_id').val())">Filter</button>
                        <button class="btn btn-primary mb-3 mt-3 ml-1 mr-1"
                            onclick="printPreview($('#f_expense_id').val(),$('#t_expense_id').val(),'expense_master_view')">List
                            Preview</button>
                    </div>
                </div>
                <div style="overflow:auto">
                    <div id="expense_table">
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
                    <h4>Create New Expense Master</h4>
                    <div class="form-group">
                        <label for="expense_id">Expense ID</label>
                        <input type="text" class="form-control" id="expense_id" name="expense_id"
                            onchange="check_id_exist('expense_master','expense_id',this.id)" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="save" id="save">Save</button>
                    <button type="button" class="btn btn-secondary" onclick="list_template();">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="update_">
        <div class="row">
            <div class="col-md-6">
                <form method="POST" class="frm_">
                    <h4>Update Expense Master</h4>
                    <div class="form-group">
                        <label for="u_expense_id">Expense ID</label>
                        <input type="text" class="form-control" id="u_expense_id" name="u_expense_id" readonly disabled>
                    </div>

                    <div class="form-group">
                        <label for="u_description">Description</label>
                        <input type="text" class="form-control" id="u_description" name="u_description" required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="update" id="update">Update</button>
                    <button type="button" class="btn btn-secondary" onclick="list_template();">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>