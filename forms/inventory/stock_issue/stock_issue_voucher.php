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
        $issue_id = $_GET['id'];

        $sql = "Select * From stock_issue WHERE issue_id=:issue_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':issue_id', $issue_id, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);


        $issue_id = $result->issue_id;
        $issue_date = $result->issue_date;
        $staff_id = $result->staff_id;
        $currency_id = $result->currency_id;
        $office_id = $result->office_id;
        $exchange_rate = $result->exchange_rate;
        $total_amount = $result->total_amount;
        $remark = $result->remark;

        //  For company name 
        $sql = "Select * From foundation";
        $query = $dbh->prepare($sql);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);


        $client_name = $result->client_name;

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
        <button id="exportExcel" class="btn btn-light" onclick="javascript:exportExcel('stock_issue')">Excel Export</button>
    </div>

    <table id="stock_issue" class="voucher">
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
                    <h5 class="title">Stock Issue Voucher</h5>
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
                        <div class="col-sm-6 head-data">
                            <table class="top-data">
                                <tr>
                                    <th>
                                        <p>Issue ID</p>
                                    </th>
                                    <td>: <?php echo $issue_id ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <p>Date</p>
                                    </th>
                                    <td>
                                        <p class="data"> : <?php $date = date_create($issue_date);
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
                            </table>


                        </div>
                        <div class="col-sm-6 head-data">
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
                                        <p>Office ID</p>
                                    </th>
                                    <td>
                                        <p class="data"> : <?php echo $office_id ?></p>
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
                            <th scope="col">Unit</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Amount</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php

$sql = "Select * From stock_issue_details where issue_id=:issue_id ";
$query = $dbh->prepare($sql);
$query->bindParam(':issue_id', $issue_id, PDO::PARAM_STR);
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
            <?php echo $num ?>
        </td>
        <td style="text-align: right;">
            <?php echo $amount ?>
        </td>
    </tr>


                        <?php

                            $num = $num + 1;
                        }

                        ?>
                        <tr style="line-height: 2.5;">
                            <td colspan="6" style="text-align : right">
                                <b>Total Amount</b>

                              
                            </td>
                            <td style="text-align: right;">
                            <b><?php echo $total_amount ?></b>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <div class="print-footer">

                    <table class="normal-footer" style="text-align: center;line-height:3">
                        <tr>
                            <td>
                                <p>Prepaired By</p>.............................................
                            </td>
                            <td>
                                <p>Approved By</p>..............................................
                            </td>
                            <td>
                                <p>Receored By</p>..............................................
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Signature</p>.................................................
                            </td>
                            <td>
                                <p>Signature</p>.................................................
                            </td>
                            <td>
                                <p>Signature</p>.................................................
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
                <td class="footer-space" style="height : 9cm">
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