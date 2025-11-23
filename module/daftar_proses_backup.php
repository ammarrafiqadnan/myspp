<?php
include '../connection/common.php';
//$conn->debug=true;
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$date=date("Y-m-d H:i:s");
//$ip_add="https://10.29.25.144/";
$ip_add="https://myspp.spp.gov.my/"; 

if($pro=='DAFTAR'){
	//$conn->debug=true;      
	$emel=isset($_REQUEST["ed"])?$_REQUEST["ed"]:"";
	$nama=strtoupper(isset($_REQUEST["na"])?$_REQUEST["na"]:"");
	$nokp=isset($_REQUEST["kp"])?$_REQUEST["kp"]:"";

	$rsSel = $conn->query("SELECT * FROM $schema2.`myid_jpn` A, $schema2.`myid` B WHERE A.`ICno`=B.`ICno` AND A.`ICno`='{$nokp}' AND B.`emel`='{$emel}' 
	AND A.`trxDate` LIKE '".date("Y-m-d")."%' 
	AND A.`ReplyIndicator` = 1 AND A.`RecordStatus` IN ('1','A') AND A.`ResidentialStatus` IN ('B','C')");

	if($rsSel->recordcount()>=3){ 

		$err="XLIMIT";

	} else {

		ini_set("soap.wsdl_cache_enabled", "0");

		// Point to the WSDL file
		$wsdl_url = "https://10.29.25.144/myspp/wsdl/crsservice.wsdl";
		
		$options = [
			'stream_context' => stream_context_create([
				'ssl' => [
					'verify_peer' => false,
					'verify_peer_name' => false,
				]
			])
		];	

		// Create a new instance of the SoapClient class
		$client = new SoapClient($wsdl_url, $options);

		// List available operations
		// print_r($client->__getFunctions());

		$requestParams = array(
		  'AgencyCode' => 'SPPTQQBSE',
		  'BranchCode' => 'MySPP',
		  'UserId' => '10.29.25.144',
		  'TransactionCode' => 'SPP14717',
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
				if(($ICNumber == $nokp) && ($Name == $nama)){
					$verify='OK';
				} else {
					$verify='XOK';
				}
			} else { 
				//JIKA BUKAN WARGANEGARA
				$verify='JPN';
			}
		} // JIKA DATA ADA 
		else if($RecordStatus=='A' && $ReplyIndicator=='1'){ 
			if(($ICNumber == $nokp) && ($Name == $nama)){
					$verify='OK';
				} else {
					$verify='XOK';
				}


		 } // JIKA DATA ADA 
		else if($RecordStatus=='1' && $ReplyIndicator=='2'){ $verify='JPN'; } // JIKA ADA MASALAH NOKP 
		else if($RecordStatus=='2' && $ReplyIndicator=='1'){ $verify='JPN'; } // JIKA MENINGGAL DUNIA
		else if($RecordStatus=='1' && $ReplyIndicator=='0' && $ICNumber != $nokp && $Name != $nama){ $verify='XOK'; }
		else if($RecordStatus=='2' && $ReplyIndicator=='0' && $ICNumber != $nokp && $Name != $nama){ $verify='XOK'; }
		else if($RecordStatus=='0' && $ReplyIndicator=='1' && $ICNumber != $nokp && $Name != $nama){ $verify='XOK'; }
		else if($RecordStatus=='0' && $ReplyIndicator=='2' && $ICNumber != $nokp && $Name != $nama){ $verify='XOK'; }
		else { 
			if($ReplyIndicator=='2'){
				$verify='JPN';
			} else {
				if(($ICNumber != $nokp) && ($Name != $nama)){
					$verify='XOK';
				}
			}

		} // JIKA DATA TAK 
		//else { $verify='JPN'; } // JIKA DATA BERMASALAH


		if($verify=='OK'){
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
		}

		//exit;
		//$verify='OK'; //$conn->debug=true;
		//print $verify; 
		if($verify=='JPN'){ 
			// JIKA DATA BERMASALAH DALAM MYIDENTITY
			$err = 'JPN';

		} else if($verify=='OK'){ 

			
			$rs2 = $conn->query("SELECT * FROM $schema2.`myid` WHERE `ICNo`=".tosqln($nokp). " AND emel=".tosql($emel));

			if(!$rs2->EOF){
				if($rs2->fields['ICNo']==$nokp && $rs2->fields['ic_ind']=='Z'){
					$err='OK';
				} else if($rs2->fields['ICNo']==$nokp && $rs2->fields['ic_ind']!='Z'){
					$err='DDAF';
				} 
			} else {
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

			}



			if($err=='OK'){
				
				$rsSel = $conn->query("SELECT * FROM $schema2.`myid_jpn` WHERE `ICno`='{$nokp}' AND `trxDate` LIKE '".date("Y-m-d")."%' 
				AND ReplyIndicator = 1 AND RecordStatus IN ('1','A') AND ResidentialStatus IN ('B','C')");

				 $rsSel = $conn->query("SELECT * FROM $schema2.`myid_jpn` A, $schema2.`myid` B WHERE A.`ICno`=B.`ICno` AND A.`ICno`='{$nokp}' AND B.`emel`='{$emel}' 
				 	AND A.`trxDate` LIKE '".date("Y-m-d")."%' 
				 	AND A.`ReplyIndicator` = 1 AND A.`RecordStatus` IN ('1','A') AND A.`ResidentialStatus` IN ('B','C')");

				 if($rsSel->recordcount()<=3){ 
					$hurl = $ip_add."myspp/index.php?data=".base64_encode('module/daftar_myspp;'.$emel.";".$nama.";".$nokp.";".date("Ymd"));
					//print $hurl;  
					include '../email/mail_send.php';
		         		// PENERIMA EMEL
		         		$kepada = $emel; //'nizamms@gmail.com';
		         		$nama_penerima = $nama; //"Hairul Nizam";
		         		// PENGHANTAR EMEL
		         		$dari = "adminmyspp@spp.gov.my";
		         		// SALINA KEPADA
		         		$cc = '';
		         		// TAJUK EMEL
		         		$tajuk="Pendaftaran Sistem MySPP";
		         		// KANDUNGAN EMEL
		         		$mesej = "<b>Pra-Pendaftaran permohonan bagi sistem mySPP telah berjaya.</b>";
		         		$mesej .= '<br><br>Untuk mengaktifkan akaun pendaftaran anda, sila klik di pautan ini <a href="'.$hurl.'">'.$hurl.'</a> dan setkan kata laluan anda. Pautan ini hanya sah dalam masa tiga (3) hari. Gagal berbuat demikian, anda dikehendaki untuk membuat Pra-Pendaftaran semula.'; 
		         		$mesej .= '<br><br>Sekian, terima kasih';
		         		$mesej .= '<br><br>Admin mySPP<br><br>';

					$mesej .= "<b> Peringatan </b><br> Perkhidmatan MyGovUC 2.0 adalah bertanggungjawab melindungi kerahsiaan data/maklumat Rahsia Rasmi Kerajaan. Adalah diingatkan agar pengguna sentiasa peka dengan SEMUA peraturan, arahan keselamatan dan pekeliling semasa yang berkuatkuasa bagi semua pengendalian data/maklumat Rahsia Rasmi Kerajaan yang berkaitan.";
		         		// mail_send($tajuk, $mesej, $kepada, $nama_penerima, $dari, $cc);
		         		mail_smtp($tajuk, $mesej, $kepada, $nama_penerima, $dari, $cc);
				
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
	}

	//print $err;
} else if($pro=='REG'){
	//$conn->debug=true;
	$emel=isset($_REQUEST["emel"])?$_REQUEST["emel"]:"";
	$ICNo=isset($_REQUEST["ICNo"])?$_REQUEST["ICNo"]:"";
	$nama=isset($_REQUEST["nama"])?$_REQUEST["nama"]:"";
	//$notel=isset($_REQUEST["notel"])?$_REQUEST["notel"]:"";
	$pass1=isset($_REQUEST["pass1"])?$_REQUEST["pass1"]:"";

	$sql = "SELECT A.*, B.`Gander`, B.`Race`, B.`Religon` 
		FROM $schema2.`myid` A, $schema2.`myid_jpn` B WHERE A.`ICno`=B.`ICno` AND A.`ICNo`=".tosql($ICNo)." AND A.`emel`=".tosql($emel); //AND `ic_ind`='Z' 
	$rs = $conn->query($sql);

	if(!$rs->EOF){
		if($rs->fields['ic_ind']=='Z'){ 
			$idpemohon = date("Y").substr($ICNo, 2);
			$strSQL = "UPDATE $schema2.`myid` SET `ICNo`=".tosql($ICNo).", `MyID`=".tosql($ICNo).", `nama`=".tosql($nama).", `ic_ind`='A', `daftar_flag`=1, `id_pemohon`=".tosql($idpemohon);
			$strSQL .= ", katalaluan=".tosql(md5($pass1)).", `d_upd`=".tosql(date("Y-m-d H:i:s")).", `tkh_daftar`=".tosql(date("Y-m-d H:i:s"));
			$strSQL .= " WHERE `ic_ind`='Z' AND `emel`=".tosql($emel);
			$rss = $conn->execute($strSQL);
			if($rss){
				$err='OK';
				$sql = "INSERT INTO $schema2.`calon` (`id_pemohon`, `ICNo`, `jenis_id`, `nama_penuh`, `e_mail`, `d_cipta`, `jantina`, `agama`, `keturunan`)";
				$sql .= " VALUES(".tosql($idpemohon).", ".tosql($ICNo).", 'A', ".tosql($nama).", ".tosql($emel).", 
					".tosql(date("Y-m-d H:i:s")).", ".tosql($rs->fields['Gander']).", ".tosql($rs->fields['Religon']).", ".tosql($rs->fields['Race']).")";
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

	$sql = "SELECT * FROM $schema2.`myid` WHERE `ICNo`='{$ICNo}' AND `emel`=".tosql($emel); //AND `ic_ind`='Z' 
	$rs = $conn->query($sql);

	if(!$rs->EOF){

		$idpemohon = date("Y").substr($ICNo, 5);
		$strSQL = "UPDATE $schema2.`myid` SET `notel`=".tosql($notel).", `katalaluan`=".tosql(md5($pass1));
		$strSQL .= " WHERE `ICNo`=".tosql($ICNo)." AND `MyID`=".tosql($ICNo)." AND `emel`=".tosql($emel);
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

		$hurl = $ip_add."myspp/index.php?data=".base64_encode('module/ubah_myspp;'.$emel.";".$nama.";".$ICNo);
		include '../email/mail_send.php';
		// PENERIMA EMEL
		$kepada = $emel; 
		$nama_penerima = $nama;
		// PENGHANTAR EMEL
		$dari = "adminmyspp@spp.gov.my";
		// SALINA KEPADA
		$cc = '';
		// TAJUK EMEL
		$tajuk="Lupa Kata Laluan";
		// KANDUNGAN EMEL
		$mesej = "<b>Pengemaskinian Kata Laluan Sistem MySPP.</b>";
		// $mesej .= 'Sila gunakan maklumat di bawah untuk log masuk ke dalam sistem.<br>ID:'.$ICNo.'<br>Kata laluan: '.$passwd; 
		$mesej .= '<br><br>Bagi melengkapkan perubahan kata Laluan anda, sila klik di pautan ini <a href="'.$hurl.'">'.$hurl.'</a>'; 
        $mesej .= '<br><br>Admin mySPP<br><br>';
		$mesej .= "<b> Peringatan </b><br> Perkhidmatan MyGovUC 2.0 adalah bertanggungjawab melindungi kerahsiaan data/maklumat Rahsia Rasmi Kerajaan. Adalah diingatkan agar pengguna sentiasa peka dengan SEMUA peraturan, arahan keselamatan dan pekeliling semasa yang berkuatkuasa bagi semua pengendalian data/maklumat Rahsia Rasmi Kerajaan yang berkaitan.";
	         		
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
