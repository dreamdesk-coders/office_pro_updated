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
        $sale_type = $_GET['sale_type'];
        $group_by = $_GET['group_by'];
        $transaction_type = $_GET['transaction_type'];
        $transaction_type_t = "{$transaction_type}_type";
        $limit = $_GET['limit'];


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
        <button id="exportExcel" class="btn btn-light" onclick="javascript:exportExcel('top_customer_report')">Excel Export</button>
    </div>

    <table id="top_customer_report" class="voucher">
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
                <h5 class="title">Top Customer Report</h5>
                <hr><br>

                <?php


                if ($sale_type == "all") {
                    $sql3 = "Select $group_by From $transaction_type where invoice_date between :f_date and :t_date and currency_id between :f_currency_id and :t_currency_id and office_id between :f_office_id and :t_office_id  group by $group_by order by currency_id asc limit $limit";
                } else {
                    $sql3 = "Select $group_by From $transaction_type where invoice_date between :f_date and :t_date and currency_id between :f_currency_id and :t_currency_id and office_id between :f_office_id and :t_office_id and $transaction_type_t = :sale_type group by $group_by order by currency_id asc limit $limit";
                }
                $query3 = $dbh->prepare($sql3);

                $query3->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                $query3->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                $query3->bindParam(':f_currency_id', $f_currency_id, PDO::PARAM_STR);
                $query3->bindParam(':t_currency_id', $t_currency_id, PDO::PARAM_STR);
                $query3->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                $query3->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);
                if ($sale_type != "all") {
                    $query3->bindParam(':sale_type', $sale_type, PDO::PARAM_STR);
                }

                $query3->execute();

                $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                $number_of_rows = $query3->rowcount();
                ?>
                <h6 class="groupby" style="text-align: right;width: 90%;"><b class="type-box">Transaction Type : <?php echo strtoupper($transaction_type) ?></b></h6><br>
                <h6 class="groupby" style="text-align: right;width: 90%;"><b class="type-box">Sale Type : <?php echo strtoupper($sale_type) ?></b></h6><br>


                <?php
                if ($number_of_rows > 0) {
                    foreach ($results3 as $result3) {

                ?>
                        <!-- Start Print Content -->
                        <table class="print-content table table-bordered">
                            <h6 class="groupby">

                                <b><?php
                                    if ($group_by == "currency_id") {
                                        echo " Currency ID : ", htmlentities($result3->currency_id);
                                    }
                                    ?></b>

                                <br>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Customer ID</th>
                                        <th>Customer Name</th>
                                        <th>Currency ID</th>
                                        <th>Total Invoice</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    if ($sale_type == "all") {
                                        $sql = "Select $transaction_type.customer_id,currency_id,customer.customer_name,sum(grand_total_amount) as grand_total From $transaction_type,customer where invoice_date between :f_date and :t_date and currency_id between :f_currency_id and :t_currency_id and office_id between :f_office_id and :t_office_id and currency_id = :group_currency_id and $transaction_type.customer_id = customer.customer_id group by $transaction_type.customer_id,currency_id order by grand_total desc limit $limit";
                                    } else {
                                        $sql = "Select $transaction_type.customer_id,currency_id,customer.customer_name,sum(grand_total_amount) as grand_total From $transaction_type,customer where invoice_date between :f_date and :t_date and currency_id between :f_currency_id and :t_currency_id and office_id between :f_office_id and :t_office_id and currency_id = :group_currency_id and $transaction_type_t = :sale_type and $transaction_type.customer_id = customer.customer_id group by $transaction_type.customer_id,currency_id order by grand_total desc limit $limit";
                                    }
                                    $query = $dbh->prepare($sql);

                                    $query->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                                    $query->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                                    $query->bindParam(':f_currency_id', $f_currency_id, PDO::PARAM_STR);
                                    $query->bindParam(':t_currency_id', $t_currency_id, PDO::PARAM_STR);
                                    $query->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                                    $query->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);
                                    $query->bindParam(':group_currency_id', $result3->currency_id, PDO::PARAM_STR);
                                    if ($sale_type != "all") {
                                        $query->bindParam(':sale_type', $sale_type, PDO::PARAM_STR);
                                    }


                                    $query->execute();

                                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                                    $num = 1;


                                    foreach ($results as $result) {

                                        //  For Total Invoice  
                                        $sql_invoice = "Select count(*) as total_invoice from $transaction_type where customer_id = :group_customer_id and currency_id = :group_currency_id ";
                                        $query_invoice = $dbh->prepare($sql_invoice);
                                        $query_invoice->bindParam(':group_customer_id', $result->customer_id, PDO::PARAM_STR);
                                        $query_invoice->bindParam(':group_currency_id', $result3->currency_id, PDO::PARAM_STR);
                                        $query_invoice->execute();

                                        $result_invoice = $query_invoice->fetch(PDO::FETCH_OBJ);


                                        $total_invoice = $result_invoice->total_invoice;
                                    ?>


                                        <tr>
                                            <td>
                                                <?php echo $num ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->customer_id); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->customer_name); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->currency_id); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($total_invoice); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->grand_total); ?>
                                            </td>
                                        </tr>



                                    <?php

                                        $num = $num + 1;
                                    }

                                    ?>

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