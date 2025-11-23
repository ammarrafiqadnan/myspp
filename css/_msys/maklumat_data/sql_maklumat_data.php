<?php
session_start();
include '../connection/common.php';
$frm=isset($_GET["frm"])?$_GET["frm"]:"";
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$date=date("Y-m-d H:i:s");
$oleh=$_SESSION['SESS_UID'];
// $conn->debug=true;


if($frm=='PASS'){
	
	if($pro=='SAVE'){
		$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
		$nama=isset($_REQUEST["nama"])?$_REQUEST["nama"]:"";
		$no_pengenalan=isset($_REQUEST["no_pengenalan"])?$_REQUEST["no_pengenalan"]:"";
		$warganegara=isset($_REQUEST["warganegara"])?$_REQUEST["warganegara"]:"";
		$pengalaman_tahun=isset($_REQUEST["pengalaman_tahun"])?$_REQUEST["pengalaman_tahun"]:"";
		$no_tel=isset($_REQUEST["no_tel"])?$_REQUEST["no_tel"]:"";
		$catatan=isset($_REQUEST["catatan"])?$_REQUEST["catatan"]:"";
		$status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";

		if(!empty($id)){
			$strSQL = "UPDATE tbl_penyembelih SET is_deleted=0 ";
			$strSQL .= ", nama=".tosql($nama).", no_pengenalan=".tosql($no_pengenalan).", warganegara=".tosql($warganegara).", pengalaman_tahun=".tosql($pengalaman_tahun); 
			$strSQL .= ", no_tel=".tosql($no_tel) . ", catatan=".tosql($catatan); //.", status=".tosql($status); 
			$strSQL .= ", update_dt='{$date}', update_by=".tosql($oleh);	
			$strSQL .= " WHERE id=".tosql($id);
			
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "KEMASKINI");

		} else {
			//$conn->debug=true;
			$strSQL = "INSERT INTO tbl_penyembelih(nama, no_pengenalan, warganegara, pengalaman_tahun, no_tel,  
				catatan, status, is_deleted, create_dt, create_by, update_dt, update_by) 
				VALUES(".tosql($nama).", ".tosql($no_pengenalan).", ".tosql($warganegara).",  ".tosql($pengalaman_tahun).", ".tosql($no_tel).", 
				".tosql($catatan).", ".tosql($status).", 0, ".tosql($date).", ".tosql($oleh).", ".tosql($date).", ".tosql($oleh).")";
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "TAMBAH");
			//$conn->debug=false;
		}
		//exit;
		if($rss){
			// KEMASKINI DATA DETAIL
			$err='OK';
		} else {
			$err='ERR'; 
		}
	
	} else if($pro=="DEL"){
	
		$ID=isset($_REQUEST["ID"])?$_REQUEST["ID"]:"";
		//$sqld = "DELETE FROM _ref_akta WHERE akta_id='{$akta_id}'";
		$sqld = "UPDATE tbl_penyembelih SET is_deleted=1, deleted_dt='{$date}', deleted_by=".tosql($oleh)." WHERE id='{$ID}'";
		$rss = $conn->execute($sqld);
		audit_trail($sqld, "HAPUS");
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	}		
} else if($frm=='PASS_DET'){
	// $conn->debug=true;
	if($pro=='SAVE'){
		$id_penyembelih=isset($_REQUEST["id_penyembelih"])?$_REQUEST["id_penyembelih"]:"";
		$id_det=isset($_REQUEST["id_det"])?$_REQUEST["id_det"]:"";

		$majikan_nossm=isset($_REQUEST["majikan_nossm"])?$_REQUEST["majikan_nossm"]:"";
		$majikan_nama=isset($_REQUEST["majikan_nama"])?$_REQUEST["majikan_nama"]:"";
		$majikan_alamat=isset($_REQUEST["majikan_alamat"])?$_REQUEST["majikan_alamat"]:"";
		$majikan_notel=isset($_REQUEST["majikan_notel"])?$_REQUEST["majikan_notel"]:"";
		$majikan_nofaks=isset($_REQUEST["majikan_nofaks"])?$_REQUEST["majikan_nofaks"]:"";
		
		$premis_nama=isset($_REQUEST["premis_nama"])?$_REQUEST["premis_nama"]:"";
		$premis_alamat=isset($_REQUEST["premis_alamat"])?$_REQUEST["premis_alamat"]:"";
		$premis_notel=isset($_REQUEST["premis_notel"])?$_REQUEST["premis_notel"]:"";
		$tarikh_sah_mula=isset($_REQUEST["tarikh_sah_mula"])?$_REQUEST["tarikh_sah_mula"]:"";
		$tarikh_sah_akhir=isset($_REQUEST["tarikh_sah_akhir"])?$_REQUEST["tarikh_sah_akhir"]:"";
		$no_sijil=isset($_REQUEST["no_sijil"])?$_REQUEST["no_sijil"]:"";
		$no_kad=isset($_REQUEST["no_kad"])?$_REQUEST["no_kad"]:"";
		$jenis=isset($_REQUEST["jenis"])?$_REQUEST["jenis"]:"";
		$status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";

		if(!empty($id_det)){
			$strSQL = "UPDATE tbl_penyembelih_detail SET is_deleted=0 ";
			$strSQL .= ", majikan_nossm=".tosql($majikan_nossm).", majikan_nama=".tosql($majikan_nama).", majikan_alamat=".tosql($majikan_alamat).", majikan_notel=".tosql($majikan_notel); 
			$strSQL .= ", majikan_nofaks=".tosql($majikan_nofaks) . ", premis_nama=".tosql($premis_nama).", premis_alamat=".tosql($premis_alamat).", premis_notel=".tosql($premis_notel); 
			$strSQL .= ", tarikh_sah_mula=".tosql($tarikh_sah_mula) . ", tarikh_sah_akhir=".tosql($tarikh_sah_akhir).", no_sijil=".tosql($no_sijil).", 
				no_kad=".tosql($no_kad).", status=".tosql($status); 
			$strSQL .= ", jenis=".tosql($jenis).", update_dt='{$date}', update_by=".tosql($oleh);	
			$strSQL .= " WHERE id_det=".tosql($id_det);
			
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "KEMASKINI");

		} else {
			//$conn->debug=true;
			$strSQL = "INSERT INTO tbl_penyembelih_detail(id_penyembelih, majikan_nossm, majikan_nama, majikan_alamat, majikan_notel, majikan_nofaks,  
				premis_nama, premis_alamat, premis_notel, tarikh_sah_mula, tarikh_sah_akhir, no_sijil, no_kad,
				jenis, is_deleted, create_dt, create_by, update_dt, update_by, status) 
				VALUES(".tosql($id_penyembelih).", ".tosql($majikan_nossm).", ".tosql($majikan_nama).",  ".tosql($majikan_alamat).", ".tosql($majikan_notel).", ".tosql($majikan_nofaks).",  
				".tosql($premis_nama).", ".tosql($premis_alamat).", ".tosql($premis_notel).", ".tosql($tarikh_sah_mula).", ".tosql($tarikh_sah_akhir).", ".tosql($no_sijil).", ".tosql($no_kad).", 
				".tosql($jenis).", 0, ".tosql($date).", ".tosql($oleh).", ".tosql($date).", ".tosql($oleh).", '{$status}')";
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "TAMBAH");
			//$conn->debug=false;
		}
		//exit;
		if($rss){
			$err='OK';
			if(!empty($status)){ 
				$strSQL = "UPDATE `tbl_penyembelih` SET `status`='{$status}' WHERE `id`=".tosql($id_penyembelih);
			} else {
				$strSQL = "UPDATE `tbl_penyembelih` SET `status`=0 WHERE `id`=".tosql($id_penyembelih);
			}
			$conn->execute($strSQL);
		} else {
			$err='ERR'; 
		}
	
	} else if($pro=="DEL"){
	
		$ID=isset($_REQUEST["ID"])?$_REQUEST["ID"]:"";
		//$sqld = "DELETE FROM _ref_akta WHERE akta_id='{$akta_id}'";
		$sqld = "UPDATE tbl_penyembelih_detail SET is_deleted=1, deleted_dt='{$date}', deleted_by=".tosql($oleh)." WHERE id_det='{$ID}'";
		$rss = $conn->execute($sqld);
		audit_trail($sqls, "HAPUS");
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	}		

} else if($frm=='PASS_INFO'){
	// $conn->debug=true;
	if($pro=='SAVE'){
		$dt=date("Y-m-d H:i:s");
		$by = '';
		$id_det=isset($_REQUEST["id_det"])?$_REQUEST["id_det"]:"";
		$id_penyembelih=isset($_REQUEST["id_penyembelih"])?$_REQUEST["id_penyembelih"]:"";
		$info_tarikh=isset($_REQUEST["info_tarikh"])?$_REQUEST["info_tarikh"]:"";
		$info_jenis=isset($_REQUEST["info_jenis"])?$_REQUEST["info_jenis"]:"";
		$info_kenyataan=isset($_REQUEST["info_kenyataan"])?$_REQUEST["info_kenyataan"]:"";

		if(empty($id_det)){
			$strSQL = "INSERT INTO tbl_penyembelih_info(penyembelih_id, info_tarikh, info_jenis, info_kenyataan, create_dt, create_by) 
			VALUES(".tosql($id_penyembelih).", ".tosql($info_tarikh).", ".tosql($info_jenis).", ".tosql($info_kenyataan).", ".tosql($dt).", ".tosql($by).")";
		} else {
			$strSQL = "UPDATE tbl_penyembelih_info SET info_tarikh=".tosql($info_tarikh).", info_jenis=".tosql($info_jenis).", info_kenyataan=".tosql($info_kenyataan).", 
			update_dt=".tosql($dt).", update_dt=".tosql($by)." WHERE id_pdetail='{$id_det}'";
		}

		$rss = $conn->execute($strSQL);
		audit_trail($strSQL, "TAMBAH");
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	} else if($pro=='DEL'){
		$id_det=isset($_REQUEST["id_det"])?$_REQUEST["id_det"]:"";
		$rss = $conn->execute("UPDATE tbl_penyembelih_info SET `is_deleted`=1 WHERE id_pdetail='{$id_det}'");
		
		audit_trail($strSQL, "TAMBAH");
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	}	

} else if($frm=='PLIK'){
	
	if($pro=='SAVE'){
		$plik_id=isset($_REQUEST["plik_id"])?$_REQUEST["plik_id"]:"";
		$plik_nama=isset($_REQUEST["plik_nama"])?$_REQUEST["plik_nama"]:"";
		$plik_pasport=isset($_REQUEST["plik_pasport"])?$_REQUEST["plik_pasport"]:"";
		$plik_warga=isset($_REQUEST["plik_warga"])?$_REQUEST["plik_warga"]:"";
		$plik_tlahir=isset($_REQUEST["plik_tlahir"])?$_REQUEST["plik_tlahir"]:"";
		$plik_notel=isset($_REQUEST["plik_notel"])?$_REQUEST["plik_notel"]:"";
		$plik_catatan=isset($_REQUEST["plik_catatan"])?$_REQUEST["plik_catatan"]:"";
		$plik_status=isset($_REQUEST["plik_status"])?$_REQUEST["plik_status"]:"";

		if(!empty($plik_id)){
			$strSQL = "UPDATE tbl_plik SET is_deleted=0 ";
			$strSQL .= ", plik_nama=".tosql($plik_nama).", plik_pasport=".tosql($plik_pasport).", plik_warga=".tosql($plik_warga).", plik_tlahir=".tosql($plik_tlahir); 
			$strSQL .= ", plik_notel=".tosql($plik_notel) . ", plik_catatan=".tosql($plik_catatan).", plik_status=".tosql($plik_status); 
			$strSQL .= ", update_dt='{$date}', update_by=".tosql($oleh);	
			$strSQL .= " WHERE plik_id=".tosql($plik_id);
			
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "KEMASKINI");

		} else {
			//$conn->debug=true;
			$strSQL = "INSERT INTO tbl_plik(plik_nama, plik_pasport, plik_warga, plik_tlahir, plik_notel,  
				plik_catatan, plik_status, is_deleted, create_dt, create_by, update_dt, update_by) 
				VALUES(".tosql($plik_nama).", ".tosql($plik_pasport).", ".tosql($plik_warga).",  ".tosql($plik_tlahir).", ".tosql($plik_notel).", 
				".tosql($plik_catatan).", ".tosql($plik_status).", 0, ".tosql($date).", ".tosql($oleh).", ".tosql($date).", ".tosql($oleh).")";
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "TAMBAH");
			//$conn->debug=false;
		}
		//exit;
		if($rss){
			// TINDAKAN RAHMAH - KATEGORI RAHMAH
			$err='OK';
		} else {
			$err='ERR'; 
		}
	
	} else if($pro=="DEL"){
	
		$ID=isset($_REQUEST["ID"])?$_REQUEST["ID"]:"";
		//$sqld = "DELETE FROM _ref_akta WHERE akta_id='{$akta_id}'";
		$sqld = "UPDATE tbl_plik SET is_deleted=1, deleted_dt='{$date}', deleted_by=".tosql($oleh)." WHERE plik_id='{$ID}'";
		$rss = $conn->execute($sqld);
		audit_trail($sqld, "HAPUS");
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	}	

} else if($frm=='PLIK_DET'){
	
	if($pro=='SAVE'){
		$plik_id=isset($_REQUEST["plik_id"])?$_REQUEST["plik_id"]:"";
		$plik_detid=isset($_REQUEST["plik_detid"])?$_REQUEST["plik_detid"]:"";

		$no_daftar_ssm=isset($_REQUEST["no_daftar_ssm"])?$_REQUEST["no_daftar_ssm"]:"";
		$nama_sekolah=isset($_REQUEST["nama_sekolah"])?$_REQUEST["nama_sekolah"]:"";
		$alamat=isset($_REQUEST["alamat"])?$_REQUEST["alamat"]:"";
		$nama_penganjur=isset($_REQUEST["nama_penganjur"])?$_REQUEST["nama_penganjur"]:"";
		$jawatan=isset($_REQUEST["jawatan"])?$_REQUEST["jawatan"]:"";
		
		$notel=isset($_REQUEST["notel"])?$_REQUEST["notel"]:"";
		$nofaks=isset($_REQUEST["nofaks"])?$_REQUEST["nofaks"]:"";
		$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
		$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";
		$jenis=isset($_REQUEST["jenis"])?$_REQUEST["jenis"]:"";
		$status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";

		if(!empty($plik_detid)){
			$strSQL = "UPDATE tbl_plik_detail SET is_deleted=0 ";
			$strSQL .= ", no_daftar_ssm=".tosql($no_daftar_ssm).", nama_sekolah=".tosql($nama_sekolah).", alamat=".tosql($alamat).", nama_penganjur=".tosql($nama_penganjur); 
			$strSQL .= ", jawatan=".tosql($jawatan) . ", notel=".tosql($notel).", nofaks=".tosql($nofaks).", tkh_mula=".tosql($tkh_mula); 
			$strSQL .= ", tkh_tamat=".tosql($tkh_tamat) . ", jenis=".tosql($jenis).", status='{$status}'"; 
			$strSQL .= ", update_dt='{$date}', update_by=".tosql($oleh);	
			$strSQL .= " WHERE plik_detid=".tosql($plik_detid);
			
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "KEMASKINI");

		} else {
			//$conn->debug=true;
			$strSQL = "INSERT INTO tbl_plik_detail(plik_id, no_daftar_ssm, nama_sekolah, alamat, nama_penganjur, jawatan,  
				notel, nofaks, tkh_mula, tkh_tamat, jenis, status, 
				is_deleted, create_dt, create_by, update_dt, update_by) 
				VALUES(".tosql($plik_id).", ".tosql($no_daftar_ssm).", ".tosql($nama_sekolah).",  ".tosql($alamat).", ".tosql($nama_penganjur).", ".tosql($jawatan).",  
				".tosql($notel).", ".tosql($nofaks).", ".tosql($tkh_mula).", ".tosql($tkh_tamat).", ".tosql($jenis).", '{$status}',  
				0, ".tosql($date).", ".tosql($oleh).", ".tosql($date).", ".tosql($oleh).")";
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "TAMBAH");
			//$conn->debug=false;
		}
		//exit;
		if($rss){
			$err='OK';
			if(!empty($status)){ 
				$strSQL = "UPDATE tbl_plik SET plik_status='{$status}' WHERE plik_id=".tosql($plik_id);
			} else {
				$strSQL = "UPDATE tbl_plik SET plik_status=0 WHERE plik_id=".tosql($plik_id);
			}
			$conn->execute($strSQL);
		} else {
			$err='ERR'; 
		}
	
	} else if($pro=="DEL"){
	
		$ID=isset($_REQUEST["ID"])?$_REQUEST["ID"]:"";
		//$sqld = "DELETE FROM _ref_akta WHERE akta_id='{$akta_id}'";
		$sqld = "UPDATE tbl_plik_detail SET status=1, is_deleted=1, deleted_dt='{$date}', deleted_by=".tosql($oleh)." WHERE plik_detid='{$ID}'";
		$rss = $conn->execute($sqld);
		audit_trail($sqld, "HAPUS");
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	}		

} else if($frm=='PLIK_INFO'){
	// $conn->debug=true;
	if($pro=='SAVE'){
		$dt=date("Y-m-d H:i:s");
		$by = '';
		$id_det=isset($_REQUEST["id_det"])?$_REQUEST["id_det"]:"";
		$plik_id=isset($_REQUEST["plik_id"])?$_REQUEST["plik_id"]:"";
		$info_tarikh=isset($_REQUEST["info_tarikh"])?$_REQUEST["info_tarikh"]:"";
		$info_jenis=isset($_REQUEST["info_jenis"])?$_REQUEST["info_jenis"]:"";
		$info_kenyataan=isset($_REQUEST["info_kenyataan"])?$_REQUEST["info_kenyataan"]:"";

		if(empty($id_det)){
			$strSQL = "INSERT INTO tbl_plik_info(plik_id, info_tarikh, info_jenis, info_kenyataan, create_dt, create_by) 
			VALUES(".tosql($plik_id).", ".tosql($info_tarikh).", ".tosql($info_jenis).", ".tosql($info_kenyataan).", ".tosql($dt).", ".tosql($by).")";
		} else {
			$strSQL = "UPDATE tbl_plik_info SET info_tarikh=".tosql($info_tarikh).", info_jenis=".tosql($info_jenis).", info_kenyataan=".tosql($info_kenyataan).", 
			update_dt=".tosql($dt).", update_dt=".tosql($by)." WHERE id_pdetail='{$id_det}'";
		}

		$rss = $conn->execute($strSQL);
		audit_trail($strSQL, "TAMBAH");
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	} else if($pro=='DEL'){
		$id_det=isset($_REQUEST["id_det"])?$_REQUEST["id_det"]:"";
		$rss = $conn->execute("UPDATE tbl_plik_info SET `is_deleted`=1 WHERE id_pdetail='{$id_det}'");
		
		audit_trail($strSQL, "TAMBAH");
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	}

} else if($frm=='PASS_ADD'){
	// $conn->debug=true;
	$no_id=isset($_REQUEST["no_id"])?$_REQUEST["no_id"]:"";

	$rs = $conn->query("SELECT id FROM `tbl_penyembelih` WHERE `no_pengenalan`='{$no_id}'");
	// $rs = $conn->query($sql);

	if(!$rs->EOF){
		// ADA REKOD
		$href = "index.php?data=". base64_encode('maklumat_data/pass_form;DATA;Maklumat Pemegang Pas Sembelihan;;;'.$rs->fields['id']);
		$err="OK:".$href;
	} else {
		// TIADA REKOD
		$strSQL = "INSERT INTO `tbl_penyembelih`(`no_pengenalan`) VALUES('{$no_id}')";
		$rss = $conn->execute($strSQL);
		audit_trail($strSQL, "TAMBAH");
		$rs = $conn->query("SELECT id FROM `tbl_penyembelih` WHERE `no_pengenalan`='{$no_id}'");

		$href = "index.php?data=". base64_encode('maklumat_data/pass_form;DATA;Maklumat Pemegang Pas Sembelihan;;;'.$rs->fields['id']);
		$err='ERR:'.$href; 

	}

} else if($frm=='PLIK_ADD'){
	// $conn->debug=true;
	$no_pasport=isset($_REQUEST["no_pasport"])?$_REQUEST["no_pasport"]:"";

	$rs = $conn->query("SELECT `plik_id` FROM `tbl_plik` WHERE `plik_pasport`='{$no_pasport}'");
	// $rs = $conn->query($sql);

	if(!$rs->EOF){
		// ADA REKOD
		$href = "index.php?data=". base64_encode('maklumat_data/plik_form;DATA;Maklumat Pemegang Pas Lawatan Ikhtisas;;;'.$rs->fields['plik_id']);
		$err="OK:".$href;
	} else {
		// TIADA REKOD
		$strSQL = "INSERT INTO `tbl_plik`(`plik_pasport`) VALUES('{$no_pasport}')";
		$rss = $conn->execute($strSQL);
		audit_trail($strSQL, "TAMBAH");
		$rs = $conn->query("SELECT `plik_id` FROM `tbl_plik` WHERE `plik_pasport`='{$no_pasport}'");

		$href = "index.php?data=". base64_encode('maklumat_data/plik_form;DATA;Maklumat Pemegang Pas Lawatan Ikhtisas;;;'.$rs->fields['plik_id']);
		$err='ERR:'.$href; 

	}

}

// header("Content-Type: text/json");
// print json_encode($err); 
print $err;
?>
