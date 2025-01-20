<?php 
$purchase_module = $_SESSION['purchase_module'];
$step_string = $_COOKIE['purchase_step'];
if($purchase_module == "0"){
    echo "<script> window.location.href = '$common_form_route?frm=not_activated&m=purchase'; </script>";
    
}
$purchase_dec = $_SESSION['purchase_decimal'];
$_SESSION['current_transaction'] = "P";
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
include("handler/common/common_functions.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {?>
<style type="text/css">
ol {
    padding: 0px !important;
}

li {
    float: right;
}
</style>
<script type="text/javascript" src="assets/js/purchase/purchase/purchase.js"></script>
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
                <form method="POST" action="handler/purchase/purchase/purchase_handler.php" class="frm_">
                    <h4>Purchase</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="invoice_id">Invoice ID</label>
                                <input type="text" class="form-control" id="invoice_id" name="invoice_id"
                                    onchange="check_id_exist('purchase','invoice_id',this.id)" required>
                            </div>

                            <div class="form-group">
                                <label for="invoice_date">Date</label>
                                <input type="date" class="form-control" id="invoice_date" name="invoice_date" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="staff_id">Staff ID <small><label id="lbl_staff_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="staff_id" name="staff_id"
                                    onchange="check_data_exist('staff','staff_id',$('#staff_id').val(), this.id,'lbl_staff_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_staff_id"></button>
                                </div>
                            </div>

                            <label for="currency_id">Currency ID <small><label
                                        id="lbl_currency_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="currency_id" name="currency_id"
                                    onchange="check_data_exist('currency','currency_id',$('#currency_id').val(), this.id,'lbl_currency_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_currency_id"></button>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exchange_rate">Exchange Rate</label>
                                <input type="number" class="form-control" id="exchange_rate" name="exchange_rate"
                                    min="0" step="<?php echo htmlentities($step_string); ?>" required>
                            </div>

                            <label for="supplier_id">Supplier ID <small><label
                                        id="lbl_supplier_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="supplier_id" name="supplier_id"
                                    onchange="check_data_exist('supplier','supplier_id',$('#supplier_id').val(), this.id,'lbl_supplier_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_supplier_id"></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea class="form-control" rows="4" id="remark" name="remark">
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-12">
                            <br>
                            <input type="button" class="btn btn-info" id="addRow" value="Add New Row"
                                onclick="addNewRow()" />
                            <br><br>
                            <ol>
                                <div class="res-table">
                                <table class="table table-striped" id="_table">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Stock ID</th>
                                        <th scope="col">Stock Name</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </table>
                                </div>
                            </ol>
                        </div>
                    </div>
                    <input type="hidden" name="rownum" id="rownum" value="0">
                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="advance" name="advance">
                                <label class="form-check-label" for="advance">Advance Purchase</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tax">Tax</label>
                                <input type="number" class="form-control" id="tax" name="tax" value="0"
                                    onchange="sum_amounts()" min="0" step="<?php echo htmlentities($step_string); ?>"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="expense">Expense</label>
                                <input type="number" class="form-control" id="expense" name="expense" value="0"
                                    onchange="sum_amounts()" min="0" step="<?php echo htmlentities($step_string); ?>"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="discount">Discount</label>
                                <input type="number" class="form-control" id="discount" name="discount" value="0"
                                    onchange="discount_percent_();sum_amounts();" min="0" step="<?php echo htmlentities($step_string); ?>"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="discount_percent">Discount Percent</label>
                                <input type="number" class="form-control" id="discount_percent" name="discount_percent" value="0"
                                    onchange="discount_();sum_amounts()" min="0" max="100" step="<?php echo htmlentities($step_string); ?>"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="total_amount">Total Amount</label>
                                <input type="number" class="form-control" id="total_amount" name="total_amount"
                                    value="0" onchange="sum_amounts()" min="0"
                                    step="<?php echo htmlentities($step_string); ?>" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="grand_total">Grand Total</label>
                                <input type="number" class="form-control" id="grand_total" name="grand_total" value="0"
                                    onchange="sum_amounts()" min="0" step="<?php echo htmlentities($step_string); ?>"
                                    readonly required>
                            </div>
                            <div class="form-group">
                                <label for="paid_amount">Paid Amount</label>
                                <input type="number" class="form-control" id="paid_amount" name="paid_amount" value="0"
                                    onchange="sum_amounts()" min="0" step="<?php echo htmlentities($step_string); ?>"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="net_amount">Net Amount</label>
                                <input type="number" class="form-control" id="net_amount" name="net_amount" value="0"
                                    onchange="sum_amounts()" min="0" step="<?php echo htmlentities($step_string); ?>"
                                    readonly required>
                            </div>
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="invoice_print">
                        <label class="custom-control-label" for="defaultUnchecked">Invoice Print</label>
                    </div>
                    <input type="submit" name="save" value="Add Purchase" onclick="sum_amounts()"
                        class="btn btn-primary">
                    <input type="button" value="Cancel"
                        onclick="window.location.href ='<?php echo $common_form_route."?frm=purchase_list" ?>'"
                        class="btn btn-secondary">
                    <input type="button" value="List"
                        onclick="window.location.href ='<?php echo $common_form_route."?frm=purchase_list" ?>'"
                        class="btn btn-info">
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