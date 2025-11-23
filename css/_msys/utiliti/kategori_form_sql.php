<?php
include '../connection/common.php';
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$kategori_id=isset($_REQUEST["kategori_id"])?$_REQUEST["kategori_id"]:"";
$kategori_nama=isset($_REQUEST["kategori_nama"])?$_REQUEST["kategori_nama"]:"";
$kategori_status=isset($_REQUEST["kategori_status"])?$_REQUEST["kategori_status"]:"";

$date=date("Y-m-d H:i:s");
if($pro=='SAVE'){

	//$conn->debug=true;
	if(!empty($kategori_id)){
		$strSQL = "UPDATE _ref_kategori SET 
			kategori_nama=".tosql($kategori_nama).", kategori_status =".tosql($kategori_status);
		$strSQL .= " WHERE kategori_id=".tosql($kategori_id);
		$rss = $conn->execute($strSQL);
	} else {
		$strSQL = "INSERT INTO _ref_kategori(kategori_nama, kategori_status, is_deleted) 
			VALUES(".tosql($kategori_nama).", ".tosql($kategori_status).", 0)";
		$rss = $conn->execute($strSQL);
	}
	//exit;
	if($rss){
		$err='OK';
	} else {
		$err='ERR'; 
	}
	
} else if($pro=="DEL"){

	$sqld = "UPDATE _ref_kategori SET is_deleted=1 WHERE kategori_id='{$kategori_id}'";
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
