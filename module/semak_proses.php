<?php
include '../connection/common.php';
// $conn->debug=true;
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$date=date("Y-m-d H:i:s");

if($pro=='PANGGILAN'){

	$emel=isset($_REQUEST["emel"])?$_REQUEST["emel"]:"";
	$ICNo=isset($_REQUEST["ICNo"])?$_REQUEST["ICNo"]:"";


	$rs = $conn->query("SELECT * FROM $schema2.`myid` WHERE `emel`=".tosql($emel));

	if(!$rs->EOF){
		if($rs->fields['ICNo']=='0' && $rs->fields['ic_ind']=='Z'){
			$err='OK';
		} else {
			$err = 'ADA';
		}
	} else {

		if(!empty($emel)){ 
			$strSQL = "INSERT INTO $schema2.`myid`(`ICNo`, `ic_ind`, `emel`, `daftar_flag`) VALUES('0','Z',".tosql($emel).",0)";
			$rss = $conn->execute($strSQL);
			if($rss){
				$err='OK';
			} else {
				$err='ERR'; 
			}	
		} else {
			$err='ERR'; 
		}
	}
} else if($pro=='KEPUTUSAN'){
	
	$emel=isset($_REQUEST["emel"])?$_REQUEST["emel"]:"";
	$ICNo=isset($_REQUEST["ICNo"])?$_REQUEST["ICNo"]:"";

	
	$rs = $conn->query("SELECT * FROM $schema2.`myid` WHERE `emel`=".tosql($emel));

	if(!$rs->EOF){
		if($rs->fields['ICNo']=='0' && $rs->fields['ic_ind']=='Z'){
			$err='OK';
		} else {
			$err = 'ADA';
		}
	} else {

		if(!empty($emel)){ 
			$strSQL = "INSERT INTO $schema2.`myid`(`ICNo`, `ic_ind`, `emel`, `daftar_flag`) VALUES('0','Z',".tosql($emel).",0)";
			$rss = $conn->execute($strSQL);
			if($rss){
				$err='OK';
			} else {
				$err='ERR'; 
			}	
		} else {
			$err='ERR'; 
		}
	}
}

// header("Content-Type: text/json");
// print json_encode($err); 
print $err;
?>
