<?php
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
error_reporting(0);
if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {


?>
<script type="text/javascript" src="assets/js/reports/profit_and_loss_report/profit_and_loss_report.js"></script>
<script type="text/javascript" src="assets/js/common.js"></script>
<div class="main-content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="row bg-white report">
                    <div class="col-md-12">
                        <h4>Profit & Loss Report</h4>
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



                    <div class="col-md-6 ft_currency" style="display:none">
                        <form>
                            <label for="l_f_currency_id">From Currency ID</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="f_currency_id" name="f_currency_id"
                                    onchange="check_data_exist('currency','currency_id',$('#f_currency_id').val(), this.id,'l_f_currency_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_f_currency_id"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 ft_stock" style="display:none">
                        <form>
                            <label for="l_t_currency_id">To Currency ID</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="t_currency_id" name="t_currency_id"
                                    onchange="check_data_exist('currency','currency_id',$('#t_currency_id').val(), this.id,'l_t_currency_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_t_currency_id"></button>
                                </div>
                            </div>
                        </form>
                    </div>


                    <div class="col-md-6" style="display:none">
                        <form>
                            <label for="l_f_office_id">To Office ID</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="f_office_id" name="f_office_id"
                                    onchange="check_data_exist('office','office_id',$('#f_office_id').val(), this.id,'l_f_office_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_f_office_id"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6" style="display:none">
                        <form>
                            <label for="l_t_office_id">To Office ID</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="t_office_id" name="t_office_id"
                                    onchange="check_data_exist('office','office_id',$('#t_office_id').val(), this.id,'l_t_office_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_t_office_id"></button>
                                </div>
                            </div>
                        </form>
                    </div><br><br><br><br>
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
                                <input type="radio" class="form-check-input" name="optradio" value="currency"
                                    id="gb_currency" checked>Currency
                            </label>
                        </div><br>
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