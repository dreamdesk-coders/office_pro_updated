<?php
$_SESSION = array();
unset($_SESSION['alogin']);
unset($_SESSION['role'] );
unset($_SESSION['office_id']);
session_destroy(); // destroy session
if (isset($_COOKIE['remember'])) {
    // $hash = md5("0ff!cePr0h@shsTr!nG@)@)");
    setcookie("remember", "", time() + (86400 * 30), "/");
     
}
echo "<script> location.replace('$common_form_route?frm=login&auth=out'); </script>";

