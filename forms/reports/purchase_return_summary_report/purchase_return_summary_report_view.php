<?php

error_reporting(0);

if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

    if (isset($_GET['f_office_id']) && isset($_GET['t_office_id'])) {
        $f_date = $_GET['f_date'];
        $t_date = $_GET['t_date'];
        $f_invoice_id = $_GET['f_invoice_id'];
        $t_invoice_id = $_GET['t_invoice_id'];
        $f_supplier_id = $_GET['f_supplier_id'];
        $t_supplier_id = $_GET['t_supplier_id'];
        $f_currency_id = $_GET['f_currency_id'];
        $t_currency_id = $_GET['t_currency_id'];
        $f_staff_id = $_GET['f_staff_id'];
        $t_staff_id = $_GET['t_staff_id'];
        $f_office_id = $_GET['f_office_id'];
        $t_office_id = $_GET['t_office_id'];
        $group_by = $_GET['group_by'];


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

    <link rel="stylesheet" type="text/css" href="assets/css/report.css">

    <div class="nav-bar no-print">
        <button class="btn btn-light print" onclick="window.print();">Print</button>
        <button id="exportExcel" class="btn btn-light" onclick="javascript:exportExcel('purchase_return_summary_report')">Excel Export</button>
    </div>

    <table id="purchase_return_summary_report" class="voucher">
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
                <h5 class="title">Purchase Return Summary Report</h5>
                <hr><br>

                <?php


                $sql3 = "Select invoice_date,$group_by,sum(net_amount) as net_total_amount From purchase_return where invoice_date between :f_date and :t_date and invoice_id between :f_invoice_id and :t_invoice_id and supplier_id between :f_supplier_id and :t_supplier_id and currency_id between :f_currency_id and :t_currency_id and staff_id between :f_staff_id and :t_staff_id and office_id between :f_office_id and :t_office_id  group by invoice_date,$group_by order by invoice_date asc";

                $query3 = $dbh->prepare($sql3);

                $query3->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                $query3->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                $query3->bindParam(':f_invoice_id', $f_invoice_id, PDO::PARAM_STR);
                $query3->bindParam(':t_invoice_id', $t_invoice_id, PDO::PARAM_STR);
                $query3->bindParam(':f_supplier_id', $f_supplier_id, PDO::PARAM_STR);
                $query3->bindParam(':t_supplier_id', $t_supplier_id, PDO::PARAM_STR);
                $query3->bindParam(':f_currency_id', $f_currency_id, PDO::PARAM_STR);
                $query3->bindParam(':t_currency_id', $t_currency_id, PDO::PARAM_STR);
                $query3->bindParam(':f_staff_id', $f_staff_id, PDO::PARAM_STR);
                $query3->bindParam(':t_staff_id', $t_staff_id, PDO::PARAM_STR);
                $query3->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                $query3->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);


                $query3->execute();
                $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                $number_of_rows = $query3->rowcount();
                ?>



                <?php
                if ($number_of_rows > 0) {
                    foreach ($results3 as $result3) {

                ?>
                        <!-- Start Print Content -->
                        <table class="print-content table table-bordered">
                            <h6 class="groupby">

                                <b> Return Date : <?php $date = date_create($result3->invoice_date);
                                                    echo date_format($date, "d/m/Y"); ?>
                                    (<?php
                                        if ($group_by == "currency_id") {
                                            echo " Currency ID : ", htmlentities($result3->currency_id);
                                        } else {
                                            echo " Supplier ID : ", htmlentities($result3->supplier_id);
                                        }
                                        ?> )</b>

                                <br>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Invoice ID</th>
                                        <th>Invoice Date</th>
                                        <th>Office ID</th>
                                        <th>Staff ID</th>
                                        <th>Supplier ID</th>
                                        <th>Supplier Name</th>
                                        <th>Currency ID</th>
                                        <th>Exchange Rate</th>
                                        <th>Total Amount</th>
                                        <th>Expenese</th>
                                        <th>Grand Total</th>
                                        <th>Refund Amount</th>
                                        <th>Net Amount</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $sql = "Select * From purchase_return where invoice_date between :f_date and :t_date and invoice_id between :f_invoice_id and :t_invoice_id and supplier_id between :f_supplier_id and :t_supplier_id and currency_id between :f_currency_id and :t_currency_id and staff_id between :f_staff_id and :t_staff_id and office_id between :f_office_id and :t_office_id and invoice_date = :group_invoice_date and $group_by = :group_by_id order by invoice_date asc";

                                    $query = $dbh->prepare($sql);

                                    $query->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                                    $query->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                                    $query->bindParam(':f_invoice_id', $f_invoice_id, PDO::PARAM_STR);
                                    $query->bindParam(':t_invoice_id', $t_invoice_id, PDO::PARAM_STR);
                                    $query->bindParam(':f_supplier_id', $f_supplier_id, PDO::PARAM_STR);
                                    $query->bindParam(':t_supplier_id', $t_supplier_id, PDO::PARAM_STR);
                                    $query->bindParam(':f_currency_id', $f_currency_id, PDO::PARAM_STR);
                                    $query->bindParam(':t_currency_id', $t_currency_id, PDO::PARAM_STR);
                                    $query->bindParam(':f_staff_id', $f_staff_id, PDO::PARAM_STR);
                                    $query->bindParam(':t_staff_id', $t_staff_id, PDO::PARAM_STR);
                                    $query->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                                    $query->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);
                                    $query->bindParam(':group_invoice_date', $result3->invoice_date, PDO::PARAM_STR);
                                    if ($group_by == "supplier_id") {
                                        $query->bindParam(':group_by_id', $result3->supplier_id, PDO::PARAM_STR);
                                    } else {
                                        $query->bindParam(':group_by_id', $result3->currency_id, PDO::PARAM_STR);
                                    }

                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                                    $num = 1;



                                    foreach ($results as $result) {

                                           //  For supplier name 
                                           $sql_supplier = "Select * From supplier where supplier_id = :supplier_id";
                                           $query_supplier = $dbh->prepare($sql_supplier);
                                           $query_supplier->bindParam(':supplier_id', $result->supplier_id, PDO::PARAM_STR);
                                           $query_supplier->execute();
   
                                           $result_supplier = $query_supplier->fetch(PDO::FETCH_OBJ);
                                    ?>


                                        <tr>
                                            <td>
                                                <?php echo $num ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->invoice_id); ?>
                                            </td>
                                            <td>
                                                <?php $date = date_create($result->invoice_date);
                                                echo date_format($date, "d/m/Y"); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->office_id); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->staff_id); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->supplier_id); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result_supplier->supplier_name); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->currency_id); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->exchange_rate); ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php echo htmlentities($result->total_amount); ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php echo htmlentities($result->expense); ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php echo htmlentities($result->grand_total_amount); ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php echo htmlentities($result->refund_amount); ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php echo htmlentities($result->net_amount); ?>
                                            </td>
                                        </tr>



                                    <?php

                                        $num = $num + 1;
                                    }

                                    ?>

                                    <tr>

                                        <td style="text-align:center" colspan="12"><b>Net Total</b></td>
                                        <td style="text-align:right" colspan="8"><b>
                                                <?php echo htmlentities($result3->net_total_amount); ?>
                                            </b></td>
                                    </tr>


                                </tbody>
                        </table>
                        <br>
                <?php

                    }
                } else {
                    echo "<script type='text/javascript' language='Javascript'>alert('There is no record to report');window.close();</script>";
                }

                ?>
                <div class="print-footer">


                </div>
                <!-- End Print Content -->
            </td>

        </tr>

        <!-- Start Space For Footer -->
        <tfoot>
            <tr>
                <td class="footer-space">
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