<?php

error_reporting(0);

if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

    if (isset($_GET['f_office_id']) && isset($_GET['t_office_id'])) {
        $f_date = $_GET['f_date'];
        $t_date = $_GET['t_date'];
        $f_slip_id = $_GET['f_slip_id'];
        $t_slip_id = $_GET['t_slip_id'];
        // $f_unit_id = $_GET['f_unit_id'];
        // $t_unit_id = $_GET['t_unit_id'];
        $f_stock_id = $_GET['f_stock_id'];
        $t_stock_id = $_GET['t_stock_id'];
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
        <button id="exportExcel" class="btn btn-light" onclick="javascript:exportExcel('stock_repacking_summary_report')">Excel Export</button>
    </div>

    <table id="stock_repacking_summary_report" class="voucher">
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
                <h5 class="title">Stock Repacking Summary Report</h5>
                <hr><br>

                <?php


                $sql3 = "Select slip_date,$group_by,sum(from_quantity) as total_quantity From repacking where slip_date between :f_date and :t_date and slip_id between :f_slip_id and :t_slip_id and from_stock_id between :f_stock_id and :t_stock_id and staff_id between :f_staff_id and :t_staff_id and office_id between :f_office_id and :t_office_id  group by slip_date,$group_by order by slip_date asc";

                $query3 = $dbh->prepare($sql3);

                $query3->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                $query3->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                $query3->bindParam(':f_slip_id', $f_slip_id, PDO::PARAM_STR);
                $query3->bindParam(':t_slip_id', $t_slip_id, PDO::PARAM_STR);
                // $query3->bindParam(':f_unit_id', $f_unit_id, PDO::PARAM_STR);
                // $query3->bindParam(':t_unit_id', $t_unit_id, PDO::PARAM_STR);
                $query3->bindParam(':f_stock_id', $f_stock_id, PDO::PARAM_STR);
                $query3->bindParam(':t_stock_id', $t_stock_id, PDO::PARAM_STR);
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

                                <b> Slip Date : <?php $date = date_create($result3->slip_date);
                                                echo date_format($date, "d/m/Y"); ?>

                                    ( <?php
                                        if ($group_by == "from_unit_id") {
                                            echo "From Unit ID : ", htmlentities($result3->from_unit_id);
                                        } else {
                                            echo "From Stock ID : " , htmlentities($result3->from_stock_id);
                                        }
                                        ?> )</b>

                                <br>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th style="width: 100px;">Slip ID</th>
                                        <th style="width: 110px;">Date</th>
                                        <th>Office ID</th>
                                        <th>Staff ID</th>
                                        <th style="width: 300px;">Remark</th>
                                        <th>From Unit ID</th>
                                        <th>From Stock ID</th>
                                        <th>From Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $sql = "Select * From repacking where slip_date between :f_date and :t_date and slip_id between :f_slip_id and :t_slip_id and from_stock_id between :f_stock_id and :t_stock_id and staff_id between :f_staff_id and :t_staff_id and office_id between :f_office_id and :t_office_id and slip_date = :group_slip_date and $group_by = :group_by_id order by slip_date asc";

                                    $query = $dbh->prepare($sql);

                                    $query->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                                    $query->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                                    $query->bindParam(':f_slip_id', $f_slip_id, PDO::PARAM_STR);
                                    $query->bindParam(':t_slip_id', $t_slip_id, PDO::PARAM_STR);
                                    // $query->bindParam(':f_unit_id', $f_unit_id, PDO::PARAM_STR);
                                    // $query->bindParam(':t_unit_id', $t_unit_id, PDO::PARAM_STR);
                                    $query->bindParam(':f_stock_id', $f_stock_id, PDO::PARAM_STR);
                                    $query->bindParam(':t_stock_id', $t_stock_id, PDO::PARAM_STR);
                                    $query->bindParam(':f_staff_id', $f_staff_id, PDO::PARAM_STR);
                                    $query->bindParam(':t_staff_id', $t_staff_id, PDO::PARAM_STR);
                                    $query->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                                    $query->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);
                                    $query->bindParam(':group_slip_date', $result3->slip_date, PDO::PARAM_STR);
                                    if ($group_by == "from_unit_id") {
                                        $query->bindParam(':group_by_id', $result3->from_unit_id, PDO::PARAM_STR);
                                    } else {
                                        $query->bindParam(':group_by_id', $result3->from_stock_id, PDO::PARAM_STR);
                                    }


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
                                                <?php echo htmlentities($result->slip_id); ?>
                                            </td>
                                            <td>
                                                <?php $date = date_create($result->slip_date);
                                                echo date_format($date, "d/m/Y"); ?>
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
                                                <?php echo htmlentities($result->from_unit_id); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlentities($result->from_stock_id); ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php echo htmlentities($result->from_quantity); ?>
                                            </td>
                                        </tr>



                                    <?php

                                        $num = $num + 1;
                                    }

                                    ?>

                                    <tr>

                                        <td style="text-align:center" colspan="7"><b>Total Quantity</b></td>
                                        <td style="text-align:right" colspan="8"><b>
                                                <?php echo htmlentities($result3->total_quantity); ?>
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