<?php
session_start();
if(file_exists('../connection/common.php')){
	include '../connection/common.php';
} else {
	include '../../connection/common.php';
}
$frm=isset($_GET["frm"])?$_GET["frm"]:"";
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$date=date("Y-m-d H:i:s");
//$oleh=$_SESSION['SESS_UID'];
// $conn->debug=true;

function get_user($conn, $uid){
	//$conn->debug=true;
	global $schema2;
	$sql = "SELECT * FROM $schema2.`myid` WHERE `id_pemohon`=".tosql($uid);
	$rs = $conn->query($sql);
	$data = array();
	// $columns[] = $data;
	
	$data = array('ICNo'=> $rs->fields['ICNo'], 'ic_ind'=> $rs->fields['ic_ind'], 'MyID'=> $rs->fields['MyID'], 
	'id_pemohon'=> $rs->fields['id_pemohon'], 'nama'=> $rs->fields['nama'], 'addr1'=> $rs->fields['addr1'], 'addr2'=> $rs->fields['addr2'], 'addr3'=> $rs->fields['addr3'], 'poskod'=> $rs->fields['poskod'], 'bandar'=> $rs->fields['bandar'], 'negeri'=> $rs->fields['negeri'], 'no_tel'=> $rs->fields['no_tel'], 'e_mail'=> $rs->fields['e_mail'], 'katalaluan'=> $rs->fields['katalaluan'], 'kod_keselamatan'=> $rs->fields['kod_keselamatan'], 'neg_keselamatan'=> $rs->fields['neg_keselamatan']); 

	$rss = $conn->query("SELECT * FROM $schema2.`calon` WHERE `id_pemohon`=".tosql($rs->fields['id_pemohon']));
	if($rss->EOF){
	
		$sql = "INSERT INTO $schema2.`calon` (`id_pemohon`, `ICNo`, `jenis_id`, `nama_penuh`, `no_tel`, `e_mail`, `d_cipta`)";
		$sql .= " VALUES(".tosql($uid).", ".tosql($rs->fields['ICNo']).", 'A', ".tosql($rs->fields['nama']).", ".tosql($rs->fields['no_tel']).", 
			".tosql($rs->fields['e_mail']).", ".tosql(date("Y-m-d H:i:s")).")";
		$conn->execute($sql);	

	}

	return $data;
}

function get_biodata($conn, $uid){
	//$conn->debug=true;
	global $schema2;
	$sql = "SELECT * FROM $schema2.`calon` WHERE `id_pemohon`=".tosql($uid);
	$rs = $conn->query($sql);
	$data = array();
	// $columns[] = $data;
	
	$data = array('id_pemohon'=> $rs->fields['id_pemohon'], 'jenis_id'=> $rs->fields['jenis_id'], 'nama_penuh'=> $rs->fields['nama_penuh'], 
	'dob'=> $rs->fields['dob'], 'addr1'=> $rs->fields['addr1'], 'addr2'=> $rs->fields['addr2'], 'addr3'=> $rs->fields['addr3'], 'poskod'=> $rs->fields['poskod'], 'bandar'=> $rs->fields['bandar'], 'negeri'=> $rs->fields['negeri'], 'no_tel'=> $rs->fields['no_tel'], 'e_mail'=> $rs->fields['e_mail'], 'negeri_lahir_pemohon'=> $rs->fields['negeri_lahir_pemohon'], 'negeri_lahir_ibu'=> $rs->fields['negeri_lahir_ibu'], 'negeri_lahir_bapa'=> $rs->fields['negeri_lahir_bapa'], 'jantina'=> $rs->fields['jantina'], 'agama'=> $rs->fields['agama'], 'keturunan'=> $rs->fields['keturunan'], 'warganegara'=> $rs->fields['warganegara'], 'lesen_kenderaan'=> $rs->fields['lesen_kenderaan'], 'taraf_kawin'=> $rs->fields['taraf_kawin'], 'ketinggian'=> $rs->fields['ketinggian'], 'berat'=> $rs->fields['berat'], 'masih_khidmat'=> $rs->fields['masih_khidmat'], 'oku'=> $rs->fields['oku'], 'no_rujukan_oku'=> $rs->fields['no_rujukan_oku'], 'bantuan'=> $rs->fields['bantuan'], 'no_rujukan_bantuan'=> $rs->fields['no_rujukan_bantuan']); 

	return $data;
}

function get_profesional($conn, $uid){
	//$conn->debug=true;
	global $schema2;
	$sql = "SELECT * FROM $schema2.`calon` WHERE `id_pemohon`=".tosql($uid);
	$rs = $conn->query($sql);
	$data = array();
	// $columns[] = $data;
	
	$data = array('id_pemohon'=> $rs->fields['id_pemohon'], 
		'professional_1'=> $rs->fields['professional_1'], 'professional_d_1'=> $rs->fields['professional_d_1'], 
		'professional_no_ahli_1'=> $rs->fields['professional_no_ahli_1'], ); 

	return $data;
}

function get_khidmat_awam($conn, $uid){
	//$conn->debug=true;
	global $schema2;
	$sql = "SELECT * FROM $schema2.`calon_masih_khidmat` WHERE `id_pemohon`=".tosql($uid);
	$rs = $conn->query($sql);
	$data = array();
	// $columns[] = $data;
	
	$data = array('jenis_perkhidmatan'=> $rs->fields['jenis_perkhidmatan'], 'taraf_jawatan'=> $rs->fields['taraf_jawatan'], 
		'd_lantikan_jpa'=> $rs->fields['d_lantikan_jpa'], 'd_lantikan_kontrak'=> $rs->fields['d_lantikan_kontrak'], 
		'skim_sekarang'=> $rs->fields['skim_sekarang'], 'skim_sekarang_jika_tiada'=> $rs->fields['skim_sekarang_jika_tiada'], 
		'd_lantikan_khidmat_sekarang'=> $rs->fields['d_lantikan_khidmat_sekarang'], 'd_sah_khidmat_sekarang'=> $rs->fields['d_sah_khidmat_sekarang'], 
		'gred_jawatan_sekarang'=> $rs->fields['gred_jawatan_sekarang'], 'tpt_bertugas'=> $rs->fields['tpt_bertugas'], 
		'tpt_bertugas_jika_tiada'=> $rs->fields['tpt_bertugas_jika_tiada'], 'negeri_tpt_bertugas'=> $rs->fields['negeri_tpt_bertugas'], 
		'd_lulus_kpsl'=> $rs->fields['d_lulus_kpsl'], 'jenis_xm'=> $rs->fields['jenis_xm'], 'jenis_xm_jika_tiada'=> $rs->fields['jenis_xm_jika_tiada'], 
		'd_cipta'=> $rs->fields['d_cipta'], 'd_kemaskini'=> $rs->fields['d_kemaskini']); 

	return $data;
}

function get_gambar($conn, $uid){
	//$conn->debug=true;
	global $schema2;
	$sql = "SELECT * FROM $schema2.`calon_gambar` WHERE `id_pemohon`=".tosql($uid);
	$rs = $conn->query($sql);
	$data = array();
	// $columns[] = $data;
	
	$data = array('gambar'=> $rs->fields['gambar']); 

	return $data;
}

function get_negeri($conn, $kods){
	global $schema2;
	//$conn->debug=true;
	$sql = "SELECT * FROM $schema2.`ref_negeri` WHERE 1";
	$rs = $conn->query($sql);
	$data='';
	while(!$rs->EOF){
		$data .= '<option value="'.$rs->fields['kod'].'"';
		if($rs->fields['kod']==$kods){ $data .= " selected"; }
		$data .= '>'.$rs->fields['diskripsi'].'</option>';
		$rs->movenext();
	}

	return $data;

}


function get_bandar($conn, $kods, $neg){
	global $schema1;
	$conn->debug=true;
	$sql = "SELECT * FROM $schema1.`ref_poskod` WHERE kod_negeri=".tosql($neg)." GROUP BY `kod_negeri`, `bandar`";
	$rs = $conn->query($sql);
	$data='';
	while(!$rs->EOF){
		$data .= '<option value="'.$rs->fields['bandar'].'"';
		if($rs->fields['bandar']==$kods){ $data .= " selected"; }
		$data .= '>'.$rs->fields['bandar'].'</option>';
		$rs->movenext();
	}

	return $data;

}

function get_perkahwinan($conn, $kods){
	global $schema2;
	//$conn->debug=true;
	// $sql = "SELECT * FROM $schema2.`ref_negeri` WHERE 1";
	// $rs = $conn->query($sql);
	// $data='';
	// while(!$rs->EOF){
	// 	$data .= '<option value="'.$rs->fields['kod'].'"';
	// 	if($rs->fields['kod']==$kods){ $data .= " selected"; }
	// 	$data .= '>'.$rs->fields['diskripsi'].'</option>';
	// 	$rs->movenext();
	// }

		$data .= '<option value="B"';
		if($kods=='B'){ $data .= " selected"; }
		$data .= '>Bujang</option>';

		$data .= '<option value="K"';
		if($kods=='K'){ $data .= " selected"; }
		$data .= '>Berkahwin</option>';

		$data .= '<option value="J"';
		if($kods=='J'){ $data .= " selected"; }
		$data .= '>Janda</option>';

		$data .= '<option value="D"';
		if($kods=='D'){ $data .= " selected"; }
		$data .= '>Duda</option>';

	return $data;
}

function get_perkhidmatan($conn, $kods){
	global $schema1;
	//$conn->debug=true;
	$sql = "SELECT * FROM $schema1.`ref_jenis_perkhidmatan` WHERE 1";
	$rs = $conn->query($sql);
	$data='';
	while(!$rs->EOF){
		$data .= '<option value="'.$rs->fields['KOD'].'"';
		if($rs->fields['KOD']==$kods){ $data .= " selected"; }
		$data .= '>'.$rs->fields['DISKRIPSI'].'</option>';
		$rs->movenext();
	}

	return $data;
}

function get_oku($conn, $kods){
	global $schema1;
	//$conn->debug=true;
	$sql = "SELECT * FROM $schema1.`ref_kecacatan_calon` WHERE 1";
	$rs = $conn->query($sql);
	$data='';
	while(!$rs->EOF){
		$data .= '<option value="'.$rs->fields['KOD'].'"';
		if($rs->fields['KOD']==$kods){ $data .= " selected"; }
		$data .= '>'.$rs->fields['DISKRIPSI'].'</option>';
		$rs->movenext();
	}

	return $data;
}

function get_bantuan($conn, $kods){
	global $schema1;
	//$conn->debug=true;
	$sql = "SELECT * FROM $schema1.`ref_bantuan` WHERE 1";
	$rs = $conn->query($sql);
	$data='';
	while(!$rs->EOF){
		$data .= '<option value="'.$rs->fields['kod_bantuan'].'"';
		if($rs->fields['kod_bantuan']==$kods){ $data .= " selected"; }
		$data .= '>'.$rs->fields['bantuan'].'</option>';
		$rs->movenext();
	}

	return $data;
}

function get_taraf_jawatan($conn, $kods){
	global $schema1;
	//$conn->debug=true;
	$sql = "SELECT * FROM $schema1.`ref_taraf_jawatan` WHERE `SAH_YT`='Y'";
	$rs = $conn->query($sql);
	$data='';
	while(!$rs->EOF){
		$data .= '<option value="'.$rs->fields['KOD'].'"';
		if($rs->fields['KOD']==$kods){ $data .= " selected"; }
		$data .= '>'.$rs->fields['DISKRIPSI'].'</option>';
		$rs->movenext();
	}

	return $data;
}

function get_skim($conn, $kods){
	global $schema1;
	//$conn->debug=true;
	$sql = "SELECT KOD, DISKRIPSI FROM $schema1.`ref_skim` WHERE `SAH_YT`='Y' AND GAB_YT='T' AND GGH_KOD IS NOT NULL AND GGH_KOD<>'' ORDER BY DISKRIPSI";
	$rs = $conn->query($sql);
	$data='';
	while(!$rs->EOF){
		$data .= '<option value="'.$rs->fields['KOD'].'"';
		if($rs->fields['KOD']==$kods){ $data .= " selected"; }
		$data .= '>'.$rs->fields['DISKRIPSI'].'</option>';
		$rs->movenext();
	}

	return $data;
}

function get_gred_jawatan($conn, $kods, $skim){
	global $schema1;

	$rsD = $conn->query("SELECT B.`DISKRIPSI` FROM $schema1.`ref_skim` A, $schema1.`ref_gred_gaji` B WHERE A.=`GGH_KOD`=B.`KOD` AND A.`KOD`='{$skim}'");
	$decs = $rsD->fields['DISKRIPSI'];
	// $conn->debug=true;
	// $sql = "SELECT KOD FROM $schema1.`ref_gred_gaji` WHERE `SAH_YT`='Y' AND GAB_YT='T' AND KOD IS NOT NULL ORDER BY KOD";
	$sql = "SELECT KOD FROM $schema1.`ref_gred_gaji` WHERE `SAH_YT`='Y' AND GAB_YT='T' AND `DISKRIPSI` IN ('{$desc}') AND KOD IS NOT NULL ORDER BY KOD";
	$rs = $conn->query($sql);
	$data='';
	while(!$rs->EOF){
		$data .= '<option value="'.$rs->fields['KOD'].'"';
		if($rs->fields['KOD']==$kods){ $data .= " selected"; }
		$data .= '>'.$rs->fields['KOD'].'</option>';
		$rs->movenext();
	}

	return $data;
}

function get_kementerian($conn, $kods){
	global $schema1;
	//$conn->debug=true;
	$sql = "SELECT KOD, DISKRIPSI FROM $schema1.`ref_kem_jabatan` WHERE DISKRIPSI IS NOT NULL ORDER BY KOD";
	$rs = $conn->query($sql);
	$data='';
	while(!$rs->EOF){
		$data .= '<option value="'.$rs->fields['KOD'].'"';
		if($rs->fields['KOD']==$kods){ $data .= " selected"; }
		$data .= '>'.$rs->fields['DISKRIPSI'].'</option>';
		$rs->movenext();
	}

	return $data;
}

function get_agama($conn, $kods){
	global $schema1;
	//$conn->debug=true;
	$sql = "SELECT * FROM $schema1.`ref_agama` ORDER BY kod_agama";
	$rs = $conn->query($sql);
	$data='';
	while(!$rs->EOF){
		$data .= '<option value="'.$rs->fields['kod_agama'].'"';
		if($rs->fields['kod_agama']==$kods){ $data .= " selected"; }
		$data .= '>'.$rs->fields['agama'].'</option>';
		$rs->movenext();
	}

	return $data;
}


function get_sijil_pro($conn, $kods){
	global $schema1;
	//$conn->debug=true;
	$sql = "SELECT KOD, DISKRIPSI FROM $schema1.`ref_kelulusan` WHERE KATEGORI='P' AND JENIS=1 AND DISKRIPSI IS NOT NULL ORDER BY DISKRIPSI";
	$rs = $conn->query($sql);
	$data='';
	while(!$rs->EOF){
		$data .= '<option value="'.$rs->fields['KOD'].'"';
		if($rs->fields['KOD']==$kods){ $data .= " selected"; }
		$data .= '>'.$rs->fields['DISKRIPSI'].'</option>';
		$rs->movenext();
	}

	return $data;
}

if($frm=='BIODATA'){
	// $conn->debug=true;
	if($pro=='SAVE'){
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$addr1=isset($_REQUEST["addr1"])?$_REQUEST["addr1"]:"";
		$addr2=isset($_REQUEST["addr2"])?$_REQUEST["addr2"]:"";
		$addr3=isset($_REQUEST["addr3"])?$_REQUEST["addr3"]:"";
		$poskod=isset($_REQUEST["poskod"])?$_REQUEST["poskod"]:"";
		$negeri=isset($_REQUEST["negeri"])?$_REQUEST["negeri"]:"";
		$bandar=isset($_REQUEST["bandar"])?$_REQUEST["bandar"]:"";
		$e_mail=isset($_REQUEST["e_mail"])?$_REQUEST["e_mail"]:"";
		$no_tel=isset($_REQUEST["no_tel"])?$_REQUEST["no_tel"]:"";
		$negeri_lahir_pemohon=isset($_REQUEST["negeri_lahir_pemohon"])?$_REQUEST["negeri_lahir_pemohon"]:"";
		$taraf_kawin=isset($_REQUEST["taraf_kawin"])?$_REQUEST["taraf_kawin"]:"";
		$negeri_lahir_ibu=isset($_REQUEST["negeri_lahir_ibu"])?$_REQUEST["negeri_lahir_ibu"]:"";
		$ketinggian=isset($_REQUEST["ketinggian"])?$_REQUEST["ketinggian"]:"";
		$berat=isset($_REQUEST["berat"])?$_REQUEST["berat"]:"";
		$negeri_lahir_bapa=isset($_REQUEST["negeri_lahir_bapa"])?$_REQUEST["negeri_lahir_bapa"]:"";
		$lesen_kenderaan=isset($_REQUEST["lesen_kenderaan"])?$_REQUEST["lesen_kenderaan"]:"";
		$masih_khidmat=isset($_REQUEST["masih_khidmat"])?$_REQUEST["masih_khidmat"]:"";
		$jantina=isset($_REQUEST["jantina"])?$_REQUEST["jantina"]:"";
		$agama=isset($_REQUEST["agama"])?$_REQUEST["agama"]:"";
		$dob=isset($_REQUEST["dob"])?$_REQUEST["dob"]:"";

		$oku=isset($_REQUEST["oku"])?$_REQUEST["oku"]:"";
		$no_rujukan_oku=isset($_REQUEST["no_rujukan_oku"])?$_REQUEST["no_rujukan_oku"]:"";

		$bantuan=isset($_REQUEST["bantuan"])?$_REQUEST["bantuan"]:"";
		$no_rujukan_bantuan=isset($_REQUEST["no_rujukan_bantuan"])?$_REQUEST["no_rujukan_bantuan"]:"";

		$lesen_kenderaan = str_replace(",", "-", $lesen_kenderaan);

		// print "UPL:".$_FILES['fileupload']['name'];
		//$sijil_pmr=isset($_REQUEST["sijil_pmr"])?$_REQUEST["sijil_pmr"]:"";
		if(!empty($_FILES['fileupload']['name'])){ 
			// $conn->debug=true;
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif','pdf'); // valid extensions
	        $path = '../../uploads_doc/'.$id_pemohon.'/'; // upload directory
	        if (file_exists($path)) {
	            $path = $path;
	        } else {
	            mkdir($path);
	            $path = '../../uploads_doc/'.$id_pemohon.'/';
	        }

	        $img = $_FILES['fileupload']['name'];
	        $tmp = $_FILES['fileupload']['tmp_name'];
	        
	        $ext = end((explode(".", $img))); 
	        // $fname = $img; //$id.".".$ext;
	        // $fname = str_replace(" ", "_", $fname);
	        // $fname = str_replace("-", "_", $fname);

	        // $final_image = "docSenaraiSemak_D3_1_".$appli_id2."_".$item_id.".".$ext;
	        // $final_image = rand(1000,1000000)."_".$fname;
	        $final_image = strtolower($id_pemohon.".".$ext);
	        $sijil_size = $_FILES['fileupload']['size'];
	        $sijil_type = $_FILES['fileupload']['type'];
			// check's valid format
			// $conn->debug=true;
			if(in_array($ext, $valid_extensions)){ 
				$path = $path.strtolower($final_image); 
				// print "n:".$path.'>'.$tmp; exit();
				move_uploaded_file($tmp,$path);
				// $err = $path;
				$dt = date("Y-m-d H:i:s");
				$rs = $conn->query("SELECT * FROM $schema2.`calon_gambar` WHERE `id_pemohon`=".tosql($id_pemohon));
				if($rs->EOF){ 
					$sqlu = "INSERT INTO $schema2.`calon_gambar`(`id_pemohon`, `gambar`, `create_dt`, `update_dt`) 
					VALUES('{$id_pemohon}', '{$final_image}', '{$dt}', '{$dt}')";
				} else {
					$sqlu = "UPDATE $schema2.`calon_gambar` SET `gambar`=".tosql($final_image)." WHERE `id_pemohon`=".tosql($id_pemohon);
				}
				$rsn = $conn->execute($sqlu);		
			}
		}

		$strSQL = "UPDATE $schema2.`calon` SET ";
		$strSQL .= "addr1=".tosql($addr1).", addr2=".tosql($addr2).", addr3=".tosql($addr3).", poskod=".tosql($poskod); 
		$strSQL .= ", negeri=".tosql($negeri) . ", bandar=".tosql($bandar); 
		$strSQL .= ", no_tel=".tosql($no_tel) . ", negeri_lahir_pemohon=".tosql($negeri_lahir_pemohon).", taraf_kawin=".tosql($taraf_kawin); 
		$strSQL .= ", negeri_lahir_ibu=".tosql($negeri_lahir_ibu) . ", ketinggian=".tosql($ketinggian).", berat=".tosql($berat);
		$strSQL .= ", lesen_kenderaan=".tosql($lesen_kenderaan) . ", masih_khidmat=".tosql($masih_khidmat); 
		$strSQL .= ", negeri_lahir_bapa=".tosql($negeri_lahir_bapa).", d_kemaskini='{$date}'";	
		$strSQL .= ", jantina=".tosql($jantina) . ", agama=".tosql($agama) . ", dob=".tosql($dob); 
		$strSQL .= ", oku=".tosql($oku) . ", no_rujukan_oku=".tosql($no_rujukan_oku); 
		$strSQL .= ", bantuan=".tosql($bantuan) . ", no_rujukan_bantuan=".tosql($no_rujukan_bantuan); 
		$strSQL .= " WHERE id_pemohon=".tosql($id_pemohon);
		$rss = $conn->execute($strSQL);

		$strSQL1 = "UPDATE $schema2.`myid` SET ";
		$strSQL1 .= "addr1=".tosql($addr1).", addr2=".tosql($addr2).", addr3=".tosql($addr3).", poskod=".tosql($poskod); 
		$strSQL1 .= ", negeri=".tosql($negeri) . ", bandar=".tosql($bandar); 
		$strSQL1 .= ", notel=".tosql($no_tel);	
		$strSQL1 .= " WHERE id_pemohon=".tosql($id_pemohon);
		//.", e_mail=".tosql($e_mail)
		$conn->execute($strSQL1);
		// audit_trail($strSQL, "KEMASKINI");

		
		//exit;
		if($rss){
			// KEMASKINI DATA DETAIL
			set_tarikh($id_pemohon, "tkh_upd_biodata");
			$err='OK';
		} else {
			$err='ERR'; 
		}
	
	// } else if($pro=="DEL"){
	
	// 	$ID=isset($_REQUEST["ID"])?$_REQUEST["ID"]:"";
	// 	//$sqld = "DELETE FROM _ref_akta WHERE akta_id='{$akta_id}'";
	// 	$sqld = "UPDATE tbl_penyembelih SET is_deleted=1, deleted_dt='{$date}', deleted_by=".tosql($oleh)." WHERE id='{$ID}'";
	// 	$rss = $conn->execute($sqld);
	// 	audit_trail($sqld, "HAPUS");
	// 	if($rss){
	// 		$err='OK';
	// 	} else {
	// 		$err='ERR'; 
	// 	}
	}		
} else if($frm=='KHIDMAT'){
	// $conn->debug=true;
	if($pro=='SAVE'){
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$jenis_perkhidmatan=isset($_REQUEST["jenis_perkhidmatan"])?$_REQUEST["jenis_perkhidmatan"]:"";
		$taraf_jawatan=isset($_REQUEST["taraf_jawatan"])?$_REQUEST["taraf_jawatan"]:"";
		$d_lantikan_jpa=isset($_REQUEST["d_lantikan_jpa"])?$_REQUEST["d_lantikan_jpa"]:"";
		$d_lantikan_kontrak=isset($_REQUEST["d_lantikan_kontrak"])?$_REQUEST["d_lantikan_kontrak"]:"";
		$skim_sekarang=isset($_REQUEST["skim_sekarang"])?$_REQUEST["skim_sekarang"]:"";
		$gred_jawatan_sekarang=isset($_REQUEST["gred_jawatan_sekarang"])?$_REQUEST["gred_jawatan_sekarang"]:"";
		$d_lantikan_khidmat_sekarang=isset($_REQUEST["d_lantikan_khidmat_sekarang"])?$_REQUEST["d_lantikan_khidmat_sekarang"]:"";
		$d_sah_khidmat_sekarang=isset($_REQUEST["d_sah_khidmat_sekarang"])?$_REQUEST["d_sah_khidmat_sekarang"]:"";
		$tpt_bertugas=isset($_REQUEST["tpt_bertugas"])?$_REQUEST["tpt_bertugas"]:"";
		$negeri_tpt_bertugas=isset($_REQUEST["negeri_tpt_bertugas"])?$_REQUEST["negeri_tpt_bertugas"]:"";
		$jenis_xm=isset($_REQUEST["jenis_xm"])?$_REQUEST["jenis_xm"]:"";
		$d_lulus_kpsl=isset($_REQUEST["d_lulus_kpsl"])?$_REQUEST["d_lulus_kpsl"]:"";
		// $e_mail=isset($_REQUEST["e_mail"])?$_REQUEST["e_mail"]:"";
		
		
		$rs = $conn->query("SELECT * FROM $schema2.`calon_masih_khidmat` WHERE `id_pemohon`=".tosql($id_pemohon));
		if(!$rs->EOF){
			$strSQL1 = "UPDATE $schema2.`calon_masih_khidmat` SET ";
			$strSQL1 .= "jenis_perkhidmatan=".tosql($jenis_perkhidmatan).", taraf_jawatan=".tosql($taraf_jawatan).", 
				d_lantikan_jpa=".tosql($d_lantikan_jpa).", d_lantikan_kontrak=".tosql($d_lantikan_kontrak).", 
				skim_sekarang=".tosql($skim_sekarang).", skim_sekarang_jika_tiada=".tosql($skim_sekarang_jika_tiada).", 
				d_lantikan_khidmat_sekarang=".tosql($d_lantikan_khidmat_sekarang).", d_sah_khidmat_sekarang=".tosql($d_sah_khidmat_sekarang).", 
				gred_jawatan_sekarang=".tosql($gred_jawatan_sekarang).", tpt_bertugas=".tosql($tpt_bertugas).", 
				negeri_tpt_bertugas=".tosql($negeri_tpt_bertugas).", d_lulus_kpsl=".tosql($d_lulus_kpsl).", 
				jenis_xm=".tosql($jenis_xm).", d_kemaskini=".tosql($d_kemaskini);
			$strSQL1 .= " WHERE id_pemohon=".tosql($id_pemohon);
		} else {
			$strSQL1 = "INSERT INTO $schema2.`calon_masih_khidmat`(id_pemohon, jenis_perkhidmatan, taraf_jawatan, 
				d_lantikan_jpa, d_lantikan_kontrak, skim_sekarang, d_lantikan_khidmat_sekarang, 
				d_sah_khidmat_sekarang, gred_jawatan_sekarang, tpt_bertugas,  
				negeri_tpt_bertugas, d_lulus_kpsl, jenis_xm, d_cipta)
				VALUES(".tosql($id_pemohon).", ".tosql($jenis_perkhidmatan).", ".tosql($taraf_jawatan).", 
				".tosql($d_lantikan_jpa).", ".tosql($d_lantikan_kontrak).", ".tosql($skim_sekarang).", ".tosql($d_lantikan_khidmat_sekarang).",
				".tosql($d_sah_khidmat_sekarang).", ".tosql($gred_jawatan_sekarang).", ".tosql($tpt_bertugas).",  
				".tosql($negeri_tpt_bertugas).", ".tosql($d_lulus_kpsl).", ".tosql($jenis_xm).", ".tosql($date).")";	
		}
		//.", e_mail=".tosql($e_mail)
		$rss = $conn->execute($strSQL1);
		//exit;
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}

	} else if($pro=='HAPUS'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$rs = $conn->query("SELECT * FROM $schema2.`calon_masih_khidmat` WHERE `id_pemohon`=".tosql($id_pemohon));
		if(!$rs->EOF){
			$rss = $conn->execute("DELETE FROM $schema2.`calon_masih_khidmat` WHERE `id_pemohon`=".tosql($id_pemohon));
			if($rss){
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
