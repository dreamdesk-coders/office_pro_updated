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
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

    if(isset($_GET['id'])){

        $invoice_id = $_GET['id'];
        $invoice_id = rawurldecode($invoice_id);
        $sql = "Select * From purchase WHERE invoice_id=:invoice_id";
        $query = $dbh -> prepare($sql);
        $query->bindParam(':invoice_id',$invoice_id,PDO::PARAM_STR);
        $query->execute();

        $result= $query->fetch(PDO::FETCH_OBJ);


            $invoice_id = $result->invoice_id;
            $invoice_date = $result->invoice_date;
            $staff_id = $result->staff_id;
            $supplier_id = $result->supplier_id;
            $currency_id = $result->currency_id;
            $office_id = $result->office_id;
            $exchange_rate = $result->exchange_rate;
            $total_amount = $result->total_amount;
            $grand_total_amount = $result->grand_total_amount;
            $paid_amount = $result->paid_amount;
            $discount = $result->discount;
            $discount_percent = $result->discount_percent;
            $tax = $result->tax;
            $expense = $result->expense;
            $net_amount = $result->net_amount;
            $purchase_type = $result->purchase_type;
            $remark = $result->remark;
    }
    else{

        /* header('location:$common_form_route?frm=purchase_list');*/
    }

    ?>
<style type="text/css">
ol {
    padding: 0px !important;
}

li {
    float: right;
}
</style>

<script type="text/javascript" src="assets/js/purchase/opening/opening_purchase.js"></script>
<div class="main-content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php include("forms/common/alerts.php"); ?>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="handler/purchase/opening/opening_purchase_handler.php" class="frm_">
                    <h4>Purchase</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="invoice_id">Invoice ID</label>
                                <input type="text" class="form-control" id="invoice_id" name="invoice_id"
                                    value="<?php echo htmlentities($invoice_id);?>" readonly required>
                            </div>

                            <div class="form-group">
                                <label for="invoice_date">Date</label>
                                <input type="date" class="form-control" id="invoice_date" name="invoice_date"
                                    value="<?php echo htmlentities($invoice_date);?>" required readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="staff_id">Staff ID <small><label id="lbl_staff_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="staff_id" name="staff_id"
                                    onchange="check_data_exist('staff','staff_id',$('#staff_id').val(), this.id,'lbl_staff_id')"
                                    value="<?php echo htmlentities($staff_id);?>" required readonly>
                            </div>

                            <label for="currency_id">Currency ID <small><label
                                        id="lbl_currency_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="currency_id" name="currency_id"
                                    onchange="check_data_exist('currency','currency_id',$('#currency_id').val(), this.id,'lbl_currency_id')"
                                    value="<?php echo htmlentities($currency_id);?>" required readonly>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exchange_rate">Exchange Rate</label>
                                <input type="number" class="form-control" id="exchange_rate" name="exchange_rate"
                                    min="0" step="<?php echo htmlentities($step_string); ?>"
                                    value="<?php echo htmlentities($exchange_rate);?>" required readonly>
                            </div>

                            <label for="supplier_id">Supplier ID <small><label
                                        id="lbl_supplier_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="supplier_id" name="supplier_id"
                                    onchange="check_data_exist('supplier','supplier_id',$('#supplier_id').val(), this.id,'lbl_supplier_id')"
                                    value="<?php echo htmlentities($supplier_id);?>" required readonly>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea class="form-control" rows="4" id="remark" name="remark">
                                    <?php echo htmlentities($remark);?>
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="rownum" id="rownum" value="<?php echo htmlentities($num) ?>">
                    <div class="row">
                        <div class="col-md-2">
                            <?php if($purchase_type == "Advance"){ ?>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="advance" name="advance" checked>
                                <label class="form-check-label" for="advance">Advance Purchase</label>
                            </div>
                            <?php }else{?>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="advance" name="advance">
                                <label class="form-check-label" for="advance">Advance Purchase</label>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tax">Tax</label>
                                <input type="number" class="form-control" id="tax" name="tax" onchange="sum_amounts()"
                                    min="0" step="<?php echo htmlentities($step_string); ?>"
                                    value="<?php echo htmlentities($tax) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="expense">Expense</label>
                                <input type="number" class="form-control" id="expense" name="expense"
                                    onchange="sum_amounts()" min="0" step="<?php echo htmlentities($step_string); ?>"
                                    value="<?php echo htmlentities($expense) ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="discount">Discount</label>
                                <input type="number" class="form-control" id="discount" name="discount"
                                    onchange="discount_percent_();sum_amounts();" min="0" step="<?php echo htmlentities($step_string); ?>"
                                    value="<?php echo htmlentities($discount) ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="discount_percent">Discount Percent</label>
                                <input type="number" class="form-control" id="discount_percent" name="discount_percent"
                                    onchange="discount_();sum_amounts()" min="0" step="<?php echo htmlentities($step_string); ?>"
                                    value="<?php echo htmlentities($discount_percent) ?>" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="total_amount">Total Amount</label>
                                <input type="number" class="form-control" id="total_amount" name="total_amount"
                                    onchange="sum_amounts()" min="0" step="<?php echo htmlentities($step_string); ?>"
                                    value="<?php echo htmlentities($total_amount) ?>"readonly required>
                            </div>
                            <div class="form-group">
                                <label for="grand_total">Grand Total</label>
                                <input type="number" class="form-control" id="grand_total" name="grand_total"
                                    onchange="sum_amounts()" min="0" step="<?php echo htmlentities($step_string); ?>"
                                    value="<?php echo htmlentities($grand_total_amount) ?>" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="paid_amount">Paid Amount</label>
                                <input type="number" class="form-control" id="paid_amount" name="paid_amount"
                                    value="<?php echo htmlentities($paid_amount) ?>" onchange="sum_amounts()" min="0"
                                    step="<?php echo htmlentities($step_string); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="net_amount">Net Amount</label>
                                <input type="number" class="form-control" id="net_amount" name="net_amount"
                                    onchange="sum_amounts()" min="0" step="<?php echo htmlentities($step_string); ?>"
                                    value="<?php echo htmlentities($net_amount) ?>" readonly required>
                            </div>
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="invoice_print">
                        <label class="custom-control-label" for="defaultUnchecked">Invoice Print</label>
                    </div>
                    <!-- <input type="submit" name="update" value="Update Purchase" class="btn btn-primary"> -->
                    <button type="submit" name="update" class="btn btn-primary">Update Purchase</button>
                    <input type="button" value="Cancel"
                        onclick="window.location.href ='<?php echo $common_form_route."?frm=purchase_list" ?>'"
                        class="btn btn-secondary">

                    <a href="handler/purchase/purchase/purchase_handler.php?delete=1&invoice_id=<?php echo $invoice_id ?>"
                        class="btn btn-danger">Delete Transaction</a>

                    <input type="button" value="List"
                        onclick="window.location.href ='<?php echo $common_form_route."?frm=purchase_list" ?>'"
                        class="btn btn-info">
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var rownum = $("#rownum").val() - 1;
</script>

<?php } ?>