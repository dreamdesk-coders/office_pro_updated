<?php 
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {?>
<script type="text/javascript" src="assets/js/master/currency/currency.js"></script>
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
                <button class="btn btn-primary" onclick="create_template();">Add New Currency</button>
                <br><br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" style="background-color: #fff;">
                <br>
                <h4>Currency</h4>
                <br>
                <div class="row bg-white">
                    <div class="col-md-8"></div>
                    <div class="col-md-2">
                        <form>
                            <label for="f_currency_id">From Currency ID<small><label
                                        id="l_f_currency_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="f_currency_id" name="f_currency_id"
                                    onchange="check_data_exist('currency','currency_id',$('#f_currency_id').val(), this.id,'l_f_currency_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_f_currency_id"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <form>
                            <label for="t_currency_id">To Currency ID<small><label
                                        id="l_t_currency_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="t_currency_id" name="t_currency_id"
                                    onchange="check_data_exist('currency','currency_id',$('#t_currency_id').val(), this.id,'l_f_currency_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_t_currency_id"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 d-flex flex-row-reverse">
                        <button class="btn btn-secondary mb-3 mt-3 ml-1 mr-1" onclick="get_currency_()">Clear</button>
                        <button class="btn btn-info mb-3 mt-3"
                            onclick="get_currency_filter($('#f_currency_id').val(),$('#t_currency_id').val())">Filter</button>
                        <button class="btn btn-primary mb-3 mt-3 ml-1 mr-1"
                            onclick="printPreview($('#f_currency_id').val(),$('#t_currency_id').val(),'currency_view')">List
                            Preview</button>
                    </div>
                </div>
                <div style="overflow:auto">
                    <div id="currency-table">
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
                    <h4>Create New Currency</h4>
                    <div class="form-group">
                        <label for="cid">Currency ID</label>
                        <input type="text" class="form-control" id="currency_id" name="currency_id"
                            onchange="check_id_exist('currency','currency_id',this.id)" required>
                    </div>

                    <div class="form-group">
                        <label for="name">Currency Name</label>
                        <input type="text" class="form-control" id="currency_name" name="currency_name" required>
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
                    <h4>Update Currency</h4>
                    <div class="form-group">
                        <label for="u_currency_id">Currency ID</label>
                        <input type="text" class="form-control" id="u_currency_id" name="u_currency_id" readonly
                            disabled>
                    </div>

                    <div class="form-group">
                        <label for="u_currency_name">Currency Name</label>
                        <input type="text" class="form-control" id="u_currency_name" name="u_currency_name" required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="update" id="update">Update</button>
                    <button type="button" class="btn btn-secondary" onclick="list_template();">Cancel</button>

                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>