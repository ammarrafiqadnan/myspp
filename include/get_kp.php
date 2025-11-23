<?php
include '../connection/common_log.php';
//$conn->debug=true;
$nokp=isset($_REQUEST["nokp"])?$_REQUEST["nokp"]:"";
if(!empty($nokp)){ 
	$query ="SELECT * FROM $schema2.`calon_block` WHERE `NOIc`=".tosql($nokp);
	$results = $conn->query($query);
	if(!$results->EOF){ $err = 'ADA'; }
	else { 
		//$err='DAFTAR';
		$query ="SELECT * FROM $schema2.`myid` WHERE `ICNo`=".tosql($nokp);
		$results = $conn->query($query);
		if(!$results->EOF){ 
			$err = 'DAFTAR'; 
		} else { 
			$err='SEMULA'; 
		}

	 }
}

//print $err;
echo json_encode($err);
//$conn->close();
?>