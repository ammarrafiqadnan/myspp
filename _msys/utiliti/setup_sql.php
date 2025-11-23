<?php
include '../connection/common.php';
//$conn->debug=true;
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$setup_id=isset($_REQUEST["setup_id"])?$_REQUEST["setup_id"]:"";
$setup_name=isset($_REQUEST["setup_name"])?$_REQUEST["setup_name"]:"";
$nama_tpo=isset($_REQUEST["nama_tpo"])?$_REQUEST["nama_tpo"]:"";
$nama_pengarah=isset($_REQUEST["nama_pengarah"])?$_REQUEST["nama_pengarah"]:"";

$date=date("Y-m-d H:i:s");
if($pro=='SAVE'){
	$strSQL = "UPDATE tbl_setup SET 
		setup_name=".tosqln($setup_name).", nama_tpo =".tosql($nama_tpo).", nama_pengarah=".tosql($nama_pengarah).",
		update_dt=".tosql($date).", update_by=".tosql($by);
		$strSQL .= " WHERE setup_id=".tosql($setup_id);
	$rss = $conn->execute($strSQL);
	//exit;
	if($rss){
		$err='OK';
	} else {
		$err='ERR'; 
	}
	
}

header("Content-Type: text/json");
print json_encode($err); 
?>
