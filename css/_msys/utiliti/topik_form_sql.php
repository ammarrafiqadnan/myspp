<?php
include '../connection/common.php';
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$topik_id=isset($_REQUEST["topik_id"])?$_REQUEST["topik_id"]:"";
$topik_nama=isset($_REQUEST["topik_nama"])?$_REQUEST["topik_nama"]:"";
$topik_status=isset($_REQUEST["topik_status"])?$_REQUEST["topik_status"]:"";

$date=date("Y-m-d H:i:s");
if($pro=='SAVE'){

	//$conn->debug=true;
	if(!empty($topik_id)){
		$strSQL = "UPDATE _ref_topik SET topik_nama=".tosql($topik_nama).", topik_status =".tosql($topik_status);
		$strSQL .= " WHERE topik_id=".tosql($topik_id);
		$rss = $conn->execute($strSQL);
	} else {
		$strSQL = "INSERT INTO _ref_topik(topik_nama, topik_status, is_deleted) 
			VALUES(".tosql($topik_nama).", ".tosql($topik_status).", 0)";
		$rss = $conn->execute($strSQL);
	}
	//exit;
	if($rss){
		$err='OK';
	} else {
		$err='ERR'; 
	}
	
} else if($pro=="DEL"){

	$sqld = "UPDATE _ref_topik SET is_deleted=1 WHERE topik_id='{$topik_id}'";
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
