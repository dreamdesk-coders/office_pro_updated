<style>

.card{
    border-radius:10px;
}
.card img{
    vertical-align: middle;
    border-style: none;
    width: 55px;
    position: relative;
    margin: auto;
}
</style>
<?php
include("forms/common/side_menu.php");
error_reporting(0);
if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else { ?>

    <div class="main-content">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-md-12">
                    <h2>Help Center</h2>
                    <p>This is the official released version of Office Pro. </p>
                    <h4 class="text-center mb-4">Connect with Office Pro</h4>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="card p-4">
                        <h6 class="text-center">Official Facebook Page of Office Pro</h6>
                        <img src="assets/images/icons/facebook.svg" class="mt-3">
                        <a href="https://www.facebook.com/officeprosoftware" target="_blank" class="text-center mt-3">Facebook</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="card p-4">
                        <h6 class="text-center">Send Mail to Office Pro Team</h6>
                        <img src="assets/images/icons/gmail.svg" class="mt-3">
                        <a href="https://www.facebook.com/gmail" target="_blank" class="text-center mt-3">Send Mail</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="card p-4">
                        <h6 class="text-center">Call Office Pro Team</h6>
                        <img src="assets/images/icons/telephone.svg" class="mt-3">
                        <a href="https://www.facebook.com/officeprosoftware" target="_blank" class="text-center mt-3">Call Now</a>
                    </div>
                </div>

                <div class="col-md-12 mt-4 mb-4">
                    <div class="card p-4">
                        <h6 class="text-center">Official Website of Office Pro</h6>
                        <img src="https://officepromm.web.app/assets/images/laptop-mockup.png" style="width:45%;" class="mt-4">
                        <a href="https://officepromm.web.app/" target="_blank" class="text-center mt-3">Visit Now</a>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
<?php } ?>