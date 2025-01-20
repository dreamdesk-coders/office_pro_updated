<?php 
include("forms/common/side_menu.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

	$sql = "Select * From office order by created_date asc";
    $query = $dbh -> prepare($sql);
    $query->bindParam(':invoice_id',$invoice_id,PDO::PARAM_STR);
    $query->execute();

    $results= $query->fetchAll(PDO::FETCH_OBJ);
    $office_count = $query->rowcount();

    $today = date("Y-m-d");  

    $sql1 = "Select * From sale";
    $query1 = $dbh -> prepare($sql1);
    $query1->execute();
    $sale_count = $query1->rowcount();

    $sql2 = "Select * From purchase";
    $query2 = $dbh -> prepare($sql2);
    $query2->execute();
    $purchase_count = $query2->rowcount();

    $sql3 = "Select * From sale where invoice_date=:today";
    $query3 = $dbh -> prepare($sql3);
    $query3->bindParam(':today',$today,PDO::PARAM_STR);
    $query3->execute();
    $sale_today_count = $query3->rowcount();

    $sql4 = "Select * From purchase where invoice_date=:today";
    $query4 = $dbh -> prepare($sql4);
    $query4->bindParam(':today',$today,PDO::PARAM_STR);
    $query4->execute();
	$purchase_today_count = $query4->rowcount();

    $sql5 = "Select * From expenses where expense_date=:today";
    $query5 = $dbh -> prepare($sql5);
    $query5->bindParam(':today',$today,PDO::PARAM_STR);
    $query5->execute();
	$expense_today_count = $query5->rowcount();

    $sql6 = "Select * From sale_order where order_date=:today";
    $query6 = $dbh -> prepare($sql6);
    $query6->bindParam(':today',$today,PDO::PARAM_STR);
    $query6->execute();
	$sale_order_today_count = $query6->rowcount();

    $sql7 = "Select * From delivery_order where order_date=:today";
    $query7 = $dbh -> prepare($sql7);
    $query7->bindParam(':today',$today,PDO::PARAM_STR);
    $query7->execute();
	$delivery_order_today_count = $query7->rowcount();
	
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

    $sqlstaff = "Select * From staff";
    $querystaff = $dbh -> prepare($sqlstaff);
	$querystaff->execute();
    $staffcount = $querystaff->rowcount();
    
    $sqlfoundation = "Select * From foundation";
    $queryfoundation = $dbh -> prepare($sqlfoundation);
    $queryfoundation->execute();

    $foundationresult= $queryfoundation->fetch(PDO::FETCH_OBJ);

	?>

<div class="main-content" id="main-content">
    <div class="container" style="padding:0px 25px 0px 25px">
        <div class="row">
            <div class="col-md-8">
                <h3 id="greet"></h3>
                <div class="row">
                    <div class="col-md-6">
                        <p>Transactions summary for today</p>
                        <div class="summary_ mb-2" style="border: 0.5px solid #eeeeee;">
                            <h5 class="title">Sale</h5>
                            <div class="transaction_outer mb-2">
                                <div class="transaction">
                                    <h5><?php echo htmlentities(number_format($sale_today_count)); ?></h5>
                                </div>
                            </div>
                            
                            <a href="<?php echo $common_form_route ?>?frm=sale_list" class="btn btn-link">See More</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                    <p>&nbsp;</p>
                        <div class="summary_ mb-2" style="border: 0.5px solid #eeeeee;">
                            <h5 class="title">Purchase</h5>
                            <div class="transaction_outer mb-2">
                                <div class="transaction">
                                    <h5><?php echo htmlentities(number_format($purchase_today_count)); ?></h5>
                                </div>
                            </div>
                                <a href="<?php echo $common_form_route ?>?frm=purchase_list" class="btn btn-link">See More</a>
                        
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="summary_ mb-2 mt-2 p-2" style="border: 0.5px solid #eeeeee;">
                            <h5 class="title">Expense</h5>
                                    <h3><?php echo htmlentities(number_format($expense_today_count)); ?></h3>
                            <a href="<?php echo $common_form_route ?>?frm=daily_expense_list" class="btn btn-link">See More</a>
                        </div>
                    </div>
                    

                    <div class="col-md-4">
                        <div class="summary_ mb-2 mt-2 p-2" style="border: 0.5px solid #eeeeee;">
                            <h5 class="title">Sale Order</h5>
                                    <h3><?php echo htmlentities(number_format($sale_order_today_count)); ?></h3>
                            <a href="<?php echo $common_form_route ?>?frm=sale_order_list" class="btn btn-link">See More</a>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="summary_ mb-2 mt-2 p-2" style="border: 0.5px solid #eeeeee;">
                            <h5 class="title">Delivery Order</h5>
                                    <h3><?php echo htmlentities(number_format($delivery_order_today_count)); ?></h3>         
                            <a href="<?php echo $common_form_route ?>?frm=delivery_order_list" class="btn btn-link">See More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 bg-white mt-3 mb-4 br-15">
                    <div class="row">
                        <div class="col-md-3 summary_" onclick="window.location.href='<?php echo $common_form_route?>?frm=stock'">
                            <h6 class="mt-3 pb-2">Total Stock</h6>
                            <img src="assets/images/master/stock.svg" style="width:50px;" class="mb-3">
                            <p><?php echo $stockcount ?></p>
                        </div>
                        <div class="col-md-3 summary_" onclick="window.location.href='<?php echo $common_form_route?>?frm=customer'">
                            <h6 class="mt-3 pb-2">Total Customer</h6>
                            <img src="assets/images/master/customer.svg" style="width:50px;" class="mb-3">
                            <p><?php echo $customercount ?></p>
                        </div>
                        <div class="col-md-3 summary_" onclick="window.location.href='<?php echo $common_form_route?>?frm=supplier'">
                            <h6 class="mt-3 pb-2">Total Supplier</h6>
                            <img src="assets/images/master/supplier.svg" style="width:50px;" class="mb-3">
                            <p><?php echo $suppliercount ?></p>
                        </div>
                        <div class="col-md-3 summary_" onclick="window.location.href='<?php echo $common_form_route?>?frm=staff'">
                            <h6 class="mt-3 pb-2">Total Staff</h6>
                            <img src="assets/images/master/staff.svg" style="width:50px;" class="mb-3">
                            <p><?php echo $staffcount ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 bg-white mt-4 mb-4 br-15">
                    <div class="office-list">
                        <h4 class="mt-3">Offices</h4>
                        <div class="row">
                            <?php foreach ($results as $result) {
							$office_id = $result->office_id;
							$office_name = $result->office_name;
							$admin = $result->admin;
							$color = $result->color;
							$address = $result->address; ?>

                            <div class="col-md-4">
                                <a href="#" class="office-link">
                                    <div class="office-block mt-3 mb-3 br-15">
                                        <p><?php echo $office_name; ?></p>
                                        <div class="circle mb-3" style="background-color: <?php echo $color ?>;">
                                            <img src="assets/images/icons/building.svg">
                                        </div>
                                        <p class="mb-0">Admin - <?php echo $admin; ?></p>
                                    </div>
                                </a>
                            </div>

                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="col-md-12 br-15 pt-2 pb-1">
                <h5>Plan</h5>
                <p>Subscription ends on :  <?php $date = date_create( $foundationresult->sub_end_date);
                                                echo date_format($date, "d-m-Y"); ?></p>
               
                </div>
                <div class="totals_ bg-white br-15 mb-4">
                    <h5>Total Sale</h5>
                    <p><?php echo htmlentities(number_format($sale_count)); ?></p>
                    <hr>
                    <h5>Total Purchase</h5>
                    <p><?php echo htmlentities(number_format($purchase_count)); ?></p>
                    <hr>
                    <h5>Total Offices</h5>
                    <p><?php echo htmlentities(number_format($office_count)); ?></p>
                    <hr>
                </div>
 
                <div class="balances_ bg-white br-15 mb-4">
                    <h5>Cash Balance</h5>

                    <?php

			    $sql5 = "Select Sum(CONCAT(status, amount)) as amount , currency_id from cash_balance GROUP by currency_id asc";
			    $query5 = $dbh -> prepare($sql5);
                $query5->execute();
                $cb_count = $query5->rowcount();
			    $c_results= $query5->fetchAll(PDO::FETCH_OBJ);
				foreach ($c_results as $c_result) {
					
					$currency_id = $c_result->currency_id;
					$amount = $c_result->amount;?>

                    <h6><?php echo htmlentities($currency_id); ?></h6>
                    <p><?php echo htmlentities(number_format($amount)); ?></p>
                    <hr>

                    <?php }?>

                    <?php
                        if($cb_count == 0){
                            echo "<p class='mb-0'>Cash Balance for each currency will appear here.</p>";
                        }
                    ?>
                </div>

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