<?php
session_start();
include_once '../../connection/common_log.php';
date_default_timezone_set('UTC');
date_default_timezone_set('Asia/Kuala_Lumpur'); 
error_reporting (E_ALL ^ E_NOTICE);
ini_set("display_errors", 0);
// require_once('../adodb.inc.php');
// require_once('../setting_db.php');
// require_once('../common_func.php');

$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$userid=isset($_REQUEST["userid"])?$_REQUEST["userid"]:"";
$katalaluan=isset($_REQUEST["katalaluan"])?$_REQUEST["katalaluan"]:"";
$token=isset($_REQUEST["token"])?$_REQUEST["token"]:"";
$pass = $katalaluan;
$tarikh = date("Y-m-d H:i:s");
//$conn->debug=true;

if(!empty($katalaluan) && $pro=='CHK'){
	$sql = "SELECT * FROM $schema2.`myid` WHERE `daftar_flag`='1' AND `MyID`=".tosql($userid)." AND `katalaluan`=".tosql(md5($katalaluan)); 
	$rs = $conn->query($sql);
	if(!$rs->EOF){
		if(!$rs->EOF){
			//$err = 'OK';
			@session_start();
			// $user_katamasuk = $rs->fields['password'];
			// $verify = password_verify($katalaluan, $user_katamasuk);

			// print $user_katamasuk.":".$pass;
			// if($verify){
				$_SESSION['SESS_USER']="PEMOHON";
				$_SESSION['SESS_ID']=$rs->fields['id_pemohon'];
				$_SESSION['SESS_MYID']=$rs->fields['MyID'];
				$_SESSION['SESS_UID']=$rs->fields['id_pemohon'];
				$_SESSION['SESS_ICNO']=$rs->fields['ICNo'];
				$_SESSION['SESS_UIC']=$rs->fields['ICNo'];
				$_SESSION['SESS_UNAME']=$rs->fields['nama'];
				$_SESSION['SESS_EMEL']=$rs->fields['emel'];
				$_SESSION['SESS_NOTEL']=$rs->fields['notel'];
				$err = 'OK';
			// } else {
			// 	$err = 'ERR'; //.$user_katamasuk.":".$pass;
			// }
			$rsu = $conn->execute("INSERT INTO $schema2.`user_log`(`id_pemohon`, `login_date`) 
				VALUES (".tosql($rs->fields['id_pemohon']).",".tosql($tarikh).")");
		}
	} else {
		
		$err='XADA';
		
	}
}
//header("Content-Type: text/json");
//print json_encode($err); 
print $err;
?>
