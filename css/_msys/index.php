<?php
session_start();
//GLOBAL $HTTP_SESSION_VARS;
error_reporting (E_ALL ^ E_NOTICE);
//$_SESSION['SESS_UID']='1';
header('X-Frame-Options: SAMEORIGIN');
//print "S:".$_SESSION['SESS_UID'];

if(empty($_SESSION['SESS_UID'])){
	header('Location: ../log_masuk_admin.php');
    die();
} else {
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	// print $actual_link;
	if(empty($pages)){ $pages = 'dashboard/dashboard_utama'; $module="DASHBOARD"; }
	include '../connection/common.php';
	include 'index_header.php';
	include 'index_menu.php';
	include 'index_pages.php';
	include 'index_footer.php';
}
?>
