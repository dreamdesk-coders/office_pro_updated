<?php
$inventory_module = $_SESSION['inventory_module'];
if ($inventory_module == "0") {
    echo "<script> window.location.href = '$common_form_route?frm=not_activated&m=inventory'; </script>";
}
error_reporting(0);

if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

    if (isset($_GET['id'])) {
        $transfer_id = $_GET['id'];

        $sql = "Select * From stock_transfer WHERE transfer_id=:transfer_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':transfer_id', $transfer_id, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);


        $transfer_id = $result->transfer_id;
        $transfer_date = $result->transfer_date;
        $staff_id = $result->staff_id;
        $currency_id = $result->currency_id;
        $office_id = $result->office_id;
        $to_office_id = $result->to_office_id;
        $exchange_rate = $result->exchange_rate;
        $total_amount = $result->total_amount;
        $remark = $result->remark;

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

    <body>
        <div class="nav-bar no-print">
            <button class="btn btn-light print" onclick="window.print();">Print</button>
            <button id="exportExcel" class="btn btn-light" onclick="javascript:exportExcel('stock_transfer')">Excel Export</button>


        </div>

        <div class="voucher" id="stock_transfer">
            <div class="page-header">
                <div class="heading">
                    <img src="assets/images/voucher/voucher-logo.png" class="voucher-logo">
                    <h3 style="margin-left:20px;"><?php echo $client_name ?></h3>
                </div>

                <h5 class="title">Stock Transfer Voucher</h5><br><br>
                <div class="heading-2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6 head">
                                <table class="top-data">
                                    <tr>
                                        <th>
                                            <p>Transfer Id</p>
                                            <p class="data">
                                        </th>
                                        <td>: <?php echo $transfer_id ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <p>Date</p>
                                        </th>
                                        <td>
                                            <p class="data"> : <?php $date = date_create($transfer_date);
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
                            <div class="col-sm-6 head">
                                <table class="top-data custom">
                                    <tr>
                                        <th>
                                            <p>Staff Id</p>
                                        </th>
                                        <td>
                                            <p class="data"> : <?php echo $staff_id ?></p>
                                    </tr>
                                    <tr>
                                        <th>
                                            <p>From Office Id</p>
                                        </th>
                                        <td>
                                            <p class="data"> : <?php echo $office_id ?></p>
                                        </td>

                                    </tr>
                                    <tr>
                                        <th>
                                            <p>To Office Id</p>
                                        </th>
                                        <td>
                                            <p class="data"> : <?php echo $to_office_id ?></p>
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

                                            $sql = "Select * From stock_transfer_details where transfer_id=:transfer_id ";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':transfer_id', $transfer_id, PDO::PARAM_STR);
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
                                                    <td>
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
                                                <td><b>Total</b></td>
                                                <td><b><?php echo $total_amount ?></b></td>
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
                                <table>
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

                        </td>
                    </tr>
                </tfoot>

            </table>
        </div>
        </div>
        <div class="foot-div no-print"></div>

    </body>

<?php } ?>
<style>
    .custom th {
        width: 150px !important;
    }
</style>