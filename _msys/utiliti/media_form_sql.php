<?php
include '../connection/common.php';
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$medium_id=isset($_REQUEST["medium_id"])?$_REQUEST["medium_id"]:"";
$medium_name=isset($_REQUEST["medium_name"])?$_REQUEST["medium_name"]:"";
$medium_code=isset($_REQUEST["medium_code"])?$_REQUEST["medium_code"]:"";
$medium_status=isset($_REQUEST["medium_status"])?$_REQUEST["medium_status"]:"";

$date=date("Y-m-d H:i:s");
if($pro=='SAVE'){

	//$conn->debug=true;
	if(!empty($medium_id)){
		$strSQL = "UPDATE `_ref_medium_media` SET 
			medium_name=".tosql($medium_name).", medium_code =".tosql($medium_code).", medium_status ='{$medium_status}'";
		$strSQL .= " WHERE medium_id=".tosql($medium_id);
		$rss = $conn->execute($strSQL);
	} else {
		$strSQL = "INSERT INTO `_ref_medium_media`(medium_name, medium_code, medium_status, is_deleted) 
			VALUES(".tosql($medium_name).", ".tosql($medium_code).", '{$medium_status}', 0)";
		$rss = $conn->execute($strSQL);
	}
	//exit;
	if($rss){
		$err='OK';
	} else {
		$err='ERR'; 
	}
	
} else if($pro=="DEL"){

	$sqld = "UPDATE `_ref_medium_media` SET is_deleted=1 WHERE medium_id='{$medium_id}'";
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
