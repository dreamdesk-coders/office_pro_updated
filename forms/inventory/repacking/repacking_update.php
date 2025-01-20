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
        $slip_id = $_GET['id'];

        $sql = "Select * From repacking WHERE slip_id=:slip_id";
        $query = $dbh -> prepare($sql);
        $query->bindParam(':slip_id',$slip_id,PDO::PARAM_STR);
        $query->execute();

        $result= $query->fetch(PDO::FETCH_OBJ);

            $slip_id = $result->slip_id;
            $slip_date = $result->slip_date;
            $staff_id = $result->staff_id;
            $office_id = $result->office_id;
            $from_stock_id = $result->from_stock_id;
            $from_unit_id = $result->from_unit_id;
            $from_quantity = $result->from_quantity;
            $remark = $result->remark;

    }
    else{

        // header('location:$common_form_route?frm=repacking_list');
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

<script type="text/javascript" src="assets/js/inventory/repacking/repacking.js"></script>
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
                <form method="POST" action="handler/inventory/repacking/repacking_handler.php" class="frm_"> 
                    <h4>Repacking</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                            <label for="slip_id">Slip ID</label>
                            <input type="text" class="form-control" id="slip_id" name="slip_id" value="<?php echo htmlentities($slip_id);?>" readonly required>
                            </div>

                            <div class="form-group">
                            <label for="slip_date">Date</label>
                            <input type="date" class="form-control" id="slip_date" name="slip_date" value="<?php echo htmlentities($slip_date);?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">

                            <label for="staff_id">Staff ID <small><label id="lbl_staff_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="staff_id" name="staff_id" onchange="check_data_exist('staff','staff_id',$('#staff_id').val(), this.id,'lbl_staff_id')" value="<?php echo htmlentities($staff_id);?>" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_from_stock_id"></button>
                                </div>
                            </div>

                            <label for="staff_id">From Stock ID <small><label id="lbl_from_stock_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="from_stock_id" name="from_stock_id" onchange="check_data_exist('stock','stock_id',$('#from_stock_id').val(), this.id,'lbl_from_stock_id')" value="<?php echo htmlentities($from_stock_id);?>" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_from_stock_id"></button>
                                </div>
                            </div>


                        </div>
                        <div class="col-md-4">

                            <label for="from_unit_id">From Unit ID <small><label id="lbl_from_unit_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="from_unit_id" name="from_unit_id" onchange="check_data_exist('stock_unit','stock_id',$('#from_stock_id').val(), this.id,'lbl_from_stock_id')" value="<?php echo htmlentities($from_unit_id);?>" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_from_unit_id"></button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="from_quantity">From Quantity</label>
                                <input type="number" class="form-control" id="from_quantity" name="from_quantity" min="0" value="<?php echo htmlentities($from_quantity);?>" onchange="get_stock_balance_fq($('#from_stock_id').val(), $('#from_unit_id').val(), $('#from_quantity').val(), <?php echo $from_quantity ?>,this.id)" required>
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
                                    <th scope="col">To Stock ID</th>
                                    <th scope="col">Stock Name</th>
                                    <th scope="col">To Unit ID</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $sql = "Select * From repacking_details where slip_id=:slip_id";
                                    $query = $dbh -> prepare($sql);
                                    $query->bindParam(':slip_id',$slip_id,PDO::PARAM_STR);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $num = 1;

                                    foreach($results as $result){

                                    $to_stock_id = $result->to_stock_id;
                                    $to_unit_id = $result->to_unit_id;
                                    $quantity = $result->quantity;
                                    $price = $result->price;                              

                                        $sql = "Select * From stock where stock_id=:to_stock_id";
                                        $query = $dbh -> prepare($sql);
                                        $query->bindParam(':to_stock_id',$to_stock_id,PDO::PARAM_STR);
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
                                            <input type="text" value="<?php echo $to_stock_id ?>" class="form-control" id="sid<?php echo $num ?>" name="sid<?php echo $num ?>" onchange="check_parent_stock(this.id);" required>
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
                                            <input type="text" value="<?php echo $to_unit_id ?>" id="unit_id<?php echo htmlentities($num) ?>" name="unit_id<?php echo $num ?>" onchange="check_child_su(this.id);get_stock_price(this.id, 'P');reset_qty_on_unit_change(this.id);sum_amounts();" class="form-control" required>
                                            <div class="input-group-append">
                                                <input type="button" class="btn btn-outline-secondary lookup-btn" id="<?php echo $num ?>" onclick="get_child_su(this.id);">
                                            </div>
                                        </div>
                                        </td>
                                        <td>
                                            <input type="number" id="<?php echo htmlentities('quantity'.$num) ?>" name="quantity<?php echo $num ?>" value="<?php echo htmlentities($quantity); ?>" class="form-control" min="0" onchange="sum_amounts(),get_stock_balance(this.id)">
                                        </td>
                                        <td>
                                            <input type="number" id="price<?php echo $num ?>" name="price<?php echo $num ?>" value="<?php echo htmlentities($price) ?>" class="form-control" min="0" step="<?php echo htmlentities($step_string); ?>" onchange="sum_amounts()">
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
                    <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="invoice_print">
                            <label class="custom-control-label" for="defaultUnchecked">Invoice Print</label>
                        </div>
                     <input type="hidden" name="rownum" id="rownum" value="<?php echo htmlentities($num) ?>">
                    <button type="submit" name="update" class="btn btn-primary">Update Repacking</button>
                
                    <input type="button" value="Cancel" onclick="window.location.href ='<?php echo $common_form_route."?frm=repacking_list" ?>'" class="btn btn-secondary">
                    
                    <a href="handler/inventory/repacking/repacking_handler.php?delete=1&slip_id=<?php echo $slip_id ?>" class="btn btn-danger">Delete Transaction</a>

                    <input type="button" value="List" onclick="window.location.href ='<?php echo $common_form_route."?frm=repacking_list" ?>'" class="btn btn-info">
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    var rownum = $("#rownum").val() -1;
 
</script>

<?php } ?>

