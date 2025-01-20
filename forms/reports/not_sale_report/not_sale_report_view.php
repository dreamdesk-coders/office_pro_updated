<?php

error_reporting(0);

if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

    if (isset($_GET['f_office_id']) && isset($_GET['t_office_id'])) {
        $f_date = $_GET['f_date'];
        $t_date = $_GET['t_date'];
        $f_customer_id = $_GET['f_customer_id'];
        $f_office_id = $_GET['f_office_id'];
        $t_office_id = $_GET['t_office_id'];
        $group_by = $_GET['group_by'];


        //  For customer name 
        $sql4 = "Select * From customer where customer_id = '$f_customer_id'";
        $query4 = $dbh->prepare($sql4);
        $query4->execute();

        $result4 = $query4->fetch(PDO::FETCH_OBJ);

        $customer_id = $result4->customer_id;
        $customer_name = $result4->customer_name;


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
        <button id="exportExcel" class="btn btn-light" onclick="javascript:exportExcel('not_sale_report')">Excel Export</button>
    </div>

    <table id="not_sale_report" class="voucher">
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
                <h5 class="title">Not Sale Report</h5>
                <hr><br>


                <!-- Start Print Content -->
                <table class="print-content table table-bordered">
                    <h6 class="groupby">

                        <b>Customer ID : <?php echo $customer_id ?> ( <?php echo $customer_name ?> )</b>
                    </h6>

                    <br>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Stock ID</th>
                            <th>Stock Name</th>
                            <th>Category ID</th>
                            <th>Report Group ID</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        $temp_stock = "temp_stock" . date("Ymdhis");

                        $sql3 = "Create table $temp_stock Select distinct sale_details.stock_id FROM sale,sale_details WHERE sale_details.invoice_id = sale.invoice_id  and sale.invoice_date between :f_date and :t_date and sale.office_id between :f_office_id and :t_office_id and sale.customer_id = :f_customer_id";
                        $query3 = $dbh->prepare($sql3);

                        $query3->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                        $query3->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                        $query3->bindParam(':f_customer_id', $f_customer_id, PDO::PARAM_STR);
                        $query3->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                        $query3->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);


                        $query3->execute();

                        //delivery

                        $sql1 = "Insert Into $temp_stock Select distinct delivery_details.stock_id FROM delivery,delivery_details WHERE delivery_details.invoice_id = delivery.invoice_id  and delivery.invoice_date between :f_date and :t_date and delivery.office_id between :f_office_id and :t_office_id and delivery.customer_id = :f_customer_id";
                        $query1 = $dbh->prepare($sql1);

                        $query1->bindParam(':f_date', $f_date, PDO::PARAM_STR);
                        $query1->bindParam(':t_date', $t_date, PDO::PARAM_STR);
                        $query1->bindParam(':f_customer_id', $f_customer_id, PDO::PARAM_STR);
                        $query1->bindParam(':f_office_id', $f_office_id, PDO::PARAM_STR);
                        $query1->bindParam(':t_office_id', $t_office_id, PDO::PARAM_STR);

                        $query1->execute();

                        
                        //check stock

                        $sql2 = "Select * FROM stock WHERE stock_id NOT in (select distinct stock_id from $temp_stock)";
                        $query2 = $dbh->prepare($sql2);
                        $query2->execute();

                        $result2 = $query2->fetchAll(PDO::FETCH_OBJ);


                        $num = 1;


                        foreach ($result2 as $result2) {
                        ?>


                            <tr>
                                <td>
                                    <?php echo $num ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($result2->stock_id); ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($result2->stock_name); ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($result2->category_id); ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($result2->rg_id); ?>
                                </td>
                            </tr>



                        <?php

                            $num = $num + 1;
                        }

                        //drop table
                        $sql2 = "drop table $temp_stock";
                        $query2 = $dbh->prepare($sql2);
                        $query2->execute();

                        ?>

                    </tbody>
                </table>
                <br>
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