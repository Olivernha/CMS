<?php ob_start();

//$db_user='root';
//$db_password='';
//$db_name='cms';
//$db = new PDO('mysql:host=localhost;dbname=cms', $db_user, $db_password);
//
////set some db attributes
//$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
//$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,true);
//$db->setAttribute( PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$db['db_host']="localhost";
$db['db_user']="root";
$db['db_pass']="";
$db['db_name']="cms";

//$db['db_host'] = "sql109.epizy.com";
//$db['db_user'] = "epiz_26111331";
//$db['db_pass'] = "qi5taj7DJgtA";
//$db['db_name'] = "epiz_26111331_demo_cms_db";

foreach ($db as $key=>$value) {
    define(strtoupper($key),$value);
}

$connection=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

$query="SET NAMES utf8";
mysqli_query($connection,$query);
//
//if($connection){
//    echo "We are connected";
//}

//$
