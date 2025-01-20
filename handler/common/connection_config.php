<?php

// Set Default Time Zone
date_default_timezone_set('Asia/Yangon');

// Common route for navigation
$common_form_route = "http://localhost/officepro/officepro";

// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');

// Master DB
define('MASTER_DB_NAME','yinyinky_aw_officepro_master');

if (!isset($_COOKIE['app_db'])) {
    $_COOKIE['app_db'] = 'yinyinkyaw_2024';
}

// App DB
define('DB_NAME',$_COOKIE['app_db']);

// Establish master database connection.
try
{
$dbh_master = new PDO("mysql:host=".DB_HOST.";dbname=".MASTER_DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}


// Establish app database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
