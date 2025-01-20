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
    <script type="text/javascript" src="assets/js/reports/stock_repacking_summary_report/stock_repacking_summary_report.js"></script>
    <script type="text/javascript" src="assets/js/common.js"></script>
    <div class="main-content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="row bg-white report">
                        <div class="col-md-12">
                            <h4>Repacking Summary Report</h4>
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
                                <label for="l_f_slip_id">From Slip ID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="f_slip_id" name="f_slip_id" onchange="check_data_exist('stock_repacking','slip_id',$('#f_slip_id').val(), this.id,'l_f_slip_id')" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_f_slip_id"></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 ft_invoice">
                            <form>
                                <label for="l_t_slip_id">To Slip ID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="t_slip_id" name="t_slip_id" onchange="check_data_exist('stock_repacking','slip_id',$('#t_slip_id').val(), this.id,'l_t_slip_id')" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_t_slip_id"></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6 ft_stock">
                            <form>
                                <label for="l_f_stock_id">From From Stock ID</label>
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
                                <label for="l_t_stock_id">To Form Stock ID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="t_stock_id" name="t_stock_id" onchange="check_data_exist('stock','stock_id',$('#t_stock_id').val(), this.id,'l_t_stock_id')" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_t_stock_id"></button>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <!-- <div class="col-md-6 ft_unit">
                            <form>
                                <label for="l_f_unit_id">From Unit ID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="f_unit_id" name="f_unit_id" onchange="check_data_exist('stock_unit','unit_id',$('#f_unit_id').val(), this.id,'l_f_unit_id')" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_f_unit_id"></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 ft_unit">
                            <form>
                                <label for="l_t_unit_id">To Unit ID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="t_unit_id" name="t_unit_id" onchange="check_data_exist('stock_unit','unit_id',$('#t_unit_id').val(), this.id,'l_t_unit_id')" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_t_unit_id"></button>
                                    </div>
                                </div>
                            </form>
                        </div> -->



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
                                    <input type="radio" class="form-check-input" name="optradio" value="unit" id="gb_unit" checked>Unit ID
                                </label>
                            </div><br>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio" value="stock" id="gb_stock">From Stock ID
                                </label>
                            </div><br>
                        </div>
                    </div><br>
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