<?php
include '../connection/common.php';
include '../email/mail_send.php';
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$ICNo=isset($_REQUEST["ICNo"])?$_REQUEST["ICNo"]:"";
$password1=isset($_REQUEST["password1"])?$_REQUEST["password1"]:"";
// $conn->debug=true;
$tarikh = date("Y-m-d H:i:s");
if($pro=='SAVE'){
	
	$pwd = md5($password1);
	$sqln = "UPDATE $schema2.myid SET `katalaluan`=".tosqln($pwd)." WHERE ICNo=".tosql($ICNo);
	$rsn = $conn->execute($sqln);

	if($rsn){
		$err='OK';
	} else { 
		$err = 'ERR'; 
	}

	if($err == 'OK'){
		$rs = $conn->query("SELECT * FROM $schema2.myid WHERE ICNo=".tosql($ICNo));
		//print $username->fields['username'];
			
	         		// PENERIMA EMEL
	         		$kepada = $rs->fields['emel'];
	         		$nama_penerima = $rs->fields['nama'];
	         		// PENGHANTAR EMEL
	         		$dari = "hidayumutalib@gmail.com";
	         		// SALINA KEPADA
	         		$cc = "";
	         		// TAJUK EMEL
	         		$tajuk="Reset Katalaluan Bagi Sistem MySPP";
	         		// KANDUNGAN EMEL
	         		$mesej = "<b>Berjaya kemaskini katalaluan.</b>";
				$mesej .= "<br><br>ID Pengguna :".$rs->fields['ICNo'];
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