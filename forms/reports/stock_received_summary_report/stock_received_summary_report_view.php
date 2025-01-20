<?php

error_reporting(0);

if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

    if (isset($_GET['f_office_id']) && isset($_GET['t_office_id'])) {
        $f_date = $_GET['f_date'];
        $t_date = $_GET['t_date'];
        $f_received_id = $_GET['f_received_id'];
        $t_received_id = $_GET['t_received_id'];
        $f_currency_id = $_GET['f_currency_id'];
        $t_currency_id = $_GET['t_currency_id'];
        $f_staff_id = $_GET['f_staff_id'];
        $t_staff_id = $_GET['t_staff_id'];
        $f_office_id = $_GET['f_office_id'];
        $t_office_id = $_GET['t_office_id'];
        $group_by = $_GET['group_by'];
        $received_type = $_GET['received_type'];




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
        <button id="exportExcel" class="btn btn-light" onclick="javascript:exportExcel('stock_received_summary_report')">Excel Export</button>
    </div>

    <table id="stock_received_summary_report" class="voucher">
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
                <h5 class="title">Stock Received Summary Report</h5>
                <hr><br>

                <?php

                if ($received_type == "normal") {
                    $sql3 = "Select received_date,$group_by,sum(total_amount) as grand_total_amount From stock_received where received_date between :f_date and :t_date and received_id between :f_received_id and :t_received_id and currency_id between :f_currency_id and :t_currency_id and staff_id between :f_staff_id and :t_staff_id and office_id between :f_office_id and :t_office_id  and transfer_id = '' group by received_date,$group_by order by received_date asc";
                } else if ($received_type == "transfer") {
                    $sql3 = "Select received_date,$group_by,sum(total_amount) as grand_total_amount From stock_received where received_date between :f_date and :t_date and received_id between :f_received_id and :t_received_id and currency_id between :f_currency_id and :t_currency_id and staff_id between :f_staff_id and :t_staff_id and office_id between :f_office_id and :t_office_id and transfer_id <> '' group by received_date,$group_by order by received_date asc";
                } else {
                    $sql3 = "Select received_date,$group_by,sum(total_amount) as grand_total_amount From stock_received where received_date between :f_date and :t_date and received_id between :f_received_id and :t_received_id and currency_id between :f_currency_id and :t_currency_id and staff_id between :f_staff_id and :t_staff_id and office_id between :f_office_id and :t_office_id group by received_date,$group_by order by received_date asc";
                }
                $query3 = $dbh->prepare($sql3);

                $query3->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                $query3->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                $query3->bindParam(':f_received_id', $f_received_id, PDO::PARAM_STR);
                $query3->bindParam(':t_received_id', $t_received_id, PDO::PARAM_STR);
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

                <h6 class="groupby" style="text-align: right;width: 90%;"><b class="type-box">Received Type : <?php echo strtoupper($received_type) ?></b></h6><br>

                <?php
                if ($number_of_rows > 0) {
                    foreach ($results3 as $result3) {

                ?>
                        <!-- Start Print Content -->
                        <table class="print-content table table-bordered">
                            <h6 class="groupby">

                                <b> Received Date : <?php $date = date_create($result3->received_date);
                                                    echo date_format($date, "d/m/Y"); ?>
                                    ( Currency ID : <?php echo htmlentities($result3->currency_id); ?> )</b>

                                <br>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th style="width: 100px;">Received ID</th>
                                        <th style="width: 110px;">Date</th>
                                        <th>Transfer ID</th>
                                        <th>From Office ID</th>
                                        <th>To Office ID</th>
                                        <th>Staff ID</th>
                                        <th style="width: 300px;">Remark</th>
                                        <th>Currency ID</th>
                                        <th>Exchange Rate</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    // $sql = "Select * From stock_received where received_date between :f_date and :t_date and received_id between :f_received_id and :t_received_id and currency_id between :f_currency_id and :t_currency_id and staff_id between :f_staff_id and :t_staff_id and office_id between :f_office_id and :t_office_id and received_date = :group_received_date and currency_id = :group_currency_id order by received_date asc";

                                    if ($received_type == "normal") {
                                        $sql = "Select * From stock_received where received_date between :f_date and :t_date and received_id between :f_received_id and :t_received_id and currency_id between :f_currency_id and :t_currency_id and staff_id between :f_staff_id and :t_staff_id and office_id between :f_office_id and :t_office_id  and received_date = :group_received_date and  currency_id = :group_currency_id and transfer_id = ''  order by received_date asc";
                                    } else if ($received_type == "transfer") {
                                        $sql = "Select * From stock_received where received_date between :f_date and :t_date and received_id between :f_received_id and :t_received_id and currency_id between :f_currency_id and :t_currency_id and staff_id between :f_staff_id and :t_staff_id and office_id between :f_office_id and :t_office_id and  received_date = :group_received_date and currency_id = :group_currency_id and transfer_id <> '' order by received_date asc";
                                    } else {
                                        $sql = "Select * From stock_received where received_date between :f_date and :t_date and received_id between :f_received_id and :t_received_id and currency_id between :f_currency_id and :t_currency_id and staff_id between :f_staff_id and :t_staff_id and office_id between :f_office_id and :t_office_id  and received_date = :group_received_date and currency_id = :group_currency_id order by received_date asc";
                                    }

                                    $query = $dbh->prepare($sql);

                                    $query->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                                    $query->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                                    $query->bindParam(':f_received_id', $f_received_id, PDO::PARAM_STR);
                                    $query->bindParam(':t_received_id', $t_received_id, PDO::PARAM_STR);
                                    $query->bindParam(':f_currency_id', $f_currency_id, PDO::PARAM_STR);
                                    $query->bindParam(':t_currency_id', $t_currency_id, PDO::PARAM_STR);
                                    $query->bindParam(':f_staff_id', $f_staff_id, PDO::PARAM_STR);
                                    $query->bindParam(':t_staff_id', $t_staff_id, PDO::PARAM_STR);
                                    $query->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                                    $query->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);
                                    $query->bindParam(':group_received_date', $result3->received_date, PDO::PARAM_STR);
                                    $query->bindParam(':group_currency_id', $result3->currency_id, PDO::PARAM_STR);


                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                                    $num = 1;




                                    foreach ($results as $result) {
                                        //  For from office name
                                        $sql_from_office = "Select * From stock_transfer where transfer_id = :transfer_id";
                                        $query_from_office = $dbh->prepare($sql_from_office);
                                        $query_from_office->bindParam(':transfer_id', $result->transfer_id, PDO::PARAM_STR);
                                        $query_from_office->execute();

                                        $result_from_office = $query_from_office->fetch(PDO::FETCH_OBJ);
                                    ?>


                                        <tr>
                                            <td>
                                                <?php echo $num ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->received_id); ?>
                                            </td>
                                            <td>
                                                <?php $date = date_create($result->received_date);
                                                echo date_format($date, "d/m/Y"); ?>
                                            </td>
                                            <td>
                                                <?php 
                                                if($result->transfer_id == "")
                                                {echo "-";
                                                } else{
                                                    echo htmlentities($result->transfer_id);
                                                }
                                                ?>
                                            </td>
                                            <td>
                                            <?php 
                                                if($result->transfer_id == "")
                                                {echo "-";
                                                } else{
                                                    echo htmlentities($result_from_office->office_id);
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->office_id); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->staff_id); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->remark); ?>
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
                                        </tr>



                                    <?php

                                        $num = $num + 1;
                                    }

                                    ?>

                                    <tr>

                                        <td style="text-align:center" colspan="9"><b>Grand Total</b></td>
                                        <td style="text-align:right" colspan="8"><b>
                                                <?php echo htmlentities($result3->grand_total_amount); ?>
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