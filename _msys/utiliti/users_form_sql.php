<?php
session_start();
include '../connection/common.php';
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$ic=isset($_REQUEST["ic"])?$_REQUEST["ic"]:"";
$nama=isset($_REQUEST["nama"])?$_REQUEST["nama"]:"";
$jawatan=isset($_REQUEST["jawatan"])?$_REQUEST["jawatan"]:"";
$bahagian_id=isset($_REQUEST["bahagian_id"])?$_REQUEST["bahagian_id"]:"";
$agensi_id=isset($_REQUEST["agensi_id"])?$_REQUEST["agensi_id"]:"";
$notel=isset($_REQUEST["notel"])?$_REQUEST["notel"]:"";
$nohp=isset($_REQUEST["nohp"])?$_REQUEST["nohp"]:"";
$emel=isset($_REQUEST["emel"])?$_REQUEST["emel"]:"";
$level=isset($_REQUEST["level"])?$_REQUEST["level"]:"";
$access=isset($_REQUEST["access"])?$_REQUEST["access"]:"";
$peg_io=isset($_REQUEST["peg_io"])?$_REQUEST["peg_io"]:"";

// $conn->debug=true;

$tarikh = date("Y-m-d H:i:s");
$proses='';
//print $pro;
if($pro=='SAVE'){
	
	$pwd = md5($ic);
	if(empty($id)){
		$rs = $conn->query("SELECT * FROM _tbl_users WHERE ic='{$ic}'");
		if($rs->EOF){
			$proses='INS';
			// $id = "K".uniqid(date("ymdHis"));
			$sqln = "INSERT INTO _tbl_users(ic, nama, jawatan, bahagian_id, agensi_id, notel, 
				nohp, emel, level, access, created, isdeleted, username, passwords) 
			VALUES(".tosql($ic).", ".tosql($nama).", ".tosql($jawatan).", ".tosql($bahagian_id).", ".tosql($agensi_id).", ".tosql($notel).", 
				".tosql($nohp).", ".tosqln($emel).", ".tosql($level).", ".tosql($access).", ".tosql($tarikh).", 0, 
				".tosql($ic).", '{$pwd}')";
			//$err = 'SAVES';
			$rsn = $conn->execute($sqln);
		} else {
			if($rs->fields['isdeleted']==1){
				$sqln = "UPDATE _tbl_users SET ic=".tosql($ic).", nama=".tosql($nama).", 
				jawatan=".tosql($jawatan).", bahagian_id=".tosql($bahagian_id).", agensi_id=".tosql($agensi_id).", 
				notel=".tosql($notel).", nohp=".tosql($nohp).", 
				emel=".tosqln($emel).", level=".tosql($level).", access=".tosql($access).", username=".tosql($ic).", 
				modified='{$tarikh}', isdeleted=0   
				WHERE id=".tosql($id);
				$rsn = $conn->execute($sqln);
			}
		}
	} else {
		$proses='UPD';
		$sqln = "UPDATE _tbl_users SET ic=".tosql($ic).", nama=".tosql($nama).", 
			jawatan=".tosql($jawatan).", bahagian_id=".tosql($bahagian_id).", agensi_id=".tosql($agensi_id).", 
			notel=".tosql($notel).", nohp=".tosql($nohp).", 
			emel=".tosqln($emel).", level=".tosql($level).", access=".tosql($access).", username=".tosql($ic).", 
			modified='{$tarikh}'  
		WHERE id=".tosql($id);
		//$err = 'SAVES1';
		$rsn = $conn->execute($sqln);
	}
	
	if($rsn){
		$err='OK';
	} else { 
		$err = 'ERR'; 
	}
} else if($pro=='DEL'){
	//$conn->debug=true;
	$tkh=date("Y-m-d H:i:s");
	$oleh=$_SESSION['SESSADM_UID'];
	$ID=isset($_REQUEST["ID"])?$_REQUEST["ID"]:"";
	$rss = $conn->execute("UPDATE _tbl_users SET isdeleted=1, isdeletedt='{$tkh}', isdeleteby='{$oleh}' WHERE id='{$ID}'");
	if($rss){
		$err='OK';
	} else {
		$err='ERR'; 
	}
} else if($pro=='RESET'){
	//$conn->debug=true;
	$tkh=date("Y-m-d H:i:s");
	$oleh=$_SESSION['SESSADM_UID'];
	$ID=isset($_REQUEST["ID"])?$_REQUEST["ID"]:"";
	$rs = $conn->query("SELECT * FROM _tbl_users WHERE id='{$ID}'");
	if(!$rs->EOF){
		$pwd=md5($rs->fields['ic']);
		$rss = $conn->execute("UPDATE _tbl_users SET passwords='{$pwd}', modified='{$tkh}' WHERE id='{$ID}'");
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	} else {
		$err='ERR'; 
	}
}
header("Content-Type: text/json");
print json_encode($err); 
?>