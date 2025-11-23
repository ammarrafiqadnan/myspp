<?php
include '../connection/common.php';
//$conn->debug=true;
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$date=date("Y-m-d H:i:s");
//$ip_add="https://10.29.25.144/";
$ip_add="https://myspp.spp.gov.my/"; 

function do_simpan_jpn($code, $ReplyIndicator, $RecordStatus, $MessageCode, $Message, $ICNumber, $Name, $ReplyDateTime, $ic_jpn, $nama_jpn){
	global $conn;
	global $schema2;

	//$conn->debug=true;
	$sqli = "INSERT INTO $schema2.`myid_jpn_error` (ReplyIndicator, RecordStatus, MessageCode, Message, ICno, Nama, trxDate, ic_jpn, nama_jpn)";
	$sqli .= " VALUES(".tosql($ReplyIndicator).", ".tosql($RecordStatus).", ".tosql($MessageCode).", ".tosql($Message).", 
		".tosql($ICNumber).", ".tosql($Name).", ".tosql($ReplyDateTime).", ".tosql($ic_jpn).", ".tosql($nama_jpn).")";
	//print $sqli; exit;
	$conn->execute($sqli);
	//$conn->debug=false;
}

if($pro=='DAFTAR'){
	//$conn->debug=true;      
	$emel=trim(isset($_REQUEST["ed"])?$_REQUEST["ed"]:"");
	$nama=trim(strtoupper(isset($_REQUEST["na"])?$_REQUEST["na"]:""));
	$nokp=trim(isset($_REQUEST["kp"])?$_REQUEST["kp"]:"");
	
	$query ="SELECT * FROM $schema2.`calon_block` WHERE `NOIc`=".tosql(trim($nokp));
	$results = $conn->query($query);
	//exit;
	if(!$results->EOF){ 
		$err = 'ADAS'; 
		// JIKA PEMOHON ADA DALAM SENARAI DISEKAT
	} else { 
		// JIKA PEMOHON YTIADA DALAM SENARAI DEISEKAT
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
			//request start
			
			// Create a new instance of the SoapClient class
			$client = new SoapClient($wsdl_url, $options);

			// List available operations
			// print_r($client->__getFunctions());
			
			$requestParams = array(
			  'AgencyCode' => 'SPPTQQBSE', //kod agensi yg dibekalkan oleh JPN
			  'BranchCode' => 'MySPP', //kod sistem yg dibekalkan oleh JPN
			  'UserId' => '10.29.25.144', //ip addr yg berinteraksi dgn server intergrasi di JPN
			  'TransactionCode' => 'SPP14717', //kod transaksi yg dibekalkan oleh JPN
			  'RequestDateTime' => date("Y-m-dTH:i:s"),  //'2023-03-11T11:34:00', //tarikh semakan dilakukan
			  'ICNumber' => $nokp, //'600101015011', //noKP yg dicari di JPN
			  'RequestIndicator' => 'A'
			);
			//request end

			//prosess start bagi intergrasi ke sistem
			// Call the operation
			$result = $client->__soapCall("retrieveCitizensData", array($requestParams));
			//print_r($result); exit;
			$verify='JPN';


			//respon daripada JPN
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
			// end off respon JPN
			
			//print $RecordStatus.":".$ResidentialStatus.":".$ReplyIndicator; exit;

			if($RecordStatus=='1' && $ReplyIndicator=='1'){ 
				// JIKA DATA ADA
				if($ResidentialStatus == 'B' || $ResidentialStatus == 'C'){
					if(($ICNumber == $nokp) && ($Name == $nama)){
						$verify='OK';
					} else { 
						$verify='XOK';
						do_simpan_jpn($code, $ReplyIndicator, $RecordStatus, $MessageCode, "NOKP atau Nama Tidak Tepat", $nokp, $nama, $ReplyDateTime, $ICNumber, $Name);
					}
				} else { 
					//JIKA BUKAN WARGANEGARA
					$verify='JPN';
				}
			} else if($RecordStatus=='5' && $ReplyIndicator=='1'){ 
				// JIKA DATA ADA
				if($ResidentialStatus == 'B' || $ResidentialStatus == 'C'){
					if(($ICNumber == $nokp) && ($Name == $nama)){
						$verify='OK';
					} else { 
						$verify='XOK';
						do_simpan_jpn($code, $ReplyIndicator, $RecordStatus, $MessageCode, "NOKP atau Nama Tidak Tepat", $nokp, $nama, $ReplyDateTime, $ICNumber, $Name);
					}
				} else { 
					//JIKA BUKAN WARGANEGARA
					$verify='JPN';
				}
			} else if($RecordStatus=='A' && $ReplyIndicator=='1'){ 
				if(($ICNumber == $nokp) && ($Name == $nama)){
						$verify='OK';
					} else {
						$verify='XOK';					
						do_simpan_jpn($code, $ReplyIndicator, $RecordStatus, $MessageCode, "NOKP atau Nama Tidak Tepat", $nokp, $nama, $ReplyDateTime, $ICNumber, $Name);				}


			} else if($RecordStatus=='F' && $ReplyIndicator=='1'){ 
				if(($ICNumber == $nokp) && ($Name == $nama)){
						$verify='OK';
					} else {
						$verify='XOK';					
						do_simpan_jpn($code, $ReplyIndicator, $RecordStatus, $MessageCode, "NOKP atau Nama Tidak Tepat", $nokp, $nama, $ReplyDateTime, $ICNumber, $Name);
					}


			} // JIKA DATA ADA 
			else if($RecordStatus=='1' && $ReplyIndicator=='2'){ 
				$verify='JPN'; do_simpan_jpn($code, $ReplyIndicator, $RecordStatus, $MessageCode, $Message, $nokp, $nama, $ReplyDateTime, $ICNumber, $Name);
	 		} // JIKA ADA MASALAH NOKP 
			else if($RecordStatus=='2' && $ReplyIndicator=='1'){ 
				$verify='JPN'; do_simpan_jpn($code, $ReplyIndicator, $RecordStatus, $MessageCode, $Message, $nokp, $nama, $ReplyDateTime, $ICNumber, $Name);
	 		} // JIKA MENINGGAL DUNIA
			else if($RecordStatus=='1' && $ReplyIndicator=='0' && $ICNumber != $nokp && $Name != $nama){ 
				$verify='XOK'; do_simpan_jpn($code, $ReplyIndicator, $RecordStatus, $MessageCode, "NOKP atau Nama Tidak Tepat", $nokp, $nama, $ReplyDateTime, $ICNumber, $Name);
	 		}
			else if($RecordStatus=='2' && $ReplyIndicator=='0' && $ICNumber != $nokp && $Name != $nama){ 
				$verify='XOK'; do_simpan_jpn($code, $ReplyIndicator, $RecordStatus, $MessageCode, "NOKP atau Nama Tidak Tepat", $nokp, $nama, $ReplyDateTime, $ICNumber, $Name);
	 		}
			else if($RecordStatus=='0' && $ReplyIndicator=='1' && $ICNumber != $nokp && $Name != $nama){ 
				$verify='XOK'; do_simpan_jpn($code, $ReplyIndicator, $RecordStatus, $MessageCode, "NOKP atau Nama Tidak Tepat", $nokp, $nama, $ReplyDateTime, $ICNumber, $Name);
	 		}
			else if($RecordStatus=='0' && $ReplyIndicator=='2' && $ICNumber != $nokp && $Name != $nama){ 
				$verify='XOK'; do_simpan_jpn($code, $ReplyIndicator, $RecordStatus, $MessageCode, "NOKP atau Nama Tidak Tepat", $nokp, $nama, $ReplyDateTime, $ICNumber, $Name);
	 		}
			else { 
				if($ReplyIndicator=='2'){
					$verify='JPN';
					do_simpan_jpn($code, $ReplyIndicator, $RecordStatus, $MessageCode, $Message, $nokp, $nama, $ReplyDateTime, $ICNumber, $Name);
				} else {
					if(($ICNumber != $nokp) && ($Name != $nama)){
						$verify='XOK';					
						do_simpan_jpn($code, $ReplyIndicator, $RecordStatus, $MessageCode, "NOKP atau Nama Tidak Tepat", $nokp, $nama, $ReplyDateTime, $ICNumber, $Name);
					}
				}

			} // JIKA DATA TAK 
			//else { $verify='JPN'; } // JIKA DATA BERMASALAH

			//if($ICNumber=='951104045118'){ $conn->debug=true; }
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
			//print_r($result); exit;

			//exit;
			//$verify='OK'; //$conn->debug=true;
			//print $verify; 
			if($verify=='JPN'){ 
				//exit;
				// JIKA DATA BERMASALAH DALAM MYIDENTITY
				$err = 'JPN';
				do_simpan_jpn($code, $ReplyIndicator, $RecordStatus, $MessageCode, $Message, $nokp, $nama, $ReplyDateTime, $ICNumber, $Name);
				//exit;
			} else if($verify=='OK'){ 

				
				$rs2 = $conn->query("SELECT * FROM $schema2.`myid` WHERE `ICNo`=".tosqln($nokp). " AND emel=".tosqln($emel));

				if(!$rs2->EOF){
					if($rs2->fields['ICNo']==$nokp && $rs2->fields['ic_ind']=='Z'){
						$err='OK';
					} else if($rs2->fields['ICNo']==$nokp && $rs2->fields['ic_ind']!='Z'){
						$err='DDAF';
					} 
				} else {
					$rs3 = $conn->query("SELECT * FROM $schema2.`myid` WHERE emel=".tosqln($emel). " AND ic_ind='A'");
					if(!$rs3->EOF){
						$err='EMELX';
					} else {
						$strSQL = "INSERT INTO $schema2.`myid`(`ICNo`, `nama`, `ic_ind`, `emel`, `daftar_flag`, `d_create`) 
						VALUES(".tosql($nokp).",".tosql($nama).",'Z',".tosqln($emel).",0,".tosql(date("Y-m-d H:i:s")).")";
						$rss = $conn->execute($strSQL);
						//$conn->debug=false;
						if($rss){
							$err='OK';
						} else {
							$err='ERR'; 
						}
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
	}
	//print $err;
} else if($pro=='REG'){
	$emel=trim(isset($_REQUEST["emel"])?$_REQUEST["emel"]:"");
	$ICNo=trim(isset($_REQUEST["ICNo"])?$_REQUEST["ICNo"]:"");
	$nama=trim(isset($_REQUEST["nama"])?$_REQUEST["nama"]:"");
	//$notel=isset($_REQUEST["notel"])?$_REQUEST["notel"]:"";
	$pass1=isset($_REQUEST["pass1"])?$_REQUEST["pass1"]:"";

	$sql = "SELECT A.*, B.`Gander`, B.`Race`, B.`Religon` 
		FROM $schema2.`myid` A, $schema2.`myid_jpn` B WHERE A.`ICno`=B.`ICno` AND A.`ICNo`=".tosql($ICNo)." AND A.`emel`=".tosqln($emel); //AND `ic_ind`='Z' 
	$sql .= " ORDER BY id DESC";
	$rs = $conn->query($sql);

	if(!$rs->EOF){
		if($rs->fields['ic_ind']=='Z'){ 
			$idpemohon = date("Y").$ICNo;
			$rs3 = $conn->query("SELECT * FROM $schema2.`myid` WHERE ICNo=".tosql($ICNo). " AND ic_ind='A'");
			if($rs3->EOF){
			//$conn->debug=true;
			$strSQL = "UPDATE $schema2.`myid` SET `ICNo`=".tosql($ICNo).", `MyID`=".tosql($ICNo).", `nama`=".tosql($nama).", `ic_ind`='A', `daftar_flag`=1, `id_pemohon`=".tosql($idpemohon);
			$strSQL .= ", katalaluan=".tosql(md5($pass1)).", `d_upd`=".tosql(date("Y-m-d H:i:s")).", `tkh_daftar`=".tosql(date("Y-m-d H:i:s"));
			$strSQL .= " WHERE `ic_ind`='Z' AND `emel`=".tosqln($emel)." AND `ICNo`=".tosqln($ICNo);
			$rss = $conn->execute($strSQL);
				if($rss){
					$err='OK';
					$sql = "INSERT INTO $schema2.`calon` (`id_pemohon`, `ICNo`, `jenis_id`, `nama_penuh`, `e_mail`, `d_cipta`, `jantina`, `agama`, `keturunan`)";
					$sql .= " VALUES(".tosql($idpemohon).", ".tosql($ICNo).", 'A', ".tosql($nama).", ".tosqln($emel).", 
						".tosql(date("Y-m-d H:i:s")).", ".tosql($rs->fields['Gander']).", ".tosql($rs->fields['Religon']).", ".tosql($rs->fields['Race']).")";
					$conn->execute($sql);	
				} else {
				
					if(!$rs3->EOF){
						$err='EMELX';
					} else {
						$err='ERR'; 
					}
				}
			} else {
				$err='ICDAHDAFTAR';
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

	//$rs = $conn->query("SELECT * FROM $schema2.`myid` WHERE `ICNo`=".tosql($ICNo)." AND `MyID`=".tosql($ICNo)." AND `emel`=".tosqln($emel). " AND ic_ind='A'");
	$rs = $conn->query("SELECT * FROM $schema2.`myid` WHERE `ICNo`=".tosql($ICNo)." AND `MyID`=".tosql($ICNo)." AND ic_ind='A'");

	if(!$rs->EOF){

		if($rs->fields['emel']==$emel){
			$err='OK';

			$conn->execute("UPDATE $schema2.`myid` SET tkh_lupa=".tosql(date('Y-m-d'))." 
			WHERE ic_ind='A' AND `ICNo`=".tosql($ICNo)." AND `MyID`=".tosql($ICNo)." AND `emel`=".tosqln($emel));

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
			$err='EMEL';
		}	

	} else {
		$err='ERR'; 
	}

} else if($pro=='LUPA_ADMIN'){
	//$conn->debug=true;
	$emel=isset($_REQUEST["emel"])?$_REQUEST["emel"]:"";
	$ICNo=isset($_REQUEST["ICNo"])?$_REQUEST["ICNo"]:"";

	$pwd = md5($noKP);


	$rs = $conn->query("SELECT * FROM $schema2.`spa8i_admin` WHERE `noKP`=".tosql($ICNo)." AND `emel`=".tosqln($emel));

	if(!$rs->EOF){
		$err='OK';

		$conn->execute("UPDATE $schema2.`spa8i_admin` SET username=".tosql($ICNo).", password=".tosqln($pwd)." WHERE `noKP`=".tosql($ICNo)." AND `emel`=".tosqln($emel));

		$nama = $rs->fields['nama_penuh']; 

		//$hurl = $ip_add."myspp/index.php?data=".base64_encode('module/ubah_myspp;'.$emel.";".$nama.";".$ICNo);
		$hurl = $ip_add."myspp/mysppadmin/";
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
		$mesej = "<b>Pengemaskinian Kata Laluan Sistem MySPP.</b><br><br>";
		$mesej .= 'Sila gunakan maklumat di bawah untuk log masuk ke dalam sistem.<br><br>ID:'.$ICNo.'<br>Kata laluan: '.$ICNo; 
		//$mesej .= '<br><br>Bagi melengkapkan perubahan kata Laluan anda, sila klik di pautan ini <a href="'.$hurl.'">'.$hurl.'</a>'; 
        $mesej .= '<br><br>Admin mySPP<br><br>';
		$mesej .= "<b> Peringatan </b><br> Perkhidmatan MyGovUC 2.0 adalah bertanggungjawab melindungi kerahsiaan data/maklumat Rahsia Rasmi Kerajaan. Adalah diingatkan agar pengguna sentiasa peka dengan SEMUA peraturan, arahan keselamatan dan pekeliling semasa yang berkuatkuasa bagi semua pengendalian data/maklumat Rahsia Rasmi Kerajaan yang berkaitan.";
	         		
		// mail_send($tajuk, $mesej, $kepada, $nama_penerima, $dari, $cc);
		mail_smtp($tajuk, $mesej, $kepada, $nama_penerima, $dari, $cc);

	} else {
		$err='ERR'; 
	}
}


header("Content-Type: text/json");
print json_encode($err); 
//print $err;
?>
