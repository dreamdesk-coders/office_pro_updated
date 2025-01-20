<?php 


$current_date = date("Y-m-d");

if(isset($_SESSION['sub_end_date'])){
    $sub_end_date = $_SESSION['sub_end_date'];

    if($sub_end_date == $current_date){
        if($_GET['frm'] != "help"){
            include("forms/master/sub_end.php");
        }
    }
    
}

?>