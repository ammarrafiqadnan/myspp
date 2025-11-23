<?php
session_start();
include '../../connection/common.php';
$frm=isset($_GET["frm"])?$_GET["frm"]:"";
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$date=date("Y-m-d H:i:s");
$oleh=$_SESSION['SESS_UID'];
// $conn->debug=true;
$err='ERR';



if($frm=='PENGGUNA'){
	//  $conn->debug=true;
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$id_hapus=isset($_REQUEST["id_hapus"])?$_REQUEST["id_hapus"]:"";
	$id_pengguna=isset($_REQUEST["id_pengguna"])?$_REQUEST["id_pengguna"]:"";
	$noKP=isset($_REQUEST["noKP"])?$_REQUEST["noKP"]:"";
	$nama_penuh=isset($_REQUEST["nama_penuh"])?$_REQUEST["nama_penuh"]:"";
	$email=isset($_REQUEST["email"])?$_REQUEST["email"]:"";
	$bahagian=isset($_REQUEST["bahagian"])?$_REQUEST["bahagian"]:"";
	$jawatan=isset($_REQUEST["jawatan"])?$_REQUEST["jawatan"]:"";
	$no_tel=isset($_REQUEST["no_tel"])?$_REQUEST["no_tel"]:"";
	$peranan=isset($_REQUEST["peranan"])?$_REQUEST["peranan"]:"";
	$status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";
	// $noKP=isset($_REQUEST["noKP"])?$_REQUEST["noKP"]:"";

	// print 'aaaa'.$id_hapus;
	if($pro == 'SAVE'){
		// print 'aaaaaaa'.$rs->fields['total'];
		
		if(!empty($id)){
			$strSQL = "UPDATE $schema2.spa8i_admin SET username=".tosql($id_pengguna).",noKP=".tosql($noKP).",nama_penuh=".tosql($nama_penuh).",emel=".tosql($email).",bahagian=".tosql($bahagian).",jawatan=".tosql($jawatan).",no_tel=".tosql($no_tel).",peranan=".tosql($peranan).",status=".tosql($status).", password=".tosql($noKP); 	
			$strSQL .= " WHERE kod=".tosql($kod);
			
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "KEMASKINI PENGGUNA");

		} else {
			$sql = "INSERT INTO $schema2.spa8i_admin (username, `password`,noKP ,nama_penuh,emel,bahagian,jawatan,no_tel,`status`, peranan) ";
			$sql .= " VALUES(".tosql($id_pengguna).",".tosql($noKP).",".tosql($noKP).",".tosql($nama_penuh).",".tosql($email).",".tosql($bahagian).",".tosql($jawatan).",".tosql($no_tel).",".tosql($status).",".tosql($peranan).")";
			$rss = $conn->Execute($sql);
			audit_trail($strSQL, "TAMBAH BARU PENGGUNA");
		}

		if($rss){
			// KEMASKINI DATA DETAIL
			$err='OK';
		} else {
			$err='ERR'; 
		}
	} else if($pro == 'HAPUS'){
		$sql = "UPDATE $schema2.spa8i_admin SET is_deleted=1 WHERE `id`='{$id_hapus}'"; 
		$rss = $conn->Execute($sql);
		audit_trail($strSQL, "HAPUS PENGGUNA");

		if($rss){
			// KEMASKINI DATA DETAIL
			$err='OK';
		} else {
			$err='ERR'; 
		}
	} 

} else if($frm=='NEGERI'){
	// $conn->debug=true;
    global $schema2;
    
	if($pro=='SAVE'){
		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
		$negeri=isset($_REQUEST["negeri"])?$_REQUEST["negeri"]:"";
		$status_negeri=isset($_REQUEST["status_negeri"])?$_REQUEST["status_negeri"]:"";

		if(!empty($kod)){
			$strSQL = "UPDATE $schema2.`ref_negeri` SET diskripsi2=".tosql($negeri).", status=".tosql($status_negeri); 	
			$strSQL .= " WHERE kod=".tosql($kod);
			
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "KEMASKINI NEGERI");

		} 
        
		//exit;
		if($rss){
			// KEMASKINI DATA DETAIL
			$err='OK';
		} else {
			$err='ERR'; 
		}
	
	} 		
} else if($frm=='PARAMETER'){
    global $schema1;
    $jenis=isset($_REQUEST["jenis"])?$_REQUEST["jenis"]:"";

	if($jenis=='BANGSA'){
		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
		$bangsa=isset($_REQUEST["bangsa"])?$_REQUEST["bangsa"]:"";
		$status_bangsa=isset($_REQUEST["status_bangsa"])?$_REQUEST["status_bangsa"]:"";

		if(!empty($kod)){
			$strSQL = "UPDATE $schema1.`ref_bangsa` SET diskripsi=".tosql($bangsa).", status=".tosql($status_bangsa); 	
			$strSQL .= " WHERE kod=".tosql($kod);
			
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "KEMASKINI BANGSA");

		} 
        
		//exit;
		if($rss){
			// KEMASKINI DATA DETAIL
			$err='OK';
		} else {
			$err='ERR'; 
		}
	
	} else if($jenis=='UNIVERSITI'){
		//$conn->debug=true;
		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
		$universiti=isset($_REQUEST["universiti"])?$_REQUEST["universiti"]:"";
		$status_universiti=isset($_REQUEST["status_universiti"])?$_REQUEST["status_universiti"]:"";
		$negara_universiti=isset($_REQUEST["negara_universiti"])?$_REQUEST["negara_universiti"]:"";
		$jenis_institusi=isset($_REQUEST["jenis_institusi"])?$_REQUEST["jenis_institusi"]:"";


		if($pro == 'SAVE'){
			$sql3 = "SELECT COUNT(*) as total FROM $schema1.`ref_institusi` WHERE KOD='{$kod}'";
			$rs = $conn->query($sql3);
			// print 'aaaaaaa'.$rs->fields['total'];
			
			if(($rs->fields['total']) >= 1){
				$strSQL = "UPDATE $schema1.`ref_institusi` SET DISKRIPSI=".tosql($universiti).", STATUS=".tosql($status_universiti).", NEGARA=".tosql($negara_universiti).", JENIS_INSTITUSI=".tosql($jenis_institusi).", TARIKH_UBAHSUAI=".tosql($date).", ID_PENCIPTA=".tosql($oleh); 	
				$strSQL .= " WHERE KOD=".tosql($kod);
				
				$rss = $conn->execute($strSQL);
				audit_trail($strSQL, "KEMASKINI INSTITUSI");

			} else {
				$sql = "INSERT INTO $schema1.`ref_institusi` (KOD, DISKRIPSI, `STATUS`, NEGARA, JENIS_INSTITUSI, TARIKH_CIPTA, ID_PENCIPTA) ";
				$sql .= " VALUES(".tosql($kod).",".tosql($universiti).",".tosql($status_universiti).",".tosql($negara_universiti).",".tosql($jenis_institusi).",".tosql($date).",".tosql($oleh).")";
				$rss = $conn->Execute($sql);
				audit_trail($sql, "TAMBAH BARU INSTITUSI");
			}
			
			
			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} else if($pro == 'HAPUS'){
			$sql = "UPDATE $schema1.`ref_institusi` SET is_deleted=1 WHERE `KOD`='{$kod}'"; 
			$rss = $conn->Execute($sql);
			audit_trail($sql, "HAPUS INSTITUSI");

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} else if($pro == 'CHECK_KOD'){
			// print 'sini'; exit();
			// $conn->debug=true;
			$sql3 = "SELECT COUNT(*) as total FROM $schema1.`ref_institusi` WHERE KOD='{$kod}' AND is_deleted=0";
			$rs = $conn->query($sql3);
			// print 'aaaaaaa'.$rs->fields['total'];
			
			if(($rs->fields['total']) >= 1){
				$err='ERR';
			} else {
				$err='OK';
			}
		}
	
	} else if($jenis=='PENGKHUSUSAN'){
		// $conn->debug=true;
		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
		$pengkhususan=isset($_REQUEST["pengkhususan"])?$_REQUEST["pengkhususan"]:"";
		$status_pengkhususan=isset($_REQUEST["status_pengkhususan"])?$_REQUEST["status_pengkhususan"]:"";
		$no_pemerolehan=isset($_REQUEST["no_pemerolehan"])?$_REQUEST["no_pemerolehan"]:"";

		if($pro == 'SAVE'){
			
			if(!empty($kod)){
				$strSQL = "UPDATE $schema1.`ref_pengkhususan` SET is_deleted=0 AND DISKRIPSI=".tosql($pengkhususan).", STATUS=".tosql($status_pengkhususan).", NO_PEMEROLEHAN=".tosql($no_pemerolehan).", TARIKH_UBAHSUAI=".tosql($date).", ID_PENCIPTA=".tosql($oleh); 	
				$strSQL .= " WHERE kod=".tosql($kod);
				
				$rss = $conn->execute($strSQL);
				audit_trail($strSQL, "KEMASKINI PENGKHUSUSAN");

			} else {
				$sql3 = "SELECT kod FROM $schema1.`ref_pengkhususan` ORDER BY kod DESC LIMIT 1";
				$rs = $conn->query($sql3);

				$kod_save = str_pad(($rs->fields['kod'])+1, 5, '0', STR_PAD_LEFT);
				// print $kod_save;
				$sql = "INSERT INTO $schema1.`ref_pengkhususan` (kod, DISKRIPSI, `STATUS`, NO_PEMEROLEHAN, TARIKH_CIPTA, ID_PENCIPTA) ";
				$sql .= " VALUES(".tosql($kod_save).",".tosql($pengkhususan).",".tosql($status_pengkhususan).",".tosql($no_pemerolehan).",".tosql($date).",".tosql($oleh).")";
				$rss = $conn->Execute($sql);
				audit_trail($sql, "TAMBAH BARU PENGKHUSUSAN");
			}
			// $sql3 = "SELECT COUNT(*) as total FROM $schema1.`ref_pengkhususan` WHERE KOD='{$kod}'";
			// $rs = $conn->query($sql3);
			// // print 'aaaaaaa'.$rs->fields['total'];
			
			// if(($rs->fields['total']) >= 1){
			// 	$strSQL = "UPDATE $schema1.`ref_pengkhususan` SET is_deleted=0 AND DISKRIPSI=".tosql($pengkhususan).", STATUS=".tosql($status_pengkhususan).", NO_PEMEROLEHAN=".tosql($no_pemerolehan).", TARIKH_UBAHSUAI=".tosql($date).", ID_PENCIPTA=".tosql($oleh); 	
			// 	$strSQL .= " WHERE kod=".tosql($kod);
				
			// 	$rss = $conn->execute($strSQL);
			// 	// audit_trail($strSQL, "KEMASKINI NEGERI");

			// } else {
			// 	$sql = "INSERT INTO $schema1.`ref_pengkhususan` (kod, DISKRIPSI, `STATUS`, NO_PEMEROLEHAN, TARIKH_CIPTA, ID_PENCIPTA) ";
			// 	$sql .= " VALUES(".tosql($kod).",".tosql($pengkhususan).",".tosql($status_pengkhususan).",".tosql($no_pemerolehan).",".tosql($date).",".tosql($oleh).")";
			// 	$rss = $conn->Execute($sql);
			// }

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} else if($pro == 'HAPUS'){
			$sql = "UPDATE $schema1.`ref_pengkhususan` SET is_deleted=1 WHERE `kod`='{$kod}'"; 
			$rss = $conn->Execute($sql);
			audit_trail($sql, "HAPUS PENGKHUSUSAN");

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} else if($pro == 'CHECK_KOD'){
			// print 'sini'; exit();
			// $conn->debug=true;
			$sql3 = "SELECT COUNT(*) as total FROM $schema1.`ref_pengkhususan` WHERE KOD='{$kod}' AND is_deleted=0";
			$rs = $conn->query($sql3);
			// print 'aaaaaaa'.$rs->fields['total'];
			
			if(($rs->fields['total']) >= 1){
				$err='ERR';
			} else {
				$err='OK';
			}
		}  else if($pro == 'CHECK_PENGKHUSUSAN'){
			// print 'sini'; exit();
			// $conn->debug=true;
			$sql3 = "SELECT COUNT(*) as total FROM $schema1.`ref_pengkhususan` WHERE DISKRIPSI LIKE '$pengkhususan' AND is_deleted=0";
			$rs = $conn->query($sql3);
			// print 'aaaaaaa'.$rs->fields['total'];
			
			if(($rs->fields['total']) >= 1){
				$err='ERR';
			} else {
				$err='OK';
			}
		}
	
	} else if($jenis=='PERINGKAT_KELULUSAN'){
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
				audit_trail($strSQL, "KEMASKINI PERINGKAT KELULUSAN");

			} else {
				$sql = "INSERT INTO $schema1.`ref_peringkat_kelulusan` (kod, diskripsi, `status`, tarikh_cipta, id_pencipta) ";
				$sql .= " VALUES(".tosql($kod).",".tosql($peringkat_kelulusan).",".tosql($status_peringkat_kelulusan).",".tosql($date).",".tosql($oleh).")";
				$rss = $conn->Execute($sql);
				audit_trail($sql, "TAMBAH BARU PERINGKAT KELULUSAN");
			}

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} else if($pro == 'HAPUS'){
			$sql = "UPDATE $schema1.`ref_peringkat_kelulusan` SET is_deleted=1 WHERE `kod`='{$kod}'"; 
			$rss = $conn->Execute($sql);
			audit_trail($sql, "HAPUS PERINGKAT KELULUSAN");

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} else if($pro == 'CHECK_KOD'){
			// print 'sini'; exit();
			// $conn->debug=true;
			$sql3 = "SELECT COUNT(*) as total FROM $schema1.`ref_peringkat_kelulusan` WHERE kod='{$kod}'";
			$rs = $conn->query($sql3);
			// print 'aaaaaaa'.$rs->fields['total'];
			
			if(($rs->fields['total']) >= 1){
				$err='ERR';
			} else {
				$err='OK';
			}
		}
	
	} else if($jenis=='CGPA'){
		//$conn->debug=true;
		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
		$cgpa=isset($_REQUEST["cgpa"])?$_REQUEST["cgpa"]:"";
		$status_cgpa=isset($_REQUEST["status_cgpa"])?$_REQUEST["status_cgpa"]:"";
		$no_pemerolehan=isset($_REQUEST["no_pemerolehan"])?$_REQUEST["no_pemerolehan"]:"";

		if($pro == 'SAVE'){
			// print 'aaaaaaa'.$rs->fields['total'];
			
			if(!empty($kod)){
				$strSQL = "UPDATE $schema1.`ref_cgpa` SET diskripsi=".tosql($cgpa).", status=".tosql($status_cgpa).", tarikh_ubahsuai=".tosql($date).", id_pencipta=".tosql($oleh); 	
				$strSQL .= " WHERE kod=".tosql($kod);
				
				$rss = $conn->execute($strSQL);
				audit_trail($strSQL, "KEMASKINI CGPA");

			} else {
				$sql = "INSERT INTO $schema1.`ref_cgpa` (kod, diskripsi, `status`, tarikh_cipta, id_pencipta) ";
				$sql .= " VALUES(".tosql($kod).",".tosql($cgpa).",".tosql($status_cgpa).",".tosql($date).",".tosql($oleh).")";
				$rss = $conn->Execute($sql);
				audit_trail($sql, "TAMBAH BARU CGPA");
			}

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} else if($pro == 'HAPUS'){
			$sql = "UPDATE $schema1.`ref_cgpa` SET is_deleted=1 WHERE `kod`='{$kod}'"; 
			$rss = $conn->Execute($sql);
			audit_trail($sql, "HAPUS CGPA");

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} 
	
	} else if($jenis=='OKU'){
		//$conn->debug=true;
		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
		$oku=isset($_REQUEST["oku"])?$_REQUEST["oku"]:"";
		$status_oku=isset($_REQUEST["status_oku"])?$_REQUEST["status_oku"]:"";
		$no_pemerolehan=isset($_REQUEST["no_pemerolehan"])?$_REQUEST["no_pemerolehan"]:"";

		if($pro == 'SAVE'){
			// print 'aaaaaaa'.$rs->fields['total'];
			
			if(!empty($kod)){
				$strSQL = "UPDATE $schema1.`ref_kecacatan_calon` SET DISKRIPSI=".tosql($oku).", status=".tosql($status_oku); 	
				$strSQL .= " WHERE KOD=".tosql($kod);
				
				$rss = $conn->execute($strSQL);
				audit_trail($strSQL, "KEMASKINI MAKLUMAT OKU");

			} else {
				$sql = "INSERT INTO $schema1.`ref_kecacatan_calon` (KOD, DISKRIPSI, `status`) ";
				$sql .= " VALUES(".tosql($kod).",".tosql($oku).",".tosql($status_oku).")";
				$rss = $conn->Execute($sql);
				audit_trail($sql, "TAMBAH BARU MAKLUMAT OKU");
			}

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} else if($pro == 'HAPUS'){
			$sql = "UPDATE $schema1.`ref_kecacatan_calon` SET is_deleted=1 WHERE `KOD`='{$kod}'"; 
			$rss = $conn->Execute($sql);
			audit_trail($sql, "HAPUS MAKLUMAT OKU");

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} 
	
	} else if($jenis=='DOMAIN_EMAIL'){
		//$conn->debug=true;
		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
		$domainEmail=isset($_REQUEST["domainEmail"])?$_REQUEST["domainEmail"]:"";
		$status_domainEmail=isset($_REQUEST["status_domainEmail"])?$_REQUEST["status_domainEmail"]:"";
		$no_pemerolehan=isset($_REQUEST["no_pemerolehan"])?$_REQUEST["no_pemerolehan"]:"";

		if($pro == 'SAVE'){
			// print 'aaaaaaa'.$rs->fields['total'];
			
			if(!empty($kod)){
				$strSQL = "UPDATE $schema1.`ref_domain_email` SET diskripsi=".tosql($domainEmail).", status=".tosql($status_domainEmail).", tarikh_ubahsuai=".tosql($date).", id_pencipta=".tosql($oleh); 	
				$strSQL .= " WHERE kod=".tosql($kod);
				
				$rss = $conn->execute($strSQL);
				audit_trail($strSQL, "KEMASKINI DOMAI EMEL");

			} else {
				$sql = "INSERT INTO $schema1.`ref_domain_email` (kod, diskripsi, `status`, tarikh_cipta, id_pencipta) ";
				$sql .= " VALUES(".tosql($kod).",".tosql($domainEmail).",".tosql($status_domainEmail).",".tosql($date).",".tosql($oleh).")";
				$rss = $conn->Execute($sql);
				audit_trail($sql, "TAMBAH BARU DOMAIN EMEL");
			}

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} else if($pro == 'HAPUS'){
			$sql = "UPDATE $schema1.`ref_domain_email` SET is_deleted=1 WHERE `kod`='{$kod}'"; 
			$rss = $conn->Execute($sql);
			audit_trail($sql, "HAPUS DOMAIN EMEL");

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} 
	} else if($jenis=='SKIM'){
		//$conn->debug=true;
		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
		$skim=isset($_REQUEST["skim"])?$_REQUEST["skim"]:"";
		$status_skim=isset($_REQUEST["status_skim"])?$_REQUEST["status_skim"]:"";

		if($pro == 'SAVE'){
			// print 'aaaaaaa'.$rs->fields['total'];
			$sql3 = "SELECT COUNT(*) as total FROM $schema1.`ref_skim` WHERE KOD='{$kod}'";
			$rs = $conn->query($sql3);
			
			if(($rs->fields['total']) >= 1){
				$strSQL = "UPDATE $schema1.`ref_skim` SET DISKRIPSI=".tosql($skim).", STATUS=".tosql($status_skim); 	
				$strSQL .= " WHERE KOD=".tosql($kod);
				
				$rss = $conn->execute($strSQL);
				audit_trail($strSQL, "KEMASKINI SKIM");

			} else {
				$sql = "INSERT INTO $schema1.`ref_skim` (KOD, DISKRIPSI, `STATUS`) ";
				$sql .= " VALUES(".tosql($kod).",".tosql($skim).",".tosql($status_skim).")";
				$rss = $conn->Execute($sql);

				audit_trail($sql, "TAMBAH BARU SKIM");
			}

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		}  else if($pro == 'CHECK_KOD'){
			// print 'sini'; exit();
			// $conn->debug=true;
			$sql3 = "SELECT COUNT(*) as total FROM $schema1.`ref_skim` WHERE KOD='{$kod}' AND is_deleted=0";
			$rs = $conn->query($sql3);
			// print 'aaaaaaa'.$rs->fields['total'];
			
			if(($rs->fields['total']) >= 1){
				$err='ERR';
			} else {
				$err='OK';
			}
		} else if($pro == 'HAPUS'){
			$sql = "UPDATE $schema1.`ref_skim` SET is_deleted=1 WHERE `KOD`='{$kod}'"; 
			$rss = $conn->Execute($sql);

			audit_trail($sql, "HAPUS SKIM");

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} 
	
	} else if($jenis=='KLUSTER'){
		//$conn->debug=true;
		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
		$kluster=isset($_REQUEST["kluster"])?$_REQUEST["kluster"]:"";
		$status_kluster=isset($_REQUEST["status_kluster"])?$_REQUEST["status_kluster"]:"";

		if($pro == 'SAVE'){
			// print 'aaaaaaa'.$rs->fields['total'];
			
			if(!empty($kod)){
				$strSQL = "UPDATE $schema1.`ref_kluster` SET diskripsi=".tosql($kluster).", status=".tosql($status_kluster).", tarikh_ubahsuai=".tosql($date).", id_pencipta=".tosql($oleh); 	
				$strSQL .= " WHERE kod=".tosql($kod);
				
				$rss = $conn->execute($strSQL);
				audit_trail($strSQL, "KEMASKINI KLUSTER");

			} else {
				$sql = "INSERT INTO $schema1.`ref_kluster` (kod, diskripsi, `status`, tarikh_cipta, id_pencipta) ";
				$sql .= " VALUES(".tosql($kod).",".tosql($kluster).",".tosql($status_kluster).",".tosql($date).",".tosql($oleh).")";
				$rss = $conn->Execute($sql);

				audit_trail($sql, "TAMBAH BARU KLUSTER");
			}

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} else if($pro == 'HAPUS'){
			$sql = "UPDATE $schema1.`ref_kluster` SET is_deleted=1 WHERE `kod`='{$kod}'"; 
			$rss = $conn->Execute($sql);

			audit_trail($sql, "HAPUS KLUSTER");

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} 
	
	} else if($jenis=='PADANAN_PERINGKATKELULUSAN_INSTITUSI'){
		// $conn->debug=true;
		$peringkat2=isset($_REQUEST["peringkat2"])?$_REQUEST["peringkat2"]:"";
		$check=isset($_REQUEST["check"])?$_REQUEST["check"]:"";
		$chk=isset($_REQUEST["chk"])?$_REQUEST["chk"]:"";
		$kod_institusi=isset($_REQUEST["kod_institusi"])?$_REQUEST["kod_institusi"]:"";
		$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";

		// print $kategori;exit();
		if($pro == 'SAVE_ALL'){
			// print 'sini';exit();
			if($kategori == 'AWAM'){
				$sql3 = "SELECT * FROM $schema1.`ref_institusi` WHERE `NEGARA`='130' AND SAH_YT='Y' AND KATEGORI='A'";
			} else if($kategori == 'SWASTA'){
				$sql3 = "SELECT * FROM $schema1.`ref_institusi` WHERE `NEGARA`='130' AND SAH_YT='Y' AND KATEGORI IS NULL";
			}

			$rsInstitusi = $conn->query($sql3);
			
			if($check == 'yes'){

				while(!$rsInstitusi->EOF) {

					$sql3 = "SELECT COUNT(*) as total FROM $schema1.`padanan_peringkatkelulusan_institusi` WHERE kod_peringkat_kelulusan=".tosql($peringkat2)." AND kod_institusi=".tosql($rsInstitusi->fields['KOD']);
					$checkDiPadanan = $conn->query($sql3);

					if($checkDiPadanan->fields['total'] > 0){
						$strSQL = "UPDATE $schema1.`padanan_peringkatkelulusan_institusi` SET `status`=0"; 	
						$strSQL .= " WHERE kod_peringkat_kelulusan=".tosql($peringkat2)." AND kod_institusi=".tosql($rsInstitusi->fields['KOD']);
						
						$rss = $conn->execute($strSQL);
						audit_trail($strSQL, "KEMASKINI PADANAN PERINGKAT KELULUSAN DAN INSTITUSI");
					} else {
						$sql = "INSERT INTO $schema1.`padanan_peringkatkelulusan_institusi` (kod_peringkat_kelulusan, `kod_institusi`) ";
						$sql .= " VALUES(".tosql($peringkat2).",".tosql($rsInstitusi->fields['KOD']).")";
						$rss = $conn->Execute($sql);
						audit_trail($sql, "TAMBAH BARU PADANAN PERINGKAT KELULUSAN DAN INSTITUSI");
					}
					
				$rsInstitusi->movenext(); }
			} else if($check == 'no'){

				while(!$rsInstitusi->EOF){
					$strSQL = "UPDATE $schema1.`padanan_peringkatkelulusan_institusi` SET `status`=1"; 	
					$strSQL .= " WHERE kod_peringkat_kelulusan=".tosql($peringkat2)." AND kod_institusi=".tosql($rsInstitusi->fields['KOD']);
					
					$rss = $conn->execute($strSQL);
					audit_trail($strSQL, "KEMASKINI PADANAN PERINGKAT KELULUSAN DAN INSTITUSI");
				$rsInstitusi->movenext(); }
			} 
		} else if($pro == 'SAVE'){
			// print 'sini2';print $chk;exit();

			if($kategori == 'AWAM'){
				$sql3 = "SELECT * FROM $schema1.`ref_institusi` WHERE `NEGARA`='130' AND SAH_YT='Y' AND KATEGORI='A'";
			} else if($kategori == 'SWASTA'){
				$sql3 = "SELECT * FROM $schema1.`ref_institusi` WHERE `NEGARA`='130' AND SAH_YT='Y' AND KATEGORI IS NULL";
			}

			$rsInstitusi = $conn->query($sql3);

			if($chk == 'true'){

				// print 'aaa'.$peringkat2;
				$sql3 = "SELECT COUNT(*) as total FROM $schema1.`padanan_peringkatkelulusan_institusi` WHERE kod_peringkat_kelulusan=".tosql($peringkat2)." AND kod_institusi=".tosql($kod_institusi);
				$checkDiPadanan = $conn->query($sql3);

				if($checkDiPadanan->fields['total']){
					$strSQL = "UPDATE $schema1.`padanan_peringkatkelulusan_institusi` SET `status`=0"; 	
					$strSQL .= " WHERE kod_peringkat_kelulusan=".tosql($peringkat2)." AND kod_institusi=".tosql($kod_institusi);
					
					$rss = $conn->execute($strSQL);
					audit_trail($strSQL, "KEMASKINI PADANAN PERINGKAT KELULUSAN DAN INSTITUSI");
				} else {
					$sql = "INSERT INTO $schema1.`padanan_peringkatkelulusan_institusi` (kod_peringkat_kelulusan, `kod_institusi`) ";
					$sql .= " VALUES(".tosql($peringkat2).",".tosql($kod_institusi).")";
					$rss = $conn->Execute($sql);
					audit_trail($sql, "TAMBAH BARU PADANAN PERINGKAT KELULUSAN DAN INSTITUSI");
				}
			} else {

				$strSQL = "UPDATE $schema1.`padanan_peringkatkelulusan_institusi` SET `status`=1"; 	
				$strSQL .= " WHERE kod_peringkat_kelulusan=".tosql($peringkat2)." AND kod_institusi=".tosql($kod_institusi);
				
				$rss = $conn->execute($strSQL);
				audit_trail($strSQL, "KEMASKINI PADANAN PERINGKAT KELULUSAN DAN INSTITUSI");
			}

		} else if($pro == 'HAPUS'){

			$strSQL = "UPDATE $schema1.`padanan_peringkatkelulusan_institusi` SET `status`=1"; 	
			$strSQL .= " WHERE kod_peringkat_kelulusan=".tosql($peringkat2)." AND kod_institusi=".tosql($kod_institusi);
			
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "HAPUS PADANAN PERINGKAT KELULUSAN DAN INSTITUSI");
		}

		if($rss){
			// KEMASKINI DATA DETAIL
			$err='OK';
		} else {
			$err='ERR'; 
		}
	} else if($jenis=='PADANAN_INSTITUSI_PENGKHUSUSAN'){
		//$conn->debug=true;
		$institusi_kod=isset($_REQUEST["institusi_kod"])?$_REQUEST["institusi_kod"]:"";
		$check=isset($_REQUEST["check"])?$_REQUEST["check"]:"";
		$chk=isset($_REQUEST["chk"])?$_REQUEST["chk"]:"";
		$kod_pengkhususan=isset($_REQUEST["kod_pengkhususan"])?$_REQUEST["kod_pengkhususan"]:"";
		$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
		$peringkatKelulusan=isset($_REQUEST["peringkatKelulusan"])?$_REQUEST["peringkatKelulusan"]:"";

		//print $kategori;
		if($pro == 'SAVE_ALL'){
			// print 'sini';exit();
			$sql3 = "SELECT * FROM $schema1.`ref_pengkhususan` WHERE `STATUS`=0 AND is_deleted=0";

			$rsPengkhususan = $conn->query($sql3);
			
			if($check == 'yes'){

				while(!$rsPengkhususan->EOF) {

					$sql3 = "SELECT COUNT(*) as total FROM $schema1.`padanan_institusi_pengkhususan` WHERE kod_institusi=".tosql($institusi_kod)." AND kod_pengkhususan=".tosql($rsPengkhususan->fields['kod'])." AND peringkat_kelulusan=".tosql($peringkatKelulusan);
					if($kategori == 'IKHTISAS'){
						$sql3 .= " AND kategori=1";
					} else if($kategori == 'BUKANIKHTISAS'){
						$sql3 .= " AND kategori=2";
					}
					$checkDiPadanan = $conn->query($sql3);

					if($checkDiPadanan->fields['total'] > 0){
						$strSQL = "UPDATE $schema1.`padanan_institusi_pengkhususan` SET `status`=0"; 	
						$strSQL .= " WHERE kod_institusi=".tosql($institusi_kod)." AND kod_pengkhususan=".tosql($rsPengkhususan->fields['kod'])." AND peringkat_kelulusan=".tosql($peringkatKelulusan);
						
						if($kategori == 'IKHTISAS'){
							$strSQL .= " AND kategori=1";
						} else if($kategori == 'BUKANIKHTISAS'){
							$strSQL .= " AND kategori=2";
						}
						
						
						$rss = $conn->execute($strSQL);
						audit_trail($strSQL, "KEMASKINI PADANAN INSTITUSI DAN PENGKHUSUSAN");
					} else {
						$sql = "INSERT INTO $schema1.`padanan_institusi_pengkhususan` (kod_institusi, `kod_pengkhususan`, kategori, peringkatKelulusan) ";

						if($kategori == 'IKHTISAS'){
							$sql .= " VALUES(".tosql($institusi_kod).",".tosql($rsPengkhususan->fields['kod']).",1,".tosql($peringkatKelulusan).")";
						} else if($kategori == 'BUKANIKHTISAS'){
							$sql .= " VALUES(".tosql($institusi_kod).",".tosql($rsPengkhususan->fields['kod']).",2,".tosql($peringkatKelulusan).")";
						}

						$rss = $conn->Execute($sql);
						audit_trail($sql, "TAMBAH BARU PADANAN INSTITUSI DAN PENGKHUSUSAN");
					}
					
				$rsPengkhususan->movenext(); }
			} else if($check == 'no'){

				while(!$rsPengkhususan->EOF){
					$strSQL = "UPDATE $schema1.`padanan_institusi_pengkhususan` SET `status`=1"; 	
					$strSQL .= " WHERE kod_institusi=".tosql($institusi_kod)." AND kod_pengkhususan=".tosql($rsPengkhususan->fields['kod'])." AND peringkat_kelulusan=".tosql($peringkatKelulusan);
					if($kategori == 'IKHTISAS'){
						$strSQL .= " AND kategori=1";
					} else if($kategori == 'BUKANIKHTISAS'){
						$strSQL .= " AND kategori=2";
					}
					
					$rss = $conn->execute($strSQL);
					audit_trail($strSQL, "KEMASKINI PADANAN INSTITUSI DAN PENGKHUSUSAN");
				$rsPengkhususan->movenext(); }
			} 
		} else if($pro == 'SAVE'){
			// print 'sini2';print $chk;exit();

			$sql3 = "SELECT * FROM $schema1.`ref_pengkhususan` WHERE `STATUS`=0 AND is_deleted=0";
			$rsPengkhususan = $conn->query($sql3);

			if($chk == 'true'){

				// print 'aaa'.$institusi_kod;
				$sql3 = "SELECT COUNT(*) as total FROM $schema1.`padanan_institusi_pengkhususan` WHERE kod_institusi=".tosql($institusi_kod)." AND kod_pengkhususan=".tosql($kod_pengkhususan)." AND peringkat_kelulusan=".tosql($peringkatKelulusan);
				if($kategori == 'IKHTISAS'){
					$sql3 .= " AND kategori=1";
				} else if($kategori == 'BUKANIKHTISAS'){
					$sql3 .= " AND kategori=2";
				}
				$checkDiPadanan = $conn->query($sql3);

				if($checkDiPadanan->fields['total']){
					$strSQL = "UPDATE $schema1.`padanan_institusi_pengkhususan` SET `status`=0"; 	
					$strSQL .= " WHERE kod_institusi=".tosql($institusi_kod)." AND kod_pengkhususan=".tosql($kod_pengkhususan)." AND peringkat_kelulusan=".tosql($peringkatKelulusan);
					if($kategori == 'IKHTISAS'){
						$strSQL .= " AND kategori=1";
					} else if($kategori == 'BUKANIKHTISAS'){
						$strSQL .= " AND kategori=2";
					}
					$rss = $conn->execute($strSQL);
					audit_trail($strSQL, "KEMASKINI PADANAN INSTITUSI DAN PENGKHUSUSAN");
				} else {
					$sql = "INSERT INTO $schema1.`padanan_institusi_pengkhususan` (kod_institusi, `kod_pengkhususan`, `kategori`, peringkat_kelulusan) ";

					if($kategori == 'IKHTISAS'){
						$sql .= " VALUES(".tosql($institusi_kod).",".tosql($kod_pengkhususan).",1,".tosql($peringkatKelulusan).")";
					} else if($kategori == 'BUKANIKHTISAS'){
						$sql .= " VALUES(".tosql($institusi_kod).",".tosql($kod_pengkhususan).",2,".tosql($peringkatKelulusan).")";
					}

					$rss = $conn->Execute($sql);
					audit_trail($sql, "TAMBAH BARU PADANAN INSTITUSI DAN PENGKHUSUSAN");
				}
			} else {

				$strSQL = "UPDATE $schema1.`padanan_institusi_pengkhususan` SET `status`=1"; 	
				$strSQL .= " WHERE kod_institusi=".tosql($institusi_kod)." AND kod_pengkhususan=".tosql($kod_pengkhususan)." AND peringkat_kelulusan=".tosql($peringkatKelulusan);
				if($kategori == 'IKHTISAS'){
					$strSQL .= " AND kategori=1";
				} else if($kategori == 'BUKANIKHTISAS'){
					$strSQL .= " AND kategori=2";
				}

				$rss = $conn->execute($strSQL);
				audit_trail($strSQL, "KEMASKINI PADANAN INSTITUSI DAN PENGKHUSUSAN");
			}

		} else if($pro == 'HAPUS'){

			$strSQL = "UPDATE $schema1.`padanan_institusi_pengkhususan` SET `status`=1"; 	
			$strSQL .= " WHERE kod_institusi=".tosql($institusi_kod)." AND kod_pengkhususan=".tosql($kod_pengkhususan);

			if($kategori == 'IKHTISAS'){
				$strSQL .= " AND kategori=1";
			} else if($kategori == 'BUKANIKHTISAS'){
				$strSQL .= " AND kategori=2";
			}
			
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "HAPUS PADANAN INSTITUSI DAN PENGKHUSUSAN");
		}

		if($rss){
			// KEMASKINI DATA DETAIL
			$err='OK';
		} else {
			$err='ERR'; 
		}
	} else if($jenis=='PADANAN_PERINGKATAKADEMIK_SKIM'){
		//$conn->debug=true;
		$peringkat2=isset($_REQUEST["peringkat2"])?$_REQUEST["peringkat2"]:"";
		$check=isset($_REQUEST["check"])?$_REQUEST["check"]:"";
		$chk=isset($_REQUEST["chk"])?$_REQUEST["chk"]:"";
		$kod_skim=isset($_REQUEST["kod_skim"])?$_REQUEST["kod_skim"]:"";

		// print $kategori;exit();
		if($pro == 'SAVE_ALL'){
			$sql3 = "SELECT * FROM $schema1.`ref_institusi` WHERE `STATUS`=0 AND is_deleted=0";

			$rsInstitusi = $conn->query($sql3);
			
			if($check == 'yes'){

				while(!$rsInstitusi->EOF) {

					$sql3 = "SELECT COUNT(*) as total FROM $schema1.`padanan_peringkatakademik_skim` WHERE kod_peringkat_akademik=".tosql($peringkat2)." AND kod_skim=".tosql($rsInstitusi->fields['KOD']);
					$checkDiPadanan = $conn->query($sql3);

					if($checkDiPadanan->fields['total'] > 0){
						$strSQL = "UPDATE $schema1.`padanan_peringkatakademik_skim` SET `status`=0"; 	
						$strSQL .= " WHERE kod_peringkat_akademik=".tosql($peringkat2)." AND kod_skim=".tosql($rsInstitusi->fields['KOD']);
						
						$rss = $conn->execute($strSQL);
						audit_trail($strSQL, "KEMASKINI PADANAN PERINGKAT AKDEMIK DAN SKIM");
					} else {
						$sql = "INSERT INTO $schema1.`padanan_peringkatakademik_skim` (kod_peringkat_akademik, `kod_skim`) ";
						$sql .= " VALUES(".tosql($peringkat2).",".tosql($rsInstitusi->fields['KOD']).")";
						$rss = $conn->Execute($sql);
						audit_trail($sql, "TAMBAH BARU PADANAN PERINGKAT AKDEMIK DAN SKIM");
					}
					
				$rsInstitusi->movenext(); }
			} else if($check == 'no'){

				while(!$rsInstitusi->EOF){
					$strSQL = "UPDATE $schema1.`padanan_peringkatakademik_skim` SET `status`=1"; 	
					$strSQL .= " WHERE kod_peringkat_akademik=".tosql($peringkat2)." AND kod_skim=".tosql($rsInstitusi->fields['KOD']);
					
					$rss = $conn->execute($strSQL);
					audit_trail($strSQL, "KEMASKINI PADANAN PERINGKAT AKDEMIK DAN SKIM");
				$rsInstitusi->movenext(); }
			} 
		} else if($pro == 'SAVE'){
			// print 'sini2';print $chk;exit();

			$sql3 = "SELECT * FROM $schema1.`ref_institusi` WHERE `STATUS`=0 AND is_deleted=0";

			$rsInstitusi = $conn->query($sql3);

			if($chk == 'true'){

				// print 'aaa'.$peringkat2;
				$sql3 = "SELECT COUNT(*) as total FROM $schema1.`padanan_peringkatakademik_skim` WHERE kod_peringkat_akademik=".tosql($peringkat2)." AND kod_skim=".tosql($kod_skim);
				$checkDiPadanan = $conn->query($sql3);

				if($checkDiPadanan->fields['total']){
					$strSQL = "UPDATE $schema1.`padanan_peringkatakademik_skim` SET `status`=0"; 	
					$strSQL .= " WHERE kod_peringkat_akademik=".tosql($peringkat2)." AND kod_skim=".tosql($kod_skim);
					
					$rss = $conn->execute($strSQL);
					audit_trail($strSQL, "KEMASKINI PADANAN PERINGKAT AKDEMIK DAN SKIM");
				} else {
					$sql = "INSERT INTO $schema1.`padanan_peringkatakademik_skim` (kod_peringkat_akademik, `kod_skim`) ";
					$sql .= " VALUES(".tosql($peringkat2).",".tosql($kod_skim).")";
					$rss = $conn->Execute($sql);
					audit_trail($strSQL, "TAMBAH BARU PADANAN PERINGKAT AKDEMIK DAN SKIM");
				}
			} else {

				$strSQL = "UPDATE $schema1.`padanan_peringkatakademik_skim` SET `status`=1"; 	
				$strSQL .= " WHERE kod_peringkat_akademik=".tosql($peringkat2)." AND kod_skim=".tosql($kod_skim);
				
				$rss = $conn->execute($strSQL);
				audit_trail($strSQL, "KEMASKINI PADANAN PERINGKAT AKDEMIK DAN SKIM");
			}

		} else if($pro == 'HAPUS'){
			$strSQL = "UPDATE $schema1.`padanan_peringkatakademik_skim` SET `status`=1"; 	
			$strSQL .= " WHERE kod_peringkat_akademik=".tosql($peringkat2)." AND kod_skim=".tosql($kod_skim);
			
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "HAPUS PADANAN PERINGKAT AKDEMIK DAN SKIM");
		}

		if($rss){
			// KEMASKINI DATA DETAIL
			$err='OK';
		} else {
			$err='ERR'; 
		}
	} else if($jenis=='PADANAN_PENGKHUSUSAN_SKIM'){
		//$conn->debug=true;
		$pengkhususan2=isset($_REQUEST["pengkhususan2"])?$_REQUEST["pengkhususan2"]:"";
		$check=isset($_REQUEST["check"])?$_REQUEST["check"]:"";
		$chk=isset($_REQUEST["chk"])?$_REQUEST["chk"]:"";
		$kod_skim=isset($_REQUEST["kod_skim"])?$_REQUEST["kod_skim"]:"";

		// print $kategori;exit();
		if($pro == 'SAVE_ALL'){
			$sql3 = "SELECT * FROM $schema1.`ref_pengkhususan` WHERE `STATUS`=0 AND is_deleted=0";

			$rsInstitusi = $conn->query($sql3);
			
			if($check == 'yes'){

				while(!$rsInstitusi->EOF) {

					$sql3 = "SELECT COUNT(*) as total FROM $schema1.`padanan_pengkhususan_skim` WHERE kod_pengkhususan=".tosql($pengkhususan2)." AND kod_skim=".tosql($rsInstitusi->fields['KOD']);
					$checkDiPadanan = $conn->query($sql3);

					if($checkDiPadanan->fields['total'] > 0){
						$strSQL = "UPDATE $schema1.`padanan_pengkhususan_skim` SET `status`=0"; 	
						$strSQL .= " WHERE kod_pengkhususan=".tosql($pengkhususan2)." AND kod_skim=".tosql($rsInstitusi->fields['KOD']);
						
						$rss = $conn->execute($strSQL);
						audit_trail($strSQL, "KEMASKINI PADANAN PENGKHUSUSAN DAN SKIM");
					} else {
						$sql = "INSERT INTO $schema1.`padanan_pengkhususan_skim` (kod_pengkhususan, `kod_skim`) ";
						$sql .= " VALUES(".tosql($pengkhususan2).",".tosql($rsInstitusi->fields['KOD']).")";
						$rss = $conn->Execute($sql);
						audit_trail($strSQL, "TAMBAH BARU PADANAN PENGKHUSUSAN DAN SKIM");
					}
					
				$rsInstitusi->movenext(); }
			} else if($check == 'no'){ 

				while(!$rsInstitusi->EOF){
					$strSQL = "UPDATE $schema1.`padanan_pengkhususan_skim` SET `status`=1"; 	
					$strSQL .= " WHERE kod_pengkhususan=".tosql($pengkhususan2)." AND kod_skim=".tosql($rsInstitusi->fields['KOD']);
					
					$rss = $conn->execute($strSQL);
					audit_trail($strSQL, "KEMASKINI PADANAN PENGKHUSUSAN DAN SKIM");
				$rsInstitusi->movenext(); }
			} 
		} else if($pro == 'SAVE'){
			// print 'sini2';print $chk;exit();

			$sql3 = "SELECT * FROM $schema1.`ref_pengkhususan` WHERE `STATUS`=0 AND is_deleted=0";

			$rsInstitusi = $conn->query($sql3);

			if($chk == 'true'){

				// print 'aaa'.$pengkhususan2;
				$sql3 = "SELECT COUNT(*) as total FROM $schema1.`padanan_pengkhususan_skim` WHERE kod_pengkhususan=".tosql($pengkhususan2)." AND kod_skim=".tosql($kod_skim);
				$checkDiPadanan = $conn->query($sql3);

				if($checkDiPadanan->fields['total']){
					$strSQL = "UPDATE $schema1.`padanan_pengkhususan_skim` SET `status`=0"; 	
					$strSQL .= " WHERE kod_pengkhususan=".tosql($pengkhususan2)." AND kod_skim=".tosql($kod_skim);
					
					$rss = $conn->execute($strSQL);
					audit_trail($strSQL, "KEMASKINI PADANAN PENGKHUSUSAN DAN SKIM");
				} else {
					$sql = "INSERT INTO $schema1.`padanan_pengkhususan_skim` (kod_pengkhususan, `kod_skim`) ";
					$sql .= " VALUES(".tosql($pengkhususan2).",".tosql($kod_skim).")";
					$rss = $conn->Execute($sql);
					audit_trail($sql, "TAMBAH BARU PADANAN PENGKHUSUSAN DAN SKIM");
				}
			} else {

				$strSQL = "UPDATE $schema1.`padanan_pengkhususan_skim` SET `status`=1"; 	
				$strSQL .= " WHERE kod_pengkhususan=".tosql($pengkhususan2)." AND kod_skim=".tosql($kod_skim);
				
				$rss = $conn->execute($strSQL);
				audit_trail($strSQL, "KEMASKINI PADANAN PENGKHUSUSAN DAN SKIM");
			}

		} else if($pro == 'HAPUS'){

			$strSQL = "UPDATE $schema1.`padanan_pengkhususan_skim` SET `status`=1"; 	
			$strSQL .= " WHERE kod_pengkhususan=".tosql($pengkhususan2)." AND kod_skim=".tosql($kod_skim);
			
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "HAPUS PADANAN PENGKHUSUSAN DAN SKIM");
		}

		if($rss){
			// KEMASKINI DATA DETAIL
			$err='OK';
		} else {
			$err='ERR'; 
		}
	} else if($jenis=='PADANAN_BIDANG_PENGKHUSUSAN'){
		// $conn->debug=true;
		$bidang_kod=isset($_REQUEST["bidang_kod"])?$_REQUEST["bidang_kod"]:"";
		$check=isset($_REQUEST["check"])?$_REQUEST["check"]:"";
		$chk=isset($_REQUEST["chk"])?$_REQUEST["chk"]:"";
		$kod_pengkhususan=isset($_REQUEST["kod_pengkhususan"])?$_REQUEST["kod_pengkhususan"]:"";

		//print $kategori;
		if($pro == 'SAVE_ALL'){
			// print 'sini';exit();
			$sql3 = "SELECT * FROM $schema1.`ref_pengkhususan` WHERE `STATUS`=0 AND is_deleted=0";

			$rsPengkhususan = $conn->query($sql3);
			
			if($check == 'yes'){

				while(!$rsPengkhususan->EOF) {

					$sql3 = "SELECT COUNT(*) as total FROM $schema1.`padanan_bidang_pengkhususan` WHERE kod_bidang=".tosql($bidang_kod)." AND kod_pengkhususan=".tosql($rsPengkhususan->fields['kod']);
				
					$checkDiPadanan = $conn->query($sql3);

					if($checkDiPadanan->fields['total'] > 0){
						$strSQL = "UPDATE $schema1.`padanan_bidang_pengkhususan` SET `status`=0"; 	
						$strSQL .= " WHERE kod_bidang=".tosql($bidang_kod)." AND kod_pengkhususan=".tosql($rsPengkhususan->fields['kod']);
						
						$rss = $conn->execute($strSQL);
						audit_trail($strSQL, "KEMASKINI PADANAN BIDANG DAN PENGKHUSUSAN");
					} else {
						$sql = "INSERT INTO $schema1.`padanan_bidang_pengkhususan` (kod_bidang, `kod_pengkhususan`, kategori, peringkatKelulusan) ";

						$rss = $conn->Execute($sql);
						audit_trail($sql, "TAMBAH BARU PADANAN BIDANG DAN PENGKHUSUSAN");
					}
					
				$rsPengkhususan->movenext(); }
			} else if($check == 'no'){

				while(!$rsPengkhususan->EOF){
					$strSQL = "UPDATE $schema1.`padanan_bidang_pengkhususan` SET `status`=1"; 	
					$strSQL .= " WHERE kod_bidang=".tosql($bidang_kod)." AND kod_pengkhususan=".tosql($rsPengkhususan->fields['kod']);
					
					$rss = $conn->execute($strSQL);
					audit_trail($strSQL, "KEMASKINI PADANAN BIDANG DAN PENGKHUSUSAN");
				$rsPengkhususan->movenext(); }
			} 
		} else if($pro == 'SAVE'){
			// print 'sini2';print $chk;exit();

			$sql3 = "SELECT * FROM $schema1.`ref_pengkhususan` WHERE `STATUS`=0 AND is_deleted=0";
			$rsPengkhususan = $conn->query($sql3);

			if($chk == 'true'){

				// print 'aaa'.$bidang_kod;
				$sql3 = "SELECT COUNT(*) as total FROM $schema1.`padanan_bidang_pengkhususan` WHERE kod_bidang=".tosql($bidang_kod)." AND kod_pengkhususan=".tosql($kod_pengkhususan);
			
				$checkDiPadanan = $conn->query($sql3);

				if($checkDiPadanan->fields['total']){
					$strSQL = "UPDATE $schema1.`padanan_bidang_pengkhususan` SET `status`=0"; 	
					$strSQL .= " WHERE kod_bidang=".tosql($bidang_kod)." AND kod_pengkhususan=".tosql($kod_pengkhususan);
				
					$rss = $conn->execute($strSQL);
					audit_trail($strSQL, "KEMASKINI PADANAN BIDANG DAN PENGKHUSUSAN");
				} else {
					$sql = "INSERT INTO $schema1.`padanan_bidang_pengkhususan` (kod_bidang, `kod_pengkhususan`) ";
					$sql .= " VALUES(".tosql($bidang_kod).",".tosql($kod_pengkhususan).")";
					$rss = $conn->Execute($sql);
					audit_trail($sql, "TAMBAH BARU PADANAN BIDANG DAN PENGKHUSUSAN");
				}
			} else {

				$strSQL = "UPDATE $schema1.`padanan_bidang_pengkhususan` SET `status`=1"; 	
				$strSQL .= " WHERE kod_bidang=".tosql($bidang_kod)." AND kod_pengkhususan=".tosql($kod_pengkhususan);

				$rss = $conn->execute($strSQL);
				audit_trail($strSQL, "KEMASKINI PADANAN BIDANG DAN PENGKHUSUSAN");
			}

		} else if($pro == 'HAPUS'){

			$strSQL = "UPDATE $schema1.`padanan_bidang_pengkhususan` SET `status`=1"; 	
			$strSQL .= " WHERE kod_bidang=".tosql($bidang_kod)." AND kod_pengkhususan=".tosql($kod_pengkhususan);
			
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "HAPUS PADANAN BIDANG DAN PENGKHUSUSAN");
		}

		if($rss){
			// KEMASKINI DATA DETAIL
			$err='OK';
		} else {
			$err='ERR'; 
		}
	}
} else if($frm=='PENGURUSAN'){
	//$conn->debug=true;
	$jenis=isset($_REQUEST["jenis"])?$_REQUEST["jenis"]:"";
	if($jenis == 'KAWALAN_MUATNAIK_DOKUMEN'){
		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
		$tajuk=isset($_REQUEST["tajuk"])?$_REQUEST["tajuk"]:"";
		$status_dokumen=isset($_REQUEST["status_dokumen"])?$_REQUEST["status_dokumen"]:"";
		$no_pemerolehan=isset($_REQUEST["no_pemerolehan"])?$_REQUEST["no_pemerolehan"]:"";

		if($pro == 'SAVE'){
			// print 'aaaaaaa'.$rs->fields['total'];
			
			if(!empty($kod)){
				$strSQL = "UPDATE $schema2.`kawalan_muatnaik_dokumen` SET tajuk_dokumen=".tosql($tajuk).", status=".tosql($status_dokumen); 	
				$strSQL .= " WHERE kod=".tosql($kod);
				
				$rss = $conn->execute($strSQL);
				audit_trail($strSQL, "KEMASKINI KAWALAN MUATNAIK DOKUMEN");

			} else {
				$sql = "INSERT INTO $schema2.`kawalan_muatnaik_dokumen` (kod, tajuk_dokumen, `status`) ";
				$sql .= " VALUES(".tosql($kod).",".tosql($tajuk).",".tosql($status_dokumen).")";
				$rss = $conn->Execute($sql);
				audit_trail($strSQL, "TAMBAH BARU KAWALAN MUATNAIK DOKUMEN");

			}

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} else if($pro == 'HAPUS'){
			$sql = "UPDATE $schema2.`kawalan_muatnaik_dokumen` SET is_deleted=1 WHERE `kod`='{$kod}'"; 
			$rss = $conn->Execute($sql);
			audit_trail($strSQL, "HAPUS KAWALAN MUATNAIK DOKUMEN");

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} 
	} else if($jenis == 'KAWALAN_TEMPOH_AKAUN'){
		$tempoh=isset($_REQUEST["tempoh"])?$_REQUEST["tempoh"]:"";

		if($pro == 'SAVE'){
			$strSQL = "UPDATE $schema2.`kawalan_tempoh_akaun` SET tempoh=".tosql($tempoh);
			
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "KEMASKINI KAWALAN TEMPOH AKAUN");

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} 
	} else if($jenis == 'HEBAHAN_MAKLUMAN'){
		
		if($pro == 'SAVE'){
			$jenis_hebahan=isset($_REQUEST["jenis_hebahan"])?$_REQUEST["jenis_hebahan"]:"";
			$tajuk=isset($_REQUEST["tajuk"])?$_REQUEST["tajuk"]:"";
			$keterangan=isset($_REQUEST["keterangan"])?$_REQUEST["keterangan"]:"";
			$tarikh_mula=isset($_REQUEST["tarikh_mula"])?$_REQUEST["tarikh_mula"]:"";
			$tarikh_tamat=isset($_REQUEST["tarikh_tamat"])?$_REQUEST["tarikh_tamat"]:"";
			$status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";
			$dokumen_ada=isset($_REQUEST["dokumen_ada"])?$_REQUEST["dokumen_ada"]:"";
			$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";

			// print $dokumen_ada;exit();

			if(!empty($_FILES['dokumen']['name'])){
				$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'pdf', 'JPEG', 'JPG', 'PNG', 'GIF', 'PDF'); // valid extensions
				$path = '../../uploads_doc/'; // upload directory
				
				$img = $_FILES['dokumen']['name'];
				$tmp = $_FILES['dokumen']['tmp_name'];
				
				// print "IMG:".$img;
		
				$ext = end((explode(".", $img))); 
				$fname = $id.".".$ext;
				$fname = str_replace(" ", "_", $fname);
				$fname = str_replace("-", "_", $fname);
				
				// $final_image = "perubahanNamaItem_".$appli_id.".".$ext;
				$final_image = rand(1000,1000000)."_".$fname;
				if(in_array($ext, $valid_extensions)){ 
					$path = $path.strtolower($final_image); 
					move_uploaded_file($tmp,$path);
				}
			} else if(!empty($dokumen_ada)) {
				$final_image = $dokumen_ada;
			}

			$final_image = strtolower($final_image);

			if(empty($id)){
				$sql = "INSERT INTO $schema2.hebahan_makluman(jenis, tajuk, keterangan, tarikh_mula, tarikh_tamat, dokumen, `status`)";
				$sql .= " VALUES(".tosql($jenis_hebahan).", ".tosql($tajuk).", ".tosql($keterangan).", ".tosql($tarikh_mula).", ".tosql($tarikh_tamat).", ".tosql($final_image)." ,".tosql($status).")";

				audit_trail($sql, "TAMBAH BARU HEBAHAN ATAU MAKLUMAN");

			} else {
				$sql="UPDATE $schema2.hebahan_makluman SET jenis=".tosql($jenis_hebahan).", tajuk=".tosql($tajuk).", keterangan=".tosql($keterangan).", tarikh_mula=".tosql($tarikh_mula).", tarikh_tamat=".tosql($tarikh_tamat).", dokumen=".tosql($final_image)." WHERE kod='{$id}'";	

				audit_trail($sql, "KEMASKINI HEBAHAN ATAU MAKLUMAN");

			}
			$rss = $conn->execute($sql);
			if($rss){
				$err='OK';
			} else {
				$err='ERR';
			}
		} else if($pro == 'HAPUS'){
			// $conn->debug=true;
			$id_hapus=isset($_REQUEST["id_hapus"])?$_REQUEST["id_hapus"]:"";
			// print $id_hapus;
			$sql = "UPDATE $schema2.`hebahan_makluman` SET is_deleted=1 WHERE `kod`='{$id_hapus}'"; 
			$rss = $conn->Execute($sql);

			audit_trail($sql, "HAPUS HEBAHAN ATAU MAKLUMAN");


			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} 
	} else if($jenis == 'FAQ'){
		
		if($pro == 'SAVE'){
			$tajuk=isset($_REQUEST["tajuk"])?$_REQUEST["tajuk"]:"";
			$keterangan=isset($_REQUEST["keterangan"])?$_REQUEST["keterangan"]:"";
			$status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";
			$dokumen_ada=isset($_REQUEST["dokumen_ada"])?$_REQUEST["dokumen_ada"]:"";
			$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";

			// print $dokumen_ada;exit();

			if(!empty($_FILES['dokumen']['name'])){
				$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'pdf', 'JPEG', 'JPG', 'PNG', 'GIF', 'PDF'); // valid extensions
				$path = '../../uploads_doc/'; // upload directory
				
				$img = $_FILES['dokumen']['name'];
				$tmp = $_FILES['dokumen']['tmp_name'];
				
				// print "IMG:".$img;
		
				$ext = end((explode(".", $img))); 
				$fname = $id.".".$ext;
				$fname = str_replace(" ", "_", $fname);
				$fname = str_replace("-", "_", $fname);
				
				// $final_image = "perubahanNamaItem_".$appli_id.".".$ext;
				$final_image = rand(1000,1000000)."_".$fname;
				if(in_array($ext, $valid_extensions)){ 
					$path = $path.strtolower($final_image); 
					move_uploaded_file($tmp,$path);
				}
			} else if(!empty($dokumen_ada)) {
				$final_image = $dokumen_ada;
			}

			$final_image = strtolower($final_image);

			if(empty($id)){
				$sql = "INSERT INTO $schema2.faq(tajuk, keterangan, dokumen, `status`)";
				$sql .= " VALUES(".tosql($tajuk).", ".tosql($keterangan).", ".tosql($final_image)." ,".tosql($status).")";

				audit_trail($sql, "TAMBAH BARU FAQ");

			} else {
				$sql="UPDATE $schema2.faq SET tajuk=".tosql($tajuk).", keterangan=".tosql($keterangan).", dokumen=".tosql($final_image)." WHERE kod='{$id}'";	

				audit_trail($sql, "KEMASKINI FAQ");
			}
			$rss = $conn->execute($sql);
			if($rss){
				$err='OK';
			} else {
				$err='ERR';
			}
		} else if($pro == 'HAPUS'){
			// $conn->debug=true;
			$id_hapus=isset($_REQUEST["id_hapus"])?$_REQUEST["id_hapus"]:"";
			// print $id_hapus;
			$sql = "UPDATE $schema2.`faq` SET is_deleted=1 WHERE `kod`='{$id_hapus}'"; 
			$rss = $conn->Execute($sql);
			audit_trail($sql, "HAPUS FAQ");
			

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} 
	} else if($jenis == 'NOTIFIKASI'){
		
		if($pro == 'SAVE'){
			$tajuk=isset($_REQUEST["tajuk"])?$_REQUEST["tajuk"]:"";
			$kod_noti=isset($_REQUEST["kod_noti"])?$_REQUEST["kod_noti"]:"";
			$status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";
			$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";

			if(empty($id)){
				$sql = "INSERT INTO $schema2.kandungan_notifikasi(tajuk, kod_noti, `status`)";
				$sql .= " VALUES(".tosql($tajuk).", ".tosql($kod_noti).", ".tosql($status).")";

				audit_trail($sql, "TAMBAH BARU KANDUNGAN NOTIFIKASI");

			} else {
				$sql="UPDATE $schema2.kandungan_notifikasi SET tajuk=".tosql($tajuk).", kod_noti=".tosql($kod_noti)." WHERE kod='{$id}'";	
				audit_trail($sql, "KEMASKINI KANDUNGAN NOTIFIKASI");

			}
			$rss = $conn->execute($sql);
			if($rss){
				$err='OK';
			} else {
				$err='ERR';
			}
		} else if($pro == 'HAPUS'){
			// $conn->debug=true;
			$id_hapus=isset($_REQUEST["id_hapus"])?$_REQUEST["id_hapus"]:"";
			// print $id_hapus;
			$sql = "UPDATE $schema2.`kandungan_notifikasi` SET is_deleted=1 WHERE `kod`='{$id_hapus}'"; 
			$rss = $conn->Execute($sql);
			audit_trail($sql, "HAPUS KANDUNGAN NOTIFIKASI");


			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} 
	} else if($jenis == 'KANDUNGAN_SURAT'){
		
		if($pro == 'SAVE'){
			$tajuk=isset($_REQUEST["tajuk"])?$_REQUEST["tajuk"]:"";
			$keterangan=isset($_REQUEST["keterangan"])?$_REQUEST["keterangan"]:"";
			$status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";
			$jenis_surat=isset($_REQUEST["jenis_surat"])?$_REQUEST["jenis_surat"]:"";
			$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";

			// print $dokumen_ada;exit();

			if(empty($id)){
				$sql = "INSERT INTO $schema2.kandungan_surat(tajuk, keterangan, `status`, jenis)";
				$sql .= " VALUES(".tosql($tajuk).", ".tosql($keterangan).", ".tosql($status)." ,".tosql($jenis_surat).")";

				audit_trail($sql, "TAMBAH BARU KANDUNGAN SURAT");

			} else {
				$sql="UPDATE $schema2.kandungan_surat SET tajuk=".tosql($tajuk).", keterangan=".tosql($keterangan).",  jenis=".tosql($jenis_surat)." WHERE kod='{$id}'";
				
				audit_trail($sql, "KEMASKINI KANDUNGAN SURAT");
				
			}
			$rss = $conn->execute($sql);
			if($rss){
				$err='OK';
			} else {
				$err='ERR';
			}
		} else if($pro == 'HAPUS'){
			// $conn->debug=true;
			$id_hapus=isset($_REQUEST["id_hapus"])?$_REQUEST["id_hapus"]:"";
			// print $id_hapus;
			$sql = "UPDATE $schema2.`kandungan_surat` SET is_deleted=1 WHERE `kod`='{$id_hapus}'"; 
			$rss = $conn->Execute($sql);

			audit_trail($sql, "HAPUS KANDUNGAN SURAT");

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} 
	} else if($jenis == 'MENU_PEMOHON'){
		
		if($pro == 'SAVE'){
			// $conn->debug=true;
			$id_menu=isset($_REQUEST["id_menu"])?$_REQUEST["id_menu"]:"";
			$status_menu=isset($_REQUEST["status_menu"])?$_REQUEST["status_menu"]:"";

			// print $id_menu_hapus;
			$sql = "UPDATE $schema2.`menu_pemohon` SET `status`=".tosql($status_menu)." WHERE `kod`='{$id_menu}'"; 
			$rss = $conn->Execute($sql);
			audit_trail($sql, "KEMASKINI MENU PEMOHON");


			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} 
	} 
}

// header("Content-Type: text/json");
// print json_encode($err); 
print $err;
?>