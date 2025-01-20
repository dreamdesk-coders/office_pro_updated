<?php
if(isset($_SESSION['save_status'])){
	$save_status = $_SESSION['save_status'];
	$transaction_id = $_SESSION['transaction_id'];
	$action = $_SESSION['action'];

	if($save_status == "1"){
		if($action == "save"){
			echo "<script> alert_('Info','Opening stock for : $transaction_id is successfully saved.');</script>";
		}
		elseif($action == "delete"){
			echo "<script> alert_('Info','Opening stock for : $transaction_id is successfully deleted.');</script>";
		}
	}
	elseif($save_status == "0"){
		if($action == "save"){
			echo "<script> alert_('Info','An error occurred while saving opening stock.');</script>";
		}
		elseif($action == "delete"){
			echo "<script> alert_('Info','An error occurred while deleting opening stock.');</script>";
		}
	}
	$_SESSION['save_status'] = "";
	$_SESSION['transaction_id'] = "";
	$_SESSION['action'] = "";
}
$inventory_module = $_SESSION['inventory_module'];
if($inventory_module == "0"){
    echo "<script> window.location.href = '$common_form_route?frm=not_activated&m=inventory'; </script>";
}
include("forms/common/side_menu.php");
include("forms/common/lookup.php");
error_reporting(0);
if (strlen($_SESSION['alogin'])==0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else { 
$role = $_SESSION['role'];
if($role == "Management Admin"){
$sql = "Select * From office Order By office_id asc";
$query = $dbh -> prepare($sql);
}else{
	$office_id = $_SESSION['office_id'];
	$sql = "Select * From office where office_id=:office_id";
	$query = $dbh -> prepare($sql);
	$query->bindParam(':office_id', $office_id, PDO::PARAM_STR);
}

$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$count = 1;
	?>

<style type="text/css">
ol {
    padding: 0px !important;
}

li {
    float: right;
}

.office-parent-link {
    text-decoration: none;
    color: #000;
}

.office-parent-link:hover {
    text-decoration: none;
    color: #000;
}
</style>


<script type="text/javascript" src="assets/js/inventory/repacking/repacking.js"></script>
<div class="main-content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php include("forms/common/alerts.php"); ?>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <?php foreach($results as $result){
			$id = $result->office_id;
			$name = $result->office_name;
			$admin = $result->admin;
			$color = $result->color;
		?>
            <div class="col-md-3">
                <a href="<?php echo $common_form_route ?>?frm=opening_stock_manage&id=<?php echo $id ?>"
                    class="office-parent-link">
                    <div class="office-card light-card text-center">
                        <div
                            style="position: absolute;width: 25px;height: 50px;border-radius: 20px;background-color: <?php echo $color; ?>;display: inline-block;top: 20px;left: 25px;">

                        </div>
                        <p class="mt-3 mb-0">Manage Opening Stock</p>
                        <p class="mt-1 mb-0"> <?php echo htmlentities($id);?></p>
                        <p class="mt-1 pb-2">
                            <?php echo htmlentities($name);?>
                        </p>
                        
                    </div>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {

    active_route("inventory_");

});
</script>
<?php } ?>