<?php
$inventory_module = $_SESSION['inventory_module'];
if($inventory_module == "0"){
    echo "<script> window.location.href = '$common_form_route?frm=not_activated&m=inventory'; </script>";
}
error_reporting(0);

if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

    if (isset($_GET['id'])) {
        $damage_id = $_GET['id'];

        $sql = "Select * From stock_damage WHERE damage_id=:damage_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':damage_id', $damage_id, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);


        $damage_id = $result->damage_id;
        $damage_date = $result->damage_date;
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
    } else {
    }


?>

    <link rel="stylesheet" type="text/css" href="assets/css/voucher.css">

    <div class="nav-bar no-print">
        <button class="btn btn-light print" onclick="window.print();">Print</button>
        <button id="exportExcel" class="btn btn-light" onclick="javascript:exportExcel('stock_damage')">Excel Export</button>


    </div>

    <div class="voucher" id="stock_damage">
        <div class="page-header">
            <div class="heading">
                <img src="assets/images/voucher/voucher-logo.png" class="voucher-logo">
                <h3 style="margin-left:20px;"><?php echo $client_name ?></h3>
            </div>

            <h5 class="title">Stock Damage Voucher</h5><br><br>
            <div class="heading-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 head">
                            <table class="top-data">
                                <tr>
                                    <th>
                                        <p>Damage Id</p>
                                    </th>
                                    <td>: <?php echo $damage_id ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <p>Date</p>
                                    </th>
                                    <td>
                                        <p class="data"> : <?php $date = date_create($damage_date);
                                                            echo date_format($date, "d/m/Y"); ?></p>
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
                                        <p>Remark</p>
                                    </th>
                                    <td>
                                        <p class="data"> : <?php echo $remark ?></p>
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

                                        $sql = "Select * From stock_damage_details where damage_id=:damage_id ";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':damage_id', $damage_id, PDO::PARAM_STR);
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
    <div class="foot-div no-print"></div>



<?php } ?>