<?php
$sale_module = $_SESSION['sale_module'];
if ($sale_module == "0") {
    echo "<script> window.location.href = '$common_form_route?frm=not_activated&m=sale'; </script>";
}
error_reporting(0);

if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

    if (isset($_GET['id'])) {
        $invoice_id = $_GET['id'];

        $sql = "Select * From sale_return WHERE invoice_id=:invoice_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);


        $invoice_id = $result->invoice_id;
        $invoice_date = $result->invoice_date;
        $staff_id = $result->staff_id;
        $currency_id = $result->currency_id;
        $customer_id = $result->customer_id;
        $exchange_rate = $result->exchange_rate;
        $total_amount = $result->total_amount;
        $grand_total_amount = $result->grand_total_amount;
        $expense = $result->expense;
        $refund_amount = $result->refund_amount;
        $net_amount = $result->net_amount;
        $remark = $result->remark;


        //For customer name
        $sql = "Select * From customer where customer_id=:customer_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':customer_id', $customer_id, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        $customer_name = $result->customer_name;
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
    <button id="exportExcel" class="btn btn-light" onclick="javascript:exportExcel('sale_return')">Excel Export</button>


</div>

<div class="voucher" id="sale_return">
    <div class="page-header">
        <div class="heading">
            <img src="assets/images/voucher/voucher-logo.png" class="voucher-logo">
            <h3 style="margin-left:20px;"><?php echo $client_name ?></h3>
        </div>

        <h5 class="title">Sale Return Voucher</h5><br>
        <hr>
        <div class="heading-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 head">
                        <table class="top-data">
                            <tr>
                                <th>
                                    <p>Invoice ID</p>
                                </th>
                                <td>: <?php echo $invoice_id; ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <p>Date</p>
                                </th>
                                <td>
                                    <p class="data"> : <?php $date = date_create($invoice_date);
                                                            echo date_format($date, "d/m/Y"); ?></p>
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
                            <tr>
                                <th>
                                    <p>Currency</p>
                                </th>
                                <td>
                                    <p class="data"> : <?php echo $currency_id; ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-6 head">
                        <table class="top-data">
                            <tr>
                                <th>
                                    <p>Staff ID</p>
                                </th>
                                <td>
                                    <p class="data"> : <?php echo $staff_id ?></p>
                            </tr>
                            <tr>
                                <th>
                                    <p>Customer Name</p>
                                </th>
                                <td>
                                    <p class="data"> : <?php echo $customer_name ?></p>
                            </tr>
                            <tr>
                                <th>
                                    <p style="width:135px;">Address</p>
                                </th>
                                <td>
                                    <p class="data"> : <?php echo $address ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <p>Exchange Rate</p>
                                </th>
                                <td>
                                    <p class="data"> : <?php echo $exchange_rate ?></p>
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

                                        $sql = "Select * From sale_return_details where invoice_id=:invoice_id ";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
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
                                            <b>Total Amount</b>
                                            <br>
                                            <b>Expense</b>
                                            <br>
                                            <b>Grand Total</b>
                                            <br>
                                            <b>Refund Amount</b>
                                            <br>
                                            <b>Net Amount</b>
                                        </td>
                                        <td style="text-align:right">
                                            <b><?php echo $total_amount ?></b>
                                            <br>
                                            <b><?php echo $expense ?></b>
                                            <br>
                                            <b><?php echo $grand_total_amount ?></b>
                                            <br>
                                            <b><?php echo $refund_amount ?></b>
                                            <br>
                                            <b><?php echo $net_amount ?></b>
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