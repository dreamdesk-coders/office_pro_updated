<?php
session_start();
include('connection_config.php');

if (isset($_POST['login_id'])) {

    $login_id = $_POST['login_id'];
    $password = md5($_POST['password']);
    $sql = "SELECT * FROM app_user WHERE login_id=:login_id and password=:password";
    $query = $dbh_master -> prepare($sql);
    $query-> bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {

        $_SESSION['alogin']=$_POST['login_id'];
    	$_SESSION['role']= $result->login_role;
		$_SESSION['office_id']= $result->office_id;

        $sql1 ="SELECT * FROM foundation";
        $query= $dbh -> prepare($sql1);
        $query-> execute();
        $foundation = $query->fetch(PDO::FETCH_OBJ);

        $client_id = $foundation->client_id;
        $client_name = $foundation->client_name;
        $home_currency = $foundation->home_currency;
        $num_of_offices = $foundation->num_of_offices;
        $user_per_office = $foundation->user_per_office;
        $sub_start_date = $foundation->sub_start_date;
        $sub_end_date = $foundation->sub_end_date;
        $purchase_decimal = $foundation->purchase_decimal;
        $inventory_decimal = $foundation->inventory_decimal;
        $sale_decimal = $foundation->sale_decimal;
        $inventory_module = $foundation->inventory_module;
        $sale_module = $foundation->sale_module;
        $purchase_module = $foundation->purchase_module;
        $announcement = $foundation->announcement;

        $_SESSION['home_currency'] = $home_currency;
        $_SESSION['num_of_offices'] = $num_of_offices;
        $_SESSION['user_per_office'] = $user_per_office;
        $_SESSION['sub_start_date'] = $sub_start_date;
        $_SESSION['sub_end_date'] = $sub_end_date;
        $_SESSION['purchase_decimal'] = $purchase_decimal;
        $_SESSION['inventory_decimal'] = $inventory_decimal;
        $_SESSION['sale_decimal'] = $sale_decimal;
        $_SESSION['inventory_module'] = $inventory_module;
        $_SESSION['sale_module'] = $sale_module;
        $_SESSION['purchase_module'] = $purchase_module;
        $_SESSION['announcement'] = $announcement;

        // Update for Version Two of Office Pro
        // Gathering Logged in user information

        $login_id = $_SESSION['alogin'];

        $sqlstaff = "Select * From staff where staff_id=:login_id";
        $querystaff = $dbh -> prepare($sqlstaff);
        $querystaff->bindParam(':login_id',$login_id,PDO::PARAM_STR);
        $querystaff->execute();

        $staff_data = $querystaff->fetch(PDO::FETCH_OBJ);
        
        $_SESSION['staff_name'] = $staff_data->staff_name;

        $office_id = $_SESSION['office_id'];

        $sqloffice = "Select * From office where office_id=:office_id";
        $queryoffice = $dbh -> prepare($sqloffice);
        $queryoffice->bindParam(':office_id',$office_id,PDO::PARAM_STR);
        $queryoffice->execute();
    
        $office_data = $queryoffice->fetch(PDO::FETCH_OBJ);
    
        $_SESSION['office_name'] = $office_data->office_name;

        

        if (isset($_POST['remember'])) {

            $cookie_name = "remember";
            $cookie_value = $login_id;
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

            $cookie_name1 = "role";
            $cookie_value1 = $result->login_role;
            setcookie($cookie_name1, $cookie_value1, time() + (86400 * 30), "/");

            $cookie_name2 = "office";
            $cookie_value2 = $result->office_id;
            setcookie($cookie_name2, $cookie_value2, time() + (86400 * 30), "/");
            
            $cookie_name4 = "num_of_offices";
            $cookie_value4 = $foundation->num_of_offices;
            setcookie($cookie_name4, $cookie_value4, time() + (86400 * 30), "/");

            $cookie_name5 = "user_per_office";
            $cookie_value5 = $foundation->user_per_office;
            setcookie($cookie_name5, $cookie_value5, time() + (86400 * 30), "/");

            $cookie_name6 = "sub_start_date";
            $cookie_value6 = $foundation->sub_start_date;
            setcookie($cookie_name5, $cookie_value5, time() + (86400 * 30), "/");

            $cookie_name7 = "sub_end_date";
            $cookie_value7 = $foundation->sub_end_date;
            setcookie($cookie_name7, $cookie_value7, time() + (86400 * 30), "/");

        }

        $cookie_name3 = "home_currency";
        $cookie_value3 = $foundation->home_currency;
        setcookie($cookie_name3, $cookie_value3, time() + (86400 * 30), "/");

        $cookie_name8 = "purchase_decimal";
        $cookie_value8 = $foundation->purchase_decimal;
        setcookie($cookie_name8, $cookie_value8, time() + (86400 * 30), "/");

        $cookie_name9 = "inventory_decimal";
        $cookie_value9 = $foundation->inventory_decimal;
        setcookie($cookie_name9, $cookie_value9, time() + (86400 * 30), "/");

        $cookie_name10 = "sale_decimal";
        $cookie_value10 = $foundation->sale_decimal;
        setcookie($cookie_name10, $cookie_value10, time() + (86400 * 30), "/");

        $cookie_name11 = "inventory_module";
        $cookie_value11 = $foundation->inventory_module;
        setcookie($cookie_name11, $cookie_value11, time() + (86400 * 30), "/");

        $cookie_name12 = "sale_module";
        $cookie_value12 = $foundation->sale_module;
        setcookie($cookie_name12, $cookie_value12, time() + (86400 * 30), "/");

        $cookie_name13 = "purchase_module";
        $cookie_value13 = $foundation->purchase_module;
        setcookie($cookie_name13, $cookie_value13, time() + (86400 * 30), "/");

        $cookie_name14 = "sale_step";
        $cookie_value14 = getStep($foundation->sale_decimal);
        setcookie($cookie_name14, $cookie_value14, time() + (86400 * 30), "/");

        $cookie_name15 = "purchase_step";
        $cookie_value15 = getStep($foundation->purchase_decimal);
        setcookie($cookie_name15, $cookie_value15, time() + (86400 * 30), "/");

        $cookie_name16 = "inventory_step";
        $cookie_value16 = getStep($foundation->inventory_decimal);
        setcookie($cookie_name16, $cookie_value16, time() + (86400 * 30), "/");

        $cookie_name17 = "announcement";
        $cookie_value17 = $foundation->announcement;
        setcookie($cookie_name17, $cookie_value17, time() + (86400 * 30), "/");

        $cookie_name18 = "num_of_offices";
        $cookie_value18 = $foundation->num_of_offices;
        setcookie($cookie_name18, $cookie_value18, time() + (86400 * 30), "/");

        $cookie_name19 = "client_name";
        $cookie_value19 = $foundation->client_name;
        setcookie($cookie_name19, $cookie_value19, time() + (86400 * 30), "/");

        echo "<script> location.replace('$common_form_route?frm=selection'); </script>";
    }

     else {
        echo "<script> location.replace('$common_form_route?frm=login&auth=fail'); </script>";
    }
}



	function getStep($step_param) {
		$step_param = $step_param - 1;
		$step_string = ".";
		for ($i = 0; $i < $step_param; $i++) {
			$step_string = $step_string ."0";
		}
		//$step_string = $step_string ."1";
		$step_string = ".0001";
	    return $step_string;
	}