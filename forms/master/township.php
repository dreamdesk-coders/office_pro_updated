<?php 
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {?>
<script type="text/javascript" src="assets/js/master/township/township.js"></script>
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
                <button class="btn btn-primary" onclick="create_template();">Add New Township</button>
                <br><br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" style="background-color: #fff;">
                <br>
                <h4>Township</h4>
                <br>
                <div class="row bg-white">
                    <div class="col-md-8"></div>
                    <div class="col-md-2">
                        <form>
                            <label for="f_township_id">From Township ID<small><label
                                        id="l_f_township_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="f_township_id" name="f_township_id"
                                    onchange="check_data_exist('township','township_id',$('#f_township_id').val(), this.id,'l_f_township_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_f_township_id"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <form>
                            <label for="t_township_id">To Township ID<small><label
                                        id="l_t_township_id"></label></small></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="t_township_id" name="t_township_id"
                                    onchange="check_data_exist('township','township_id',$('#t_township_id').val(), this.id,'l_f_township_id')"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary lookup-btn" type="button"
                                        id="btn_t_township_id"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 d-flex flex-row-reverse">
                        <button class="btn btn-secondary mb-3 mt-3 ml-1 mr-1" onclick="get_township_()">Clear</button>
                        <button class="btn btn-info mb-3 mt-3"
                            onclick="get_township_filter($('#f_township_id').val(),$('#t_township_id').val())">Filter</button>
                        <button class="btn btn-primary mb-3 mt-3 ml-1 mr-1"
                            onclick="printPreview($('#f_township_id').val(),$('#t_township_id').val(),'township_view')">List
                            Preview</button>
                    </div>
                </div>
                <div style="overflow:auto">
                    <div id="township-table">
                        <div class="ajax-loading">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="create_">
        <div class="row">
            <div class="col-md-6">
                <form method="POST" class="frm_">
                    <h4>Create New Township</h4>
                    <div class="form-group">
                        <label for="cid">Township ID</label>
                        <input type="text" class="form-control" id="township_id" name="township_id"
                            onchange="check_id_exist('township','township_id',this.id)" required>
                    </div>

                    <div class="form-group">
                        <label for="name">Township Name</label>
                        <input type="text" class="form-control" id="township_name" name="township_name" required>
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
                    <h4>Update Township</h4>
                    <div class="form-group">
                        <label for="u_township_id">Township ID</label>
                        <input type="text" class="form-control" id="u_township_id" name="u_township_id" readonly
                            disabled>
                    </div>

                    <div class="form-group">
                        <label for="u_township_name">Township Name</label>
                        <input type="text" class="form-control" id="u_township_name" name="u_township_name" required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="update" id="update">Update</button>
                    <button type="button" class="btn btn-secondary" onclick="list_template();">Cancel</button>

                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>