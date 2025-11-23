<?php
@session_start();
include_once '../../connection/common.php';
date_default_timezone_set('UTC');
date_default_timezone_set('Asia/Kuala_Lumpur'); 
error_reporting (E_ALL ^ E_NOTICE);
ini_set("display_errors", 1);
// require_once('../adodb.inc.php');
// require_once('../setting_db.php');
// require_once('../common_func.php');

$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$pengguna=isset($_REQUEST["userid"])?$_REQUEST["userid"]:"";
//$Passwd=isset($_REQUEST["katalaluan"])?$_REQUEST["katalaluan"]:"";
$katamasuk=isset($_REQUEST["katalaluan"])?$_REQUEST["katalaluan"]:"";
$token=isset($_REQUEST["token"])?$_REQUEST["token"]:"";
//$_SESSION['SESS_LOG']="LOG";
//$pwd = encode5t($Passwd);
//session_start();	
//$pengguna='1234567890';
//$katamasuk='1234567890';
$pass = md5($katamasuk);
//$pwd = $katamasuk;
$tarikh = date("Y-m-d H:i:s");
// print $pengguna." / ".$pro;

//$sql = "SELECT * FROM _tbl_users WHERE isdeleted=0 AND username=".tosql($UserID)." AND passwords=".tosql($pwd);
//if($_SESSION['token']==$token){



if(!empty($pengguna) && $pro=='CHK'){
	
	// $conn->debug=true;

	// print 'sini';exit();

	$sql = "SELECT * FROM $schema2.spa8i_admin WHERE username=".tosql($pengguna)." AND `password`=".tosqln($pass);
	$rs = $conn->query($sql);

	$sql = "SELECT COUNT(*) as total FROM $schema2.spa8i_admin WHERE username=".tosql($pengguna)." AND `password`=".tosqln($pass);
	$rsT = $conn->query($sql);

	if(($rsT->fields['total']) >= 1){
		if(!$rs->EOF){
			//$err = 'OK';
			@session_start();
				$user_katamasuk = $rs->fields['password'];
			// if($user_katamasuk == $pass){
				$_SESSION['SESS_UID']=$rs->fields['id'];
				// $_SESSION['SESS_UIC']=$rs->fields['MyID'];
				$_SESSION['SESS_UNAME']=$rs->fields['nama_penuh'];
				$_SESSION['SESS_UROLE']=$rs->fields['peranan'];	
				$_SESSION['SESS_MENU']=$rs->fields['menu'];	
				$err = 'OK';
			// } else {
			// 	$err = 'ERR';
			// }
			// print $_SESSION['SESS_UROLE'].'/'.$_SESSION['SESS_UNAME'].'/'.$_SESSION['SESS_UID'];
		}
	} else {
		$err='XADA';
	}

} else if(!empty($pengguna) && $pro=='SAVE'){
	print 'sini2';exit();
	// $conn->debug=true;
	$sql = "SELECT * FROM $schema2.myid WHERE status='50' AND `MyID`=".tosql($pengguna);
	$rs = $conn->query($sql);
	if($rs->recordcount()>=1){
		if(!$rs->EOF){
			//$err = 'OK';
			@session_start();
			$user_katamasuk = $rs->fields['katalaluan'];
			// print $user_katamasuk.":".$pass."<br>";
			if($user_katamasuk == $pass){
				$_SESSION['SESS_UID']=$rs->fields['id_pemohon'];
				$_SESSION['SESS_UIC']=$rs->fields['MyID'];
				$_SESSION['SESS_UNAME']=$rs->fields['nama'];			
				//print $_SESSION['SESS_UID'];
				$err = 'OK';
			} else {
				$err = 'ERR'; //.$user_katamasuk.":".$pass;
			}
		}
	} else {
		
		$err='XADA';
		
	}

} else {
	$err='XSTAT';
}
//print $_SESSION['SESS_UID']; exit;
//if(!empty($pengguna) && $pro=='CHK'){
// header("Content-Type: text/json");
// print json_encode($err);
print $err; 
?>
