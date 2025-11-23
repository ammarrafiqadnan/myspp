<?php
@session_start();
date_default_timezone_set('UTC');
date_default_timezone_set('Asia/Kuala_Lumpur'); 
error_reporting (E_ALL ^ E_NOTICE);
error_reporting(E_ALL & ~E_DEPRECATED);
// call_deprecated_function_here()
ini_set("display_errors", 0);
require_once('adodb.inc.php');
require_once('common_func.php');
require_once('dateformat.php');
$data=isset($_REQUEST["data"])?$_REQUEST["data"]:"";
$pages='';
if(!empty($data)){
	$datas = base64_decode($data);
	//print_r($datas);
	$get_data = explode(";", $datas);
	if(!empty($get_data[0])){ $pages = $get_data[0]; } else { $pages=''; }// piece2
	if(!empty($get_data[1])){ $module = $get_data[1]; } else { $module=''; }// piece2
	if(!empty($get_data[2])){ $menu = $get_data[2]; } else { $menu=''; }// piece2
	if(!empty($get_data[3])){ $submenu = $get_data[3]; } else { $submenu=''; }// piece2
	if(!empty($get_data[4])){ $actions = $get_data[4]; } else { $actions=''; }// piece2
	if(!empty($get_data[5])){ $id = $get_data[5]; } else { $id=''; }// piece2
	if(!empty($get_data[6])){ $id2 = $get_data[6]; } else { $id2=''; }// piece2

	//$PageNo=$_GET["PageNo"];
	
	//if($PageNo>1){ $_SESSION['pg']=$PageNo; }
	
	//$disp_pages = $pages." : ".$module." : ".$menu." : ".$submenu." : ".$id;
	
	
} else {
	//$_SESSION["SESS_UserID"]='';
	//$pages='login_form.php';
}

//$strsess = "SESS:".$_SESSION['SESS_UID'];

if(empty($_SESSION['SESS_UID'])){
	//header("Location: ../index.php");
}

if($pages=='logout'){ 
	$_SESSION['SESS_UID']='';
	@session_destroy();
	$pages='';
}

require_once('setting_db.php');

?>