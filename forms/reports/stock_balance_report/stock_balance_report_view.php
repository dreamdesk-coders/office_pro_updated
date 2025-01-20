<?php

error_reporting(0);

if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

    if (isset($_GET['f_office_id']) && isset($_GET['t_office_id'])) {
        $f_date = $_GET['f_date'];
        $t_date = $_GET['t_date'];
        $f_stock_id = $_GET['f_stock_id'];
        $t_stock_id = $_GET['t_stock_id'];
        $f_category_id = $_GET['f_category_id'];
        $t_category_id = $_GET['t_category_id'];
        $f_rg_id = $_GET['f_rg_id'];
        $t_rg_id = $_GET['t_rg_id'];
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
        $sub_start_date = $result->sub_start_date;
    } else {
    }
?>

    <link rel="stylesheet" type="text/css" href="assets/css/report.css">

    <div class="nav-bar no-print">
        <button class="btn btn-light print" onclick="window.print();">Print</button>
        <button id="exportExcel" class="btn btn-light" onclick="javascript:exportExcel('stock_balance_report')">Excel Export</button>
    </div>

    <table id="stock_balance_report" class="voucher">
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
                <h5 class="title">Stock Balance Report</h5>
                <hr><br>

                <?php

                if ($group_by == "stock") {
                    $sql_stock_id = "Select DISTINCT stock_id FROM stock_balance WHERE stock_id BETWEEN :f_stock_id and :t_stock_id order by stock_id";
                } else if ($group_by == "category") {
                    $sql_stock_id = "Select DISTINCT stock.category_id FROM stock_balance,stock WHERE stock.category_id BETWEEN :f_category_id and :t_category_id and stock_balance.date between :f_date and :t_date and stock_balance.office_id between :f_office_id and :t_office_id and stock_balance.stock_id = stock.stock_id order by stock.category_id";
                } else if ($group_by = "report_group") {
                    $sql_stock_id = "Select DISTINCT stock.rg_id FROM stock_balance,stock WHERE stock.rg_id BETWEEN :f_rg_id and :t_rg_id and stock_balance.date between :f_date and :t_date and stock_balance.office_id between :f_office_id and :t_office_id and stock_balance.stock_id = stock.stock_id order by stock.rg_id";
                } else {
                    $sql_stock_id = "Select DISTINCT stock_id FROM stock_balance WHERE stock_id BETWEEN :f_stock_id and :t_stock_id order by stock_id";
                }
                $query_stock_id = $dbh->prepare($sql_stock_id);

                if ($group_by == "stock") {
                    $query_stock_id->bindParam(':f_stock_id', $f_stock_id, PDO::PARAM_STR);
                    $query_stock_id->bindParam(':t_stock_id', $t_stock_id, PDO::PARAM_STR);
                } else if ($group_by == "category") {
                    $query_stock_id->bindParam(':f_category_id', $f_category_id, PDO::PARAM_STR);
                    $query_stock_id->bindParam(':t_category_id', $t_category_id, PDO::PARAM_STR);
                    $query_stock_id->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                    $query_stock_id->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);
                    $query_stock_id->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                    $query_stock_id->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                } else if ($group_by == "report_group") {
                    $query_stock_id->bindParam(':f_rg_id', $f_rg_id, PDO::PARAM_STR);
                    $query_stock_id->bindParam(':t_rg_id', $t_rg_id, PDO::PARAM_STR);
                    $query_stock_id->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                    $query_stock_id->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);
                    $query_stock_id->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                    $query_stock_id->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                } else {
                    $query_stock_id->bindParam(':f_stock_id', $f_stock_id, PDO::PARAM_STR);
                    $query_stock_id->bindParam(':t_stock_id', $t_stock_id, PDO::PARAM_STR);
                }

                $query_stock_id->execute();


                $results_stock_id = $query_stock_id->fetchAll(PDO::FETCH_OBJ);

                foreach ($results_stock_id as $result_stock_id) {

                    $my_stock_id = $result_stock_id->stock_id;

                    if ($group_by == "stock") {
                        $sql3 = "Select stock_id,unit_id,Sum(CONCAT(status, quantity)) as total_quantity , SUM(CASE WHEN CONCAT(status, quantity)>0 THEN quantity ELSE 0 END) as stockin_total , SUM(CASE WHEN CONCAT(status, quantity)<0 THEN quantity ELSE 0 END) as stockout_total From stock_balance where date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and stock_id = :group_stock_id group by unit_id order by stock_id asc";
                    } else if ($group_by == "category") {
                        $sql3 = "Select category_id,unit_id,Sum(CONCAT(status, quantity)) as total_quantity, SUM(CASE WHEN CONCAT(status, quantity)>0 THEN quantity ELSE 0 END) as stockin_total , SUM(CASE WHEN CONCAT(status, quantity)<0 THEN quantity ELSE 0 END) as stockout_total From stock_balance,stock where date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and category_id between :f_category_id and :t_category_id and stock.stock_id = stock_balance.stock_id group by category_id,unit_id order by category_id asc";
                    } else if ($group_by == "report_group") {
                        $sql3 = "Select rg_id,unit_id,Sum(CONCAT(status, quantity)) as total_quantity , SUM(CASE WHEN CONCAT(status, quantity)>0 THEN quantity ELSE 0 END) as stockin_total , SUM(CASE WHEN CONCAT(status, quantity)<0 THEN quantity ELSE 0 END) as stockout_total From stock_balance,stock where date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and rg_id between :f_rg_id and :t_rg_id  and stock.stock_id = stock_balance.stock_id group by rg_id,unit_id order by rg_id asc";
                    } else {
                        $sql3 = "Select stock_id,unit_id,Sum(CONCAT(status, quantity)) as total_quantity , SUM(CASE WHEN CONCAT(status, quantity)>0 THEN quantity ELSE 0 END) as stockin_total , SUM(CASE WHEN CONCAT(status, quantity)<0 THEN quantity ELSE 0 END) as stockout_total From stock_balance where date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and stock_id between :f_stock_id and :t_stock_id group by stock_id,unit_id order by stock_id asc";
                    }
                    $query3 = $dbh->prepare($sql3);

                    $query3->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                    $query3->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                    if ($group_by == "stock") {
                        $query3->bindParam(':group_stock_id', $my_stock_id, PDO::PARAM_STR);
                    } else if ($group_by == "category") {
                        $query3->bindParam(':f_category_id', $f_category_id, PDO::PARAM_STR);
                        $query3->bindParam(':t_category_id', $t_category_id, PDO::PARAM_STR);
                    } else if ($group_by == "report_group") {
                        $query3->bindParam(':f_rg_id', $f_rg_id, PDO::PARAM_STR);
                        $query3->bindParam(':t_rg_id', $t_rg_id, PDO::PARAM_STR);
                    } else {
                        $query3->bindParam(':f_stock_id', $f_stock_id, PDO::PARAM_STR);
                        $query3->bindParam(':t_stock_id', $t_stock_id, PDO::PARAM_STR);
                    }

                    $query3->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                    $query3->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);

                    $query3->execute();
                    $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                    $number_of_rows = $query3->rowcount();
                ?>



                    <?php
                    if ($number_of_rows > 0) {
                        foreach ($results3 as $result3) {

                            //stock name

                            $sql_stock_name = "Select * From stock where stock_id = :stock_id";
                            $query_stock_name = $dbh->prepare($sql_stock_name);
                            $query_stock_name->bindParam(':stock_id', $result3->stock_id, PDO::PARAM_STR);
                            $query_stock_name->execute();

                            $result_stock_name = $query_stock_name->fetch(PDO::FETCH_OBJ);


                    ?>
                            <!-- Start Print Content -->
                            <br>
                            <table class="print-content table table-bordered">
                                <h6 class="groupby">

                                    <b><?php
                                        if ($group_by == "stock") {
                                            echo "Stock ID : ", htmlentities($result3->stock_id), " ( Stock Name : ", htmlentities($result_stock_name->stock_name), ") |";
                                        } else if ($group_by == "category") {
                                            echo "Category ID : ", htmlentities($result3->category_id);
                                        } else {
                                            echo "Report Group ID : ", htmlentities($result3->rg_id);
                                        }
                                        ?></b>
                                    <b> ( Unit ID : <?php echo htmlentities($result3->unit_id); ?> )</b>
                                </h6>


                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Transaction ID</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Transaction Type</th>
                                        <th scope="col">Stock ID</th>
                                        <th scope="col">Stock Name</th>
                                        <th scope="col">Category ID</th>
                                        <th scope="col">Report Group ID</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Office ID</th>
                                        <th scope="col">Unit ID</th>
                                        <th scope="col">Stock In (+)</th>
                                        <th scope="col">Stock Out (-)</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    $num = 1;
                                    if ($group_by == "stock") {
                                        $sql = "Select * From stock_balance where date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and stock_id between :f_stock_id and :t_stock_id  and stock_id = :group_by_id and unit_id = :group_unit_id order by date,transaction_id asc";
                                    } else if ($group_by == "category") {
                                        $sql = "Select * From stock_balance,stock where date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and category_id between :f_category_id and :t_category_id  and category_id = :group_by_id and unit_id = :group_unit_id and stock.stock_id = stock_balance.stock_id order by date,transaction_id asc";
                                    } else {
                                        $sql = "Select * From stock_balance,stock where date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and rg_id between :f_rg_id and :t_rg_id  and rg_id = :group_by_id and unit_id = :group_unit_id and stock.stock_id = stock_balance.stock_id order by date,transaction_id asc";
                                    }
                                    $query = $dbh->prepare($sql);

                                    $query->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                                    $query->bindParam(':t_date', $t_date, PDO::PARAM_STR);

                                    $query->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                                    $query->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);
                                    if ($group_by == "stock") {
                                        $query->bindParam(':f_stock_id', $f_stock_id, PDO::PARAM_STR);
                                        $query->bindParam(':t_stock_id', $t_stock_id, PDO::PARAM_STR);
                                        $query->bindParam(':group_by_id', $result3->stock_id, PDO::PARAM_STR);
                                    } else if ($group_by == "category") {
                                        $query->bindParam(':f_category_id', $f_category_id, PDO::PARAM_STR);
                                        $query->bindParam(':t_category_id', $t_category_id, PDO::PARAM_STR);
                                        $query->bindParam(':group_by_id', $result3->category_id, PDO::PARAM_STR);
                                    } else {
                                        $query->bindParam(':f_rg_id', $f_rg_id, PDO::PARAM_STR);
                                        $query->bindParam(':t_rg_id', $t_rg_id, PDO::PARAM_STR);
                                        $query->bindParam(':group_by_id', $result3->rg_id, PDO::PARAM_STR);
                                    }
                                    $query->bindParam(':group_unit_id', $result3->unit_id, PDO::PARAM_STR);

                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                                    foreach ($results as $result) {
                                        // category and report group id

                                        $sql_stock = "Select * From stock where  stock_id = :stock_id order by stock_id asc";
                                        $query_stock = $dbh->prepare($sql_stock);
                                        // $query_stock->bindParam(':f_category_id', $f_category_id, PDO::PARAM_STR);
                                        // $query_stock->bindParam(':t_category_id', $t_category_id, PDO::PARAM_STR);
                                        // $query_stock->bindParam(':f_rg_id', $f_rg_id, PDO::PARAM_STR);
                                        // $query_stock->bindParam(':t_rg_id', $t_rg_id, PDO::PARAM_STR);
                                        $query_stock->bindParam(':stock_id', $result->stock_id, PDO::PARAM_STR);


                                        $query_stock->execute();
                                        $result_stock = $query_stock->fetch(PDO::FETCH_OBJ);
                                    ?>


                                        <tr>
                                            <td>
                                                <?php echo $num ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->transaction_id); ?>
                                            </td>
                                            <td>
                                                <?php $date = date_create($result->date);
                                                echo date_format($date, "d/m/Y"); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->transaction_type); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->stock_id); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result_stock->stock_name); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result_stock->category_id); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result_stock->rg_id); ?>
                                            </td>
                                            <td>
                                                <?php $date = date_create($result->date);
                                                echo date_format($date, "d/m/Y"); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->office_id); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->unit_id); ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php
                                                if ($result->status == '+') {
                                                    echo htmlentities($result->quantity);
                                                } else {
                                                    echo "<p style='text-align:center'>-</p>";
                                                }
                                                ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php
                                                if ($result->status == '-') {
                                                    echo htmlentities($result->quantity);
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


                                    <?php

                                    //opening balance

                                    $max_date = date_create($f_date);
                                    $max_date = date_sub($max_date, date_interval_create_from_date_string("1 days"));
                                    $max_date = date_format($max_date, "Y-m-d");

                                    if ($group_by == "stock") {
                                        $sql_o = "Select Sum(CONCAT(status, quantity)) as opening_balance From stock_balance where date between :f_date and :t_date  and office_id between :f_office_id and :t_office_id and stock_id between :f_stock_id and :t_stock_id  and stock_id = :group_by_id and unit_id = :group_unit_id order by date asc";
                                    } else if ($group_by == "category") {
                                        $sql_o = "Select Sum(CONCAT(status, quantity))  as opening_balance  From stock_balance,stock where date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and category_id between :f_category_id and :t_category_id  and category_id = :group_by_id and unit_id = :group_unit_id and stock.stock_id = stock_balance.stock_id order by date asc";
                                    } else {
                                        $sql_o = "Select Sum(CONCAT(status, quantity))  as opening_balance  From stock_balance,stock where date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and rg_id between :f_rg_id and :t_rg_id  and rg_id = :group_by_id and unit_id = :group_unit_id and stock.stock_id = stock_balance.stock_id order by date asc";
                                    }
                                    $query_o = $dbh->prepare($sql_o);

                                    $query_o->bindParam(':f_date', $sub_start_date, PDO::PARAM_STR);
                                    $query_o->bindParam(':t_date', $max_date, PDO::PARAM_STR);

                                    $query_o->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                                    $query_o->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);
                                    if ($group_by == "stock") {
                                        $query_o->bindParam(':f_stock_id', $f_stock_id, PDO::PARAM_STR);
                                        $query_o->bindParam(':t_stock_id', $t_stock_id, PDO::PARAM_STR);
                                        $query_o->bindParam(':group_by_id', $result3->stock_id, PDO::PARAM_STR);
                                    } else if ($group_by == "category") {
                                        $query_o->bindParam(':f_category_id', $f_category_id, PDO::PARAM_STR);
                                        $query_o->bindParam(':t_category_id', $t_category_id, PDO::PARAM_STR);
                                        $query_o->bindParam(':group_by_id', $result3->category_id, PDO::PARAM_STR);
                                    } else {
                                        $query_o->bindParam(':f_rg_id', $f_rg_id, PDO::PARAM_STR);
                                        $query_o->bindParam(':t_rg_id', $t_rg_id, PDO::PARAM_STR);
                                        $query_o->bindParam(':group_by_id', $result3->rg_id, PDO::PARAM_STR);
                                    }
                                    $query_o->bindParam(':group_unit_id', $result3->unit_id, PDO::PARAM_STR);

                                    $query_o->execute();
                                    $results_o = $query_o->fetchAll(PDO::FETCH_OBJ);

                                    foreach ($results_o as $result_o) {
                                        $opening_balance = $result_o->opening_balance;
                                    ?>

                                        <tr>

                                            <td style="text-align:center" colspan="10"><b>Opening Stock Balance</b></td>
                                            <td style="text-align:right" colspan="8"><b>
                                                    <?php
                                                    if ($opening_balance != "") {
                                                        echo $opening_balance;
                                                    } else {
                                                        echo '0';
                                                    }
                                                    ?>
                                                </b></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                    <tr>

                                        <td style="text-align:center" colspan="10"><b>Stock In (+) Total</b></td>
                                        <td style="text-align:right" colspan="8"><b>
                                                <?php echo htmlentities($result3->stockin_total); ?>
                                            </b></td>
                                    </tr>
                                    <tr>

                                        <td style="text-align:center" colspan="10"><b>Stock Out (-) Total</b></td>
                                        <td style="text-align:right" colspan="8"><b>
                                                <?php echo htmlentities($result3->stockout_total); ?>
                                            </b></td>
                                    </tr>

                                    <tr>

                                        <td style="text-align:center" colspan="10"><b>Closing Stock Balance</b></td>
                                        <td style="text-align:right" colspan="8"><b>
                                                <?php echo htmlentities($result3->total_quantity) + $opening_balance; ?>
                                            </b></td>
                                    </tr>


                                </tbody>
                            </table>
                            <br>
                            <?php

                        }
                    } else {



                        //stock id check

                        if ($group_by == "category") {
                            $sql_stock_check = "select DISTINCT stock.category_id FROM stock_balance,stock WHERE stock_balance.stock_id BETWEEN :f_stock_id and :t_stock_id and stock_balance.date between :f_date and :t_date and stock_balance.office_id between :f_office_id and :t_office_id and stock_balance.stock_id = stock.stock_id order by stock.category_id";
                        } else if ($group_by == "report_group") {
                            $sql_stock_check = "select DISTINCT stock.rg_id FROM stock_balance,stock WHERE stock_balance.stock_id BETWEEN :f_stock_id and :t_stock_id and stock_balance.date between :f_date and :t_date and stock_balance.office_id between :f_office_id and :t_office_id and stock_balance.stock_id = stock.stock_id order by stock.category_id";
                        } else {
                            $sql_stock_check = "Select DISTINCT stock_id FROM stock_balance WHERE date between :f_date and :t_date and stock_id BETWEEN :f_stock_id and :t_stock_id and office_id between :f_office_id and :t_office_id order by stock_id";
                        }
                        $query_stock_check = $dbh->prepare($sql_stock_check);

                        $query_stock_check->bindParam(':f_date', $sub_start_date, PDO::PARAM_STR);
                        $query_stock_check->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                        $query_stock_check->bindParam(':f_stock_id', $f_stock_id, PDO::PARAM_STR);
                        $query_stock_check->bindParam(':t_stock_id', $t_stock_id, PDO::PARAM_STR);
                        $query_stock_check->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                        $query_stock_check->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);

                        $query_stock_check->execute();

                        $results_stock_check = $query_stock_check->fetchAll(PDO::FETCH_OBJ);
                        $stock_rows = $query_stock_check->rowcount();

                        if ($stock_rows > 0) {


                            //opening balance

                            $max_date = date_create($f_date);
                            $max_date = date_sub($max_date, date_interval_create_from_date_string("1 days"));
                            $max_date = date_format($max_date, "Y-m-d");

                            if ($group_by == "stock") {
                                $sql_o = "Select unit_id,Sum(CONCAT(status, quantity)) as opening_balance From stock_balance where date between :f_date and :t_date  and office_id between :f_office_id and :t_office_id and stock_id = :group_stock_id group by unit_id order by unit_id";
                            } else if ($group_by == "category") {
                                $sql_o = "Select Sum(CONCAT(status, quantity))  as opening_balance  From stock_balance,stock where date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and category_id between :f_category_id and :t_category_id  and stock.stock_id = stock_balance.stock_id order by unit_id";
                            } else {
                                $sql_o = "Select Sum(CONCAT(status, quantity))  as opening_balance  From stock_balance,stock where date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and rg_id between :f_rg_id and :t_rg_id  and stock.stock_id = stock_balance.stock_id order by unit_id";
                            }
                            $query_o = $dbh->prepare($sql_o);

                            $query_o->bindParam(':f_date', $sub_start_date, PDO::PARAM_STR);
                            $query_o->bindParam(':t_date', $max_date, PDO::PARAM_STR);

                            $query_o->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                            $query_o->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);
                            if ($group_by == "stock") {
                                $query_o->bindParam(':group_stock_id', $my_stock_id, PDO::PARAM_STR);
                            } else if ($group_by == "category") {
                                $query_o->bindParam(':f_category_id', $f_category_id, PDO::PARAM_STR);
                                $query_o->bindParam(':t_category_id', $t_category_id, PDO::PARAM_STR);
                            } else {
                                $query_o->bindParam(':f_rg_id', $f_rg_id, PDO::PARAM_STR);
                                $query_o->bindParam(':t_rg_id', $t_rg_id, PDO::PARAM_STR);
                            }


                            $query_o->execute();
                            $results_o = $query_o->fetchAll(PDO::FETCH_OBJ);

                            foreach ($results_o as $result_o) {
                                $opening_balance = $result_o->opening_balance;


                                //  For stock name 
                                $sql_stock_name = "Select * From stock where stock_id = :stock_id";
                                $query_stock_name = $dbh->prepare($sql_stock_name);
                                $query_stock_name->bindParam(':stock_id', $result_stock_id->stock_id, PDO::PARAM_STR);
                                $query_stock_name->execute();

                                $result_stock_name = $query_stock_name->fetch(PDO::FETCH_OBJ);

                            ?>

                                <br>
                                <table class="print-content table table-bordered">
                                    <h6 class="groupby">

                                        <b><?php
                                            if ($group_by == "stock") {
                                                echo "Stock ID : ", htmlentities($result_stock_id->stock_id), " ( Stock Name : ", htmlentities($result_stock_name->stock_name), ") |";
                                            } else if ($group_by == "category") {
                                                echo "Category ID : ", htmlentities($result3->category_id);
                                            } else {
                                                echo "Report Group ID : ", htmlentities($result3->rg_id);
                                            }
                                            ?></b>
                                        <b> ( Unit ID : <?php echo htmlentities($result_o->unit_id); ?> )</b>
                                    </h6>

                                    <tbody>

                                        <tr>
                                            <td style="text-align:center" colspan="10"><b>Opening Stock Balance</b></td>
                                            <td style="text-align:right" colspan="8"><b>
                                                    <?php
                                                    if ($opening_balance != "") {
                                                        echo $opening_balance;
                                                    } else {
                                                        echo '0';
                                                    }
                                                    ?>
                                                </b></td>
                                        </tr>
                                        <tr>

                                            <td style="text-align:center" colspan="10"><b>Stock In (+) Total</b></td>
                                            <td style="text-align:right" colspan="8"><b>
                                                    0
                                                </b></td>
                                        </tr>
                                        <tr>

                                            <td style="text-align:center" colspan="10"><b>Stock Out (-) Total</b></td>
                                            <td style="text-align:right" colspan="8"><b>
                                                    0
                                                </b></td>
                                        </tr>

                                        <tr>

                                            <td style="text-align:center" colspan="10"><b>Closing Stock Balance</b></td>
                                            <td style="text-align:right" colspan="8"><b>
                                                    <?php
                                                    if ($opening_balance != "") {
                                                        echo $opening_balance;
                                                    } else {
                                                        echo '0';
                                                    }
                                                    ?>
                                                </b></td>
                                        </tr>
                                    </tbody>
                                </table>

                        <?php
                            }
                        } else {
                            echo "<script type='text/javascript' language='Javascript'>alert('There is no record to report');window.close();</script>";
                        }
                        ?>






                    <?php } ?>

                <?php }
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