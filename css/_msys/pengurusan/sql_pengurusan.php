<?php
session_start();
include '../../connection/common.php';
$frm=isset($_GET["frm"])?$_GET["frm"]:"";
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$date=date("Y-m-d H:i:s");
$oleh=$_SESSION['SESS_UID'];
// $conn->debug=true;
$err='ERR';

if($frm=='NEGERI'){
    global $schema2;
    
	if($pro=='SAVE'){
		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
		$negeri=isset($_REQUEST["negeri"])?$_REQUEST["negeri"]:"";
		$status_negeri=isset($_REQUEST["status_negeri"])?$_REQUEST["status_negeri"]:"";

		if(!empty($kod)){
			$strSQL = "UPDATE $schema2.`ref_negeri` SET diskripsi2=".tosql($negeri).", status=".tosql($status_negeri); 	
			$strSQL .= " WHERE kod=".tosql($kod);
			
			$rss = $conn->execute($strSQL);
			// audit_trail($strSQL, "KEMASKINI NEGERI");

		} 
        
		//exit;
		if($rss){
			// KEMASKINI DATA DETAIL
			$err='OK';
		} else {
			$err='ERR'; 
		}
	
	} 		
}

if($frm=='PARAMETER'){
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
			// audit_trail($strSQL, "KEMASKINI NEGERI");

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
				// audit_trail($strSQL, "KEMASKINI NEGERI");

			} else {
				$sql = "INSERT INTO $schema1.`ref_institusi` (KOD, DISKRIPSI, `STATUS`, NEGARA, JENIS_INSTITUSI, TARIKH_CIPTA, ID_PENCIPTA) ";
				$sql .= " VALUES(".tosql($kod).",".tosql($universiti).",".tosql($status_universiti).",".tosql($negara_universiti).",".tosql($jenis_institusi).",".tosql($date).",".tosql($oleh).")";
				$rss = $conn->Execute($sql);
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

			if($rss){
				// KEMASKINI DATA DETAIL
				$err='OK';
			} else {
				$err='ERR'; 
			}
		} else if($pro == 'CHECK_KOD'){
			// print 'sini'; exit();
			// $conn->debug=true;
			$sql3 = "SELECT COUNT(*) as total FROM $schema1.`ref_institusi` WHERE KOD='{$kod}'";
			$rs = $conn->query($sql3);
			// print 'aaaaaaa'.$rs->fields['total'];
			
			if(($rs->fields['total']) >= 1){
				$err='ERR';
			} else {
				$err='OK';
			}
		}
	
	} else if($jenis=='PENGKHUSUSAN'){
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
	
	} 	else if($jenis=='PERINGKAT_KELULUSAN'){
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
}
// header("Content-Type: text/json");
// print json_encode($err); 
print $err;
?>