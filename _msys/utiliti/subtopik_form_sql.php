<?php
include '../connection/common.php';
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$topik_id=isset($_REQUEST["topik_id"])?$_REQUEST["topik_id"]:"";
$subtopik_id=isset($_REQUEST["subtopik_id"])?$_REQUEST["subtopik_id"]:"";
$subtopik_nama=isset($_REQUEST["subtopik_nama"])?$_REQUEST["subtopik_nama"]:"";
$subtopik_status=isset($_REQUEST["subtopik_status"])?$_REQUEST["subtopik_status"]:"";

$date=date("Y-m-d H:i:s");
if($pro=='SAVE'){

	//$conn->debug=true;
	if(!empty($subtopik_id)){
		$strSQL = "UPDATE _ref_topik_sub SET 
			topik_id=".tosql($topik_id).", subtopik_nama=".tosql($subtopik_nama).", subtopik_status =".tosql($subtopik_status);
		$strSQL .= " WHERE subtopik_id=".tosql($subtopik_id);
		$rss = $conn->execute($strSQL);
	} else {
		$strSQL = "INSERT INTO _ref_topik_sub(topik_id, subtopik_nama, subtopik_status, is_deleted) 
			VALUES(".tosql($topik_id).", ".tosql($subtopik_nama).", ".tosql($subtopik_status).", 0)";
		$rss = $conn->execute($strSQL);
	}
	//exit;
	if($rss){
		$err='OK';
	} else {
		$err='ERR'; 
	}
	
} else if($pro=="DEL"){

	$sqld = "UPDATE _ref_topik_sub SET is_deleted=1 WHERE subtopik_id='{$subtopik_id}'";
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
