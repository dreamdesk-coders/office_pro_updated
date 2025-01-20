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
    <script type="text/javascript" src="assets/js/reports/stock_balance_report/stock_balance_report.js"></script>
    <script type="text/javascript" src="assets/js/common.js"></script>
    <div class="main-content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="row bg-white report">
                        <div class="col-md-12">
                            <h4>Stock Balance Report</h4>
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



                        <div class="col-md-6 ft_stock">
                            <form>
                                <label for="l_f_stock_id">From Stock ID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="f_stock_id" name="f_stock_id" onchange="check_data_exist('stock','stock_id',$('#f_stock_id').val(), this.id,'l_f_stock_id')" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_f_stock_id"></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 ft_stock">
                            <form>
                                <label for="l_t_stock_id">To Stock ID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="t_stock_id" name="t_stock_id" onchange="check_data_exist('stock','stock_id',$('#t_stock_id').val(), this.id,'l_t_stock_id')" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_t_stock_id"></button>
                                    </div>
                                </div>
                            </form>
                        </div>



                        <div class="col-md-6 ft_category">
                            <form>
                                <label for="l_f_category_id">From Category ID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="f_category_id" name="f_category_id" onchange="check_data_exist('category','category_id',$('#f_category_id').val(), this.id,'l_f_category_id')" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_f_category_id"></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 ft_category">
                            <form>
                                <label for="l_t_category_id">To Category ID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="t_category_id" name="t_category_id" onchange="check_data_exist('category','category_id',$('#t_category_id').val(), this.id,'l_t_category_id')" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_t_category_id"></button>
                                    </div>
                                </div>
                            </form>
                        </div>



                        <div class="col-md-6 ft_rg">
                            <form>
                                <label for="l_f_rg_id">From Report Group ID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="f_rg_id" name="f_rg_id" onchange="check_data_exist('report_group','rg_id',$('#f_rg_id').val(), this.id,'l_f_rg_id')" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_f_rg_id"></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 ft_rg">
                            <form>
                                <label for="l_t_rg_id">From Report Group ID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="t_rg_id" name="t_rg_id" onchange="check_data_exist('report_group','rg_id',$('#f_rg_id').val(), this.id,'l_t_rg_id')" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_t_rg_id"></button>
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
                            <input type="text" class="form-control" id="t_office_id" name="t_office_id" value="<?php echo $office_id ?>" required style="display: none;">
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
                                    <input type="radio" class="form-check-input" name="optradio" value="stock" id="gb_stock" checked>Stock
                                </label>
                            </div><br>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio" value="category" id="gb_category">Category
                                </label>
                            </div><br>
                            <div class="form-check disabled">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio" value="report_group" id="gb_rg">Report Group
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