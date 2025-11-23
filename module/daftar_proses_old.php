<?php
include '../connection/common.php';
//$conn->debug=true;
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$date=date("Y-m-d H:i:s");
$urls = "http://10.29.58.50/myspp/";
//$urls = "https://mysppv2.spp.gov.my/myspp/";

if($pro=='DAFTAR'){
	//$conn->debug=true; 
	$emel=isset($_REQUEST["ed"])?$_REQUEST["ed"]:"";
	$nama=isset($_REQUEST["na"])?$_REQUEST["na"]:"";
	$nokp=isset($_REQUEST["kp"])?$_REQUEST["kp"]:"";


	ini_set("soap.wsdl_cache_enabled", "0");

	// Point to the WSDL file
	$wsdl_url = $urls."wsdl/crswsdev.wsdl";

	// Create a new instance of the SoapClient class
	$client = new SoapClient($wsdl_url);

	// List available operations
	// print_r($client->__getFunctions());

	$requestParams = array(
	  'AgencyCode' => '101107',
	  'BranchCode' => 'MySPP',
	  'UserId' => 'User1',
	  'TransactionCode' => 'T7',
	  'RequestDateTime' => date("Y-m-dTH:i:s"),  //'2023-03-11T11:34:00',
	  'ICNumber' => $nokp, //'600101015011',
	  'RequestIndicator' => 'A'
	);

	// Call the operation
	$result = $client->__soapCall("retrieveCitizensData", array($requestParams));
	// print_r($result);
	$verify='JPN';
	$ReplyIndicator = $result->ReplyIndicator;
	$RecordStatus = $result->RecordStatus;

	//$ReplyIndicator = $result->ReplyIndicator;//kenapa berulang ?
	//$RecordStatus = $result->RecordStatus; //kenapa berulang ?
	$MessageCode = $result->MessageCode; 
	$Message = $result->Message; 
	$ICNumber = $result->ICNumber; 
	$Name = $result->Name; 
	$DateOfBirth = $result->DateOfBirth; 
	$Gender = $result->Gender; 
	$Race = $result->Race; 
	$Religion = $result->Religion; 
	$OldICnumber = $result->OldICnumber; 
	$DateOfDeath = $result->DateOfDeath; 
	$CitizenshipStatus = $result->CitizenshipStatus; 
	$ResidentialStatus = $result->ResidentialStatus; 
	$AddressStatus = $result->AddressStatus; 
	$VerifyStatus = $result->VerifyStatus; 
	$PermanentAddress1 = $result->PermanentAddress1; 
	$PermanentAddress2 = $result->PermanentAddress2; 
	$PermanentAddress3 = $result->PermanentAddress3; 
	$PermanentAddressPostcode = $result->PermanentAddressPostcode; 
	$PermanentAddressCityCode = $result->PermanentAddressCityCode; 
	$PermanentAddressStateCode = $result->PermanentAddressStateCode; 
	$ReplyDateTime = $result->ReplyDateTime;
	
//print $RecordStatus.'/'.$ReplyIndicator.'/'.$ResidentialStatus.'//';

	if($RecordStatus=='1' && $ReplyIndicator=='1'){ 
		if($ResidentialStatus == 'B' || $ResidentialStatus == 'C'){
			$verify='OK';
		} else { 
			//JIKA BUKAN WARGANEGARA
			$verify='JPN';
		}
	} // JIKA DATA ADA 
	else if($RecordStatus=='A' && $ReplyIndicator=='1'){ $verify='OK'; } // JIKA DATA ADA 
	else if($RecordStatus=='1' && $ReplyIndicator=='2'){ $verify='JPN'; } // JIKA ADA MASALAH NOKP 
	else if($RecordStatus=='2' && $ReplyIndicator=='1'){ $verify='JPN'; } // JIKA MENINGGAL DUNIA
	else if($RecordStatus=='1' && $ReplyIndicator=='0'){ $verify='XOK'; }
	else if($RecordStatus=='2' && $ReplyIndicator=='0'){ $verify='XOK'; }
	else if($RecordStatus=='0' && $ReplyIndicator=='1'){ $verify='XOK'; }
	else if($RecordStatus=='0' && $ReplyIndicator=='2'){ $verify='XOK'; }
	else { 
		if($ReplyIndicator=='2'){
			$verify='JPN';
		} else {
			$verify='XOK';
		}

	} // JIKA DATA TAK 
	//else { $verify='JPN'; } // JIKA DATA BERMASALAH


	$sqli = "INSERT INTO $schema2.`myid_jpn` (ReplyIndicator, RecordStatus, MessageCode, Message, 
		ICno, Nama, 
		DOB, Gander, Race, Religon, OldICNo, 
		DateOfDeath, CitizenshipStatus, ResidentialStatus, AddressStatus, 
		VerifyStatus, PermanentAddress1, PermanentAddress2, PermanentAddress3, 
		PermanentPoscode, PermanentCity, PermanentState, trxDate)";
	$sqli .= " VALUES(".tosql($ReplyIndicator).", ".tosql($RecordStatus).", ".tosql($MessageCode).", ".tosql($Message).",  
		".tosql($ICNumber).", ".tosql($Name).",  
		".tosql($DateOfBirth).", ".tosql($Gender).", ".tosql($Race).", ".tosql($Religion).", ".tosql($OldICnumber).",  
		".tosql($DateOfDeath).", ".tosql($CitizenshipStatus).", ".tosql($ResidentialStatus).", ".tosql($AddressStatus).",  
		".tosql($VerifyStatus).", ".tosql($PermanentAddress1).", ".tosql($PermanentAddress2).", ".tosql($PermanentAddress3).",  
		".tosql($PermanentAddressPostcode).", ".tosql($PermanentAddressCityCode).", ".tosql($PermanentAddressStateCode).", ".tosql($ReplyDateTime).")";
	$conn->execute($sqli);

	//exit;
	//$verify='OK'; //$conn->debug=true;
	if($verify=='JPN'){ 
		// JIKA DATA BERMASALAH DALAM MYIDENTITY
		$err = 'JPN';

	} else if($verify=='OK'){ 

		$rs = $conn->query("SELECT * FROM $schema2.`myid` WHERE `emel`=".tosqln($emel));

		if(!$rs->EOF){
			//print $rs->fields['ICNo'].":".$nokp.":".$rs->fields['ic_ind'];
			if($rs->fields['ICNo']==$nokp && $rs->fields['ic_ind']=='Z'){
				$err='OK';
			} else if($rs->fields['ICNo']==$nokp && $rs->fields['ic_ind']!='Z'){
				$err='DDAF';
			} else if($rs->fields['ICNo']!=$nokp && $rs->fields['ic_ind']=='Z'){
				$err='EMELX';
			} else if($rs->fields['ICNo']!=$nokp && $rs->fields['ic_ind']!='Z'){
				$err='EMELX';
			} else {
				$err = 'ADA';
			}

		} else {

			$rs = $conn->query("SELECT * FROM $schema2.`myid` WHERE `ICNo`=".tosqln($nokp));
			
			if($rs->EOF){

				if(!empty($emel)){ 
					$strSQL = "INSERT INTO $schema2.`myid`(`ICNo`, `nama`, `ic_ind`, `emel`, `daftar_flag`, `d_create`) 
					VALUES(".tosql($nokp).",".tosql($nama).",'Z',".tosqln($emel).",0,".tosql(date("Y-m-d H:i:s")).")";
					$rss = $conn->execute($strSQL);
					if($rss){
						$err='OK';
					} else {
						$err='ERR'; 
					}	
				} else {
					$err='ERR'; 
				}

			} else {
			
				$err = "ICADA";
			
			}
		}

		if($err=='OK'){
			if($verify == 'OK'){
			
			$rsSel = $conn->query("SELECT * FROM $schema2.`myid_jpn` WHERE `ICno`='{$nokp}' AND `trxDate` LIKE '".date("Y-m-d")."%'");
			if($rsSel->recordcount()<=3){ 
				$hurl = $urls."index.php?data=".base64_encode('module/daftar_myspp;'.$emel.";".$nama.";".$nokp.";".date("Ymd"));
				//print $hurl;  
				include '../email/mail_send.php';
	         		// PENERIMA EMEL
	         		$kepada = $emel; //'xx@gmail.com';
	         		$nama_penerima = $nama; //"XXXm";
	         		// PENGHANTAR EMEL
	         		$dari = "webmaster@spp.gov.my";
	         		// SALINA KEPADA
	         		$cc = '';
	         		// TAJUK EMEL
	         		$tajuk="Pendaftaran Sistem MySPP";
	         		// KANDUNGAN EMEL
	         		$mesej = "<b>Pendaftaran permohonan bagi sistem MySPP telah berjaya.</b>";
	         		$mesej .= '<br><br>Bagi melengkapkan pendaftaran anda, sila klik di pautan ini <a href="'.$hurl.'">'.$hurl.'</a>'; 
	         		$mesej .= '<br><br>Webmaster Sistem MySPP';
	         		// mail_send($tajuk, $mesej, $kepada, $nama_penerima, $dari, $cc);
	         		mail_smtp($tajuk, $mesej, $kepada, $nama_penerima, $dari, $cc);
			}
			
			} else {
				$err="XLIMIT";
			}

		}
	} else if($verify == 'XOK') {
		$err = 'XOK';
	} else {
		//print 'here';
		$err = 'ERR';
	}
	//print $err;
} else if($pro=='REG'){
	//$conn->debug=true;
	$emel=isset($_REQUEST["emel"])?$_REQUEST["emel"]:"";
	$ICNo=isset($_REQUEST["ICNo"])?$_REQUEST["ICNo"]:"";
	$nama=isset($_REQUEST["nama"])?$_REQUEST["nama"]:"";
	//$notel=isset($_REQUEST["notel"])?$_REQUEST["notel"]:"";
	$pass1=isset($_REQUEST["pass1"])?$_REQUEST["pass1"]:"";

	$sql = "SELECT * FROM $schema2.`myid` WHERE `ICNo`='{$ICNo}' AND `emel`=".tosqln($emel); //AND `ic_ind`='Z' 
	$rs = $conn->query($sql);

	if(!$rs->EOF){
		if($rs->fields['ic_ind']=='Z'){ 
			$idpemohon = date("Y").substr($ICNo, 2);
			$strSQL = "UPDATE $schema2.`myid` SET `ICNo`=".tosql($ICNo).", `MyID`=".tosql($ICNo).", `nama`=".tosql($nama).", `ic_ind`='A', `daftar_flag`=1, `id_pemohon`=".tosql($idpemohon);
			$strSQL .= ", katalaluan=".tosql(md5($pass1)).", `d_upd`=".tosql(date("Y-m-d H:i:s")).", `tkh_daftar`=".tosql(date("Y-m-d H:i:s"));
			$strSQL .= " WHERE `ic_ind`='Z' AND `emel`=".tosqln($emel);
			$rss = $conn->execute($strSQL);
			if($rss){
				$err='OK';
				$sql = "INSERT INTO $schema2.`calon` (`id_pemohon`, `ICNo`, `jenis_id`, `nama_penuh`, `e_mail`, `d_cipta`)";
				$sql .= " VALUES(".tosql($idpemohon).", ".tosql($ICNo).", 'A', ".tosql($nama).", ".tosqln($emel).", 
					".tosql(date("Y-m-d H:i:s")).")";
				$conn->execute($sql);	
			} else {
				$err='ERR'; 
			}	
		} else {
			$err='ADA';
		}

	} else {
		$err='ERR1'; 
	}

} else if($pro=='RESET'){
	 //$conn->debug=true;
	$emel=isset($_REQUEST["emel"])?$_REQUEST["emel"]:"";
	$ICNo=isset($_REQUEST["ICNo"])?$_REQUEST["ICNo"]:"";
	$nama=isset($_REQUEST["nama"])?$_REQUEST["nama"]:"";
	$notel=isset($_REQUEST["notel"])?$_REQUEST["notel"]:"";
	$pass1=isset($_REQUEST["pass1"])?$_REQUEST["pass1"]:"";

	$sql = "SELECT * FROM $schema2.`myid` WHERE `ICNo`='{$ICNo}' AND `emel`=".tosqln($emel); //AND `ic_ind`='Z' 
	$rs = $conn->query($sql);

	if(!$rs->EOF){

		$idpemohon = date("Y").substr($ICNo, 5);
		$strSQL = "UPDATE $schema2.`myid` SET `notel`=".tosql($notel).", `katalaluan`=".tosql(md5($pass1));
		$strSQL .= " WHERE `ICNo`=".tosql($ICNo)." AND `MyID`=".tosql($ICNo)." AND `emel`=".tosqln($emel);
		$rss = $conn->execute($strSQL);

	} else {
		$err='ERR1'; 
	}

	if($rss){

			$err='OK';
		} else {
			$err='ERR'; 
		}


} else if($pro=='LUPA'){
	//$conn->debug=true;
	$emel=isset($_REQUEST["emel"])?$_REQUEST["emel"]:"";
	$ICNo=isset($_REQUEST["ICNo"])?$_REQUEST["ICNo"]:"";

	$rs = $conn->query("SELECT * FROM $schema2.`myid` WHERE `ICNo`=".tosql($ICNo)." AND `emel`=".tosqln($emel));

	if(!$rs->EOF){
		
		$err='OK';

		$nama = $rs->fields['nama'];

		$hurl = $urls."index.php?data=".base64_encode('module/ubah_myspp;'.$emel.";".$nama.";".$ICNo);
		include '../email/mail_send.php';
		// PENERIMA EMEL
		$kepada = $emel; 
		$nama_penerima = $nama; 
		// PENGHANTAR EMEL
		$dari = "webmaster@spp.gov.my";
		// SALINA KEPADA
		$cc = '';
		// TAJUK EMEL
		$tajuk="Reset Kata Laluan";
		// KANDUNGAN EMEL
		$mesej = "<b>Pengemaskinian Kata Laluan Sistem MySPP.</b>";
		// $mesej .= 'Sila gunakan maklumat di bawah untuk log masuk ke dalam sistem.<br>ID:'.$ICNo.'<br>Kata laluan: '.$passwd; 
		$mesej .= '<br><br>Bagi melengkapkan perubahan kata Laluan anda, sila klik di pautan ini <a href="'.$hurl.'">'.$hurl.'</a>'; 
        $mesej .= '<br><br>Webmaster Sistem MySPP';
		// mail_send($tajuk, $mesej, $kepada, $nama_penerima, $dari, $cc);
		mail_smtp($tajuk, $mesej, $kepada, $nama_penerima, $dari, $cc);



	} else {
		$err='ERR'; 
	}
}

//header("Content-Type: text/json");
//print json_encode($err); 
print $err;
?>
