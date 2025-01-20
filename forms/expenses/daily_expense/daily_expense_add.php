<?php
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
include("handler/common/common_functions.php");
error_reporting(0);
if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

?>
    <style type="text/css">
        ol {
            padding: 0px !important;
        }

        li {
            float: right;
        }
    </style>
    <script type="text/javascript" src="assets/js/expenses/daily_expense/daily_expense.js"></script>
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
                    <form method="POST" action="handler/expenses/daily_expense/daily_expense_handler.php" class="frm_">
                        <h4>Daily Expense</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="expense_id">Expense ID</label>
                                    <input type="text" class="form-control" id="expense_id" name="expense_id" onchange="check_id_exist('expenses','expense_id',this.id)" required>
                                </div>

                                <div class="form-group">
                                    <label for="expense_date">Date</label>
                                    <input type="date" class="form-control" id="expense_date" name="expense_date" required>
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

                                <label for="currency_id">Currency ID <small><label id="lbl_currency_id"></label></small></label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="currency_id" name="currency_id" onchange="check_data_exist('currency','currency_id',$('#currency_id').val(), this.id,'lbl_currency_id')" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_currency_id"></button>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exchange_rate">Exchange Rate</label>
                                    <input type="number" class="form-control" id="exchange_rate" name="exchange_rate" min="0" required>
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
                                    <table class="table table-striped" id="_table">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Expense Master ID</th>
                                            <th scope="col">Description</th>
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
                                    <input type="number" class="form-control" id="total_amount" name="total_amount" min="0" value="0" onchange="sum_amounts()" required>
                                </div>
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="invoice_print">
                            <label class="custom-control-label" for="defaultUnchecked">Invoice Print</label>
                        </div>
                        <input type="submit" name="save" value="Add Daily Expense" class="btn btn-primary">
                        <input type="button" value="Cancel" onclick="window.location.href ='<?php echo $common_form_route . "?frm=office_use_list" ?>'" class="btn btn-secondary">
                        <input type="button" value="List" onclick="window.location.href ='<?php echo $common_form_route . "?frm=office_use_list" ?>'" class="btn btn-info">
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