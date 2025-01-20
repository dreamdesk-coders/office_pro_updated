<?php
session_start();
// include("../../forms/common/processing.php");
include("../common/connection_config.php");
include("../common/common_functions.php");

if (isset($_POST['upload'])) {

    $filename = $_FILES["uploaded_file"]["name"];
    // $file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
    // $file_ext = substr($filename, strripos($filename, '.')); // get file name
    $filesize = $_FILES["uploaded_file"]["size"];
    // $newfilename = md5($file_basename) . date("Y_m_d") . $file_ext;

    if (file_exists("../../documents/" . $filename)) {

    } else {

        move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], "../../documents/" . $filename);

    }

}
