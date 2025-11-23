<?php
session_start();
//GLOBAL $HTTP_SESSION_VARS;
error_reporting (E_ALL ^ E_NOTICE);
//$_SESSION['SESSADM_UID']='1';
header('X-Frame-Options: SAMEORIGIN');
//print "S:".$_SESSION['SESSADM_UID'];

//if(empty($_SESSION['SESSADM_UID'])){
if(empty($_SESSION['SESSADM_UID']) || $_SESSION['SESSADM_USER']!='ADMINMYSPP'){
	header('Location: ../log_masuk_admin.php');
    //die();
} else {
	$host = $_SERVER['HTTP_HOST'];
	if($host=='10.29.25.144'){ $host = 'myspp.spp.gov.my'; }
	$actual_link = "https://$host".$_SERVER['REQUEST_URI'];
	//print $actual_link;
	if(empty($pages)){ $pages = 'dashboard/dashboard_utama'; $module="DASHBOARD"; }
	include '../connection/common.php';

	$date=date("Y-m-d H:i:s");
	$currentDate = strtotime($date);
	$futureDate = $currentDate-(60*10);
	$formatDate = date("Y-m-d H:i:s", $futureDate);
	$rsu = $conn->query("DELETE FROM $schema2.`user_log` WHERE `login_date`<=".tosql($formatDate));

	include 'index_header.php';
	include 'index_menu.php';
	include 'index_pages.php';
	include 'index_footer.php';
}
?>
