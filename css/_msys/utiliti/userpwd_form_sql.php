<?php
include '../connection/common.php';
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$password1=isset($_REQUEST["password1"])?$_REQUEST["password1"]:"";
//$conn->debug=true;
$tarikh = date("Y-m-d H:i:s");
if($pro=='SAVE'){

	$pwd = md5($password1);
	$sqln = "UPDATE _tbl_users SET passwords=".tosqln($pwd).", modified='{$tarikh}' WHERE id=".tosql($id);
	$rsn = $conn->execute($sqln);

	if($rsn){
		$err='OK';
	} else { 
		$err = 'ERR'; 
	}

}
//if(empty($err)){ $err='PKS'; }
header("Content-Type: text/json");
print json_encode($err); 
?>