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
    <script type="text/javascript" src="assets/js/reports/stock_received_summary_report/stock_received_summary_report.js"></script>
    <script type="text/javascript" src="assets/js/common.js"></script>
    <div class="main-content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="row bg-white report">
                        <div class="col-md-12">
                            <h4>Stock Received Summary Report</h4>
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


                        <div class="col-md-6 ft_invoice">
                            <form>
                                <label for="l_f_received_id">From Received ID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="f_received_id" name="f_received_id" onchange="check_data_exist('stock_received','received_id',$('#f_received_id').val(), this.id,'l_f_received_id')" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_f_received_id"></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 ft_invoice">
                            <form>
                                <label for="l_t_received_id">To Received ID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="t_received_id" name="t_received_id" onchange="check_data_exist('stock_received','received_id',$('#t_received_id').val(), this.id,'l_t_received_id')" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_t_received_id"></button>
                                    </div>
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

                        <div class="col-md-6 ft_staff">
                            <form>
                                <label for="l_f_staff_id">From Staff ID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="f_staff_id" name="f_staff_id" onchange="check_data_exist('staff','staff_id',$('#f_staff_id').val(), this.id,'l_f_staff_id')" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_f_staff_id"></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        
                        <div class="col-md-6 ft_stock">
                            <form>
                                <label for="l_t_staff_id">To Staff ID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="t_staff_id" name="t_staff_id" onchange="check_data_exist('staff','staff_id',$('#t_staff_id').val(), this.id,'l_t_staff_id')" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_t_staff_id"></button>
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
                            <input type="text" class="form-control" id="f_office_id" name="f_office_id" value="<?php echo $office_id ?>"  required style="display: none;">
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
                            <input type="text" class="form-control" id="t_office_id" name="t_office_id" value="<?php echo $office_id ?>"  required style="display: none;">
                        <?php } ?>


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
                            </div><br>

                        </div>
                    </div><br>
                    <div class="row bg-white report report-left">
                        <div class="col-md-12">
                            <h5>Received Type</h5><br>
                        </div>
                        <div class="col-md-6">
                        <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optrt" value="all" id="rt_all" checked>All
                                </label>
                            </div><br>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optrt" value="rt_normal" id="rt_normal">Normal Received
                                </label>
                            </div><br>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optrt" value="rt_transfer" id="rt_transfer">Transfer Received
                                </label>
                            </div>
                        </div>
                    </div>
                    <br>
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