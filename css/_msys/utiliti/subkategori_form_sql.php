<?php
include '../connection/common.php';
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$kategori_id=isset($_REQUEST["kategori_id"])?$_REQUEST["kategori_id"]:"";
$subkat_id=isset($_REQUEST["subkat_id"])?$_REQUEST["subkat_id"]:"";
$subkat_nama=isset($_REQUEST["subkat_nama"])?$_REQUEST["subkat_nama"]:"";
$subkat_status=isset($_REQUEST["subkat_status"])?$_REQUEST["subkat_status"]:"";

$date=date("Y-m-d H:i:s");
if($pro=='SAVE'){

	//$conn->debug=true;
	if(!empty($subkat_id)){
		$strSQL = "UPDATE _ref_kategori_sub SET 
			kategori_id=".tosql($kategori_id).", subkat_nama=".tosql($subkat_nama).", subkat_status =".tosql($subkat_status);
		$strSQL .= " WHERE subkat_id=".tosql($subkat_id);
		$rss = $conn->execute($strSQL);
	} else {
		$strSQL = "INSERT INTO _ref_kategori_sub(kategori_id, subkat_nama, subkat_status, is_deleted) 
			VALUES(".tosql($kategori_id).", ".tosql($subkat_nama).", ".tosql($subkat_status).", 0)";
		$rss = $conn->execute($strSQL);
	}
	//exit;
	if($rss){
		$err='OK';
	} else {
		$err='ERR'; 
	}
	
} else if($pro=="DEL"){

	$sqld = "UPDATE _ref_kategori_sub SET is_deleted=1 WHERE subkat_id='{$subkat_id}'";
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
