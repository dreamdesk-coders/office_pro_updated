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
error_reporting(0);
if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

    if (isset($_GET['id'])) {
        $invoice_id = $_GET['id'];

        $sql = "Select * From delivery WHERE invoice_id=:invoice_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);

        $invoice_id = $result->invoice_id;
        $invoice_date = $result->invoice_date;
        $order_id = $result->order_id;
        $staff_id = $result->staff_id;
        $customer_id = $result->customer_id;
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
        $remark = $result->remark;
    } else {

        // header('location:$common_form_route?frm=delivery_list');
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

<script type="text/javascript" src="assets/js/sale/sale/sale.js"></script>
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
                <form method="POST" action="handler/sale/delivery/delivery_handler.php" class="frm_">
                    <h4>Delivery</h4>
                    <div class="row">
                        <div class="col-md-4">

                            <div class="form-group">
                                <label for="invoice_id">Delivery ID</label>
                                <input type="text" class="form-control" id="invoice_id" name="invoice_id"
                                    value="<?php echo htmlentities($invoice_id); ?>" readonly required>
                            </div>

                            <div class="form-group">
                                <label for="order_id">Order ID</label>
                                <input type="text" class="form-control" id="order_id" name="order_id"
                                    value="<?php echo htmlentities($order_id); ?>" readonly required>
                            </div>

                            <div class="form-group">
                                <label for="invoice_date">Date</label>
                                <input type="date" class="form-control" id="invoice_date" name="invoice_date"
                                    value="<?php echo htmlentities($invoice_date); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="staff_id">Staff ID <small><label id="lbl_staff_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="staff_id" name="staff_id"
                                    onchange="check_data_exist('staff','staff_id',$('#staff_id').val(), this.id,'lbl_staff_id')"
                                    value="<?php echo htmlentities($staff_id); ?>" required>
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
                                    value="<?php echo htmlentities($currency_id); ?>" required>
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
                                    min="0" step="<?php echo htmlentities($step_string); ?>"
                                    value="<?php echo htmlentities($exchange_rate); ?>" required>
                            </div>

                            <label for="customer_id">Customer ID <small><label
                                        id="lbl_customer_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="customer_id" name="customer_id"
                                    onchange="check_data_exist('customer','customer_id',$('#customer_id').val(), this.id,'lbl_customer_id')"
                                    value="<?php echo htmlentities($customer_id); ?>" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_customer_id"></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea class="form-control" rows="4" id="remark" name="remark">
                                    <?php echo htmlentities($remark); ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-12">
                            <ol>
                            <div class="res-table">
                                <table class="table table-striped" id="_table">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Stock ID</th>
                                            <th scope="col">Stock Name</th>
                                            <th scope="col">Unit</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                            $sql = "Select * From delivery_order_details where order_id=:order_id ";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':order_id', $order_id, PDO::PARAM_STR);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $num = 1;

                                            foreach ($results as $result) {

                                                $stock_id = $result->stock_id;
                                                $unit_id = $result->unit_id;
                                                $quantity = $result->quantity;
                                                $price = $result->price;
                                                $amount = $quantity * $price;

                                                $sql = "Select * From stock where stock_id=:stock_id";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':stock_id', $stock_id, PDO::PARAM_STR);
                                                $query->execute();
                                                $result = $query->fetch(PDO::FETCH_OBJ);

                                                $stock_name = $result->stock_name;

                                            ?>
                                        <tr>
                                            <td>
                                                <li></li>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <input type="text" value="<?php echo $stock_id ?>"
                                                        class="form-control" id="sid<?php echo $num ?>"
                                                        name="sid<?php echo $num ?>" readonly required>
                                                </div>
                                            </td>

                                            <td>
                                                <label id="s_name<?php echo $num ?>" name="s_name<?php echo $num ?>">
                                                    <?php echo htmlentities($stock_name); ?>
                                                </label>
                                            </td>

                                            <td>
                                                <div class="input-group mb-3">
                                                    <input type="text" value="<?php echo $unit_id ?>"
                                                        id="unit_id<?php echo htmlentities($num) ?>"
                                                        name="unit_id<?php echo $num ?>" class="form-control" readonly
                                                        required>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="number" id="<?php echo htmlentities('quantity' . $num) ?>"
                                                    name="quantity<?php echo $num ?>"
                                                    value="<?php echo htmlentities($quantity); ?>" class="form-control"
                                                    min="0" readonly
                                                    onchange="sum_amounts(),get_stock_balance(this.id)">
                                            </td>
                                            <td>
                                                <input type="number" id="price<?php echo $num ?>"
                                                    name="price<?php echo $num ?>"
                                                    value="<?php echo htmlentities($price) ?>" class="form-control"
                                                    min="0" step="<?php echo htmlentities($step_string); ?>" readonly
                                                    onchange="sum_amounts()">
                                            </td>
                                            <td>
                                                <input type="number" id="amount<?php echo $num ?>"
                                                    name="amount<?php echo $num ?>" value="<?php echo $amount ?>"
                                                    class="form-control" min="0"
                                                    step="<?php echo htmlentities($step_string); ?>" readonly
                                                    onchange="sum_amounts()">
                                            </td>
                                        </tr>

                                        <?php

                                                $num = $num + 1;
                                            }

                                            ?>
                                    </tbody>
                                </table>
                                </div>
                            </ol>
                        </div>
                    </div>
                    <input type="hidden" name="rownum" id="rownum" value="<?php echo htmlentities($num) ?>">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tax">Tax</label>
                                <input type="number" class="form-control" id="tax" name="tax" onchange="sum_amounts()"
                                    min="0" step="<?php echo htmlentities($step_string); ?>" value="<?php echo htmlentities($tax); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="expense">Expense</label>
                                <input type="number" class="form-control" id="expense" name="expense"
                                    onchange="sum_amounts()" min="0" step="<?php echo htmlentities($step_string); ?>"
                                    value="<?php echo htmlentities($expense); ?>" required>
                            </div>


                            <div class="form-group">
                                <label for="discount">Discount</label>
                                <input type="number" class="form-control" id="discount" name="discount"
                                    onchange="discount_percent_();sum_amounts();" min="0" step="<?php echo htmlentities($step_string); ?>"
                                    value="<?php echo htmlentities($discount); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="discount_percent">Discount Percent</label>
                                <input type="number" class="form-control" id="discount_percent" name="discount_percent"
                                    onchange="discount_();sum_amounts()" min="0" max="100" step="<?php echo htmlentities($step_string); ?>"
                                    value="<?php echo htmlentities($discount_percent) ?>" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="total_amount">Total Amount</label>
                                <input type="number" class="form-control" id="total_amount" name="total_amount"
                                    onchange="sum_amounts()" min="0" step="<?php echo htmlentities($step_string); ?>"
                                    value="<?php echo htmlentities($total_amount) ?>" readonly required>
                            </div>



                            <div class="form-group">
                                <label for="tax">Grand Total</label>
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
                                    value="<?php echo htmlentities($net_amount); ?>" readonly required>
                            </div>
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="invoice_print">
                        <label class="custom-control-label" for="defaultUnchecked">Invoice Print</label>
                    </div>
                    <!-- <input type="submit" name="update" value="Update Delivery" class="btn btn-primary"> -->
                    <button type="submit" name="update" class="btn btn-primary">Update Delivery</button>
                    <input type="button" value="Cancel"
                        onclick="window.location.href ='<?php echo $common_form_route . "?frm=delivery_list" ?>'"
                        class="btn btn-secondary">
                    <a href="handler/sale/delivery/delivery_handler.php?delete=1&invoice_id=<?php echo $invoice_id ?>"
                        class="btn btn-danger">Delete Transaction</a>
                    <input type="button" value="List"
                        onclick="window.location.href ='<?php echo $common_form_route . "?frm=delivery_list" ?>'"
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