<?php
//session_start();
include '../connection/common.php';
$ic=isset($_REQUEST["ic"])?$_REQUEST["ic"]:"";
$emel=isset($_REQUEST["emel"])?$_REQUEST["emel"]:"";
//$conn->debug=true;
$tarikh = date("Y-m-d H:i:s");
$rs=$conn->query("SELECT * FROM _tbl_users WHERE ic='{$ic}' AND emel='{$emel}'");
if(!$rs->EOF){
	$id=$rs->fields['id'];
	$pwd = md5($rs->fields['ic']);
	$sqln = "UPDATE _tbl_users SET passwords=".tosqln($pwd).", modified='{$tarikh}' WHERE id=".tosql($id);
	$rsn = $conn->execute($sqln);
	
	if($rsn){
		$err='OK';
	} else { 
		$err = 'ERR'; 
	}
} else { 
	$err = 'ERR'; 
}
//if(empty($err)){ $err='PKS'; }
header("Content-Type: text/json");
print json_encode($err); 
?>