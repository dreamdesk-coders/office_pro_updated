<?php 
include("forms/common/side_menu.php");
$module = $_GET['m'];

switch ($module) {
    case 'purchase':
        echo "<script> active_route('purchase_'); </script>";
        break;
    
    case 'sale':
        echo "<script> active_route('sale_'); </script>";
        break;
    
    case 'inventory':
        echo "<script> active_route('inventory_'); </script>";
        break;

    default:
        # code...
        break;
}
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else {?>

<div class="main-content d-flex" id="main-content"
    style="height: 100vh;justify-content: center;align-content: center;align-items: center;text-align: center;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h3 class="mb-3 font-weight-light">This module has not been activated yet.</h3>
                <a href="<?php echo $common_form_route ?>?frm=help" class="btn btn-info">Contact Support</a>
            </div>
        </div>
    </div>
</div>
<?php }?>