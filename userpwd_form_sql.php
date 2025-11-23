<?php
include 'connection/common.php';
include 'email/mail_send.php';
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$noKP=isset($_REQUEST["noKP"])?$_REQUEST["noKP"]:"";
$email=isset($_REQUEST["email"])?$_REQUEST["email"]:"";
$password1=isset($_REQUEST["password1"])?$_REQUEST["password1"]:"";
//$conn->debug=true;
$tarikh = date("Y-m-d H:i:s");
if($pro=='SAVE'){
	
	$rs = $conn->query("SELECT `id`, `emel` FROM $schema2.spa8i_admin WHERE noKP=".tosql($noKP));
	if(!$rs->EOF){
		
		if($rs->fields['emel']==$email){
	
			$pwd = md5($password1);
			$sqln = "UPDATE $schema2.spa8i_admin SET `password`=".tosqln($pwd)." WHERE noKP=".tosql($noKP). " AND id=".tosql($rs->fields['id']);
			$rsn = $conn->execute($sqln);

			if($rsn){
				$err='OK';
			} else { 
				$err = 'ERR'; 
			}

		} else {
			$err='EMEL';
		} 	

	} else {
		$err = 'ERR';
	}


	if($err == 'OK'){
		$rs = $conn->query("SELECT * FROM $schema2.spa8i_admin  WHERE noKP=".tosql($noKP). " AND emel=".tosqln($email));
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
				$mesej .= "<br><br>Webmaster Sistem MySPP";
	         		// mail_send($tajuk, $mesej, $kepada, $nama_penerima, $dari, $cc);
	         		mail_smtp($tajuk, $mesej, $kepada, $nama_penerima, $dari, $cc);			
			}


}
//if(empty($err)){ $err='PKS'; }
// header("Content-Type: text/json");
// print json_encode($err); 
print $err;
?>