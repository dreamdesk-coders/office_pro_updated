<?php 
include("forms/common/side_menu.php");
// error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {
	$office_id = $_SESSION['office_id'];

    $today = date("Y-m-d");   

    $sql1 = "Select * From sale where office_id =:office_id";
	$query1 = $dbh -> prepare($sql1);
	$query1->bindParam(':office_id', $office_id, PDO::PARAM_STR);
    $query1->execute();
    $sale_count = $query1->rowcount();

    $sql2 = "Select * From purchase where office_id =:office_id";
	$query2 = $dbh -> prepare($sql2);
	$query2->bindParam(':office_id', $office_id, PDO::PARAM_STR);
    $query2->execute();
    $purchase_count = $query2->rowcount();

    $sql3 = "Select * From sale where invoice_date=:today and office_id =:office_id";
	$query3 = $dbh -> prepare($sql3);
	$query3->bindParam(':today', $today, PDO::PARAM_STR);
	$query3->bindParam(':office_id', $office_id, PDO::PARAM_STR);
    $query3->execute();
    $sale_today_count = $query3->rowcount();

    $sql4 = "Select * From purchase where invoice_date=:today and office_id =:office_id";
	$query4 = $dbh -> prepare($sql4);
	$query4->bindParam(':today', $today, PDO::PARAM_STR);
	$query4->bindParam(':office_id', $office_id, PDO::PARAM_STR);
    $query4->execute();
	$purchase_today_count = $query4->rowcount();
	
	$sqlstock = "Select * From stock";
    $querystock = $dbh -> prepare($sqlstock);
	$querystock->execute();
	$stockcount = $querystock->rowcount();

	$sqlsupplier = "Select * From supplier";
    $querysupplier = $dbh -> prepare($sqlsupplier);
	$querysupplier->execute();
	$suppliercount = $querysupplier->rowcount();

	$sqlcustomer = "Select * From customer";
    $querycustomer = $dbh -> prepare($sqlcustomer);
	$querycustomer->execute();
	$customercount = $querycustomer->rowcount();

	
	?>

<div class="main-content" id="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <h3 id="greet"></h3>
                <p>Let's improve your business with us.</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="summary_ mb-2">
                            <h4 class="title">Today Sale</h4>
                            <div class="transaction_outer">
                                <div class="transaction">
                                    <h5><?php echo htmlentities(number_format($sale_today_count)); ?></h5>
                                </div>
                            </div>

                            <div class="summary_link">
                                <div class="dot_"></div>
                                <a href="<?php echo $common_form_route ?>?frm=sale_list">View Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="summary_ mb-2">
                            <h4 class="title">Today Purchase</h4>
                            <div class="transaction_outer">
                                <div class="transaction">
                                    <h5><?php echo htmlentities(number_format($purchase_today_count)); ?></h5>
                                </div>
                            </div>

                            <div class="summary_link">
                                <div class="dot_"></div>
                                <a href="<?php echo $common_form_route ?>?frm=purchase_list">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 bg-white mt-3 mb-4 br-15">
                    <div class="row">
                        <div class="col-md-4 summary_"
                            onclick="window.location.href='<?php echo $common_form_route?>?frm=stock'">
                            <h5 class="mt-3">Total Stock</h5>
                            <img src="assets/images/master/stock.svg" style="width:80px;" class="mb-3">
                            <p><?php echo $stockcount ?></p>
                        </div>
                        <div class="col-md-4 summary_"
                            onclick="window.location.href='<?php echo $common_form_route?>?frm=customer'">
                            <h5 class="mt-3">Total Customer</h5>
                            <img src="assets/images/master/customer.svg" style="width:80px;" class="mb-3">
                            <p><?php echo $customercount ?></p>
                        </div>
                        <div class="col-md-4 summary_"
                            onclick="window.location.href='<?php echo $common_form_route?>?frm=supplier'">
                            <h5 class="mt-3">Total Supplier</h5>
                            <img src="assets/images/master/supplier.svg" style="width:80px;" class="mb-3">
                            <p><?php echo $suppliercount ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <h3>&nbsp;</h3>
                <p>&nbsp;</p>
                <div class="totals_ bg-white br-15 mb-4">
                    <h5>Total Sale</h5>
                    <p><?php echo htmlentities($sale_count); ?></p>
                    <hr>
                    <h5>Total Purchase</h5>
                    <p><?php echo htmlentities($purchase_count); ?></p>
                    <hr>
                </div>

                <?php 
				$role = $_SESSION['role'];
				if($role == "Office Admin"){
				?>
                <div class="balances_ bg-white br-15 mb-4">
                    <h5>Cash Balance</h5>

                    <?php

			    $sql5 = "Select Sum(CONCAT(status, amount)) as amount , currency_id from cash_balance where office_id = :office_id GROUP by currency_id asc";
				$query5 = $dbh -> prepare($sql5);
				$query5->bindParam(':office_id', $office_id, PDO::PARAM_STR);
                $query5->execute();
                $cb_count = $query5->rowcount();
			    $c_results= $query5->fetchAll(PDO::FETCH_OBJ);
				foreach ($c_results as $c_result) {
					
					$currency_id = $c_result->currency_id;
					$amount = $c_result->amount;?>

                    <h6><?php echo htmlentities($currency_id); ?></h6>
                    <p><?php echo htmlentities($amount); ?></p>
                    <hr>

                    <?php }?>

                    <?php
                        if($cb_count == 0){
                            echo "<p class='mb-0'>Cash Balance for each currency will appear here.</p>";
                        }
                    ?>

                </div>
                <?php } ?>

                <div class="contact_ bg-white br-15 mb-4 pt-4">
                    <div class="img-placer">
                        <img src="favicon.ico">
                    </div>
                    <h6>Need Help?</h6>
                    <p>Do you have any problem using office pro?</p>
                    <button class="btn btn-info"
                        onclick="window.location.href = '<?php echo $common_form_route ?>?frm=help'">Contact
                        Now</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
active_route("dashboard_");
</script>
<?php } ?>