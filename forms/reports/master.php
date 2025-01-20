<?php

$role = $_SESSION['role']; {
    if ($role == "Staff") {
        echo "<script> window.location.href = '$common_form_route?frm=no_permission'; </script>";
    }
}
include("forms/common/side_menu.php");
error_reporting(0);
if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else { ?>
    <div class="main-content bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2>Reports</h2>
                    <br>
                    <input class="form-control search" id="myInput" type="text" placeholder="Search..">
                    <br>
                </div>

                <div class="container-fluid">
                    <div class="row" id="myList">
                        <div class="col-md-12">
                            <h4 id="general_reports">General Reports</h4>
                        </div>
                        
                               <div class="col-md-2 col-sm-6 col-6">
                        <a href="<?php echo $common_form_route ?>?frm=profit_and_loss_report" class="a">
                            <div class="frm_ t-block">
                                <div class="info" title="Profit & Loss Report"></div>
                                <img src="assets/images/reports/general/profit&loss.png">
                                <div class="text-holder">
                                    <p class="px-2">Profit & Loss Report</p>
                                </div>
                            </div>
                        </a>
                    </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=cash_balance_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/reports/general/cashbalance.svg">
                                    <div class="text-holder">
                                        <p class="px-2">Cash Balance Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=stock_balance_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/master/stock.svg">
                                    <div class="text-holder">
                                        <p class="px-2">Stock Balance Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=delivery_pending_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/sale/delivery.svg">
                                    <div class="text-holder">
                                        <p>Delivery Pending Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=daily_expense_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/expenses/expense.svg">
                                    <div class="text-holder">
                                        <p class="px-2">Daily Expense Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-2 col-sm-6 col-6">
                        <a href="<?php echo $common_form_route ?>?frm=expense_detail_report" class="a">
                            <div class="frm_ t-block">
                                <div class="info" title="Expense Detail Report"></div>
                                <img src="assets/images/reports/general/expense_detail.png">
                                <div class="text-holder">
                                    <p class="px-2">Expense Detail Report</p>
                                </div>
                            </div>
                        </a>
                    </div>

                        <div class="col-md-12">
                            <br>
                            <h4 id="inventory_reports">Inventory Reports</h4>
                            <button type="button" class="btn btn-outline-primary mb-1" onclick="window.location.href='<?php echo $common_form_route ?>?frm=inventory_master'">Enter Inventory Transactions</button>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=stock_received_summary_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/inventory/stock_receive.svg">
                                    <div class="text-holder">
                                        <p>Stock Received Summary Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                 

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=stock_issue_summary_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/inventory/stock_issue.svg">
                                    <div class="text-holder">
                                        <p class="px-2">Stock Issue Summary Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=stock_transfer_summary_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/inventory/stock_transfer.svg">
                                    <div class="text-holder">
                                        <p>Stock Transfer Summary Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=office_use_summary_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/master/office.svg">
                                    <div class="text-holder">
                                        <p class="px-2">Office Use Summary Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=damage_summary_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/inventory/damage.svg">
                                    <div class="text-holder">
                                        <p>Damage Summary Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- <div class="col-md-3 col-sm-6">
                    <a href="<?php echo $common_form_route ?>?frm=stock_repacking_summary_report" class="a">
                        <div class="frm_">
                            <img src="assets/images/inventory/repack.svg">
                            <p>Stock Repacking Summary Report</p>
                        </div>
                    </a>
                </div> -->

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=present_summary_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/inventory/present.svg">
                                    <div class="text-holder">
                                        <p>Present Summary Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="col-md-12">
                            <br>
                            <h4 id="sale_reports">Sale Reports</h4>
                            <button type="button" class="btn btn-outline-primary mb-1" onclick="window.location.href='<?php echo $common_form_route ?>?frm=sale_master'">Enter Sale Transactions</button>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=sale_summary_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/sale/sale.svg">
                                    <div class="text-holder">
                                        <p>Sale & Delivery Summary Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=top_sale_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/reports/sale/top_sale_n_delivery.svg">
                                    <div class="text-holder">
                                        <p>Top Sale & Delivery Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=top_customer_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/master/customer.svg">
                                    <div class="text-holder">
                                        <p class="px-2">Top Customer Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=sale_return_summary_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/sale/sale_return.svg">
                                    <div class="text-holder">
                                        <p class="px-2">Sale Return Summary Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=sale_order_summary_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/sale/sale_order.svg">
                                    <div class="text-holder">
                                        <p>Sale Order Summary Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=delivery_order_summary_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/sale/delivery_order.svg">
                                    <div class="text-holder">
                                        <p>Delivery Order Summary Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=delivery_order_cancel_summary_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/sale/delivery_order_cancel.svg">
                                    <div class="text-holder">
                                        <p class="px-2">Delivery Order Cancel Summary Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=sale_order_cancel_summary_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/sale/sale_order_cancel.svg">
                                    <div class="text-holder">
                                        <p>Sale Order Cancel Summary Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=customer_credit_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/reports/sale/customer_credit.svg">
                                    <div class="text-holder">
                                        <p>Customer Credit Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=not_sale_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/reports/sale/not_sale.svg">
                                    <div class="text-holder">
                                        <p>Not Sale Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6"></div>

                        <div class="col-md-12">
                            <br>
                            <h4 id="purchase_reports">Purchase Reports</h4>
                            <button type="button" class="btn btn-outline-primary mb-1" onclick="window.location.href='<?php echo $common_form_route ?>?frm=purchase_master'">Enter Purchase Transactions</button>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=purchase_summary_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/purchase/purchase.svg">
                                    <div class="text-holder">
                                        <p>Purchase Summary Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=purchase_return_summary_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/purchase/purchase_return.svg">
                                    <div class="text-holder">
                                        <p>Purchase Return Summary Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=purchase_order_summary_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/purchase/purchase_order.svg">
                                    <div class="text-holder">
                                        <p>Purchase Order Summary Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=purchase_order_cancel_summary_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/purchase/purchase_order_cancel.svg">
                                    <div class="text-holder">
                                        <p>Purchase Order Cancel Summary Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=top_purchase_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/reports/purchase/top_purchase.svg">
                                    <div class="text-holder">
                                        <p class="px-2">Top Purchase Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=top_supplier_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/master/supplier.svg">
                                    <div class="text-holder">
                                        <p class="px-2">Top Supplier Report</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-sm-6 col-6">
                            <a href="<?php echo $common_form_route ?>?frm=supplier_credit_report" class="a">
                                <div class="frm_ t-block">
                                    <div class="info" title="Cash Balance Report"></div>
                                    <img src="assets/images/reports/purchase/supplier_credit.svg">
                                    <div class="text-holder">
                                        <p class="px-1">Supplier Credit Report</p>
                                    </div>
                                </div>
                            </a>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        active_route("reports_");
    </script>
    <script>
        $(document).ready(function() {
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myList div").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
<?php } ?>