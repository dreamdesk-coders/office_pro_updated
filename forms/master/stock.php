<?php 
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {?>

<script type="text/javascript" src="assets/js/master/stock/stock.js"></script>
<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php 
				include("forms/common/alerts.php");

				 ?>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="list_">
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary" onclick="create_template()">Add New Stock</button>
                <br><br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="background-color: #fff;">
                <br>
                <h4>Stock</h4>
                <br>
                <div class="row bg-white">
                    <div class="col-md-8"></div>
                    <div class="col-md-2">
                        <form>
                            <label for="f_stock_id">From Stock ID<small><label
                                        id="l_f_stock_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="f_stock_id" name="f_stock_id"
                                    onchange="check_data_exist('stock','stock_id',$('#f_stock_id').val(), this.id,'l_f_stock_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_f_stock_id"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <form>
                            <label for="t_stock_id">To Stock ID<small><label id="l_t_stock_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="t_stock_id" name="t_stock_id"
                                    onchange="check_data_exist('stock','stock_id',$('#t_stock_id').val(), this.id,'l_f_stock_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_t_stock_id"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 d-flex flex-row-reverse">
                        <button class="btn btn-secondary mb-3 mt-3 ml-1 mr-1" onclick="get_stock_()">Clear</button>
                        <button class="btn btn-info mb-3 mt-3"
                            onclick="get_stock_filter($('#f_stock_id').val(),$('#t_stock_id').val())">Filter</button>
                        <button class="btn btn-primary mb-3 mt-3 ml-1 mr-1"
                            onclick="printPreview($('#f_stock_id').val(),$('#t_stock_id').val(),'stock_view')">List
                            Preview</button>
                    </div>
                </div>
                <div style="overflow:auto">
                    <div id="stock_table">
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
                    <h4>Create New Stock</h4>
                    <div class="form-group">
                        <label for="stock_id">Stock ID</label>
                        <input type="text" class="form-control" id="stock_id" name="stock_id"
                            onchange="check_id_exist('stock','stock_id',this.id)" required>
                    </div>

                    <div class="form-group">
                        <label for="stock_name">Stock Name</label>
                        <input type="text" class="form-control" id="stock_name" name="stock_name" required>
                    </div>

                    <label for="stocking_unit_id">Stocking Unit ID</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="stocking_unit_id" id="stocking_unit_id" required
                            readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary lookup-btn" type="button"
                                id="btn_stocking_unit_id"></button>
                        </div>
                    </div>

                    <label for="category_id">Category ID</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="category_id" id="category_id" required readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary lookup-btn" type="button"
                                id="btn_category_id"></button>
                        </div>
                    </div>

                    <label for="rg_id">Report Group ID</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="rg_id" id="rg_id" required readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_rg_id"></button>
                        </div>
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
                    <h4>Update Stock</h4>
                    <div class="form-group">
                        <label for="u_stock_id">Stock ID</label>
                        <input type="text" class="form-control" id="u_stock_id" name="u_stock_id" readonly required>
                    </div>

                    <div class="form-group">
                        <label for="u_stock_name">Stock Name</label>
                        <input type="text" class="form-control" id="u_stock_name" name="u_stock_name" required>
                    </div>

                    <label for="u_stocking_unit_id">Stocking Unit ID</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="u_stocking_unit_id" id="u_stocking_unit_id"
                            required readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary lookup-btn" type="button"
                                id="btn_u_stocking_unit_id"></button>
                        </div>
                    </div>

                    <label for="u_category_id">Category ID</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="u_category_id" id="u_category_id" required
                            readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary lookup-btn" type="button"
                                id="btn_u_category_id"></button>
                        </div>
                    </div>

                    <label for="u_rg_id">Report Group ID</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="u_rg_id" id="u_rg_id" required readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary lookup-btn" type="button"
                                id="btn_u_rg_id"></button>
                        </div>
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

    $("#btn_stocking_unit_id").click(function() {
        get_lookup_data('units_of_measurement', 'unit_id', 'description', 'Unit ID', 'Description',
            'stocking_unit_id');
    });

    $("#btn_u_stocking_unit_id").click(function() {
        get_lookup_data('units_of_measurement', 'unit_id', 'description', 'Unit ID', 'Description',
            'u_stocking_unit_id');
    });

    $("#btn_category_id").click(function() {
        get_lookup_data('category', 'category_id', 'category_name', 'Category ID', 'Category Name',
            'category_id');
    });

    $("#btn_u_category_id").click(function() {
        get_lookup_data('category', 'category_id', 'category_name', 'Category ID', 'Category Name',
            'u_category_id');
    });

    $("#btn_rg_id").click(function() {
        get_lookup_data('report_group', 'rg_id', 'description', 'Report Group ID', 'Description',
            'rg_id');
    });

    $("#btn_u_rg_id").click(function() {
        get_lookup_data('report_group', 'rg_id', 'description', 'Report Group ID', 'Description',
            'u_rg_id');
    });

});
</script>


<?php } ?>