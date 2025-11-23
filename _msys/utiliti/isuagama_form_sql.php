<?php
include '../connection/common.php';
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$isuagama_id=isset($_REQUEST["isuagama_id"])?$_REQUEST["isuagama_id"]:"";
$isuagama_nama=isset($_REQUEST["isuagama_nama"])?$_REQUEST["isuagama_nama"]:"";
$isuagama_status=isset($_REQUEST["isuagama_status"])?$_REQUEST["isuagama_status"]:"";

$date=date("Y-m-d H:i:s");
if($pro=='SAVE'){

	//$conn->debug=true;
	if(!empty($isuagama_id)){
		$strSQL = "UPDATE _ref_isuagama SET 
			isuagama_nama=".tosql($isuagama_nama).", isuagama_status =".tosql($isuagama_status);
		$strSQL .= " WHERE isuagama_id=".tosql($isuagama_id);
		$rss = $conn->execute($strSQL);
	} else {
		$strSQL = "INSERT INTO _ref_isuagama(isuagama_nama, isuagama_status, is_deleted) 
			VALUES(".tosql($isuagama_nama).", ".tosql($isuagama_status).", 0)";
		$rss = $conn->execute($strSQL);
	}
	//exit;
	if($rss){
		$err='OK';
	} else {
		$err='ERR'; 
	}
	
} else if($pro=="DEL"){

	$sqld = "UPDATE _ref_isuagama SET is_deleted=1 WHERE isuagama_id='{$isuagama_id}'";
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
