<?php
$sale_module = $_SESSION['sale_module'];
$step_string = $_COOKIE['sale_step'];
if($sale_module == "0"){
    echo "<script> window.location.href = '$common_form_route?frm=not_activated&m=sale'; </script>";
}
$sale_dec = $_SESSION['sale_decimal'];
$_SESSION['current_transaction'] = "S";
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
include("handler/common/common_functions.php");
error_reporting(0);
if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else { ?>
<style type="text/css">
ol {
    padding: 0px !important;
}

li {
    float: right;
}
</style>
<script type="text/javascript" src="assets/js/sale/sale_order/sale_order.js"></script>
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
                <form method="POST" action="handler/sale/sale_order/sale_order_handler.php" class="frm_ p-4">
                    <h4>Sale Order</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="order_id">Order ID</label>
                                <input type="text" class="form-control" id="order_id" name="order_id"
                                    onchange="check_id_exist('sale_order','order_id',this.id)" required>
                            </div>

                            <div class="form-group">
                                <label for="order_date">Date</label>
                                <input type="date" class="form-control" id="order_date" name="order_date" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="staff_id">Staff ID <small><label id="lbl_staff_id"></label></small></label>
                            <a href="?frm=staff" target="_blank">Add New Staff</a>
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
                            <a href="?frm=currency" target="_blank">Add New Currency</a>
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
                            <label for="customer_id">Customer ID <small><label
                                        id="lbl_customer_id"></label></small></label>
                            <a href="?frm=customer" target="_blank">Add New Customer</a>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="customer_id" name="customer_id"
                                    onchange="check_data_exist('customer','customer_id',$('#customer_id').val(), this.id,'lbl_customer_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_customer_id"></button>
                                </div>
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
                        <div class="col-md-9 col-sm-6">
                            <br>
                            <input type="button" class="btn btn-info" id="addRow" value="Add New Row"
                                onclick="addNewRow();uncheck();" />
                            <br>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <br>
                            <div class="custom-control custom-switch custom-switch-lg position-absolute"
                                style="right:40px;">
                                <input type="checkbox" class="custom-control-input" id="checkdata"
                                    onchange="formcheck()">
                                <label class="custom-control-label" for="checkdata">Form Data Complete</label>
                            </div>
                            <br>
                        </div>
                        <div class="col-md-12">
                            <br>
                            <ol>
                            <div class="res-table">
                                <table class="table table-striped" id="_table" onchange="uncheck();"
                                    onclick="uncheck();" onkeydown="uncheck();" onkeypress="uncheck();"
                                    onkeyup="uncheck();">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Stock ID</th>
                                        <th scope="col">Stock Name</th>
                                        <th scope="col">Unit ID</th>
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
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="total_amount">Total Amount</label>
                                <input type="number" class="form-control" id="total_amount" name="total_amount" min="0"
                                    step="<?php echo htmlentities($step_string); ?>" value="0" required>
                            </div>
                            <div class="form-group">
                                <label for="tax">Tax Amount</label>
                                <input type="number" class="form-control" id="tax" name="tax" min="0"
                                    step="<?php echo htmlentities($step_string); ?>" value="0" onchange="sum_amounts();"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="invoice_print">
                        <label class="custom-control-label" for="defaultUnchecked">Invoice Print</label>
                    </div>
                    <input type="submit" name="save" id="save" value="Add Sale Order" class="btn btn-primary">
                    <input type="button" value="Cancel"
                        onclick="window.location.href ='<?php echo $common_form_route . "?frm=sale_order_list" ?>'"
                        class="btn btn-secondary">
                    <input type="button" value="List"
                        onclick="window.location.href ='<?php echo $common_form_route . "?frm=sale_order_list" ?>'"
                        class="btn btn-info">
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var rownum = $("#rownum").val();
$("#save").prop('disabled', true);
addNewRow();
</script>
<?php } ?>