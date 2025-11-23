<?php
session_start();
include '../../connection/common.php';
$frm=isset($_GET["frm"])?$_GET["frm"]:"";
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$jenis=isset($_GET["jenis"])?$_GET["jenis"]:"";
$date=date("Y-m-d H:i:s");
$oleh=$_SESSION['SESSADM_UID'];
// $conn->debug=true;
$err='ERR';

// print "PRO: ".$frm.":".$jenis.":".$pro;


if($frm=='PANGGILAN_TEMUDUGA'){

	if($pro=='SAVE'){

		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
		$tajuk=isset($_REQUEST["tajuk"])?$_REQUEST["tajuk"]:"";
		$tarikh_mula=isset($_REQUEST["tarikh_mula"])?$_REQUEST["tarikh_mula"]:"";
		$masa_mula=isset($_REQUEST["masa_mula"])?$_REQUEST["masa_mula"]:"";
		$tarikh_tamat=isset($_REQUEST["tarikh_tamat"])?$_REQUEST["tarikh_tamat"]:"";
		$masa_tamat=isset($_REQUEST["masa_tamat"])?$_REQUEST["masa_tamat"]:"";

		if(!empty($kod)){
            // print 'sini'; exit();
			$strSQL = "UPDATE $schema2.`panggilan_temuduga` SET tajuk=".tosql($tajuk).", tarikh_mula=".tosql($tarikh_mula).", masa_mula=".tosql($masa_mula).", tarikh_tamat=".tosql($tarikh_tamat).", masa_tamat=".tosql($masa_tamat).", tarikh_ubahsuai=".tosql($date).", id_pencipta=".tosql($oleh); 	
			$strSQL .= " WHERE kod=".tosql($kod);
			
			$rss = $conn->execute($strSQL);
			// audit_trail($strSQL, "KEMASKINI NEGERI");

		} else {
            // print 'sini2'; exit();
			$sql = "INSERT INTO $schema2.`panggilan_temuduga` (tajuk, tarikh_mula, masa_mula, tarikh_tamat, masa_tamat, tarikh_cipta, id_pencipta) ";
			$sql .= " VALUES(".tosql($tajuk).",".tosql($tarikh_mula).",".tosql($masa_mula).",".tosql($tarikh_tamat).",".tosql($masa_tamat).",".tosql($date).",".tosql($oleh).")";
			$rss = $conn->Execute($sql);
		}

		if($rss){
			// KEMASKINI DATA DETAIL
			$err='OK';
		} else {
			$err='ERR'; 
		}

	} else if($pro=='UPLOAD'){

		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
		$new_file = $_FILES['file1'];
		$file_name = $new_file['name'];
		$file_name = str_replace(" ","_",$file_name); 
		// $valid_extensions = array('xlsx','csv'); // valid extensions
        // $path = '../../upload_doc/'; // upload directory
        // print "Nama File".$file_name;
		if(!empty($file_name)){
			$upload_dir = '../../uploads_doc/';
			$new_file = $_FILES['file1'];
			$file_name = strtolower(str_replace(" ","_",$new_file['name'])); 
			$filename = $upload_dir.$file_name;
			if (file_exists($filename)) {
				unlink($filename);
				// print "<br>Deleted";
			}

			if ($_FILES["file1"]["error"] > 0){
				$text .= "Apologies, an error has occurred.";
				$text .= "Error Code: " . $_FILES["file1"]["error"];
			} else {
				// print $_FILES["file1"]["tmp_name"];
				$nama_fails =  $upload_dir.$file_name;
				if(move_uploaded_file($_FILES["file1"]["tmp_name"], $nama_fails)) { 
					$text .= "The file ". basename($uploadedfile). " has been uploaded"; 
				} else { 
					$text .= "<br>".$nama_fails."<br>Sorry, there was a problem uploading your file.";
					$text .= "<br>".phpFileUploadErrors($_FILES['file1']['error']); 
					exit;
				}
			}
			
			//print $neg;
			if(empty($types)){ $types=","; }	
			$row = 1;
			
			//$kodupkk=''; $tahun=''; $err_msg='';
			$err_msg='';
			$bil = 0; $cnt=0; $cnt_error=0;
			if (($handle = fopen($filename, "r")) !== FALSE) {
				// print "<br>OKKKKKssss";
				$text .= "<p> Nama fails : $filename : <br /></p>\n";
				// print_r($handle); 
				//$handle = str_replace(";",",",$handle);
				$conn->debug=true;
				$jenis_proses='';
				while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
					$num = count($data)-1;
					// print "NUMS:".$row."<br>"; //exit;
					// print $data;
					$nama       = trim($data[0]);	// A
					$nokp 	  	= trim($data[1]);		// B
					$skim 		= trim($data[2]);	// C
					$tarikh 	= trim($data[3]);	// D
					$masa   	= trim($data[4]);	// E
					$tempat   	= trim($data[5]);		// F

					$nokp = str_replace("'","",$nokp);
					$nokp = str_replace("`","",$nokp);
					// print $row;
					if(!empty($nokp) && $row>=2){

						$rs = $conn->query("SELECT * FROM $schema2.`senarai_panggilan_temuduga` WHERE `noKP`=".tosql($nokp)." AND `kod`=".tosql($kod));
						//exit;
						if(!$rs->EOF){ 	
							$sql = "UPDATE $schema2.`senarai_panggilan_temuduga` SET nama_penuh=".tosql($nama).", noKP=".tosql($nokp).", skim_jawatan=".tosql($skim).", tarikh=".tosql(DBDate($tarikh)).", masa=".tosql($masa).", tempat=".tosql($tempat); 	
							$sql .= " WHERE id=".tosql($rs->fields['id']);
						} else {
							$sql = "INSERT INTO $schema2.`senarai_panggilan_temuduga` (kod, nama_penuh, noKP, skim_jawatan, tarikh, masa, tempat) ";
							$sql .= " VALUES(".tosql($kod).",".tosql($nama).",".tosql($nokp).",".tosql($skim).",".tosql(DBDate($tarikh)).",".tosql($masa).",".tosql($tempat).")";
						}
						$rss = $conn->execute($sql);
						$err='OK';
					}

					$row++;

				}
			}
		}

	}

} else if($frm=='SIMPAN'){
    
    // global $schema1;
    // global $schema2;

    $jenis=isset($_REQUEST["jenis"])?$_REQUEST["jenis"]:"";

	if($jenis=='PANGGILAN_TEMUDUGA'){
        
		// $conn->debug=true;
		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
		$tajuk=isset($_REQUEST["tajuk"])?$_REQUEST["tajuk"]:"";
		$tarikh_mula=isset($_REQUEST["tarikh_mula"])?$_REQUEST["tarikh_mula"]:"";
		$masa_mula=isset($_REQUEST["masa_mula"])?$_REQUEST["masa_mula"]:"";
		$tarikh_tamat=isset($_REQUEST["tarikh_tamat"])?$_REQUEST["tarikh_tamat"]:"";
		$masa_tamat=isset($_REQUEST["masa_tamat"])?$_REQUEST["masa_tamat"]:"";


			// exit;


			// if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			// } else {
			// 	$err='ERR'; 
			// }
		} else if($pro == 'HAPUS'){
			$sql = "UPDATE $schema2.`panggilan_temuduga` SET is_deleted=1 WHERE `kod`='{$kod}'"; 
			$rss = $conn->Execute($sql);

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} else if($pro == 'CHECK_KOD'){
			// print 'sini'; exit();
			// $conn->debug=true;
			$sql3 = "SELECT COUNT(*) as total FROM $schema1.`ref_pengkhususan` WHERE KOD='{$kod}'";
			$rs = $conn->query($sql3);
			// print 'aaaaaaa'.$rs->fields['total'];
			
			if(($rs->fields['total']) >= 1){
				$err='ERR';
			} else {
				$err='OK';
			}
		}
	
	} else if($jenis=='KEPUTUSAN_TEMUDUGA'){
		//$conn->debug=true;
		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
		$pengkhususan=isset($_REQUEST["pengkhususan"])?$_REQUEST["pengkhususan"]:"";
		$status_pengkhususan=isset($_REQUEST["status_pengkhususan"])?$_REQUEST["status_pengkhususan"]:"";
		$no_pemerolehan=isset($_REQUEST["no_pemerolehan"])?$_REQUEST["no_pemerolehan"]:"";

		if($pro == 'SAVE'){
			$sql3 = "SELECT COUNT(*) as total FROM $schema1.`ref_pengkhususan` WHERE KOD='{$kod}'";
			$rs = $conn->query($sql3);
			// print 'aaaaaaa'.$rs->fields['total'];
			
			if(($rs->fields['total']) >= 1){
				$strSQL = "UPDATE $schema1.`ref_pengkhususan` SET DISKRIPSI=".tosql($pengkhususan).", STATUS=".tosql($status_pengkhususan).", NO_PEMEROLEHAN=".tosql($no_pemerolehan).", TARIKH_UBAHSUAI=".tosql($date).", ID_PENCIPTA=".tosql($oleh); 	
				$strSQL .= " WHERE kod=".tosql($kod);
				
				$rss = $conn->execute($strSQL);
				// audit_trail($strSQL, "KEMASKINI NEGERI");

			} else {
				$sql = "INSERT INTO $schema1.`ref_pengkhususan` (kod, DISKRIPSI, `STATUS`, NO_PEMEROLEHAN, TARIKH_CIPTA, ID_PENCIPTA) ";
				$sql .= " VALUES(".tosql($kod).",".tosql($pengkhususan).",".tosql($status_pengkhususan).",".tosql($no_pemerolehan).",".tosql($date).",".tosql($oleh).")";
				$rss = $conn->Execute($sql);
			}

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} else if($pro == 'HAPUS'){
			$sql = "UPDATE $schema1.`ref_pengkhususan` SET is_deleted=1 WHERE `kod`='{$kod}'"; 
			$rss = $conn->Execute($sql);

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} else if($pro == 'CHECK_KOD'){
			// print 'sini'; exit();
			// $conn->debug=true;
			$sql3 = "SELECT COUNT(*) as total FROM $schema1.`ref_pengkhususan` WHERE KOD='{$kod}'";
			$rs = $conn->query($sql3);
			// print 'aaaaaaa'.$rs->fields['total'];
			
			if(($rs->fields['total']) >= 1){
				$err='ERR';
			} else {
				$err='OK';
			}
		}
	
	} 	else if($jenis=='RAYUAN'){
		//$conn->debug=true;
		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
		$peringkat_kelulusan=isset($_REQUEST["peringkat_kelulusan"])?$_REQUEST["peringkat_kelulusan"]:"";
		$status_peringkat_kelulusan=isset($_REQUEST["status_peringkat_kelulusan"])?$_REQUEST["status_peringkat_kelulusan"]:"";
		$no_pemerolehan=isset($_REQUEST["no_pemerolehan"])?$_REQUEST["no_pemerolehan"]:"";

		if($pro == 'SAVE'){
			// print 'aaaaaaa'.$rs->fields['total'];
			
			if(!empty($kod)){
				$strSQL = "UPDATE $schema1.`ref_peringkat_kelulusan` SET diskripsi=".tosql($peringkat_kelulusan).", status=".tosql($status_peringkat_kelulusan).", tarikh_ubahsuai=".tosql($date).", id_pencipta=".tosql($oleh); 	
				$strSQL .= " WHERE kod=".tosql($kod);
				
				$rss = $conn->execute($strSQL);
				// audit_trail($strSQL, "KEMASKINI NEGERI");

			} else {
				$sql = "INSERT INTO $schema1.`ref_peringkat_kelulusan` (kod, diskripsi, `status`, tarikh_cipta, id_pencipta) ";
				$sql .= " VALUES(".tosql($kod).",".tosql($peringkat_kelulusan).",".tosql($status_peringkat_kelulusan).",".tosql($date).",".tosql($oleh).")";
				$rss = $conn->Execute($sql);
			}

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} else if($pro == 'HAPUS'){
			$sql = "UPDATE $schema1.`ref_pengkhususan` SET is_deleted=1 WHERE `kod`='{$kod}'"; 
			$rss = $conn->Execute($sql);

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} else if($pro == 'CHECK_KOD'){
			// print 'sini'; exit();
			// $conn->debug=true;
			$sql3 = "SELECT COUNT(*) as total FROM $schema1.`ref_pengkhususan` WHERE KOD='{$kod}'";
			$rs = $conn->query($sql3);
			// print 'aaaaaaa'.$rs->fields['total'];
			
			if(($rs->fields['total']) >= 1){
				$err='ERR';
			} else {
				$err='OK';
			}
		}
	
	} 		


// header("Content-Type: text/json");
// print json_encode($err); 
print $err;
?>