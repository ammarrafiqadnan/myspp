<?php
session_start();
//GLOBAL $HTTP_SESSION_VARS;
error_reporting (E_ALL ^ E_NOTICE);
//$_SESSION['SESS_UID']='1';
header('X-Frame-Options: SAMEORIGIN');
//print "S:".$_SESSION['SESS_UID'];

//if(empty($_SESSION['SESS_UID'])){
if(empty($_SESSION['SESS_UID']) || $_SESSION['SESS_USER']!='PEMOHON'){

	header('Location: ../index.php');
    die();
} else {
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	// print $actual_link;
	if(empty($pages)){ $pages = 'dashboard/dashboard_utama'; $module="DASHBOARD"; }
	include '../connection/common.php';
	$date=date("Y-m-d H:i:s");
	$currentDate = strtotime($date);
	$futureDate = $currentDate-(60*10);
	$formatDate = date("Y-m-d H:i:s", $futureDate);
	$rsu = $conn->query("DELETE FROM $schema2.`user_log` WHERE `login_date`<=".tosql($formatDate));



	$gt='';
	$new = time();
	// $gt = $new - $_SESSION['dt_visit'];
	$rsu = $conn->query("SELECT * FROM $schema2.`user_log` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));

	// echo $rsu->fields['login_date'].":".$gt;
	$gt =  $new - strtotime($rsu->fields['login_date']);
	// print "GT:".$gt;

	if($gt>600){
		$conn->execute("DELETE FROM $schema2.`user_log` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
		session_destroy();
		$_SESSION['SESS_UID']='';
		include 'login.php'; exit;
	} else {
		$conn->execute("UPDATE $schema2.`user_log` SET `login_date`=".tosql(date("Y-m-d H:i:s"))." WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
	// 	$_SESSION['dt_visit']=time();
	}


	include 'index_header.php';
	include 'index_menu.php';
	include 'index_pages.php';
	include 'index_footer.php';
}
?>
