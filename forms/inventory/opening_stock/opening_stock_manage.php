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
        $office_id = $_GET['id'];

        $sql = "Select * From opening_stock_balance WHERE office_id=:office_id limit 1";
        $query = $dbh -> prepare($sql);
        $query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
        $query->execute();

        $result= $query->fetch(PDO::FETCH_OBJ);

            $date = $result->date;
            $currency_id = $result->currency_id;
    }
    else{

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

<script type="text/javascript" src="assets/js/inventory/opening_stock/opening_stock.js"></script>
<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="handler/inventory/opening_stock/opening_stock_handler.php" class="frm_">
                    <h4>Opening Stock Balance</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="transaction_office_id">Office ID</label>
                                <input type="text" class="form-control" id="transaction_office_id"
                                    name="transaction_office_id" value="<?php echo htmlentities($office_id);?>" readonly
                                    required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="opening_date">Opening Date</label>
                            <div class="form-group">
                                <input type="date" class="form-control" id="opening_date" name="opening_date" value="<?php echo htmlentities($date);?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="currency_id">Currency ID <small><label
                                        id="lbl_currency_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="currency_id" name="currency_id"
                                    onchange="check_data_exist('currency','currency_id',$('#currency_id').val(), this.id,'lbl_currency_id')"
                                    value="<?php echo htmlentities($currency_id);?>" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_currency_id"></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <br>
                            <input type="button" class="btn btn-info" id="addRow" value="Add New Row"
                                onclick="addNewRow()" />
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
                                            <th scope="col">Good Quantity</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                    $sql = "Select * From opening_stock_balance where office_id=:office_id order by stock_id asc";
                                    $query = $dbh -> prepare($sql);
                                    $query->bindParam(':office_id',$office_id,PDO::PARAM_STR);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $count = $query->rowCount();
                                    $num = 1;

                                    foreach($results as $result){

                                    $stock_id = $result->stock_id;
                                    $unit_id = $result->unit_id;
                                    $good_quantity = $result->good_quantity;
                                    $price = $result->price;
                                    

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
                                                    <input type="text" value="<?php echo $stock_id ?>"
                                                        class="form-control" id="sid<?php echo $num ?>"
                                                        name="sid<?php echo $num ?>"
                                                        onchange="check_parent_stock(this.id);" required>
                                                    <div class="input-group-append">
                                                        <input type="button"
                                                            class="btn btn-outline-secondary lookup-btn"
                                                            id="<?php echo $num ?>"
                                                            onclick="get_parent_stock(this.id);">
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
                                                    <input type="text" value="<?php echo $unit_id ?>"
                                                        id="unit_id<?php echo htmlentities($num) ?>"
                                                        name="unit_id<?php echo $num ?>"
                                                        onchange="check_child_su(this.id);get_stock_price(this.id, 'P');" class="form-control"
                                                        required>
                                                    <div class="input-group-append">
                                                        <input type="button"
                                                            class="btn btn-outline-secondary lookup-btn"
                                                            id="<?php echo $num ?>" onclick="get_child_su(this.id);">
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <input type="number" id="<?php echo htmlentities('gquantity'.$num) ?>"
                                                    name="gquantity<?php echo $num ?>"
                                                    value="<?php echo htmlentities($good_quantity); ?>" class="form-control"
                                                    min="0" onchange="sum_amounts(),get_stock_balance(this.id)">
                                            </td>

                                            <td>
                                                <input type="number" id="price<?php echo $num ?>"
                                                    name="price<?php echo $num ?>" value="<?php echo $price ?>"
                                                    class="form-control" min="0"
                                                    step="<?php echo htmlentities($step_string); ?>">
                                            </td>

                                            <td>
                                                <input type="button" class="btn btn-danger" onclick="removeRow(this);"
                                                    value="Remove">
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

                    <?php if($num > 0){?>
                    
                    <input type="hidden" name="rownum" id="rownum" value="<?php echo htmlentities($num) ?>">
                    <?php }else{?>
                    <input type="hidden" name="rownum" id="rownum" value="0">
                    <?php } ?>

                    <button type="submit" name="save" class="btn btn-primary">Save Opening Stock Balance</button>

                    <input type="button" value="Cancel"
                        onclick="window.location.href ='<?php echo $common_form_route."?frm=opening_stock_list" ?>'"
                        class="btn btn-secondary">

                    <a href="handler/inventory/opening_stock/opening_stock_handler.php?delete=1&transaction_office_id=<?php echo $office_id ?>"
                        class="btn btn-danger">Delete Transaction</a>

                    <input type="button" value="List"
                        onclick="window.location.href ='<?php echo $common_form_route."?frm=opening_stock_list" ?>'"
                        class="btn btn-info">
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
<?php if($count > 0){ ?>
var rownum = $("#rownum").val() - 1;

<?php }else{ ?>
    var rownum = $("#rownum").val();
    addNewRow();
<?php } ?>
</script>

<?php } ?>