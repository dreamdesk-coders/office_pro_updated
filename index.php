<?php
session_start();
error_reporting(0);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OfficePro Moonlight | Dream Desk</title>
    <link rel="icon" href="favicon.ico" type="image/ico">
    <link rel="stylesheet" type="text/css" href="assets/frameworks/bootstrap4.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/common.css">
    <script type="text/javascript" src="assets/frameworks/jquery3.5.1/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="assets/frameworks/bootstrap4.5/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="assets/js/common.js"></script>

    <!-- data table  -->
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.print.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">

    <script src="  https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="  https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>

    <!-- html to excel export -->
    <script src="assets/frameworks/htmlToExcel.js"></script>

</head>
<body>


    <?php

    include("forms/common/announcements.php");

    // Database Connection

    include("handler/common/connection_config.php");

    // Alert

    include("forms/common/alert.php");
    
    // Forms 
    
    include("config/routes.php");

    // Loading

    include("forms/common/loading.php");

    //Sub End

    include("handler/common/sub_end.php");

     ?>

</body>
</html>