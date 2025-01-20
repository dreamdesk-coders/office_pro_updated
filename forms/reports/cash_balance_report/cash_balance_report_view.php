<?php

error_reporting(0);

if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

    if (isset($_GET['f_office_id']) && isset($_GET['t_office_id'])) {
        $f_date = $_GET['f_date'];
        $t_date = $_GET['t_date'];
        $f_currency_id = $_GET['f_currency_id'];
        $t_currency_id = $_GET['t_currency_id'];
        $f_office_id = $_GET['f_office_id'];
        $t_office_id = $_GET['t_office_id'];


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
        <button id="exportExcel" class="btn btn-light" onclick="javascript:exportExcel('cash_balance_report')">Excel Export</button>
    </div>

    <table id="cash_balance_report" class="voucher">
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
                <h5 class="title">Cash Balance Report</h5>
                <hr><br>

                <?php


                $sql3 = "Select currency_id,Sum(CONCAT(status, amount)) as balance,SUM(CASE WHEN CONCAT(status, amount)>0 THEN amount ELSE 0 END) as cashin_total , SUM(CASE WHEN CONCAT(status, amount)<0 THEN amount ELSE 0 END) as cashout_total From cash_balance where date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and currency_id between :f_currency_id and :t_currency_id group by currency_id order by currency_id asc";
                $query3 = $dbh->prepare($sql3);

                $query3->bindParam(':f_date', $f_date, PDO::PARAM_STR);

                $query3->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                $query3->bindParam(':f_currency_id', $f_currency_id, PDO::PARAM_STR);
                $query3->bindParam(':t_currency_id', $t_currency_id, PDO::PARAM_STR);
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
                                <b> ( Currency ID : <?php echo htmlentities($result3->currency_id); ?> )</b>
                            </h6>

                                
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Transaction ID</th>
                                        <th scope="col">Transaction Type</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Office ID</th>
                                        <th scope="col">Currency ID</th>
                                        <th scope="col">Cash In (+)</th>
                                        <th scope="col">Cash Out (-)</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $num = 1;
                                    $sql = "Select * From cash_balance where date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and currency_id between :f_currency_id and :t_currency_id  and currency_id = :group_currency_id order by date asc";
                                    $query = $dbh->prepare($sql);

                                    $query->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                                    $query->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                                    $query->bindParam(':f_currency_id', $f_currency_id, PDO::PARAM_STR);
                                    $query->bindParam(':t_currency_id', $t_currency_id, PDO::PARAM_STR);
                                    $query->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                                    $query->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);
                                    $query->bindParam(':group_currency_id', $result3->currency_id, PDO::PARAM_STR);

                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);




                                    foreach ($results as $result) {
                                    ?>


                                        <tr>
                                            <td>
                                                <?php echo $num ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->transaction_id); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->transaction_type); ?>
                                            </td>
                                            <td>
                                                <?php $date = date_create($result->date);
                                                echo date_format($date, "d/m/Y"); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->office_id); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->currency_id); ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php
                                                if ($result->status == '+') {
                                                    echo htmlentities($result->amount);
                                                } else {
                                                    echo "<p style='text-align:center'>-</p>";
                                                }
                                                ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php
                                                if ($result->status == '-') {
                                                    echo htmlentities($result->amount);
                                                } else {
                                                    echo "<p style='text-align:center'>-</p>";
                                                }
                                                ?>
                                            </td>

                                        </tr>



                                    <?php

                                        $num = $num + 1;
                                    }

                                    ?>
                                    <tr>

                                        <td style="text-align:center" colspan="6"><b>Cash In (+) Total</b></td>
                                        <td style="text-align:right" colspan="8"><b>
                                                <?php echo htmlentities($result3->cashin_total); ?>
                                            </b></td>
                                    </tr>
                                    <tr>

                                        <td style="text-align:center" colspan="6"><b>Cash Out (-) Total</b></td>
                                        <td style="text-align:right" colspan="8"><b>
                                                <?php echo htmlentities($result3->cashout_total); ?>
                                            </b></td>
                                    </tr>

                                    <tr>

                                        <td style="text-align:center" colspan="6"><b>Balance</b></td>
                                        <td style="text-align:right" colspan="8"><b>
                                                <?php echo htmlentities($result3->balance); ?>
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