<?php
session_start();
include '../connection/common.php';
$frm=isset($_GET["frm"])?$_GET["frm"]:"";
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$act=isset($_GET["act"])?$_GET["act"]:"";
$date=date("Y-m-d H:i:s");
$oleh=$_SESSION['SESS_UID'];
// $conn->debug=true;


if($frm=='ISU_AKHBAR'){
	
	if($pro=='SAVE'){
		$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
		$tarikh=isset($_REQUEST["tarikh"])?$_REQUEST["tarikh"]:"";
		$tajuk=isset($_REQUEST["tajuk"])?$_REQUEST["tajuk"]:"";
		$akhbar=isset($_REQUEST["akhbar"])?$_REQUEST["akhbar"]:"";
		$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
		$alamat_url=isset($_REQUEST["alamat_url"])?$_REQUEST["alamat_url"]:"";

		$minggu_bulan = weekOfMonth($tarikh);
		$minggu_tahun =  date("W", strtotime($tarikh));
				
		if(!empty($id)){
			$strSQL = "UPDATE tbl_isu_agama SET is_deleted=0 ";
			$strSQL .= ", tarikh=".tosql($tarikh).", tajuk=".tosql($tajuk).", akhbar_id=".tosql($akhbar).", kategori_id=".tosql($kategori).", alamat_url=".tosql($alamat_url);  
			$strSQL .= ", minggu_bulan=".tosql($minggu_bulan).", minggu_tahun=".tosql($minggu_tahun).", update_dt='{$date}', update_by=".tosql($oleh);	
			$strSQL .= " WHERE id=".tosql($id);
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "KEMASKINI");

		} else {
			$strSQL = "INSERT INTO tbl_isu_agama(tarikh, tajuk, akhbar_id, kategori_id, alamat_url, minggu_bulan, minggu_tahun, 
				is_deleted, create_dt, create_by, update_dt, update_by) 
				VALUES(".tosql($tarikh).", ".tosql($tajuk).", ".tosql($akhbar).", ".tosql($kategori).", ".tosql($alamat_url).", ".tosql($minggu_bulan).", ".tosql($minggu_tahun).", 
				0, ".tosql($date).", ".tosql($oleh).", ".tosql($date).", ".tosql($oleh).")";
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
		$sqld = "UPDATE tbl_isu_agama SET is_deleted=1, deleted_dt='{$date}', deleted_by=".tosql($oleh)." WHERE id='{$ID}'";
		$rss = $conn->execute($sqld);
			audit_trail($sqld, "HAPUS");

		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	}		
} else if($frm=='ISU_AKIDAH'){
	// $conn->debug=true;
	if($pro=='SAVE'){
		$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
		$tarikh=isset($_REQUEST["tarikh"])?$_REQUEST["tarikh"]:"";
		$minggu=isset($_REQUEST["minggu"])?$_REQUEST["minggu"]:"";
		$subtopik_id=isset($_REQUEST["subtopik_id"])?$_REQUEST["subtopik_id"]:"";
		$sub_topik=isset($_REQUEST["sub_topik"])?$_REQUEST["sub_topik"]:"";
		$carian_oleh=isset($_REQUEST["carian_oleh"])?$_REQUEST["carian_oleh"]:"";
		$carian_sumber=isset($_REQUEST["carian_sumber"])?$_REQUEST["carian_sumber"]:"";
		$kenyataan=isset($_REQUEST["kenyataan"])?$_REQUEST["kenyataan"]:"";
		$ulasan=isset($_REQUEST["ulasan"])?$_REQUEST["ulasan"]:"";

		$topik_id = dlookup("`_ref_topik_sub`","topik_id","`subtopik_id`='{$subtopik_id}'");
				
		if(!empty($id)){
			$strSQL = "UPDATE tbl_isuakidah SET is_deleted=0 ";
			$strSQL .= ", tarikh=".tosql($tarikh).", minggu=".tosql($minggu).", topik_id=".tosql($topik_id).", subtopik_id=".tosql($subtopik_id).", sub_topik=".tosql($sub_topik); 
			$strSQL .= ", carian_oleh=".tosql($carian_oleh).", carian_sumber=".tosql($carian_sumber).", kenyataan=".tosql($kenyataan).", ulasan=".tosql($ulasan); 
			$strSQL .= ", update_dt='{$date}', update_by=".tosql($oleh);	
			$strSQL .= " WHERE id=".tosql($id);
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "KEMASKINI");

		} else {
			$strSQL = "INSERT INTO tbl_isuakidah(tarikh, minggu, topik_id, subtopik_id, sub_topik, carian_oleh, carian_sumber, kenyataan, ulasan, 
				is_deleted, create_dt, create_by, update_dt, update_by) 
				VALUES(".tosql($tarikh).", ".tosql($minggu).", ".tosql($topik_id).", ".tosql($subtopik_id).", ".tosql($sub_topik).", 
				".tosql($carian_oleh).", ".tosql($carian_sumber).", ".tosql($kenyataan).", ".tosql($ulasan).", 
				0, ".tosql($date).", ".tosql($oleh).", ".tosql($date).", ".tosql($oleh).")";
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
		$sqld = "UPDATE tbl_isuakidah SET is_deleted=1, deleted_dt='{$date}', deleted_by=".tosql($oleh)." WHERE id='{$ID}'";
		$rss = $conn->execute($sqld);
		audit_trail($sqld, "HAPUS");
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	}		

} else if($frm=='ISU_MEDIA'){
	// $conn->debug=true;
	if($pro=='SAVE'){
		$IDS = '';
		$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
		$tarikh=isset($_REQUEST["tarikh"])?$_REQUEST["tarikh"]:"";
		$minggu=isset($_REQUEST["minggu"])?$_REQUEST["minggu"]:"";
		$kluster_id=isset($_REQUEST["kluster_id"])?$_REQUEST["kluster_id"]:"";
		$isu=isset($_REQUEST["isu"])?$_REQUEST["isu"]:"";
		$syor=isset($_REQUEST["syor"])?$_REQUEST["syor"]:"";


		$medium=isset($_REQUEST["medium"])?$_REQUEST["medium"]:"";
		$massa=isset($_REQUEST["massa"])?$_REQUEST["massa"]:"";
		$links=isset($_REQUEST["links"])?$_REQUEST["links"]:"";
		$kekerapan=isset($_REQUEST["kekerapan"])?$_REQUEST["kekerapan"]:"";

		// print_r($medium);
		// print_r($massa);
		// print_r($links);
		// print_r($kekerapan);
				
		if(!empty($id)){
			$IDS=$id;
			$strSQL = "UPDATE tbl_hinaagama SET is_deleted=0 ";
			$strSQL .= ", tarikh=".tosql($tarikh).", minggu=".tosql($minggu).", kluster_id=".tosql($kluster_id).", isu=".tosql($isu).", syor=".tosql($syor); 
			$strSQL .= ", update_dt='{$date}', update_by=".tosql($oleh);	
			$strSQL .= " WHERE id=".tosql($id);
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "KEMASKINI");

		} else {
			$IDS='';
			$strSQL = "INSERT INTO tbl_hinaagama(tarikh, minggu, kluster_id, isu, syor, is_deleted, create_dt, create_by, update_dt, update_by) 
				VALUES(".tosql($tarikh).", ".tosql($minggu).", ".tosql($kluster_id).", ".tosql($isu).", ".tosql($syor).", 0, ".tosql($date).", ".tosql($oleh).", ".tosql($date).", ".tosql($oleh).")";
			$rss = $conn->execute($strSQL);
			audit_trail($strSQL, "TAMBAH");
			//$conn->debug=false;
		}
		//exit;
		if($rss){
			// $conn->debug=true;
			// TINDAKAN RAHMAH - KATEGORI RAHMAH
			if(empty($IDS)){
				$id = dlookup("`tbl_hinaagama`","id","`create_dt`='{$date}' AND `tarikh`='{$tarikh}' AND `kluster_id`='{$kluster_id}'");
			}
			// $conn->debug=true;
			// print "S:".sizeof($medium)."<br>";
			if(!empty($massa)){ 
				$bm = 0;
				foreach($massa as $item){
					//print $item;
					$link = $links[$bm];
					$nilai = $kekerapan[$bm];
					// print $item.":".$link.":".$nilai;
					$rsDet = $conn->query("SELECT * FROM `tbl_hinaagama_media` WHERE `id_hinaagama`='{$id}' AND `id_media`='{$item}'");
					if(!$rsDet->EOF){
						$idsm = $rsDet->fields['id'];
						if(empty($link) && empty($nilai)){
							$conn->execute("DELETE FROM `tbl_hinaagama_media` WHERE `id`='{$idsm}'");
						} else {
							$conn->execute("UPDATE `tbl_hinaagama_media` SET `links`='{$link}', `kekerapan`='{$nilai}' WHERE `id`='{$idsm}'");
						}
					} else {
						if(!empty($link) || !empty($nilai)){
							if(!empty($id) && !empty($item))
							$conn->execute("INSERT INTO `tbl_hinaagama_media`(`id_hinaagama`, `id_media`, `links`, `kekerapan`) VALUES('{$id}', '{$item}', '{$link}', '{$nilai}')");
						}
					}
					$bm++;
				}
			}
			$err='OK';
		} else {
			$err='ERR'; 
		}
	
	} else if($pro=="DEL"){
	
		$ID=isset($_REQUEST["ID"])?$_REQUEST["ID"]:"";
		//$sqld = "DELETE FROM _ref_akta WHERE akta_id='{$akta_id}'";
		$sqld = "UPDATE `tbl_hinaagama` SET `is_deleted`=1, `deleted_dt`='{$date}', `deleted_by`=".tosql($oleh)." WHERE id='{$ID}'";
		$rss = $conn->execute($sqld);
		audit_trail($sqld, "HAPUS");
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	}		
} else if($frm=='ULASAN'){


}

header("Content-Type: text/json");
print json_encode($err); 
?>