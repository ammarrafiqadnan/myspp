<?php
include '../connection/common.php';
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$parlimen_id=isset($_REQUEST["parlimen_id"])?$_REQUEST["parlimen_id"]:"";
$parlimen_nama=isset($_REQUEST["parlimen_nama"])?$_REQUEST["parlimen_nama"]:"";
$parlimen_status=isset($_REQUEST["parlimen_status"])?$_REQUEST["parlimen_status"]:"";

$date=date("Y-m-d H:i:s");
if($pro=='SAVE'){

	//$conn->debug=true;
	if(!empty($parlimen_id)){
		$strSQL = "UPDATE _ref_parlimen SET 
			parlimen_nama=".tosql($parlimen_nama).", parlimen_status =".tosql($parlimen_status);
		$strSQL .= " WHERE parlimen_id=".tosql($parlimen_id);
		$rss = $conn->execute($strSQL);
	} else {
		$strSQL = "INSERT INTO _ref_parlimen(parlimen_nama, parlimen_status, is_deleted) 
			VALUES(".tosql($parlimen_nama).", ".tosql($parlimen_status).", 0)";
		$rss = $conn->execute($strSQL);
	}
	//exit;
	if($rss){
		$err='OK';
	} else {
		$err='ERR'; 
	}
	
} else if($pro=="DEL"){

	$sqld = "UPDATE _ref_parlimen SET is_deleted=1 WHERE parlimen_id='{$parlimen_id}'";
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
