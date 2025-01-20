<?php

include("forms/common/side_menu.php");
include("forms/common/lookup.php");
error_reporting(0);
if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

    if (isset($_GET['id'])) {
        $expense_id = $_GET['id'];

        $sql = "Select * From expenses WHERE expense_id=:expense_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':expense_id', $expense_id, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);

        $expense_id = $result->expense_id;
        $expense_date = $result->expense_date;
        $currency_id = $result->currency_id;
        $exchange_rate = $result->exchange_rate;
        $staff_id = $result->staff_id;
        $office_id = $result->office_id;
        $total_amount = $result->total_amount;
        $remark = $result->remark;
    } else {

        // header('location:$common_form_route?frm=office_use_list');
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

    <script type="text/javascript" src="assets/js/expenses/daily_expense/daily_expense.js"></script>
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
                    <form method="POST" action="handler/expenses/daily_expense/daily_expense_handler.php" class="frm_">
                        <h4>Daily Expense</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="expense_id">Expense ID</label>
                                    <input type="text" class="form-control" id="expense_id" name="expense_id" value="<?php echo htmlentities($expense_id); ?>" readonly required>
                                </div>

                                <div class="form-group">
                                    <label for="expense_date">Date</label>
                                    <input type="date" class="form-control" id="expense_date" name="expense_date" value="<?php echo htmlentities($expense_date); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="staff_id">Staff ID <small><label id="lbl_staff_id"></label></small></label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="staff_id" name="staff_id" onchange="check_data_exist('staff','staff_id',$('#staff_id').val(), this.id,'lbl_staff_id')" value="<?php echo htmlentities($staff_id); ?>" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_staff_id"></button>
                                    </div>
                                </div>

                                <label for="currency_id">Currency ID <small><label id="lbl_currency_id"></label></small></label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="currency_id" name="currency_id" onchange="check_data_exist('currency','currency_id',$('#currency_id').val(), this.id,'lbl_currency_id')" value="<?php echo htmlentities($currency_id); ?>" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_currency_id"></button>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exchange_rate">Exchange Rate</label>
                                    <input type="number" class="form-control" id="exchange_rate" name="exchange_rate" min="0" value="<?php echo htmlentities($exchange_rate); ?>" required>
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
                                <br>
                                <input type="button" class="btn btn-info" id="addRow" value="Add New Row" onclick="addNewRow()" />
                                <br><br>
                                <ol>
                                <div class="res-table">
                                    <table class="table table-striped" id="_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Expense Master ID</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                            $sql = "Select * From expenses_details where expense_id=:expense_id";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':expense_id', $expense_id, PDO::PARAM_STR);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $num = 1;

                                            foreach ($results as $result) {

                                                $emid = $result->exp_master_id;
                                                $amount = $result->amount;


                                                $sql = "Select * From expense_master where expense_id=:emid";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':emid', $emid, PDO::PARAM_STR);
                                                $query->execute();
                                                $result = $query->fetch(PDO::FETCH_OBJ);

                                                $description = $result->description;

                                            ?>


                                                <tr>
                                                    <td>
                                                        <li></li>
                                                    </td>
                                                    <td>
                                                        <div class="input-group mb-3">
                                                            <input type="text" value="<?php echo $emid ?>" class="form-control" id="emid<?php echo $num ?>" name="emid<?php echo $num ?>" onchange="check_expense_master(this.id)" required>
                                                            <div class="input-group-append">
                                                                <input type="button" class="btn btn-outline-secondary lookup-btn" id="<?php echo $num ?>" onclick="get_expense_master(this.id)">
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>

                                                        <label id="desc<?php echo $num ?>" name="desc<?php echo $num ?>">
                                                            <?php echo htmlentities($description); ?>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <input type="number" id="amount<?php echo $num ?>" name="amount<?php echo $num ?>" value="<?php echo $amount ?>" class="form-control" min="0" onchange="sum_amounts()">
                                                    </td>
                                                    <td>
                                                        <input type="button" class="btn btn-danger" onclick="removeRow(this);" value="Remove">
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
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="total_amount">Total Amount</label>
                                    <input type="number" class="form-control" id="total_amount" name="total_amount" onchange="sum_amounts()" min="0" value="<?php echo htmlentities($total_amount) ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="invoice_print">
                            <label class="custom-control-label" for="defaultUnchecked">Invoice Print</label>
                        </div>
                        <button type="submit" name="update" class="btn btn-primary">Update Daily Expense</button>

                        <input type="button" value="Cancel" onclick="window.location.href ='<?php echo $common_form_route . "?frm=daily_expense_list" ?>'" class="btn btn-secondary">

                        <a href="handler/expenses/daily_expense/daily_expense_handler.php?delete=1&expense_id=<?php echo $expense_id ?>" class="btn btn-danger">Delete Transaction</a>

                        <input type="button" value="List" onclick="window.location.href ='<?php echo $common_form_route . "?frm=daily_expense_list" ?>'" class="btn btn-info">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var rownum = $("#rownum").val() - 1;
    </script>

<?php } ?>