<style>
    .page-header {
        width: 1000px !important;
        left: 18vw !important;
    }

    .voucher-table {
        width: 1000px !important;
        margin-left: 18vw !important;
    }

    @media print {

        .page-header {
            width: 100% !important;
            left: 0 !important;

        }

        .voucher-table {
            margin-left: 0 !important;
            width: 100% !important;
        }

        .page-header-space {
            height: 200px !important;
        }

    }
</style>
<?php

error_reporting(0);

if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

    if (isset($_GET['f_office_id']) && isset($_GET['t_office_id'])) {
        $f_date = $_GET['f_date'];
        $t_date = $_GET['t_date'];
        $f_expense_id = $_GET['f_expense_id'];
        $t_expense_id = $_GET['t_expense_id'];
        $f_office_id = $_GET['f_office_id'];
        $t_office_id = $_GET['t_office_id'];


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
    <script type="text/javascript" src="assets/js/common.js"></script>

    <div class="nav-bar no-print">
        <button class="btn btn-light print" onclick="window.print();">Print</button>
        <button id="exportExcel" class="btn btn-light" onclick="javascript:exportExcel('daily_expense_report')">Excel Export</button>


    </div>

    <div class="voucher" id="daily_expense_report">
        <div class="page-header">
            <div class="heading">
                <img src="assets/images/voucher/voucher-logo.png" class="voucher-logo">
                <h3 style="margin-left:20px;"><?php echo $client_name ?></h3>
            </div>

            <h5 class="title">Daily Expense Report</h5><br>
            <hr>

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
                            <?php
                            $sql3 = "Select expense_date,office_id,currency_id,sum(total_amount) as total_amount from expenses where expense_date between :f_date and :t_date and expense_id between :f_expense_id and :t_expense_id and office_id between :f_office_id and :t_office_id  group by expense_date,office_id,currency_id order by expense_date asc";
                            $query3 = $dbh->prepare($sql3);

                            $query3->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                            $query3->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                            $query3->bindParam(':f_expense_id', $f_expense_id, PDO::PARAM_STR);
                            $query3->bindParam(':t_expense_id', $t_expense_id, PDO::PARAM_STR);
                            $query3->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                            $query3->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);

                            $query3->execute();
                            $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                            $number_of_rows = $query3->rowcount();
                            if ($number_of_rows > 0) {
                                foreach ($results3 as $result3) {
                            ?>

                                    <ol>

                                        <table class="table" style="width: 94%;">
                                            <h6><b>Expense Date : <?php $date = date_create($result3->expense_date);
                                                                    echo date_format($date, "d/m/Y"); ?></b></h6>
                                            <h6><b>Currency ID : <?php echo htmlentities($result3->currency_id); ?></b></h6>
                                            <h6><b>Office ID : <?php echo htmlentities($result3->office_id); ?></b></h6>
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Expense ID</th>
                                                    <th scope="col">Expense Date</th>
                                                    <th scope="col">Currency ID</th>
                                                    <th scope="col">Exchange Rate</th>
                                                    <th scope="col">Staff ID</th>
                                                    <th scope="col">Office ID</th>
                                                    <th scope="col">Remark</th>
                                                    <th scope="col">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php

                                                $sql = "Select * from expenses where expense_date between :f_date and :t_date and expense_id between :f_expense_id and :t_expense_id and office_id between :f_office_id and :t_office_id and expense_date = :group_expense_date and currency_id = :group_currency order by expense_date asc";
                                                $query = $dbh->prepare($sql);

                                                $query->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                                                $query->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                                                $query->bindParam(':f_expense_id', $f_expense_id, PDO::PARAM_STR);
                                                $query->bindParam(':t_expense_id', $t_expense_id, PDO::PARAM_STR);
                                                $query->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                                                $query->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);
                                                $query->bindParam(':group_expense_date', $result3->expense_date, PDO::PARAM_STR);
                                                $query->bindParam(':group_currency', $result3->currency_id, PDO::PARAM_STR);

                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                $num = 1;





                                                foreach ($results as $result) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $num ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlentities($result->expense_id); ?>
                                                        </td>
                                                        <td>
                                                            <?php $date = date_create($result->expense_date);
                                                            echo date_format($date, "d/m/Y"); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlentities($result->currency_id); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlentities($result->exchange_rate); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlentities($result->staff_id); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlentities($result->office_id); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlentities($result->remark); ?>
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
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td style="text-align:right"><b>Total</b></td>
                                                    <td style="text-align:right"><b>
                                                            <?php echo htmlentities($result3->total_amount); ?>
                                                        </b></td>
                                                </tr>
                                        <?php

                                    }
                                } else {
                                    echo "<script type='text/javascript' language='Javascript'>alert('There is no record to report');window.close();</script>";
                                }

                                        ?>

                                            </tbody>
                                        </table>
                                    </ol>
                        </div>
                    </td>
                </tr>
            </tbody>


        </table>

    </div>
    <div class="foot-div no-print"></div>



<?php } ?>