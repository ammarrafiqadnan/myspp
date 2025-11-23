<?php
session_start();
include '../connection/common.php';
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$ic=isset($_REQUEST["ic"])?$_REQUEST["ic"]:"";
$nama=isset($_REQUEST["nama"])?$_REQUEST["nama"]:"";
$jawatan=isset($_REQUEST["jawatan"])?$_REQUEST["jawatan"]:"";
$notel=isset($_REQUEST["notel"])?$_REQUEST["notel"]:"";
$nohp=isset($_REQUEST["nohp"])?$_REQUEST["nohp"]:"";
$emel=isset($_REQUEST["emel"])?$_REQUEST["emel"]:"";
$gred=isset($_REQUEST["gred"])?$_REQUEST["gred"]:"";

$tarikh = date("Y-m-d H:i:s");
$proses='';

if($pro=='SAVE'){
	$sqln = "UPDATE _tbl_users SET  
	jawatan=".tosql($jawatan).", notel=".tosql($notel).", nohp=".tosql($nohp).", 
	gred=".tosqln($gred).", emel=".tosqln($emel).", modified='{$tarikh}'  
	WHERE id=".tosql($id);
	//$err = 'SAVES1';
	$rsn = $conn->execute($sqln);

	if($rsn){
		$_SESSION['SESS_UJAWATAN']=$jawatan;
		$err='OK';
	} else { 
		$err = 'ERR'; 
	}
}
//if(empty($err)){ $err='PKS'; }
header("Content-Type: text/json");
print json_encode($err); 
?>