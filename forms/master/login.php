<?php
$hash = md5("0ff!cePr0h@shsTr!nG@)@)");
if (isset($_COOKIE['remember'])) {
  if ($_COOKIE['remember'] !== "") {
    error_reporting(0);
    $_SESSION['alogin'] = $_COOKIE['remember'];
    $_SESSION['role'] = $_COOKIE['role'];
    $_SESSION['office_id'] = $_COOKIE['office'];
    $_SESSION['home_currency'] = $_COOKIE['home_currency'];
    $_SESSION['num_of_offices'] = $_COOKIE['num_of_offices'];
    $_SESSION['user_per_office'] = $_COOKIE['user_per_office'];
    $_SESSION['sub_start_date'] = $_COOKIE['sub_start_date'];
    $_SESSION['sub_end_date'] = $_COOKIE['sub_end_date'];
    $_SESSION['purchase_decimal'] = $_COOKIE['purchase_decimal'];
    $_SESSION['inventory_decimal'] = $_COOKIE['inventory_decimal'];
    $_SESSION['sale_decimal'] = $_COOKIE['sale_decimal'];

    echo "<script> window.location.href = '$common_form_route?frm=dashboard'; </script>";
  }
}
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6 col-sm-12 login-left-panel">
      <div class="blur-card">
        <img src="favicon.ico" class="icon">
        <h2 class="title text-light">Office Pro</h2>
        <!-- <p style="margin-bottom:0.5px !important;">Developed by <a href="https://officepromm.web.app/" target="_blank" class="text-light">Dream Desk Studio</a></p> -->
        <h5 class="text-light">Moonlight</h5>
      </div>
    </div>
    <div class="col-md-6 col-sm-12 login-right-panel">
      <form method="POST" action="handler/common/login_check.php">

      <?php include('handler/common/login_alerts.php'); ?>


      <h2 id="greet" class="text-dark text-center"></h2>
      <br>
        <div class="form-group">
          <input type="text" class="form-control" id="login_id" name="login_id" placeholder="Login ID" required>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        </div>
        <!-- <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="Remember">Remember Me</label>
              </div> -->
        <button type="submit" class="btn btn-dark w-100">Login</button>
      </form>
    </div>
  </div>
</div>