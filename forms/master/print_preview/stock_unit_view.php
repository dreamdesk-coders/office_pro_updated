<style>
    .foot-div {
        padding-bottom: 50vh !important;
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

    if (isset($_GET['f_id']) && isset($_GET['t_id'])) {
        $f_id = $_GET['f_id'];
        $t_id = $_GET['t_id'];

        $sql = "Select * From stock_unit WHERE stock_unit_id between :f_id and :t_id order by stock_unit_id asc";
        $query = $dbh->prepare($sql);
        $query->bindParam(':f_id', $f_id, PDO::PARAM_STR);
        $query->bindParam(':t_id', $t_id, PDO::PARAM_STR);
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $number_of_rows = $query->rowcount();

        if ($number_of_rows > 0) {
            //  For company name 
            $sql_cname = "Select * From foundation";
            $query_cname = $dbh->prepare($sql_cname);
            $query_cname->execute();

            $result_cname = $query_cname->fetch(PDO::FETCH_OBJ);


            $client_name = $result_cname->client_name;
        } else {
            echo "<script type='text/javascript' language='Javascript'>alert('There is no record to preview!');window.close();</script>";
        }
    } else {
        echo "<script type='text/javascript' language='Javascript'>alert('There is no record to preview!');window.close();</script>";
    }


?>

    <link rel="stylesheet" type="text/css" href="assets/css/voucher.css">

    <div class="nav-bar no-print">
        <button class="btn btn-light print" onclick="window.print();">Print</button>
        <button id="exportExcel" class="btn btn-light" onclick="javascript:exportExcel('stock_unit_pp')">Excel Export</button>


    </div>

    <div class="voucher" id="stock_unit_pp">
        <div class="page-header">
            <div class="heading">
                <img src="assets/images/voucher/voucher-logo.png" class="voucher-logo">
                <h3 style="margin-left:20px;"><?php echo $client_name ?></h3>
            </div>

            <h5 class="title" style="margin-top:25px">Stock Unit List Preview</h5><br>
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
                            <ol>
                                <table class="table" style="width: 94%;">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Stock Unit ID</th>
                                            <th scope="col">Unit ID</th>
                                            <th scope="col">Stock ID</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Purchase Price</th>
                                            <th scope="col">Sale Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $number = 1;
                                        foreach ($results as $result) {

                                        ?>
                                            <tr>
                                                <td>
                                                    <?php echo $number ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($result->stock_unit_id); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($result->unit_id); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($result->stock_id); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($result->qty); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($result->purchase_price); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($result->sale_price); ?>
                                                </td>
                                            </tr>

                                        <?php
                                            $number = $number + 1;
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