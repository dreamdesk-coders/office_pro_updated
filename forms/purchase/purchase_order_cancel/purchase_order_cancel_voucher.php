<?php
$purchase_module = $_SESSION['purchase_module'];
if ($purchase_module == "0") {
    echo "<script> window.location.href = '$common_form_route?frm=not_activated&m=purchase'; </script>";
}
error_reporting(0);

if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

    if (isset($_GET['id'])) {
        $order_id = $_GET['id'];

        $sql = "Select * From purchase_order WHERE order_id=:order_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':order_id', $order_id, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);


        $order_id = $result->order_id;
        $order_date = $result->order_date;
        $cancel_date = $result->cancel_date;
        $staff_id = $result->staff_id;
        $currency_id = $result->currency_id;
        $supplier_id = $result->supplier_id;
        $exchange_rate = $result->exchange_rate;
        $total_amount = $result->total_amount;
        $tax = $result->tax;
        $remark = $result->remark;


        //For supplier name
        $sql = "Select * From supplier where supplier_id=:supplier_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':supplier_id', $supplier_id, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        $supplier_name = $result->supplier_name;
        $address = $result->address;

        //  For company name 
        $sql = "Select * From foundation";
        $query = $dbh->prepare($sql);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);


        $client_name = $result->client_name;
    } else {
    }


?>

    <link rel="stylesheet" type="text/css" href="assets/css/voucher.css">

    <div class="nav-bar no-print">
        <button class="btn btn-light print" onclick="window.print();">Print</button>
        <button id="exportExcel" class="btn btn-light" onclick="javascript:exportExcel('purchase_order')">Excel Export</button>


    </div>

    <div class="voucher" id="purchase_order">
        <div class="page-header">
            <div class="heading">
                <img src="assets/images/voucher/voucher-logo.png" class="voucher-logo">
                <h3 style="margin-left:20px;"><?php echo $client_name ?></h3>
            </div>

            <h5 class="title">Sale Order Cancel Voucher</h5><br>
            <hr>
            <div class="heading-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 head">
                            <table class="top-data">
                                <tr>
                                    <th>
                                        <p>Order Id</p>
                                    </th>
                                    <td>: <?php echo $order_id ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <p>Order Date</p>
                                    </th>
                                    <td>
                                        <p class="data"> : <?php $date = date_create($order_date);
                                                            echo date_format($date, "d/m/Y"); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <p>Cancel Date</p>
                                    </th>
                                    <td>
                                        <p class="data"> : <?php $cdate = date_create($cancel_date);
                                                            echo date_format($cdate, "d/m/Y"); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <p>Remark</p>
                                    </th>
                                    <td>
                                        <p class="data"> : <?php echo $remark ?></p>
                                    </td>
                                </tr>
                            </table>


                        </div>
                        <div class="col-sm-6 head">
                            <table class="top-data">
                                <tr>
                                    <th>
                                        <p>Staff Id</p>
                                    </th>
                                    <td>
                                        <p class="data"> : <?php echo $staff_id ?></p>
                                </tr>
                                <tr>
                                    <th>
                                        <p>Supplier Name</p>
                                    </th>
                                    <td>
                                        <p class="data"> : <?php echo $supplier_name ?></p>
                                </tr>
                                <tr>
                                    <th>
                                        <p style="width:135px;">Address</p>
                                    </th>
                                    <td>
                                        <p class="data"> : <?php echo $address ?></p>
                                    </td>

                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>



        <table class="voucher-table">

            <thead>
                <tr>
                    <td>
                        <!--place holder for the fixed-position header-->
                        <div class="page-header-space"></div>
                    </td>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>
                        <div class="page voucher-table-body">
                            <ol>
                                <table class="table" style="width: 94%;">
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

                                        $sql = "Select * From purchase_order_details where order_id=:order_id ";
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
                                                    <?php echo $num ?>
                                                </td>
                                                <td>
                                                    <?php echo $stock_id ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($stock_name); ?>
                                                </td>
                                                <td>
                                                    <?php echo $unit_id ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($quantity); ?>
                                                </td>
                                                <td>
                                                    <?php echo $price ?>
                                                </td>
                                                <td style="text-align:right">
                                                    <?php echo $amount ?>
                                                </td>
                                            </tr>

                                        <?php

                                            $num = $num + 1;
                                        }

                                        ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <b>Tax</b>
                                                <br>
                                                <b>Total Amount</b>
                                            </td>
                                            <td style="text-align:right">
                                                <b><?php echo $tax ?></b>
                                                <br>
                                                <b><?php echo $total_amount ?></b>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </ol>
                        </div>
                    </td>
                </tr>
            </tbody>

            <tfoot>
                <tr>
                    <td>
                        <!--place holder for the fixed-position footer-->
                        <div class="page-footer-space"></div>
                        <div class="page-footer">

                        </div>


                    </td>
                </tr>
            </tfoot>

        </table>

    </div>
    <div class="foot-div no-print"></div>



<?php } ?>