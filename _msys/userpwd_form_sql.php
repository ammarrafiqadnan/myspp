<?php
include '../connection/common.php';
include '../email/mail_send.php';
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$password1=isset($_REQUEST["password1"])?$_REQUEST["password1"]:"";
//$conn->debug=true;
$tarikh = date("Y-m-d H:i:s");
if($pro=='SAVE'){

	$pwd = md5($password1);
	$sqln = "UPDATE $schema2.spa8i_admin SET `password`=".tosqln($pwd)." WHERE id=".tosql($id);
	$rsn = $conn->execute($sqln);

	if($rsn){
		$err='OK';
	} else { 
		$err = 'ERR'; 
	}

	if($err == 'OK'){
		$rs = $conn->query("SELECT * FROM $schema2.spa8i_admin WHERE id=".tosql($id));
		//print $username->fields['username'];
			
	         		// PENERIMA EMEL
	         		$kepada = $rs->fields['emel'];
	         		$nama_penerima = $rs->fields['nama_penuh'];
	         		// PENGHANTAR EMEL
	         		$dari = "webmaster.spp.gov.my";
	         		// SALINA KEPADA
	         		$cc = "";
	         		// TAJUK EMEL
	         		$tajuk="Reset Katalaluan Bagi Sistem MySPP";
	         		// KANDUNGAN EMEL
	         		$mesej = "<b>Berjaya kemaskini katalaluan.</b>";
				$mesej .= "<br><br>ID Pengguna :".$rs->fields['username'];
				$mesej .= "<br>Katalaluan  :".$password1;
				$mesej .= "<br><br>Admin MySPP";
	         		// mail_send($tajuk, $mesej, $kepada, $nama_penerima, $dari, $cc);
	         		mail_smtp($tajuk, $mesej, $kepada, $nama_penerima, $dari, $cc);			
			}


}
header("Content-Type: text/json");
print json_encode($err); 
//print $err;
?>