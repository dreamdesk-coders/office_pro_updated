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

        $sql = "Select * From delivery WHERE invoice_id=:invoice_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);


        $invoice_id = $result->invoice_id;
        $invoice_date = $result->invoice_date;
        // $staff_id = $result->staff_id;
        $currency_id = $result->currency_id;
        $customer_id = $result->customer_id;
        $exchange_rate = $result->exchange_rate;
        $total_amount = $result->total_amount;
        $grand_total_amount = $result->grand_total_amount;
        $paid_amount = $result->paid_amount;
        $expense = $result->expense;
        $discount = $result->discount;
        $tax = $result->tax;
        $net_amount = $result->net_amount;
        $delivery_type = $result->delivery_type;
        $remark = $result->remark;


        //For customer name
        $sql = "Select * From customer where customer_id=:customer_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':customer_id', $customer_id, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        $customer_name = $result->customer_name;
        $address = $result->address;
        $phone_no = $result->phone_no;

        //  For company name 
        $sql = "Select * From foundation";
        $query = $dbh->prepare($sql);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);
        $client_name = $result->client_name;
        $client_address = $result->address;
        $client_phone_no = $result->phone_no;
    } else {
    }


?>

    <link rel="stylesheet" type="text/css" href="assets/css/voucher_print.css">

    <div class="nav-bar no-print">
        <button class="btn btn-light print" onclick="window.print();">Print</button>
        <button id="exportExcel" class="btn btn-light" onclick="javascript:exportExcel('delivery')">Excel Export</button>
    </div>

    <table id="delivery" class="voucher">
        <!-- Start Header -->
        <thead>
            <tr>
                <td>
                    <div class="heading">
                        <img src="assets/images/voucher/voucher-logo.png" class="voucher-logo">
                        <h3><?php echo $client_name ?></h3>
                    </div>
                    <p class="address">
                        <?php echo $client_address ?><br>
                        <?php echo $client_phone_no ?>
                    </p>
                    <br>
                    <h5 class="title">Delivery Sale Voucher</h5>
                    <hr><br>
                    <!-- <br><br><br> -->

                </td>
            </tr>
        </thead>
        <!-- End Header -->
        <tr>
            <td>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 head-data">
                            <table class="top-data">
                                <tr>
                                    <th>
                                        <p>Invoice ID</p>
                                    </th>
                                    <td>: <?php echo $invoice_id ?></p>
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
                                        <p>Currency ID</p>
                                    </th>
                                    <td>
                                        <p class="data"> : <?php echo $currency_id ?> (Rate : <?php echo $exchange_rate ?>)</p>
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
                        <div class="col-6 head-data">
                            <table class="top-data">
                                <tr>
                                    <th>
                                        <p>Customer</p>
                                    </th>
                                    <td>
                                        <p class="data"> : <?php echo $customer_name ?></p>
                                </tr>
                                <tr>
                                    <th>
                                        <p>Phone</p>
                                    </th>
                                    <td>
                                        <p class="data"> : <?php echo $phone_no ?></p>
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
                <br>
                <!-- Start Print Content -->
                <table class="print-content table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Stock ID</th>
                            <th scope="col">Stock Name</th>
                            <th scope="col" style="width : 126px">Unit</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col" style="text-align: right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        $sql = "Select * From delivery_details where invoice_id=:invoice_id ";
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
                        <tr style="line-height: 2.5;">

                            <td colspan="3"><b>Type : <?php echo $delivery_type ?></b></td>
                            <td colspan="3" style="text-align : right">
                                <b>Total Amount</b>

                                <?php
                                if ($tax != 0) {
                                ?>
                                    <br>
                                    <b>Tax</b>

                                <?php } ?>
                                <?php
                                if ($expense != 0) {
                                ?>
                                    <br>
                                    <b>Expense</b>

                                <?php } ?>
                                <?php
                                if ($discount != 0) {
                                ?>
                                    <br>
                                    <b>Discount</b>

                                <?php } ?>
                                <br>
                                <b>Grand Total</b>
                                <br>
                                <b>Paid Amount</b>
                                <br>
                                <b>Net Amount</b>
                            </td>
                            <td style="text-align:right">
                                <b><?php echo $total_amount ?></b>

                                <?php
                                if ($tax != 0) {
                                ?>
                                    <br>
                                    <b><?php echo $tax ?></b>

                                <?php } ?>

                                <?php
                                if ($expense != 0) {
                                ?>
                                    <br>
                                    <b><?php echo $expense ?></b>

                                <?php } ?>
                                <?php
                                if ($discount != 0) {
                                ?>
                                    <br>
                                    <b><?php echo $discount ?></b>

                                <?php } ?>
                                <br>
                                <b><?php echo $grand_total_amount ?></b>
                                <br>
                                <b><?php echo $paid_amount ?></b>
                                <br>
                                <b><?php echo $net_amount ?></b>
                            </td>

                        </tr>

                    </tbody>
                </table>
                <div class="print-footer">

                    <table class="normal-footer">
                        <tr>
                            <td colspan="2">
                                <p style="margin-left: 40px;">Received the above in good order and condition.</p>
                            </td>
                        </tr>
                        <tr>

                            <td style="position: relative;">

                                <p style="margin-left: 50px;">Received By</p><br><br>
                                ..........................................................<p style="margin-left: 30px;">Customer's Signature</p>
                            </td>




                            <td style="text-align: right;position:relative"><br><br><br><br>
                                ............................................................ <p style="margin-right: 30px;">Authorised Signature</p>
                            </td>
                        </tr>
                    </table>

                </div>
                <!-- End Print Content -->
            </td>
        </tr>

        <!-- Start Space For Footer -->
        <tfoot>
            <tr>
                <td class="footer-space" style="height : 8cm">
                    <!-- Leave this empty and don't remove it. This space is where footer placed on print -->
                </td>
            </tr>
        </tfoot>
        <!-- End Space For Footer -->
    </table>

    <!-- Start Footer -->

    <!-- End Footer -->

    <div class="foot-div no-print"></div>
<?php } ?>