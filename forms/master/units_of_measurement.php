<?php 
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {?>
<script type="text/javascript" src="assets/js/master/measurement/measurement.js"></script>
<div class="main-content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php include("forms/common/alerts.php"); ?>
            </div>
        </div>
    </div>


    <div class="container-fluid" id="list_">
        <div class="row">
            <div class="col-md-12">
                <br>
                  <button class="btn btn-primary" onclick="create_template();">Add New Unit Of Measurement</button>
                <br><br>
            </div>
        </div>
        <div class="row bg-white">
            <div class="col-md-12">
                <br>
                <h4>Units of Measurement</h4>
                <br>
            </div>
        </div>
        <div class="row bg-white">
            <div class="col-md-8"></div>
            <div class="col-md-2">
                <form>
                   <label for="f_unit_id">From Unit ID<small><label id="l_f_unit_id"></label></small></label>
                    <div class="input-group mb-3">
                    <input type="text" class="form-control" id="f_unit_id" name="f_unit_id" onchange="check_data_exist('units_of_measurement','unit_id',$('#f_unit_id').val(), this.id,'l_f_unit_id')" required>
                        <div class="input-group-append">
                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_f_unit_id"></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2">
                <form>
                   <label for="t_unit_id">To Unit ID<small><label id="l_t_unit_id"></label></small></label>
                    <div class="input-group mb-3">
                    <input type="text" class="form-control" id="t_unit_id" name="t_unit_id" onchange="check_data_exist('units_of_measurement','unit_id',$('#t_unit_id').val(), this.id,'l_f_unit_id')" required>
                        <div class="input-group-append">
                        <button class="btn btn-outline-secondary lookup-btn" type="button" id="btn_t_unit_id"></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12 d-flex flex-row-reverse">
                <button  class="btn btn-secondary mb-3 mt-3 ml-1 mr-1" onclick="get_measurement_()">Clear</button>
                <button class="btn btn-info mb-3 mt-3" onclick="get_measurement_filter($('#f_unit_id').val(),$('#t_unit_id').val())">Filter</button>
                <button class="btn btn-primary mb-3 mt-3 ml-1 mr-1" onclick="printPreview($('#f_unit_id').val(),$('#t_unit_id').val(),'units_of_measurement_view')">List Preview</button>
            </div>
        </div>
        <div class="row bg-white">
            <div class="col-md-12">
                <div style="overflow:auto">
                    <div id="measurement-table"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="create_">
        <div class="row">
            <div class="col-md-6">

               <form method="POST" class="frm_">
                    <h4>Create New measurement</h4>
                    <div class="form-group">
                        <label for="unit_id">Measurement ID</label>
                            <input type="text" class="form-control" id="unit_id" name="unit_id" onchange="check_id_exist('measurement','measurement_id',this.id)" required>
                    </div>    

                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="save" id="save">Save</button>
                    <button type="button" class="btn btn-secondary" onclick="list_template();">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="update_">
        <div class="row">
            <div class="col-md-6">
                <form method="POST" class="frm_">
                    <h4>Update Measurement</h4>
                    <div class="form-group">
                        <label for="u_unit_id">Measurement ID</label>
                        <input type="text" class="form-control" id="u_unit_id" name="u_unit_id" readonly disabled>
                    </div>
                                    
                    <div class="form-group">
                        <label for="u_description">Description</label>
                        <input type="text" class="form-control" id="u_description" name="u_description" required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="update" id="update">Update</button>
                    <button type="button" class="btn btn-secondary" onclick="list_template();">Cancel</button>

                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>