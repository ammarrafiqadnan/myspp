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
			$strSQL = "UPDATE $schema2.`panggilan_temuduga` SET tajuk=".tosql($tajuk).", tarikh_mula=".tosql($tarikh_mula).", masa_mula=".tosql($masa_mula).", tarikh_tamat=".tosql($tarikh_tamat).", masa_tamat=".tosql($masa_tamat).", tarikh_ubahsuai=".tosql($date).", id_pengemaskini=".tosql($oleh); 	
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
		//$conn->debug=true;
		$kod_panggilan_temuduga=isset($_REQUEST["kod_panggilan_temuduga"])?$_REQUEST["kod_panggilan_temuduga"]:"";
		$new_file = $_FILES['file1'];
		$file_name = $new_file['name'];
		$file_name = str_replace(" ","_",$file_name); 
		// $valid_extensions = array('xlsx','csv', 'xls'); // valid extensions
        // $path = '../../upload_doc/'; // upload directory
        // print "Nama File".$file_name;
		if(!empty($file_name)){
			$rsDel = $conn->query("DELETE FROM $schema2.senarai_panggilan_temuduga WHERE kod_panggilan_temuduga=".tosql($kod_panggilan_temuduga));

			//$upload_dir = '/var/www/html/uploads/';
			$upload_dir = '/var/www/uploads/';
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
					$text = "The file ". basename($nama_fails). " has been uploaded"; 
				} else { 
					$text .= "<br>".$nama_fails."<br>Sorry, there was a problem uploading your file.";
					$text .= "<br>".phpFileUploadErrors($_FILES['file1']['error']); 
					exit;
				}
			}
			//print $text;
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
				//$conn->debug=true;
				$jenis_proses='';
				while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
					$num = count($data)-1;
					// print "NUMS:".$row."<br>"; //exit;
					// print $data;
					$no_pemerolehan = trim($data[0]);
					$nama       = trim($data[2]);	// A
					$nokp 	  	= trim($data[1]);
					$kod_skim 		= trim($data[3]);				// B
					$skim 		= trim($data[4]);	// C
					$tarikh 	= trim($data[27]);	// D
					$masa   	= date('h:i:s', strtotime(trim($data[28])));	// E
					$tempat1   	= trim($data[23]);		// F
					$tempat2   	= trim($data[24]);
					$tempat3   	= trim($data[25]);
					$tempat4   	= trim($data[26]);

					$tempat = $tempat1.','.$tempat2.','.$tempat3.','.$tempat4;
					
					$nokp = str_replace("'","",$nokp);
					$nokp = str_replace("`","",$nokp);

					// $no_pemerolehan = trim($data[0]);
					// $nokp 	  	= trim($data[1]);		// B\
					// $nama       = trim($data[2]);	// A
					// $skim 		= trim($data[3]);	// C
					// $tarikh 	= trim($data[27]);	// D
					// $masa   	= date('h:i:s', strtotime(trim($data[28])));	// E
					// $tempat   	= trim($data[24]);		// F

					// $nokp = str_replace("'","",$nokp);
					// $nokp = str_replace("`","",$nokp);
					// print $row;
					if(!empty($nokp) && $row>=2){

						$rs = $conn->query("SELECT * FROM $schema2.`senarai_panggilan_temuduga` WHERE `noKP`=".tosql($nokp)." AND `kod_panggilan_temuduga`=".tosql($kod_panggilan_temuduga));
						//exit;
						if(!$rs->EOF){ 	
							$sql = "UPDATE $schema2.`senarai_panggilan_temuduga` SET nama_penuh=".tosql($nama).", noKP=".tosql($nokp).", kod_skim=".tosql($kod_skim).", skim_jawatan=".tosql($skim).", tarikh=".tosql(date('Y-m-d',strtotime($tarikh))).", masa=".tosql($masa).", tempat=".tosql($tempat).", no_pemerolehan=".tosql($no_pemerolehan); 	
							$sql .= " WHERE kod=".tosql($rs->fields['kod']);
						} else {
							$sql = "INSERT INTO $schema2.`senarai_panggilan_temuduga` (no_pemerolehan,kod_panggilan_temuduga,nama_penuh, noKP, skim_jawatan, tarikh, masa, tempat) ";
							$sql .= " VALUES(".tosql($no_pemerolehan).",".tosql($kod_panggilan_temuduga).",".tosql($nama).",".tosql($nokp).",".tosql($skim).",".tosql(date('Y-m-d',strtotime($tarikh))).",".tosql($masa).",".tosql($tempat).")";
						}
						$rss = $conn->execute($sql);
						//$err='OK';
					}

					$row++;

				}
			}
		}

		if($rss){
			// KEMASKINI DATA DETAIL
			$err='OK';
		} else {
			$err='ERR'; 
		}

	} else if($pro == 'HAPUS'){
		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
		$tajuk=isset($_REQUEST["tajuk"])?$_REQUEST["tajuk"]:"";
		$tarikh_mula=isset($_REQUEST["tarikh_mula"])?$_REQUEST["tarikh_mula"]:"";
		$masa_mula=isset($_REQUEST["masa_mula"])?$_REQUEST["masa_mula"]:"";
		$tarikh_tamat=isset($_REQUEST["tarikh_tamat"])?$_REQUEST["tarikh_tamat"]:"";
		$masa_tamat=isset($_REQUEST["masa_tamat"])?$_REQUEST["masa_tamat"]:"";

		$sql = "UPDATE $schema2.`panggilan_temuduga` SET is_deleted=1 WHERE `kod`='{$kod}'"; 
		$rss = $conn->Execute($sql);

		$sql2 = "DELETE FROM `senarai_panggilan_temuduga` WHERE kod_panggilan_temuduga='{$kod}'";
		$rss2 = $conn->Execute($sql2);

		if($rss){
			// KEMASKINI DATA DETAIL
			$err='OK';
		} else {
			$err='ERR'; 
		}
	} 
}

// header("Content-Type: text/json");
// print json_encode($err); 
print $err;
?>