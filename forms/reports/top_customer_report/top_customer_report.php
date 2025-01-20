<?php
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
error_reporting(0);
if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {

    $role = $_SESSION['role'];
    if ($role != "Management Admin") {
        $office_id = $_SESSION['office_id'];
    }

?>
    <script type="text/javascript" src="assets/js/reports/top_customer_report/top_customer_report.js"></script>
    <script type="text/javascript" src="assets/js/common.js"></script>
    <div class="main-content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="row bg-white report">
                        <div class="col-md-12">
                            <h4>Top Customer Report</h4>
                            <br>
                        </div>
                        <div class="col-md-6">
                            <form>
                                <label>From Date</label>
                                <div class="input-group mb-3">
                                    <input type="date" class="form-control" id="f_date" required>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form>
                                <label>To Date</label>
                                <div class="input-group mb-3">
                                    <input type="date" class="form-control" id="t_date" required>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6 ft_currency">
                            <form>
                                <label for="l_f_currency_id">From Currency ID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="f_currency_id" name="f_currency_id" onchange="check_data_exist('currency','currency_id',$('#f_currency_id').val(), this.id,'l_f_currency_id')" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_f_currency_id"></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 ft_stock">
                            <form>
                                <label for="l_t_currency_id">To Currency ID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="t_currency_id" name="t_currency_id" onchange="check_data_exist('currency','currency_id',$('#t_currency_id').val(), this.id,'l_t_currency_id')" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_t_currency_id"></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <?php if ($role == "Management Admin") { ?>
                            <div class="col-md-6">
                                <form>
                                    <label for="l_f_office_id">From Office ID</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="f_office_id" name="f_office_id" onchange="check_data_exist('office','office_id',$('#f_office_id').val(), this.id,'l_f_office_id')" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_f_office_id"></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php } else { ?>
                            <input type="text" class="form-control" id="f_office_id" name="f_office_id" value="<?php echo $office_id ?>" required style="display: none;">
                        <?php } ?>

                        <?php if ($role == "Management Admin") { ?>
                            <div class="col-md-6">
                                <form>
                                    <label for="l_t_office_id">To Office ID</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="t_office_id" name="t_office_id" onchange="check_data_exist('office','office_id',$('#t_office_id').val(), this.id,'l_t_office_id')" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_t_office_id"></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php } else { ?>
                            <input type="text" class="form-control" id="t_office_id" name="f_office_id" value="<?php echo $office_id ?>" required style="display: none;">
                        <?php } ?>

                        <div class="col-md-6">
                            <form>
                                <label for="lbl_range">Range</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" id="range" name="range" required>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6"></div>

                        <br><br><br><br>
                        <div class="row" style="margin:auto">

                            <button type="submit" class="btn btn-primary" onclick="view_report()">Preview</button>
                        </div>
                        <br><br><br>



                    </div>

                </div>

                <div class="col-md-6">
                    <div class="row bg-white report report-left">
                        <div class="col-md-12">
                            <h5>Group By</h5><br>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio" value="currency" id="gb_currency" checked>Currency ID
                                </label>
                            </div>
                        </div>
                    </div><br>
                    <div class="row bg-white report report-left">
                        <div class="col-md-12">
                            <h5>Sale Type</h5><br>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="stradio" value="all" id="st_all" checked>All
                                </label>
                            </div><br>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="stradio" value="cash" id="st_cash">Cash
                                </label>
                            </div><br>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="stradio" value="credit" id="st_credit">Credit
                                </label>
                            </div><br>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="stradio" value="advance" id="st_advance">Advance
                                </label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row bg-white report report-left">
                        <div class="col-md-12">
                            <h5>Transaction Type</h5><br>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="ttradio" value="sale" id="tt_sale" checked>Sale
                                </label>
                            </div><br>
                            <div class="form-check" id="delivery_sale">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="ttradio" value="delivery" id="tt_delivery">Delivery Sale
                                </label>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
<?php } ?>

<script>
    $(document).ready(function() {

        active_route("reports_");

    });
</script>