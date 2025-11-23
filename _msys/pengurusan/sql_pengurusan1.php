<?php
session_start();
include '../../connection/common.php';
//include '../../email/mail_send.php';
$frm=isset($_GET["frm"])?$_GET["frm"]:"";
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$jenis=isset($_GET["jenis"])?$_GET["jenis"]:"";
$date=date("Y-m-d H:i:s");
$oleh=$_SESSION['SESSADM_UID'];
//$conn->debug=true;
$err='ERR';


if($frm=='PARAMETER'){

	if($jenis=='PADANAN_PERINGKATKELULUSAN_INSTITUSI'){
		// $conn->debug=true;
		$peringkat2=isset($_REQUEST["peringkat2"])?$_REQUEST["peringkat2"]:"";
		$check=isset($_REQUEST["check"])?$_REQUEST["check"]:"";
		$chk=isset($_REQUEST["chk"])?$_REQUEST["chk"]:"";
		$kod_institusi=isset($_REQUEST["kod_institusi"])?$_REQUEST["kod_institusi"]:"";
		$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";


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
						$strSQL = "UPDATE $schema1.`padanan_peringkatkelulusan_institusi` SET `status`=0, tarikh_ubahsuai=".tosql($date).", id_pengubahsuai=".tosql($oleh); 	
						$strSQL .= " WHERE kod_peringkat_kelulusan=".tosql($peringkat2)." AND kod_institusi=".tosql($rsInstitusi->fields['KOD']);
						
						$rss = $conn->execute($strSQL);
						admin_audit_trail($strSQL, "KEMASKINI PADANAN PERINGKAT KELULUSAN DAN INSTITUSI");
					} else {
						$sql = "INSERT INTO $schema1.`padanan_peringkatkelulusan_institusi` (kod_peringkat_kelulusan, `kod_institusi`, id_pencipta, tarikh_cipta) ";
						$sql .= " VALUES(".tosql($peringkat2).",".tosql($rsInstitusi->fields['KOD'])." ,".tosql($oleh)." ,".tosql($date).")";
						$rss = $conn->Execute($sql);
						admin_audit_trail($sql, "TAMBAH BARU PADANAN PERINGKAT KELULUSAN DAN INSTITUSI");
					}
					
				$rsInstitusi->movenext(); }
			} else if($check == 'no'){

				while(!$rsInstitusi->EOF){
					$strSQL = "UPDATE $schema1.`padanan_peringkatkelulusan_institusi` SET `status`=1, tarikh_ubahsuai=".tosql($date).", id_pengubahsuai=".tosql($oleh); 	
					$strSQL .= " WHERE kod_peringkat_kelulusan=".tosql($peringkat2)." AND kod_institusi=".tosql($rsInstitusi->fields['KOD']);
					
					$rss = $conn->execute($strSQL);
					admin_audit_trail($strSQL, "KEMASKINI PADANAN PERINGKAT KELULUSAN DAN INSTITUSI");
				$rsInstitusi->movenext(); }
			}
			 
		} else if($pro == 'SAVE'){
			// print 'sini2';print $chk;exit();

			// if($kategori == 'AWAM'){
			// 	$sql3 = "SELECT * FROM $schema1.`ref_institusi` WHERE `NEGARA`='130' AND SAH_YT='Y' AND KATEGORI='A'";
			// } else if($kategori == 'SWASTA'){
			// 	$sql3 = "SELECT * FROM $schema1.`ref_institusi` WHERE `NEGARA`='130' AND SAH_YT='Y' AND KATEGORI IS NULL";
			// }

			// $rsInstitusi = $conn->query($sql3);

			if($chk == 'true'){

				// print 'aaa'.$peringkat2;
				$sql3 = "SELECT COUNT(*) as total FROM $schema1.`padanan_peringkatkelulusan_institusi` WHERE kod_peringkat_kelulusan=".tosql($peringkat2)." AND kod_institusi=".tosql($kod_institusi);
				$checkDiPadanan = $conn->query($sql3);

				if($checkDiPadanan->fields['total']){
					$strSQL = "UPDATE $schema1.`padanan_peringkatkelulusan_institusi` SET `status`=0, tarikh_ubahsuai=".tosql($date).", id_pengubahsuai=".tosql($oleh);	
					$strSQL .= " WHERE kod_peringkat_kelulusan=".tosql($peringkat2)." AND kod_institusi=".tosql($kod_institusi);
					
					$rss = $conn->execute($strSQL);
					admin_audit_trail($strSQL, "KEMASKINI PADANAN PERINGKAT KELULUSAN DAN INSTITUSI");
			
				} else {
			
					$sql = "INSERT INTO $schema1.`padanan_peringkatkelulusan_institusi` (kod_peringkat_kelulusan, `kod_institusi`, id_pencipta, tarikh_cipta, tarikh_ubahsuai) ";
					$sql .= " VALUES(".tosql($peringkat2).",".tosql($kod_institusi)." ,".tosql($oleh)." ,".tosql($date)." ,".tosql($date).")";
					$rss = $conn->Execute($sql);
					admin_audit_trail($sql, "TAMBAH BARU PADANAN PERINGKAT KELULUSAN DAN INSTITUSI");
			
				}
			
			} else {

				$strSQL = "UPDATE $schema1.`padanan_peringkatkelulusan_institusi` SET `status`=1, tarikh_ubahsuai=".tosql($date).", id_pengubahsuai=".tosql($oleh);	
				$strSQL .= " WHERE kod_peringkat_kelulusan=".tosql($peringkat2)." AND kod_institusi=".tosql($kod_institusi);
				
				$rss = $conn->execute($strSQL);
				admin_audit_trail($strSQL, "KEMASKINI PADANAN PERINGKAT KELULUSAN DAN INSTITUSI");
			}

		} else if($pro == 'HAPUS'){

			$strSQL = "UPDATE $schema1.`padanan_peringkatkelulusan_institusi` SET `status`=1, tarikh_ubahsuai=".tosql($date).", id_pengubahsuai=".tosql($oleh); 	
			$strSQL .= " WHERE kod_institusi=".tosql($kod_institusi). " AND kod=".tosql($kod);
			//kod_peringkat_kelulusan=".tosql($peringkat2)." AND 
			
			$rss = $conn->execute($strSQL);
			admin_audit_trail($strSQL, "HAPUS PADANAN PERINGKAT KELULUSAN DAN INSTITUSI");
		
		}

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