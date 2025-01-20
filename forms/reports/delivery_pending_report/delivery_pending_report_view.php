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
        <button id="exportExcel" class="btn btn-light" onclick="javascript:exportExcel('delivery_pending_report')">Excel Export</button>


    </div>

    <div class="voucher" id="delivery_pending_report">
        <div class="page-header">
            <div class="heading">
                <img src="assets/images/voucher/voucher-logo.png" class="voucher-logo">
                <h3 style="margin-left:20px;"><?php echo $client_name ?></h3>
            </div>

            <h5 class="title">Delivery Pending Report</h5><br>
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
                            $sql3 = "Select office_id,order_date,Sum(total_amount) as total_amount From delivery_order where order_date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and order_id not in (SELECT order_id FROM delivery) and status = 'active' group by order_date,office_id order by order_id asc";
                            $query3 = $dbh->prepare($sql3);

                            $query3->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                            $query3->bindParam(':t_date', $t_date, PDO::PARAM_STR);
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
                                            <h6><b> Order Date : <?php $date = date_create($result3->order_date);
                                                                    echo date_format($date, "d/m/Y"); ?></b></h6>
                                            <h6><b>Office ID : <?php echo htmlentities($result3->office_id); ?></b></h6>
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Order ID</th>
                                                    <th scope="col">Order Date</th>
                                                    <th scope="col">Staff ID</th>
                                                    <th scope="col">Customer ID</th>
                                                    <th scope="col">Currency ID</th>
                                                    <th scope="col">Office ID</th>
                                                    <th scope="col">Tax</th>
                                                    <th scope="col">Remark</th>
                                                    <th scope="col">Total Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php

                                                $sql = "Select * From delivery_order where order_date between :f_date and :t_date and office_id between :f_office_id and :t_office_id and order_date = :group_date and order_id not in (SELECT order_id FROM delivery) and status = 'active' order by order_date asc";
                                                $query = $dbh->prepare($sql);

                                                $query->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                                                $query->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                                                $query->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                                                $query->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);
                                                $query->bindParam(':group_date', $result3->order_date, PDO::PARAM_STR);

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
                                                            <?php echo htmlentities($result->order_id); ?>
                                                        </td>
                                                        <td>
                                                            <?php $date = date_create($result->order_date);
                                                            echo date_format($date, "d/m/Y"); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlentities($result->staff_id); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlentities($result->customer_id); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlentities($result->currency_id); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlentities($result->office_id); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlentities($result->tax); ?>
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