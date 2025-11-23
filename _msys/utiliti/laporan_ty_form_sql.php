<?php
include '../connection/common.php';
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$kategori_id=isset($_REQUEST["kategori_id"])?$_REQUEST["kategori_id"]:"";
$kategori_desc=isset($_REQUEST["kategori_desc"])?$_REQUEST["kategori_desc"]:"";
$kategori_status=isset($_REQUEST["kategori_status"])?$_REQUEST["kategori_status"]:"";

//$conn->debug=true;
$date=date("Y-m-d H:i:s");
if($pro=='SAVE'){

	if(!empty($kategori_id)){
		$strSQL = "UPDATE _ref_kategori_laporan SET 
			kategori_desc=".tosql($kategori_desc).", kategori_status =".tosql($kategori_status);
		$strSQL .= " WHERE kategori_id=".tosql($kategori_id);
		$rss = $conn->execute($strSQL);
	} else {
		$strSQL = "INSERT INTO _ref_kategori_laporan(kategori_desc, kategori_status, is_deleted) 
			VALUES(".tosql($kategori_desc).", ".tosql($kategori_status).", 0)";
		$rss = $conn->execute($strSQL);
	}
	//exit;
	if($rss){
		$err='OK';
	} else {
		$err='ERR'; 
	}
	
} else if($pro=="DEL"){

	//$sqld = "DELETE FROM _ref_akta WHERE akta_id='{$akta_id}'";
	$sqld = "UPDATE _ref_kategori_laporan SET is_deleted=1 WHERE kategori_id='{$kategori_id}'";
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
