<?php 

$inventory_dec = $_SESSION['inventory_decimal'];

include("forms/common/side_menu.php");
include("forms/common/lookup.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {?>
<script type="text/javascript" src="assets/js/master/stock_unit/stock_unit.js"></script>
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
                <button class="btn btn-primary" onclick="create_template()">Add New Stock Unit</button>
                <br><br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="background-color: #fff;">
                <br>
                <h4>Stock Unit</h4>
                <br>
                <div class="row bg-white">
                    <div class="col-md-8"></div>
                    <div class="col-md-2">
                        <form>
                            <label for="f_stock_unit_id">From Stock Unit ID<small><label
                                        id="l_f_stock_unit_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="f_stock_unit_id" name="f_stock_unit_id"
                                    onchange="check_data_exist('stock_unit','stock_unit_id',$('#f_stock_unit_id').val(), this.id,'l_f_stock_unit_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_f_stock_unit_id"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <form>
                            <label for="t_stock_unit_id">To Stock Unit ID<small><label
                                        id="l_t_stock_unit_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="t_stock_unit_id" name="t_stock_unit_id"
                                    onchange="check_data_exist('stock_unit','stock_unit_id',$('#t_stock_unit_id').val(), this.id,'l_f_stock_unit_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_t_stock_unit_id"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 d-flex flex-row-reverse">
                        <button class="btn btn-secondary mb-3 mt-3 ml-1 mr-1" onclick="get_stock_unit_()">Clear</button>
                        <button class="btn btn-info mb-3 mt-3"
                            onclick="get_stock_unit_filter($('#f_stock_unit_id').val(),$('#t_stock_unit_id').val())">Filter</button>
                        <button class="btn btn-primary mb-3 mt-3 ml-1 mr-1"
                            onclick="printPreview($('#f_stock_unit_id').val(),$('#t_stock_unit_id').val(),'stock_unit_view')">List
                            Preview</button>
                    </div>
                </div>
                <div style="overflow:auto">
                    <div id="stock_unit_table">
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
                    <h4>Create New Stock Unit</h4>

                    <div class="form-group">
                        <label for="stock_unit_id">Stock Unit ID</label>
                        <input type="text" class="form-control" id="stock_unit_id" name="stock_unit_id"
                            onchange="check_id_exist('stock_unit','stock_unit_id',this.id)" required>
                    </div>

                    <label for="stock_id">Stock ID</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="stock_id" id="stock_id" required readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary lookup-btn" type="button"
                                id="btn_stock_id"></button>
                        </div>
                    </div>

                    <label for="unit_id">Unit ID</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="unit_id" name="unit_id" required readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary lookup-btn" type="button"
                                id="btn_unit_id"></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="pprice">Purchase Price</label>
                        <input type="number" class="form-control" id="pprice" name="pprice" min="0"
                            step="<?php echo htmlentities($inventory_dec); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="sprice">Sale Price</label>
                        <input type="number" class="form-control" id="sprice" name="sprice" min="0"
                            step="<?php echo htmlentities($inventory_dec); ?>" required>
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
                    <h4>Update Stock Unit</h4>

                    <div class="form-group">
                        <label for="u_stock_unit_id">Stock Unit ID</label>
                        <input type="text" class="form-control" id="u_stock_unit_id" name="u_stock_unit_id" readonly
                            required>
                    </div>

                    <label for="u_stock_id">Stock ID</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="u_stock_id" id="u_stock_id" readonly required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary lookup-btn" type="button"
                                id="btn_u_stock_id"></button>
                        </div>
                    </div>

                    <label for="u_unit_id">Unit ID</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="u_unit_id" name="u_unit_id" required readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary lookup-btn" type="button"
                                id="btn_u_unit_id"></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="u_quantity">Quantity</label>
                        <input type="number" class="form-control" id="u_quantity" name="u_quantity" required>
                    </div>

                    <div class="form-group">
                        <label for="u_pprice">Purchase Price</label>
                        <input type="number" class="form-control" id="u_pprice" name="u_pprice" required>
                    </div>

                    <div class="form-group">
                        <label for="u_sprice">Sale Price</label>
                        <input type="number" class="form-control" id="u_sprice" name="u_sprice" required>
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

    $("#btn_unit_id").click(function() {
        get_lookup_data('units_of_measurement', 'unit_id', 'description', 'Unit ID', 'Description',
            'unit_id');
    });

    $("#btn_u_unit_id").click(function() {
        get_lookup_data('units_of_measurement', 'unit_id', 'description', 'Unit ID', 'Description',
            'u_unit_id');
    });

    $("#btn_stock_id").click(function() {
        get_lookup_data('stock', 'stock_id', 'stock_name', 'Stock ID', 'Stock Name', 'stock_id');
    });

    $("#btn_u_stock_id").click(function() {
        get_lookup_data('stock', 'stock_id', 'stock_name', 'Stock ID', 'Stock Name', 'u_stock_id');
    });

});
</script>
<?php } ?>