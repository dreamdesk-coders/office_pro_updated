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

if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

    if(isset($_GET['id'])){
        $transfer_id = $_GET['id'];

        $sql = "Select * From stock_transfer WHERE transfer_id=:transfer_id";
        $query = $dbh -> prepare($sql);
        $query->bindParam(':transfer_id',$transfer_id,PDO::PARAM_STR);
        $query->execute();

        $result= $query->fetch(PDO::FETCH_OBJ);


            $transfer_id = $result->transfer_id;
            $transfer_date = $result->transfer_date;
            $staff_id = $result->staff_id;
            $currency_id = $result->currency_id;
            $office_id = $result->office_id;
            $to_office_id = $result->to_office_id;
            $exchange_rate = $result->exchange_rate;
            $total_amount = $result->total_amount;
            $remark = $result->remark;

           
        

    }
    else{

        // header('location:$common_form_route?frm=purchase_list');
    }




    ?>
    <style type="text/css">
    
        ol{
            padding: 0px !important;
        }
        li{
           float: right;
        }

    </style>

<script type="text/javascript" src="assets/js/inventory/stock_transfer/stock_transfer.js"></script>
<div class="main-content">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include("forms/common/alerts.php"); ?>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="handler/inventory/stock_transfer/stock_transfer_handler.php" class="frm_"> 
                    <h4>Stock Transfer</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                            <label for="transfer_id">Transfer ID</label>
                            <input type="text" class="form-control" id="transfer_id" name="transfer_id" value="<?php echo htmlentities($transfer_id);?>" readonly required>
                            </div>

                            <div class="form-group">
                            <label for="transfer_date">Date</label>
                            <input type="date" class="form-control" id="transfer_date" name="transfer_date" value="<?php echo htmlentities($transfer_date);?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="staff_id">Staff ID <small><label id="lbl_staff_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="staff_id" name="staff_id" onchange="check_data_exist('staff','staff_id',$('#staff_id').val(), this.id,'lbl_staff_id')" value="<?php echo htmlentities($staff_id);?>" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_staff_id"></button>
                                </div>
                            </div>

                            <label for="currency_id">Currency ID <small><label id="lbl_currency_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="currency_id" name="currency_id" onchange="check_data_exist('currency','currency_id',$('#currency_id').val(), this.id,'lbl_currency_id')" value="<?php echo htmlentities($currency_id);?>" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_currency_id"></button>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                            <label for="exchange_rate">Exchange Rate</label>
                            <input type="number" class="form-control" id="exchange_rate" name="exchange_rate" min="0" step="<?php echo htmlentities($step_string); ?>" value="<?php echo htmlentities($exchange_rate);?>" required>
                            </div>

                            <label for="to_office_id">To Office ID <small><label id="lbl_to_office_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="to_office_id" name="to_office_id" onchange="check_data_exist('office','office_id',$('#to_office_id').val(), this.id,'lbl_to_office_id')" value="<?php echo htmlentities($to_office_id);?>" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_to_office_id"></button>
                                </div>
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

                                    $sql = "Select * From stock_transfer_details where transfer_id=:transfer_id ";
                                    $query = $dbh -> prepare($sql);
                                    $query->bindParam(':transfer_id',$transfer_id,PDO::PARAM_STR);
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
                                            <input type="text" value="<?php echo $unit_id ?>" id="unit_id<?php echo htmlentities($num) ?>" name="unit_id<?php echo $num ?>" onchange="check_child_su(this.id);get_stock_price(this.id, 'P');reset_qty_on_unit_change(this.id);sum_amounts();" class="form-control" required>
                                            <div class="input-group-append">
                                                <input type="button" class="btn btn-outline-secondary lookup-btn" id="<?php echo $num ?>" onclick="get_child_su(this.id);">
                                            </div>
                                        </div>
                                        </td>
                                        <td>
                                            <input type="number" id="<?php echo htmlentities('quantity'.$num) ?>" name="quantity<?php echo $num ?>" value="<?php echo htmlentities($quantity); ?>" class="form-control" min="0" onchange="sum_amounts(),get_stock_balance_edit(this.id,'<?php echo $quantity ?>')" required>
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
                        <div class="col-md-6"></div>
                        <div class="col-md-3"></div>
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
                     <input type="submit" name="update" value="Update Stock Transfer" class="btn btn-primary">
                     <input type="button" value="Cancel" onclick="window.location.href ='<?php echo $common_form_route."?frm=stock_transfer_list" ?>'" class="btn btn-secondary">
                     
                     <a href="handler/inventory/stock_transfer/stock_transfer_handler.php?delete=1&transfer_id=<?php echo $transfer_id ?>" class="btn btn-danger">Delete Transaction</a>

                    <?php
                        $sql = "Select * From stock_received WHERE transfer_id=:transfer_id";
                        $query = $dbh -> prepare($sql);
                        $query->bindParam(':transfer_id',$transfer_id,PDO::PARAM_STR);
                        $query->execute();
                        $result= $query->fetch(PDO::FETCH_OBJ);
                        $received_id = $result->received_id;
                        
                        

                        $count = $query->rowCount();
                        if($count > 0){

                      ?>

                    <a href="<?php echo $common_form_route ?>?frm=st_stock_received_update&id=<?php echo $received_id ?>" class="btn btn-primary">Received</a>

                    <?php }else{ ?>

                    <a href="<?php echo $common_form_route ?>?frm=st_stock_received_add&id=<?php echo $transfer_id ?>" class="btn btn-primary">Receive</a>

                    <?php } ?>

                     <input type="button" value="List" onclick="window.location.href ='<?php echo $common_form_route."?frm=stock_transfer_list" ?>'" class="btn btn-info">
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    var rownum = $("#rownum").val() -1;
 
</script>

<?php } ?>

