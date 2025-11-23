<?php
include '../connection/common.php';
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$akhbar_id=isset($_REQUEST["akhbar_id"])?$_REQUEST["akhbar_id"]:"";
$akhbar_nama=isset($_REQUEST["akhbar_nama"])?$_REQUEST["akhbar_nama"]:"";
$akhbar_status=isset($_REQUEST["akhbar_status"])?$_REQUEST["akhbar_status"]:"";

$date=date("Y-m-d H:i:s");
if($pro=='SAVE'){

	//$conn->debug=true;
	if(!empty($akhbar_id)){
		$strSQL = "UPDATE _ref_akhbar SET 
			akhbar_nama=".tosql($akhbar_nama).", akhbar_status =".tosql($akhbar_status);
		$strSQL .= " WHERE akhbar_id=".tosql($akhbar_id);
		$rss = $conn->execute($strSQL);
	} else {
		$strSQL = "INSERT INTO _ref_akhbar(akhbar_nama, akhbar_status, is_deleted) 
			VALUES(".tosql($akhbar_nama).", ".tosql($akhbar_status).", 0)";
		$rss = $conn->execute($strSQL);
	}
	//exit;
	if($rss){
		$err='OK';
	} else {
		$err='ERR'; 
	}
	
} else if($pro=="DEL"){

	$sqld = "UPDATE _ref_akhbar SET is_deleted=1 WHERE akhbar_id='{$akhbar_id}'";
	$rss = $conn->execute($sqld);
	if($rss){
		$err='OK';
	} else {
		$err='ERR'; 
	}
	
}

header("Content-Type: text/json");
print json_encode($err); 
?>
