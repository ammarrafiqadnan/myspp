<?php
session_start();
include '../connection/common.php';
include '../email/notis_email.php';
$frm=isset($_GET["frm"])?$_GET["frm"]:"";
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$act=isset($_GET["act"])?$_GET["act"]:"";
$date=date("Y-m-d H:i:s");
$oleh=$_SESSION['SESS_UID'];
// $conn->debug=true;


if($frm=='PANTAU'){
	
	if($pro=='SAVE'){
		$pemantauan_id=isset($_REQUEST["pemantauan_id"])?$_REQUEST["pemantauan_id"]:"";
		$pemantauan_type=isset($_REQUEST["pemantauan_type"])?$_REQUEST["pemantauan_type"]:"";
		$pemantauan_jenis=isset($_REQUEST["pemantauan_jenis"])?$_REQUEST["pemantauan_jenis"]:"";
		$tajuk=isset($_REQUEST["tajuk"])?$_REQUEST["tajuk"]:"";
		$tarikh=isset($_REQUEST["tarikh"])?$_REQUEST["tarikh"]:"";
		$tempat=isset($_REQUEST["tempat"])?$_REQUEST["tempat"]:"";
		$parlimen=isset($_REQUEST["parlimen"])?$_REQUEST["parlimen"]:"";
		$pegawai=isset($_REQUEST["pegawai"])?$_REQUEST["pegawai"]:"";
		$tujuan=isset($_REQUEST["tujuan"])?$_REQUEST["tujuan"]:"";
		$laporan_kajian=isset($_REQUEST["laporan_kajian"])?$_REQUEST["laporan_kajian"]:"";
		$syor=isset($_REQUEST["syor"])?$_REQUEST["syor"]:"";
		$pegawai_list=isset($_REQUEST["pegawai_list"])?$_REQUEST["pegawai_list"]:"";

		$gid = dlookup("tbl_pemantauan","pemantauan_id","pemantauan_id=".tosql($pemantauan_id));

		if(!empty($gid)){
			$strSQL = "UPDATE tbl_pemantauan SET is_deleted=0 ";
			$strSQL .= ", pemantauan_jenis=".tosql($pemantauan_jenis).", tajuk=".tosql($tajuk).", tarikh=".tosql($tarikh).", 
				tempat=".tosql($tempat).", pegawai=".tosql($pegawai).", parlimen_id=".tosql($parlimen); 
			$strSQL .= ", tujuan=".tosql($tujuan) . ", laporan_kajian=".tosql($laporan_kajian).", syor=".tosql($syor); 
			$strSQL .= ", update_dt='{$date}', update_by=".tosql($oleh);
			$strSQL .= ", pegawai_list='{$pegawai_list}'";	
			if($act=='SEND'){ $strSQL .= ", status_proses=3"; }

			$strSQL .= " WHERE pemantauan_id=".tosql($pemantauan_id);
			
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "KEMASKINI");

		} else {
			$strSQL = "INSERT INTO tbl_pemantauan(pemantauan_id, pemantauan_type, pemantauan_jenis, tajuk, tarikh, tempat,  
				parlimen_id, pegawai, tujuan, laporan_kajian, syor, status_proses, 
				is_deleted, create_dt, create_by, update_dt, update_by, pegawai_list) 
				VALUES(".tosql($pemantauan_id).", ".tosql($pemantauan_type).", ".tosql($pemantauan_jenis).", ".tosql($tajuk).",  ".tosql($tarikh).", ".tosql($tempat).", 
				".tosql($parlimen).", ".tosql($pegawai).", ".tosql($tujuan).", ".tosql($laporan_kajian).", ".tosql($syor).", 0, 
				0, ".tosql($date).", ".tosql($oleh).", ".tosql($date).", ".tosql($oleh).", ".tosql($pegawai_list).")";
			
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "TAMBAH");
			//$conn->debug=false;
		}
		// exit;
		if($rss){
			// TINDAKAN RAHMAH - KATEGORI RAHMAH
			if($act=='SEND'){
				send_mesej($conn, "N001", $pemantauan_id);
				$err='OK;index.php?data='. $_SESSION['SESS_data'];
			} else {
				$err='OK;index.php?data='. base64_encode('maklumat/pemantauan_form;DATA;Maklumat Pemantauan;;;'.$pemantauan_id);
			}
		} else {
			$err='ERR;'; 
		}
	
	} else if($pro=="DEL"){
		// $conn->debug=true;
		$ID=isset($_REQUEST["ID"])?$_REQUEST["ID"]:"";
		//$sqld = "DELETE FROM _ref_akta WHERE akta_id='{$akta_id}'";
		$sqld = "UPDATE `tbl_pemantauan` SET `is_deleted`=1, `deleted_dt`='{$date}', `deleted_by`=".tosql($oleh)." WHERE pemantauan_id='{$ID}'";
		$rss = $conn->execute($sqld);
		audit_trail($sqld, "TAMBAH");
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	}		

} else if($frm=='BGUNAAN'){
	// $conn->debug=true;
	if($pro=='SAVE'){
		$pemantauan_id=isset($_REQUEST["pemantauan_id"])?$_REQUEST["pemantauan_id"]:"";
		$pemantauan_type=isset($_REQUEST["pemantauan_type"])?$_REQUEST["pemantauan_type"]:"";
		$tajuk=isset($_REQUEST["tajuk"])?$_REQUEST["tajuk"]:"";
		$jenis=isset($_REQUEST["jenis"])?$_REQUEST["jenis"]:"";
		$tempat=isset($_REQUEST["tempat"])?$_REQUEST["tempat"]:"";
		$parlimen=isset($_REQUEST["parlimen"])?$_REQUEST["parlimen"]:"";
		$pengeluar=isset($_REQUEST["pengeluar"])?$_REQUEST["pengeluar"]:"";
		$laporan_kajian=isset($_REQUEST["laporan_kajian"])?$_REQUEST["laporan_kajian"]:"";
		$syor=isset($_REQUEST["syor"])?$_REQUEST["syor"]:"";

		$gid = dlookup("tbl_pemantauan","pemantauan_id","pemantauan_id=".tosql($pemantauan_id));

		if(!empty($gid)){
			$strSQL = "UPDATE tbl_pemantauan SET is_deleted=0 ";
			$strSQL .= ", tajuk=".tosql($tajuk).", material=".tosql($jenis).", tempat=".tosql($tempat).", pegawai=".tosql($pengeluar); 
			$strSQL .= ", laporan_kajian=".tosql($laporan_kajian).", syor=".tosql($syor).", parlimen_id=".tosql($parlimen);  
			$strSQL .= ", update_dt='{$date}', update_by=".tosql($oleh);	
			if($act=='SEND'){ $strSQL .= ", status_proses=3"; }

			$strSQL .= " WHERE pemantauan_id=".tosql($pemantauan_id);
			
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "KEMASKINI");

		} else {
			$strSQL = "INSERT INTO tbl_pemantauan(pemantauan_id, pemantauan_type, tajuk, tempat, material,  
				pegawai, laporan_kajian, syor, status_proses, parlimen_id, 
				is_deleted, create_dt, create_by, update_dt, update_by) 
				VALUES(".tosql($pemantauan_id).", ".tosql($pemantauan_type).", ".tosql($tajuk).", ".tosql($tempat).", ".tosql($jenis).", 
				".tosql($pengeluar).", ".tosql($laporan_kajian).", ".tosql($syor).", 0, ".tosql($parlimen).",
				0, ".tosql($date).", ".tosql($oleh).", ".tosql($date).", ".tosql($oleh).")";
			
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "TAMBAH");
			//$conn->debug=false;
		}
		//exit;
		if($rss){
			// TINDAKAN RAHMAH - KATEGORI RAHMAHif($act=='SEND'){
			if($act=='SEND'){
				send_mesej($conn, "N001", $pemantauan_id);
				$err='OK;index.php?data='. $_SESSION['SESS_data'];
			} else {
				$err='OK;index.php?data='. base64_encode('maklumat/barang_gunaan_form;DATA;Laporan Kajian Bahan Gunaan;;;'.$pemantauan_id);
			}
		} else {
			$err='ERR;'; 
		}
	
	} else if($pro=="DEL"){
	
		$ID=isset($_REQUEST["ID"])?$_REQUEST["ID"]:"";
		//$sqld = "DELETE FROM _ref_akta WHERE akta_id='{$akta_id}'";
		$sqld = "UPDATE `tbl_pemantauan` SET `is_deleted`=1, `deleted_dt`='{$date}', `deleted_by`=".tosql($oleh)." WHERE pemantauan_id='{$ID}'";
		$rss = $conn->execute($sqld);
		audit_trail($sqld, "TAMBAH");
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	}	
} else if($frm=='BPENERBITAN'){
	// $conn->debug=true;
	if($pro=='SAVE'){
		$pemantauan_id=isset($_REQUEST["pemantauan_id"])?$_REQUEST["pemantauan_id"]:"";
		$pemantauan_type=isset($_REQUEST["pemantauan_type"])?$_REQUEST["pemantauan_type"]:"";
		$pemantauan_jenis=isset($_REQUEST["pemantauan_jenis"])?$_REQUEST["pemantauan_jenis"]:"";
		$tajuk=isset($_REQUEST["tajuk"])?$_REQUEST["tajuk"]:"";
		$tajuk_penerbitan=isset($_REQUEST["tajuk_penerbitan"])?$_REQUEST["tajuk_penerbitan"]:"";
		$tarikh=isset($_REQUEST["tarikh"])?$_REQUEST["tarikh"]:"";
		$tempat=isset($_REQUEST["tempat"])?$_REQUEST["tempat"]:"";
		$laporan_kajian=isset($_REQUEST["laporan_kajian"])?$_REQUEST["laporan_kajian"]:"";
		$syor=isset($_REQUEST["syor"])?$_REQUEST["syor"]:"";

		$sykt_penerbit=isset($_REQUEST["sykt_penerbit"])?$_REQUEST["sykt_penerbit"]:"";
		$sykt_pengeluar=isset($_REQUEST["sykt_pengeluar"])?$_REQUEST["sykt_pengeluar"]:"";
		$sykt_pengedar=isset($_REQUEST["sykt_pengedar"])?$_REQUEST["sykt_pengedar"]:"";
		$sykt_pencetak=isset($_REQUEST["sykt_pencetak"])?$_REQUEST["sykt_pencetak"]:"";

		$gid = dlookup("tbl_pemantauan","pemantauan_id","pemantauan_id=".tosql($pemantauan_id));

		if(!empty($gid)){
			$strSQL = "UPDATE tbl_pemantauan SET is_deleted=0 ";
			$strSQL .= ", pemantauan_jenis=".tosql($pemantauan_jenis).", tajuk=".tosql($tajuk).", tajuk_penerbitan=".tosql($tajuk_penerbitan).", 
				tarikh=".tosql($tarikh).", tempat=".tosql($tempat).", pegawai=".tosql($pegawai); 
			$strSQL .= ", tujuan=".tosql($tujuan) . ", laporan_kajian=".tosql($laporan_kajian).", syor=".tosql($syor); 
			$strSQL .= ", update_dt='{$date}', update_by=".tosql($oleh);	
			if($act=='SEND'){ $strSQL .= ", status_proses=3"; }

			$strSQL .= " WHERE pemantauan_id=".tosql($pemantauan_id);
			
			$rss = $conn->execute($strSQL);

			if($rss){
				$gids = dlookup("tbl_pemantauan_penerbitan","pemantauan_id","pemantauan_id=".tosql($pemantauan_id));
				if(empty($gids)){ 
					$sqli = "INSERT INTO `tbl_pemantauan_penerbitan`(`pemantauan_id`, `sykt_penerbit`, `sykt_pengeluar`, `sykt_pengedar`, 
						`sykt_pencetak`, `create_dt`, `update_dt`, `create_by`, `update_by`) 
						VALUES (".tosql($pemantauan_id).", ".tosql($sykt_penerbit).", ".tosql($sykt_pengeluar).", ".tosql($sykt_pengedar).", 
						".tosql($sykt_pencetak).", ".tosql($date).", ".tosql($date).", ".tosql($oleh).", ".tosql($oleh).")";
				} else {
					$sqli = "UPDATE `tbl_pemantauan_penerbitan` SET sykt_penerbit=".tosql($sykt_penerbit).", sykt_pengeluar=".tosql($sykt_pengeluar).",
						sykt_pengedar=".tosql($sykt_pengedar).", sykt_pencetak=".tosql($sykt_pencetak).", update_dt=".tosql($date).", 
						update_by=".tosql($oleh)." WHERE pemantauan_id=".tosql($pemantauan_id);
				}
				$rss = $conn->execute($sqli);	
			}			
			audit_trail($strSQL, "KEMASKINI");

		} else {
			$strSQL = "INSERT INTO tbl_pemantauan(pemantauan_id, pemantauan_type, pemantauan_jenis, tajuk, tajuk_penerbitan, 
				tarikh, tempat, pegawai, tujuan, laporan_kajian, syor, status_proses, 
				is_deleted, create_dt, create_by, update_dt, update_by) 
				VALUES(".tosql($pemantauan_id).", ".tosql($pemantauan_type).", ".tosql($pemantauan_jenis).", ".tosql($tajuk).", ".tosql($tajuk_penerbitan).",  
				".tosql($tarikh).", ".tosql($tempat).", ".tosql($pegawai).", ".tosql($tujuan).", ".tosql($laporan_kajian).", ".tosql($syor).", 0, 
				0, ".tosql($date).", ".tosql($oleh).", ".tosql($date).", ".tosql($oleh).")";
			
			$rss = $conn->execute($strSQL);

			if($rss){
				$sqli = "INSERT INTO `tbl_pemantauan_penerbitan`(`pemantauan_id`, `sykt_penerbit`, `sykt_pengeluar`, `sykt_pengedar`, 
					`sykt_pencetak`, `create_dt`, `update_dt`, `create_by`, `update_by`) 
					VALUES (".tosql($pemantauan_id).", ".tosql($sykt_penerbit).", ".tosql($sykt_pengeluar).", ".tosql($sykt_pengedar).", 
					".tosql($sykt_pencetak).", ".tosql($date).", ".tosql($date).", ".tosql($oleh).", ".tosql($oleh).")";
				$rss = $conn->execute($sqli);	
			}
			audit_trail($strSQL, "TAMBAH");
			//$conn->debug=false;
		}
		//exit;
		if($rss){
			// TINDAKAN RAHMAH - KATEGORI RAHMAH
			if($act=='SEND'){
				send_mesej($conn, "N001", $pemantauan_id);
				$err='OK;index.php?data='. $_SESSION['SESS_data'];
			} else {
				$err='OK;index.php?data='. base64_encode('maklumat/bahan_penerbitan_form;DATA;Laporan Kajian Bahan Penerbitan;;;'.$pemantauan_id);
			}
		} else {
			$err='ERR;'; 
		}
	
	} else if($pro=="DEL"){
	
		$ID=isset($_REQUEST["ID"])?$_REQUEST["ID"]:"";
		//$sqld = "DELETE FROM _ref_akta WHERE akta_id='{$akta_id}'";
		$sqld = "UPDATE `tbl_pemantauan` SET `is_deleted`=1, `deleted_dt`='{$date}', `deleted_by`=".tosql($oleh)." WHERE pemantauan_id='{$ID}'";
		$rss = $conn->execute($sqld);
		audit_trail($sqld, "TAMBAH");
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	}	

} else if($frm=='ULASAN'){
	// $conn->debug=true;
	$tarikh = date("Y-m-d");
	$pemantauan_id=isset($_REQUEST["pemantauan_id"])?$_REQUEST["pemantauan_id"]:"";
	$pemantauan_type=isset($_REQUEST["pemantauan_type"])?$_REQUEST["pemantauan_type"]:"";
	$ulasan=isset($_REQUEST["ulasan"])?$_REQUEST["ulasan"]:"";
	$status_proses=isset($_REQUEST["status_proses"])?$_REQUEST["status_proses"]:"";
	//SELECT * FROM `tbl_pemantauan_ulasan` 
	$rs = $conn->query("SELECT * FROM `tbl_pemantauan_ulasan` WHERE `pemantauan_id`='{$pemantauan_id}' AND `jenis_ulasan`='3'");
	if($rs->EOF){

		$sql = "INSERT INTO `tbl_pemantauan_ulasan`(pemantauan_id, jenis_ulasan, ulasan, ulasan_by, ulasan_bhg, ulasan_tkh, create_dt, update_dt, create_by, update_by)";
		$sql .= " VALUES('{$pemantauan_id}', 3, ".tosql($ulasan).", '{$oleh}', '{$bahagian}', '{$tarikh}', '{$date}', '{$date}', '{$oleh}', '{$oleh}')";
		audit_trail($sql, "TAMBAH");

	} else {

		$sql = "UPDATE `tbl_pemantauan_ulasan` SET ulasan=".tosql($ulasan).", ulasan_tkh='{$tarikh}', update_dt='{$date}', update_by='{$oleh}'";
		$sql .= " WHERE pemantauan_id='{$pemantauan_id}' AND `jenis_ulasan`='3'"; 
		audit_trail($strSQL, "KEMASKINI");
	}

	$rss = $conn->execute($sql);
	if($rss){
		$err='OK';
		if($act=='SEND'){
			$strSQL = "UPDATE `tbl_pemantauan` SET `status_proses`='{$status_proses}' WHERE `pemantauan_id`='{$pemantauan_id}'";
			$conn->execute($strSQL);
			audit_trail($strSQL, "KEMASKINI");
			if($status_proses=='5'){ 
				// HANTAR KE TPO
				send_mesej($conn, "N002", $pemantauan_id);
			} else if($status_proses=='1'){ 
				// HANTAR SEMULA KE PEGAWAI
				send_mesej($conn, "N003", $pemantauan_id);
			}
		}

		// if($act=='SEND'){
		// 	$err='OK;index.php?data='. $_SESSION['SESS_data'];
		// } else {
		// 	$err='OK;index.php?data='. base64_encode('maklumat/bahan_penerbitan_form;DATA;Laporan Kajian Bahan Penerbitan;;;'.$pemantauan_id);
		// }

	} else {
		$err='ERR'; 
	}

} else if($frm=='ULASAN_TP'){
	// $conn->debug=true;
	$tarikh = date("Y-m-d");
	$pemantauan_id=isset($_REQUEST["pemantauan_id"])?$_REQUEST["pemantauan_id"]:"";
	$pemantauan_type=isset($_REQUEST["pemantauan_type"])?$_REQUEST["pemantauan_type"]:"";
	$ulasan=isset($_REQUEST["ulasan"])?$_REQUEST["ulasan"]:"";
	$status_proses=isset($_REQUEST["status_proses"])?$_REQUEST["status_proses"]:"";
	//SELECT * FROM `tbl_pemantauan_ulasan` 
	$rs = $conn->query("SELECT * FROM `tbl_pemantauan_ulasan` WHERE `pemantauan_id`='{$pemantauan_id}' AND `jenis_ulasan`='5'");
	if($rs->EOF){

		$sql = "INSERT INTO `tbl_pemantauan_ulasan`(pemantauan_id, jenis_ulasan, ulasan, ulasan_by, ulasan_bhg, ulasan_tkh, create_dt, update_dt, create_by, update_by)";
		$sql .= " VALUES('{$pemantauan_id}', 5, ".tosql($ulasan).", '{$oleh}', '{$bahagian}', '{$tarikh}', '{$date}', '{$date}', '{$oleh}', '{$oleh}')";
		audit_trail($sql, "TAMBAH");

	} else {

		$sql = "UPDATE `tbl_pemantauan_ulasan` SET ulasan=".tosql($ulasan).", ulasan_tkh='{$tarikh}', update_dt='{$date}', update_by='{$oleh}'";
		$sql .= " WHERE pemantauan_id='{$pemantauan_id}' AND `jenis_ulasan`='5'"; 
		audit_trail($sql, "KEMASKINI");
	}

	$rss = $conn->execute($sql);
	if($rss){
		$err='OK';
		if($act=='SEND'){
			$strSQL = "UPDATE `tbl_pemantauan` SET `status_proses`='{$status_proses}' WHERE `pemantauan_id`='{$pemantauan_id}'";
			$conn->execute($strSQL);
			audit_trail($strSQL, "KEMASKINI");

			if($status_proses=='3'){ 
				// HANTAR KE SEMUA YG TERLIBAT
				send_mesej($conn, "N005", $pemantauan_id);
			} else if($status_proses=='7'){ 
				// HANTAR KEPADA PENGARAH
				send_mesej($conn, "N004", $pemantauan_id);
			}

		}
	} else {
		$err='ERR'; 
	}

} else if($frm=='ULASAN_PENGARAH'){
	// $conn->debug=true;
	$tarikh = date("Y-m-d");
	$pemantauan_id=isset($_REQUEST["pemantauan_id"])?$_REQUEST["pemantauan_id"]:"";
	$pemantauan_type=isset($_REQUEST["pemantauan_type"])?$_REQUEST["pemantauan_type"]:"";
	$ulasan=isset($_REQUEST["ulasan"])?$_REQUEST["ulasan"]:"";
	$status_proses=isset($_REQUEST["status_proses"])?$_REQUEST["status_proses"]:"";
	//SELECT * FROM `tbl_pemantauan_ulasan` 
	$rs = $conn->query("SELECT * FROM `tbl_pemantauan_ulasan` WHERE `pemantauan_id`='{$pemantauan_id}' AND `jenis_ulasan`='5'");
	if($rs->EOF){

		$sql = "INSERT INTO `tbl_pemantauan_ulasan`(pemantauan_id, jenis_ulasan, ulasan, ulasan_by, ulasan_bhg, ulasan_tkh, create_dt, update_dt, create_by, update_by)";
		$sql .= " VALUES('{$pemantauan_id}', 5, ".tosql($ulasan).", '{$oleh}', '{$bahagian}', '{$tarikh}', '{$date}', '{$date}', '{$oleh}', '{$oleh}')";
		audit_trail($sql, "TAMBAH");

	} else {

		$sql = "UPDATE `tbl_pemantauan_ulasan` SET ulasan=".tosql($ulasan).", ulasan_tkh='{$tarikh}', update_dt='{$date}', update_by='{$oleh}'";
		$sql .= " WHERE pemantauan_id='{$pemantauan_id}' AND `jenis_ulasan`='5'"; 
		audit_trail($sql, "KEMASKINI");
	}

	$rss = $conn->execute($sql);
	if($rss){
		$err='OK';
		if($act=='SEND'){
			$strSQL = "UPDATE `tbl_pemantauan` SET `status_proses`='{$status_proses}' WHERE `pemantauan_id`='{$pemantauan_id}'";
			$conn->execute($strSQL);
			audit_trail($strSQL, "KEMASKINI");

			if($status_proses=='5'){ 
				// HANTAR KE SEMULA TPO
				send_mesej($conn, "N007", $pemantauan_id);
			} else if($status_proses=='9'){ 
				// HANTAR KEPADA SEMUA PEGAWAI
				send_mesej($conn, "N006", $pemantauan_id);
			}

		}
	} else {
		$err='ERR'; 
	}

} else if($frm=='UPLOAD_DOC'){

	// $conn->debug=true;
	$pemantauan_id=isset($_REQUEST["pemantauan_id"])?$_REQUEST["pemantauan_id"]:"";
	$doc_id= addslashes(isset($_REQUEST["doc_id"]))?$_REQUEST["doc_id"]:"";
	$title=addslashes(isset($_REQUEST["title"]))?$_REQUEST["title"]:"";
	$type=addslashes(isset($_REQUEST["type"]))?$_REQUEST["type"]:"";
    
    // $applicant_id = dlookup("appli","applicant_id","id='{$appli_id}'");


	if($pro=='SAVE'){
	
		$upload_dir = '../upload_doc/';
		$file1=isset($_REQUEST["file1"])?$_REQUEST["file1"]:"";
	
		// $new_file = $_FILES['file1'];
		$new_file = $_FILES['file1'];

		$file_name = strtolower(str_replace(" ","_",$new_file['name'])); 
		$array = explode('.', $file_name);
		$file_extension = end($array); 
		// $passport = strtolower(str_replace("/","",$passport)); 
		$file_name = $pemantauan_id."_".$file_name;
		//echo "Mana fail-->".$_FILES['binFile'];
		$file_name = str_replace(" ","_",$file_name); 
		$file_size = $new_file['size']; 
		$file_tmp = $new_file['tmp_name'];
		//$file_name = $fldpemohon_ID."_".$file_name;
		//$file_name = $file_name;
		// echo "Mana fail-->".$file_name;
		//$file_extension = end(explode(".", $file_name));
		$file_ext = explode(".", $file_name);
		$file_extension = $file_ext[1];
// 		echo "<br>File Ext-->".$file_extension;

		$allowedExtensions = array("jpg","jpeg","gif","png","pdf","doc","xls","docx","txt","ppt"); 
		foreach ($_FILES as $file) { 
		if ($file['tmp_name'] > '') { 
			  //if (!in_array(end(explode(".", strtolower($file['name']))), $allowedExtensions)) { 
			  if (!in_array($file_extension, $allowedExtensions)) { 
			   die($new_file['name'].' is an invalid file type!<br/><br>'.'<div align="center"><input type="button" value="Tutup" onClick="javascript:parent.emailwindow.hide();" style="cursor:pointer"></div>'); 
			  } 
			} 
		}
	
		switch( $file_extension ) { 
			case "pdf": $jenisfail1="application/PDF"; break; 
			case "doc": $jenisfail1="application/msword"; break; 
			case "xls": $jenisfail1="application/vnd.ms-excel"; break; 
			case "docx": $jenisfail1="application/msword"; break; 
			case "txt": $jenisfail1="text/plain"; break; 
			case "ppt": $jenisfail1="application/vnd.ms-powerpoint"; break; 
	
			case "jpg": $jenisfail1="image/JPEG"; break; 
			case "jpeg": $jenisfail1="image/JPEG"; break; 
			case "png": $jenisfail1="image/PNG"; break; 
			case "gif": $jenisfail1="image/GIF"; break; default: 
			$jenisfail1="image/GIF";
		}

		$target = $upload_dir . basename($file_name); 
		if(move_uploaded_file($file_tmp, $target)) { 
			// echo "The file ". basename($file_tmp). " has been uploaded"; 
			$err='OK';
		} else { 
			// echo "Sorry, there was a problem uploading your file."; exit; 
			$err='ERR';
		}

		if($err=='OK'){ 
			// $cat = dlookup("appli","appli_type","id='{$appli_id}'");
			$appli_id = $rs->fields['id'];
			$sql = "INSERT INTO tbl_pemantauan_upload(pemantauan_id, type, title, file_name, ftype)";
			$sql .= " VALUES('{$pemantauan_id}', '{$type}', '{$title}', '{$file_name}', '{$jenisfail1}')";
			$rss = $conn->execute($sql);
		}

	} else if($pro=='DEL'){
		// $conn->debug=true;
		$lawat_id= addslashes(isset($_REQUEST["lawat_id"]))?$_REQUEST["lawat_id"]:"";

		$doc_name = dlookup("tbl_pemantauan_upload","file_name","id='{$lawat_id}'");
		$sql = "DELETE FROM tbl_pemantauan_upload WHERE id='{$lawat_id}'";
		$rss = $conn->execute($sql);

		if($rss){
			$upload_dir = '../upload_doc/'.$doc_name;
			unlink($upload_dir);
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