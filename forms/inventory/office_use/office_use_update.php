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
error_reporting(0);
if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

    if (isset($_GET['id'])) {
        $use_id = $_GET['id'];

        $sql = "Select * From office_use WHERE use_id=:use_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':use_id', $use_id, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);

        $use_id = $result->use_id;
        $use_date = $result->use_date;
        $staff_id = $result->staff_id;
        $currency_id = $result->currency_id;
        $exchange_rate = $result->exchange_rate;
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

    <script type="text/javascript" src="assets/js/inventory/office_use/office_use.js"></script>
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
                    <form method="POST" action="handler/inventory/office_use/office_use_handler.php" class="frm_">
                        <h4>Office Use</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="use_id">Office Use ID</label>
                                    <input type="text" class="form-control" id="use_id" name="use_id" value="<?php echo htmlentities($use_id); ?>" readonly required>
                                </div>

                                <div class="form-group">
                                    <label for="use_date">Date</label>
                                    <input type="date" class="form-control" id="use_date" name="use_date" value="<?php echo htmlentities($use_date); ?>" required>
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
                                    <input type="number" class="form-control" id="exchange_rate" name="exchange_rate" min="0" step="<?php echo htmlentities($step_string); ?>" value="<?php echo htmlentities($exchange_rate); ?>" required>
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
                                                <th scope="col">Stock ID</th>
                                                <th scope="col">Stock Name</th>
                                                <th scope="col">Unit</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                            $sql = "Select * From office_use_details where use_id=:use_id";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':use_id', $use_id, PDO::PARAM_STR);
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
                                                            <input type="text" value="<?php echo $stock_id ?>" class="form-control" id="sid<?php echo $num ?>" name="sid<?php echo $num ?>" onchange="check_parent_stock(this.id);" required>
                                                            <div class="input-group-append">
                                                                <input type="button" class="btn btn-outline-secondary lookup-btn" id="<?php echo $num ?>" onclick="get_parent_stock(this.id);">
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>

                                                        <label id="s_name<?php echo $num ?>" name="s_name<?php echo $num ?>">
                                                            <?php echo htmlentities($stock_name); ?>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <div class="input-group mb-3">
                                                            <input type="text" value="<?php echo $unit_id ?>" id="unit_id<?php echo htmlentities($num) ?>" name="unit_id<?php echo $num ?>" onchange="check_child_su(this.id);reset_qty_on_unit_change(this.id);sum_amounts();" class="form-control" required>
                                                            <div class="input-group-append">
                                                                <input type="button" class="btn btn-outline-secondary lookup-btn" id="<?php echo $num ?>" onclick="get_child_su(this.id);">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="number" id="<?php echo htmlentities('quantity' . $num) ?>" name="quantity<?php echo $num ?>" value="<?php echo htmlentities($quantity); ?>" class="form-control" min="0" step="<?php echo htmlentities($step_string); ?>" onchange="sum_amounts(),get_stock_balance_edit(this.id,'<?php echo $quantity ?>')" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" id="price<?php echo $num ?>" name="price<?php echo $num ?>" value="<?php echo htmlentities($price) ?>" class="form-control" min="0" step="<?php echo htmlentities($step_string); ?>" onchange="sum_amounts()">
                                                    </td>
                                                    <td>
                                                        <input type="number" id="amount<?php echo $num ?>" name="amount<?php echo $num ?>" value="<?php echo $amount ?>" class="form-control" min="0" step="<?php echo htmlentities($step_string); ?>" onchange="sum_amounts()">
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
                                    <input type="number" class="form-control" id="total_amount" name="total_amount" step="<?php echo htmlentities($step_string); ?>" onchange="sum_amounts()" min="0" value="<?php echo htmlentities($total_amount) ?>" required>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4"></div>
                        <!-- <div class="col-md-12">
                            <br>
                            <input type="button" class="btn btn-info" id="addRow" value="Add New Row" onclick="addNewRow()" />
                            <br><br>
                            <ol>
                            <table class="table table-striped table-responsive" id="_table">
                                <thead>
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
                                </thead>
                                <tbody>

                                    <?php

                                    $sql = "Select * From office_use_details where use_id=:use_id";
                                    $query = $dbh -> prepare($sql);
                                    $query->bindParam(':use_id',$use_id,PDO::PARAM_STR);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $num = 1;

                                    foreach($results as $result){

                                    $stock_id = $result->stock_id;
                                    $unit_id = $result->unit_id;
                                    $quantity = $result->quantity;
                                    $price = $result->price;
                                    $amount = $quantity * $price;
                                    

                                        $sql = "Select * From stock where stock_id=:stock_id";
                                        $query = $dbh -> prepare($sql);
                                        $query->bindParam(':stock_id',$stock_id,PDO::PARAM_STR);
                                        $query->execute();
                                        $result= $query->fetch(PDO::FETCH_OBJ);

                                        $stock_name = $result->stock_name;

                                    ?>


                                    <tr>
                                        <td>
                                        <li></li>
                                        </td>
                                        <td>
                                        <div class="input-group mb-3">
                                            <input type="text" value="<?php echo $stock_id ?>" class="form-control" id="sid<?php echo $num ?>" name="sid<?php echo $num ?>" onchange="check_parent_stock(this.id);" required>
                                            <div class="input-group-append">
                                                <input type="button" class="btn btn-outline-secondary lookup-btn" id="<?php echo $num ?>" onclick="get_parent_stock(this.id);">
                                            </div>
                                        </div>
                                        </td>

                                        <td>

                                            <label id="s_name<?php echo $num ?>" name="s_name<?php echo $num ?>">
                                                <?php echo htmlentities($stock_name); ?>
                                            </label>
                                        </td>

                                        <td>
                                        <div class="input-group mb-3">
                                            <input type="text" value="<?php echo $unit_id ?>" id="unit_id<?php echo htmlentities($num) ?>" name="unit_id<?php echo $num ?>" onchange="check_child_su(this.id);get_stock_price(this.id, 'P');" class="form-control" required>
                                            <div class="input-group-append">
                                                <input type="button" class="btn btn-outline-secondary lookup-btn" id="<?php echo $num ?>" onclick="get_child_su(this.id);">
                                            </div>
                                        </div>
                                        </td>
                                        <td>
                                            <input type="number" id="<?php echo htmlentities('quantity'.$num) ?>" name="quantity<?php echo $num ?>" value="<?php echo htmlentities($quantity); ?>" class="form-control" min="0" step="<?php echo htmlentities($step_string); ?>" onchange="sum_amounts(),get_stock_balance(this.id)">
                                        </td>
                                        <td>
                                            <input type="number" id="price<?php echo $num ?>" name="price<?php echo $num ?>" value="<?php echo htmlentities($price) ?>" class="form-control" min="0" step="<?php echo htmlentities($step_string); ?>" onchange="sum_amounts()">
                                        </td>
                                        <td>
                                            <input type="number" id="amount<?php echo $num ?>" name="amount<?php echo $num ?>" value="<?php echo $amount ?>" class="form-control" min="0" step="<?php echo htmlentities($step_string); ?>" onchange="sum_amounts()">
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
                            </ol>

                        </div> -->
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="invoice_print">
                            <label class="custom-control-label" for="defaultUnchecked">Invoice Print</label>
                        </div>
                        <button type="submit" name="update" class="btn btn-primary">Update Office Use</button>

                        <input type="button" value="Cancel" onclick="window.location.href ='<?php echo $common_form_route . "?frm=office_use_list" ?>'" class="btn btn-secondary">

                        <a href="handler/inventory/office_use/office_use_handler.php?delete=1&use_id=<?php echo $use_id ?>" class="btn btn-danger">Delete Transaction</a>

                        <input type="button" value="List" onclick="window.location.href ='<?php echo $common_form_route . "?frm=office_use_list" ?>'" class="btn btn-info">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var rownum = $("#rownum").val() - 1;
    </script>

<?php } ?>