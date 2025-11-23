<?php
include '../connection/common.php';
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$kluster_id=isset($_REQUEST["kluster_id"])?$_REQUEST["kluster_id"]:"";
$kluster_nama=isset($_REQUEST["kluster_nama"])?$_REQUEST["kluster_nama"]:"";
$kluster_status=isset($_REQUEST["kluster_status"])?$_REQUEST["kluster_status"]:"";

$date=date("Y-m-d H:i:s");
if($pro=='SAVE'){

	//$conn->debug=true;
	if(!empty($kluster_id)){
		$strSQL = "UPDATE _ref_kluster SET kluster_nama=".tosql($kluster_nama).", kluster_status =".tosql($kluster_status);
		$strSQL .= " WHERE kluster_id=".tosql($kluster_id);
		$rss = $conn->execute($strSQL);
	} else {
		$strSQL = "INSERT INTO _ref_kluster(kluster_nama, kluster_status, is_deleted) 
			VALUES(".tosql($kluster_nama).", ".tosql($kluster_status).", 0)";
		$rss = $conn->execute($strSQL);
	}
	//exit;
	if($rss){
		$err='OK';
	} else {
		$err='ERR'; 
	}
	
} else if($pro=="DEL"){

	$sqld = "UPDATE _ref_kluster SET is_deleted=1 WHERE kluster_id='{$kluster_id}'";
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
