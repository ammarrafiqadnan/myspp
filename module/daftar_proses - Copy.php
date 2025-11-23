<?php
include '../connection/common.php';
//$conn->debug=true;
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$date=date("Y-m-d H:i:s");

if($pro=='DAFTAR'){
	$emel=isset($_REQUEST["ed"])?$_REQUEST["ed"]:"";
	$nama=isset($_REQUEST["na"])?$_REQUEST["na"]:"";
	$nokp=isset($_REQUEST["kp"])?$_REQUEST["kp"]:"";


	ini_set("soap.wsdl_cache_enabled", "0");

	// Point to the WSDL file
	$wsdl_url = "http://10.29.58.50/myspp/wsdl/crswsdev.wsdl";

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

	$ReplyIndicator = $result->ReplyIndicator;
	$RecordStatus = $result->RecordStatus; 
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


	if($RecordStatus=='1' && $ReplyIndicator=='1'){ $verify='OK'; } // JIKA DATA ADA 
	else if($RecordStatus=='A' && $ReplyIndicator=='1'){ $verify='OK'; } // JIKA DATA ADA 
	else if($RecordStatus=='1' && $ReplyIndicator=='2'){ $verify='OK'; } // JIKA DATA ADA 
	else { $verify='JPN'; } // JIKA DATA BERMASALAH


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

	if($verify=='JPN'){ 
		// JIKA DATA BERMASALAH DALAM MYIDENTITY
		$err = 'JPN';

	} else if($verify=='OK'){ 

		$rs = $conn->query("SELECT * FROM $schema2.`myid` WHERE `emel`=".tosql($emel));

		if(!$rs->EOF){
			if($rs->fields['ICNo']=='0' && $rs->fields['ic_ind']=='Z'){
				$err='OK';
			} else {
				$err = 'ADA';
			}
		} else {

			if(!empty($emel)){ 
				$strSQL = "INSERT INTO $schema2.`myid`(`ICNo`, `nama`, `ic_ind`, `emel`, `daftar_flag`) 
				VALUES(".tosql($nokp).",".tosql($nama).",'Z',".tosql($emel).",0)";
				$rss = $conn->execute($strSQL);
				if($rss){
					$err='OK';
				} else {
					$err='ERR'; 
				}	
			} else {
				$err='ERR'; 
			}
		}

		if($err=='OK'){
			$hurl = "http://10.29.58.50/myspp/index.php?data=".base64_encode('module/daftar_myspp;'.$emel.";".$nama.";".$nokp);
			//print $hurl;  
			include '../email/mail_send.php';
	         // PENERIMA EMEL
	         $kepada = $emel; //'nizamms@gmail.com';
	         $nama_penerima = $nama; //"Hairul Nizam";
	         // PENGHANTAR EMEL
	         $dari = "nizamms@gmail.com";
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
	}

} else if($pro=='REG'){
	// $conn->debug=true;
	$emel=isset($_REQUEST["emel"])?$_REQUEST["emel"]:"";
	$ICNo=isset($_REQUEST["ICNo"])?$_REQUEST["ICNo"]:"";
	$nama=isset($_REQUEST["nama"])?$_REQUEST["nama"]:"";
	$notel=isset($_REQUEST["notel"])?$_REQUEST["notel"]:"";
	$pass1=isset($_REQUEST["pass1"])?$_REQUEST["pass1"]:"";

	$sql = "SELECT * FROM $schema2.`myid` WHERE `ICNo`='{$ICNo}' AND `emel`=".tosql($emel); //AND `ic_ind`='Z' 
	$rs = $conn->query($sql);

	if(!$rs->EOF){
		if($rs->fields['ic_ind']=='Z'){ 
			$idpemohon = date("Y").substr($ICNo, 5);
			$strSQL = "UPDATE $schema2.`myid` SET `ICNo`=".tosql($ICNo).", `MyID`=".tosql($ICNo).", `nama`=".tosql($nama).", 
				`notel`=".tosql($notel).", `ic_ind`='A', `daftar_flag`=1, `id_pemohon`=".tosql($idpemohon);
			$strSQL .= ", katalaluan=".tosql(md5($pass1));
			$strSQL .= " WHERE `ic_ind`='Z' AND `emel`=".tosql($emel);
			$rss = $conn->execute($strSQL);
			if($rss){
				$err='OK';
				$sql = "INSERT INTO $schema2.`calon` (`id_pemohon`, `ICNo`, `jenis_id`, `nama_penuh`, `no_tel`, `e_mail`, `d_cipta`)";
				$sql .= " VALUES(".tosql($idpemohon).", ".tosql($ICNo).", 'A', ".tosql($nama).", ".tosql($notel).", ".tosql($emel).", 
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

} else if($pro=='LUPA'){
	// $conn->debug=true;
	$emel=isset($_REQUEST["emel"])?$_REQUEST["emel"]:"";
	$ICNo=isset($_REQUEST["ICNo"])?$_REQUEST["ICNo"]:"";

	$rs = $conn->query("SELECT * FROM $schema2.`myid` WHERE `ICNo`=".tosql($ICNo)." AND `emel`=".tosql($emel));

	if(!$rs->EOF){
		$characters = '123456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < 10; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }

	    $passwd = substr($randomString,0,10);

		$strSQL = "UPDATE $schema2.`myid` SET katalaluan=".tosql(md5($passwd));
		$strSQL .= " WHERE `MyID`=".tosql($rs->fields['MyID'])." AND `emel`=".tosql($emel);
		// print $strSQL;
		$rss = $conn->execute($strSQL);
		if($rss){
			$err='OK';
			$hurl = "http://10.29.58.50/myspp/index.php?data=".base64_encode('module/ubah_myspp;'.$emel.";".$nama.";".$nokp);
			include '../email/mail_send.php';
			// PENERIMA EMEL
			$kepada = $emel; //'nizamms@gmail.com';
			$nama_penerima = $rs->fields['nama_penuh']; //"Hairul Nizam";
			// PENGHANTAR EMEL
			$dari = "nizamms@gmail.com";
			// SALINA KEPADA
			$cc = '';
			// TAJUK EMEL
			$tajuk="Reset Kata Laluan";
			// KANDUNGAN EMEL
			$mesej = "<b>Kata Laluan bagi sistem MySPP telah berjaya dikemaskini.</b>";
			// $mesej .= 'Sila gunakan maklumat di bawah untuk log masuk ke dalam sistem.<br>ID:'.$ICNo.'<br>Kata laluan: '.$passwd; 
			$mesej .= '<br><br>Bagi melengkapkan perubahan kata Laluan anda, sila klik di pautan ini <a href="'.$hurl.'">'.$hurl.'</a>'; 
	        $mesej .= '<br><br>Webmaster Sistem MySPP';
			// mail_send($tajuk, $mesej, $kepada, $nama_penerima, $dari, $cc);
			mail_smtp($tajuk, $mesej, $kepada, $nama_penerima, $dari, $cc);
		} else {
			$err='ERR'; 
		}	

	} else {
		$err='ERR'; 
	}
}

header("Content-Type: text/json");
print json_encode($err); 
//print $err;
?>
