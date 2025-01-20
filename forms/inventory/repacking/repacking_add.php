<?php 
$inventory_module = $_SESSION['inventory_module'];
$step_string = $_COOKIE['inventory_step'];
if($inventory_module == "0"){
    echo "<script> window.location.href = '$common_form_route?frm=not_activated&m=inventory'; </script>";
}
$inventory_dec = $_SESSION['inventory_decimal'];
$_SESSION['current_transaction'] = "P";
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
include("handler/common/common_functions.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {?>
    <style type="text/css">
    
        ol{
            padding: 0px !important;
        }
        li{
           float: right;
        }

    </style>
<script type="text/javascript" src="assets/js/inventory/repacking/repacking.js"></script>
<div class="main-content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php include("forms/common/alerts.php"); ?>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="create_">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="handler/inventory/repacking/repacking_handler.php" class="frm_"> 
                    <h4>Repacking</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                            <label for="slip_id">Slip ID</label>
                            <input type="text" class="form-control" id="slip_id" name="slip_id" onchange="check_id_exist('repacking','slip_id',this.id)" required>
                            </div>

                            <div class="form-group">
                            <label for="slip_date">Date</label>
                            <input type="date" class="form-control" id="slip_date" name="slip_date" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="staff_id">Staff ID <small><label id="lbl_staff_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="staff_id" name="staff_id" onchange="check_data_exist('staff','staff_id',$('#staff_id').val(), this.id,'lbl_staff_id')" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_staff_id"></button>
                                </div>
                            </div>

                            <label for="from_stock_id">From Stock ID <small><label id="lbl_from_stock_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="from_stock_id" name="from_stock_id" onchange="check_data_exist('stock','stock_id',$('#from_stock_id').val(), this.id,'lbl_from_stock_id')" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_from_stock_id"></button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">

                            <label for="from_unit_id">From Unit ID <small><label id="lbl_from_unit_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="from_unit_id" name="from_unit_id" onchange="check_data_exist('stock_unit','stock_id',$('#from_stock_id').val(), this.id,'lbl_from_stock_id')" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_from_unit_id"></button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="from_quantity">From Quantity</label>
                                <input type="number" class="form-control" id="from_quantity" name="from_quantity" min="0" onchange="get_stock_quantity($('#from_stock_id').val(), $('#from_unit_id').val(), $('#from_quantity').val(), this.id);" required>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea class="form-control" rows="3" id="remark" name="remark">
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-12">
                            <br>
                            <input type="button" class="btn btn-info" id="addRow" value="Add New Row" onclick="addNewRow()" />
                            <br><br>
                            <ol>
                            <div class="res-table">
                            <table class="table table-striped" id="_table" >
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">To Stock ID</th>
                                    <th scope="col">Stock Name</th>
                                    <th scope="col">To Unit ID</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </table>
                            </div>
                            </ol>
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="invoice_print">
                            <label class="custom-control-label" for="defaultUnchecked">Invoice Print</label>
                        </div>
                     <input type="hidden" name="rownum" id="rownum" value="0">
                     <input type="submit" name="save" value="Save Repacking" class="btn btn-primary">
                     <input type="button" value="Cancel" onclick="window.location.href ='<?php echo $common_form_route."?frm=repacking_list" ?>'" class="btn btn-secondary">
                     <input type="button" value="List" onclick="window.location.href ='<?php echo $common_form_route."?frm=repacking_list" ?>'" class="btn btn-info">
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var rownum = $("#rownum").val();
    addNewRow();
</script>
<?php } ?>

