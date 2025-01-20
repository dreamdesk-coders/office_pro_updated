<?php

error_reporting(0);

if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

    if (isset($_GET['f_date']) && isset($_GET['t_date'])) {
        $f_date = $_GET['f_date'];
        $t_date = $_GET['t_date'];
        // $f_currency_id = $_GET['f_currency_id'];
        // $t_currency_id = $_GET['t_currency_id'];
        // $f_office_id = $_GET['f_office_id'];
        // $t_office_id = $_GET['t_office_id'];

        //  For company name
        $sql = "Select * From foundation";
        $query = $dbh->prepare($sql);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);

        $client_name = $result->client_name;
        $client_address = $result->address;
        $client_phone_no = $result->phone_no;
        $home_currency = $result->home_currency;

        //income
        // $sql_income = "Select currency_id,Sum(CONCAT(status, amount)) as balance,SUM(CASE WHEN CONCAT(status, amount)>0 THEN amount ELSE 0 END) as income , SUM(CASE WHEN CONCAT(status, amount)<0 THEN amount ELSE 0 END) as cashout_total From cash_balance where date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and currency_id between :f_currency_id and :t_currency_id  and status = '+' and  transaction_type <> 'Delivery Transaction' and transaction_type <> 'Sale Transaction'  group by currency_id order by currency_id asc";
        $sql_income = "SELECT currency_id,SUM(CASE WHEN currency_id = 'MMK' THEN CONCAT(status, amount) ELSE CONCAT(status, amount * exchange_rate) END) AS balance, SUM(CASE WHEN CONCAT(status, amount * exchange_rate) > 0 THEN amount ELSE 0 END) AS income, SUM(CASE WHEN CONCAT(status, amount * exchange_rate) < 0 THEN amount ELSE 0 END) AS cashout_total FROM cash_balance
        WHERE
        date between :f_date and :t_date AND
            status = '+'
            AND transaction_type NOT IN ('Delivery Transaction', 'Sale Transaction')
        GROUP BY
            currency_id
        ORDER BY
            currency_id ASC";
        $query_income = $dbh->prepare($sql_income);

        $query_income->bindParam(':f_date', $f_date, PDO::PARAM_STR);

        $query_income->bindParam(':t_date', $t_date, PDO::PARAM_STR);
        // $query_income->bindParam(':f_currency_id', $f_currency_id, PDO::PARAM_STR);
        // $query_income->bindParam(':t_currency_id', $t_currency_id, PDO::PARAM_STR);
        // $query_income->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
        // $query_income->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);

        $query_income->execute();
        $results_income = $query_income->fetchAll(PDO::FETCH_OBJ);
        $number_of_income = $query_income->rowcount();

        //sale

        // $sql_sale = "Select currency_id,Sum(CONCAT(status, amount)) as balance,SUM(CASE WHEN CONCAT(status, amount)>0 THEN amount ELSE 0 END) as sale_total From cash_balance where date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and currency_id between :f_currency_id and :t_currency_id  and  transaction_type = 'Delivery Transaction' or transaction_type = 'Sale Transaction'  group by currency_id order by currency_id asc";
        $sql_sale = "SELECT currency_id,SUM(CASE WHEN currency_id = 'MMK' THEN CONCAT(status, amount) ELSE CONCAT(status, amount * exchange_rate) END) AS sale_total, SUM(CASE WHEN CONCAT(status, amount * exchange_rate) > 0 THEN amount ELSE 0 END) AS income, SUM(CASE WHEN CONCAT(status, amount * exchange_rate) < 0 THEN amount ELSE 0 END) AS cashout_total FROM cash_balance
        WHERE
        date between :f_date and :t_date AND
            status = '+'
            AND transaction_type  IN ('Delivery Transaction', 'Sale Transaction')
        GROUP BY
            currency_id
        ORDER BY
            currency_id ASC";
        $query_sale = $dbh->prepare($sql_sale);

        $query_sale->bindParam(':f_date', $f_date, PDO::PARAM_STR);

        $query_sale->bindParam(':t_date', $t_date, PDO::PARAM_STR);
        // $query_sale->bindParam(':f_currency_id', $f_currency_id, PDO::PARAM_STR);
        // $query_sale->bindParam(':t_currency_id', $t_currency_id, PDO::PARAM_STR);
        // $query_sale->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
        // $query_sale->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);

        $query_sale->execute();
        $results_sale = $query_sale->fetchAll(PDO::FETCH_OBJ);
        $number_of_sale = $query_sale->rowcount();

        // total

        //$sql3 = "Select currency_id,Sum(CONCAT(status, amount)) as balance,SUM(CASE WHEN CONCAT(status, amount)>0 THEN amount ELSE 0 END) as cashin_total , SUM(CASE WHEN CONCAT(status, amount)<0 THEN amount ELSE 0 END) as cashout_total From cash_balance where date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and currency_id between :f_currency_id and :t_currency_id group by currency_id order by currency_id asc";
        $sql3 = "SELECT currency_id,SUM(CASE WHEN currency_id = 'MMK' THEN CONCAT(status, amount) ELSE CONCAT(status, amount * exchange_rate) END) AS balance, SUM(CASE WHEN CONCAT(status, amount * exchange_rate) > 0 THEN amount ELSE 0 END) AS cashin_total, SUM(CASE WHEN CONCAT(status, amount * exchange_rate) < 0 THEN amount ELSE 0 END) AS cashout_total FROM cash_balance
        WHERE
        date between :f_date and :t_date
        GROUP BY
            currency_id
        ORDER BY
            currency_id ASC";

        $query3 = $dbh->prepare($sql3);

        $query3->bindParam(':f_date', $f_date, PDO::PARAM_STR);

        $query3->bindParam(':t_date', $t_date, PDO::PARAM_STR);
        // $query3->bindParam(':f_currency_id', $f_currency_id, PDO::PARAM_STR);
        // $query3->bindParam(':t_currency_id', $t_currency_id, PDO::PARAM_STR);
        // $query3->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
        // $query3->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);

        $query3->execute();
        $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
        $number_of_rows = $query3->rowcount();

    } else {
    }
    ?>

<link rel="stylesheet" type="text/css" href="assets/css/report.css">

<div class="nav-bar no-print">
    <button class="btn btn-light print" onclick="window.print();">Print</button>
    <button id="exportExcel" class="btn btn-light" onclick="javascript:exportExcel('cash_balance_report')">Excel
        Export</button>
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
            <h5 class="title">Profit & Loss Report</h5>
            <hr><br>




            <?php
if ($number_of_rows > 0) {
        foreach ($results3 as $result3) {

            ?>
            <!-- Start Print Content -->
            <table class="print-content table table-bordered">
                <!-- <h6 class="groupby">
                    <b> ( Home Currency : <?php echo htmlentities($result3->currency_id); ?> )</b>
                </h6> -->
                <?php }?>
                <h6 class="groupby">Income (+)</p>
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Transaction ID</th>
                            <th scope="col">Transaction Type</th>
                            <th scope="col">Date</th>
                            <th scope="col">Office ID</th>
                            <th scope="col">Currency ID</th>
                            <th scope="col">Income (+)</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
$num = 1;
        //  $sql = "Select * From cash_balance where  date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and currency_id between :f_currency_id and :t_currency_id  and currency_id = :group_currency_id  and status = '+' and  transaction_type <> 'Delivery Transaction' and transaction_type <> 'Sale Transaction'  order by date asc";
        $sql = "SELECT
            *,
            CASE
                WHEN currency_id <> 'MMK' THEN exchange_rate * amount
                ELSE amount
            END AS amt
        FROM
            cash_balance
        WHERE
        date between :f_date and :t_date AND
            status = '+'
            AND transaction_type NOT IN ('Delivery Transaction', 'Sale Transaction')
        ORDER BY
            date ASC";
        $query = $dbh->prepare($sql);

        $query->bindParam(':f_date', $f_date, PDO::PARAM_STR);
        $query->bindParam(':t_date', $t_date, PDO::PARAM_STR);
        // $query->bindParam(':f_currency_id', $f_currency_id, PDO::PARAM_STR);
        // $query->bindParam(':t_currency_id', $t_currency_id, PDO::PARAM_STR);
        // $query->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
        // $query->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);
        // $query->bindParam(':group_currency_id', $result3->currency_id, PDO::PARAM_STR);

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
            echo date_format($date, "d/m/Y");?>
                            </td>
                            <td>
                                <?php echo htmlentities($result->office_id); ?>
                            </td>
                            <td>
                                <!-- <?php echo htmlentities($result->currency_id); ?> -->
                                MMK
                            </td>
                            <td style="text-align: right;">
                                <?php
if ($result->status == '+') {
                echo htmlentities($result->amt);
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

                            <td style="text-align:center" colspan="6"><b>Income (+) Total</b></td>
                            <td style="text-align:right" colspan="8"><b>
                                    <?php

        if ($number_of_income != 0) {
            foreach ($results_income as $results_income) {

                echo htmlentities($results_income->income);

            }
        } else {
            echo '0';
        }

        ?>
                                </b></td>
                        </tr>





                    </tbody>
            </table>

            <br>

            <table class="print-content table table-borderless">
                <tbody>
                    <tr>
                        <td style="border:none">
                            <h6 style="font-weight:bold">Cost of Sale</h6>
                        </td>
                        <td style="border:none">
                            <h6 style="font-weight:bold;    text-align: right !important;">

                                <?php

        if ($number_of_sale != 0) {
            foreach ($results_sale as $results_sale) {

                echo htmlentities($results_sale->sale_total);

            }
        } else {
            echo '0';
        }

        ?>

                            </h6>
                        </td>
                    </tr>

                    <tr>
                        <td style="border:none">
                            <h6 style="font-weight:bold">Gross Profit</h6>
                        </td>
                        <td style="border:none">
                            <h6 style="font-weight:bold;    text-align: right !important;">

                                <?php echo htmlentities($result3->cashin_total); ?>

                            </h6>
                        </td>
                    </tr>

                </tbody>
            </table>

            <br>
            <table class="print-content table table-bordered">

                <h6 class="groupby">Expense (-)</p>
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Transaction ID</th>
                            <th scope="col">Transaction Type</th>
                            <th scope="col">Date</th>
                            <th scope="col">Office ID</th>
                            <th scope="col">Currency ID</th>
                            <th scope="col">Expense (-)</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
$num = 1;
        // $sql = "Select * From cash_balance where  date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and currency_id between :f_currency_id and :t_currency_id  and currency_id = :group_currency_id  and status = '-'  order by date asc";
        $sql = "SELECT
            *,
            CASE
                WHEN currency_id <> 'MMK' THEN exchange_rate * amount
                ELSE amount
            END AS amt
        FROM
            cash_balance
        WHERE
        date between :f_date and :t_date AND
            status = '-'
            AND transaction_type NOT IN ('Delivery Transaction', 'Sale Transaction')
        ORDER BY
            date ASC";
        $query = $dbh->prepare($sql);

        $query->bindParam(':f_date', $f_date, PDO::PARAM_STR);
        $query->bindParam(':t_date', $t_date, PDO::PARAM_STR);
        // $query->bindParam(':f_currency_id', $f_currency_id, PDO::PARAM_STR);
        // $query->bindParam(':t_currency_id', $t_currency_id, PDO::PARAM_STR);
        // $query->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
        // $query->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);
        // $query->bindParam(':group_currency_id', $result3->currency_id, PDO::PARAM_STR);

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
            echo date_format($date, "d/m/Y");?>
                            </td>
                            <td>
                                <?php echo htmlentities($result->office_id); ?>
                            </td>
                            <td>
                                <!-- <?php echo htmlentities($result->currency_id); ?> -->
                                MMK
                            </td>
                            <td style="text-align: right;">
                                <?php
if ($result->status == '-') {
                echo htmlentities($result->amt);
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

                            <td style="text-align:center" colspan="6"><b>Expense (-) Total</b></td>
                            <td style="text-align:right" colspan="8"><b id="cashout_total">
                                    <?php echo htmlentities($result3->cashout_total); ?>
                                </b></td>
                        </tr>





                    </tbody>
            </table>

            <br>

            <table class="table print-content table-borderless">
                <tbody>
                    <tr>
                        <td style="border:none">
                            <h5 style="font-weight:bold">Net Profit / Loss</h5>
                        </td>
                        <td style="border:none">
                            <h5 style="font-weight:bold;    text-align: right !important;">
                                <?php

        echo htmlentities($result3->balance);

        ?> </h5>
                        </td>
                    </tr>
                </tbody>
            </table>


            <br>
            <?php

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
<?php }?>