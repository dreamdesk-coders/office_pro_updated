<?php 
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {?>
<script type="text/javascript" src="assets/js/master/category/category.js"></script>
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
                <button class="btn btn-primary" onclick="create_template();">Add New Category</button>
                <br><br>
            </div>
        </div>
        <div class="row bg-white">
            <div class="col-md-12">
                <br>
                <h4>Category</h4>
                <br>
            </div>
        </div>
        <div class="row bg-white">
            <div class="col-md-8"></div>
            <div class="col-md-2">
                <form>
                    <label for="f_category_id">From Category ID<small><label
                                id="l_f_category_id"></label></small></label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="f_category_id" name="f_category_id"
                            onchange="check_data_exist('category','category_id',$('#f_category_id').val(), this.id,'l_f_category_id')"
                            required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary lookup-btn" type="button"
                                id="btn_f_category_id"></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2">
                <form>
                    <label for="t_category_id">To Category ID<small><label id="l_t_category_id"></label></small></label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="t_category_id" name="t_category_id"
                            onchange="check_data_exist('category','category_id',$('#t_category_id').val(), this.id,'l_f_category_id')"
                            required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary lookup-btn" type="button"
                                id="btn_t_category_id"></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12 d-flex flex-row-reverse">
                <button class="btn btn-secondary mb-3 mt-3 ml-1 mr-1" onclick="get_category_()">Clear</button>
                <button class="btn btn-info mb-3 mt-3"
                    onclick="get_category_filter($('#f_category_id').val(),$('#t_category_id').val())">Filter</button>
                <button class="btn btn-primary mb-3 mt-3 ml-1 mr-1"
                    onclick="printPreview($('#f_category_id').val(),$('#t_category_id').val(),'category_view')">List
                    Preview</button>
            </div>
        </div>
        <div class="row bg-white">
            <div class="col-md-12">
                <div style="overflow:auto">
                    <div id="category-table">
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
                    <h4>Create New Category</h4>
                    <div class="form-group">
                        <label for="cid">Category ID</label>
                        <input type="text" class="form-control" id="category_id" name="category_id"
                            onchange="check_id_exist('category','category_id',this.id)" required>
                    </div>

                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" required>
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
                    <h4>Update Category</h4>
                    <div class="form-group">
                        <label for="u_category_id">Category ID</label>
                        <input type="text" class="form-control" id="u_category_id" name="u_category_id" readonly
                            disabled>
                    </div>

                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" class="form-control" id="u_category_name" name="u_category_name" required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="update" id="update">Update</button>
                    <button type="button" class="btn btn-secondary" onclick="list_template();">Cancel</button>

                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>