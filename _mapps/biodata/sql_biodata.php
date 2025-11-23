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
	'id_pemohon'=> $rs->fields['id_pemohon'], 'nama'=> $rs->fields['nama'], 'addr1'=> $rs->fields['addr1'], 'addr2'=> $rs->fields['addr2'], 'addr3'=> $rs->fields['addr3'], 'poskod'=> $rs->fields['poskod'], 'bandar'=> $rs->fields['bandar'], 'negeri'=> $rs->fields['negeri'], 'no_tel'=> $rs->fields['notel'], 'e_mail'=> $rs->fields['emel'], 'katalaluan'=> $rs->fields['katalaluan'], 'kod_keselamatan'=> $rs->fields['kod_keselamatan'], 'neg_keselamatan'=> $rs->fields['neg_keselamatan']); 

	$rss = $conn->query("SELECT * FROM $schema2.`calon` WHERE `id_pemohon`=".tosql($rs->fields['id_pemohon']));
	if($rss->EOF){
	
		$sql = "INSERT INTO $schema2.`calon` (`id_pemohon`, `ICNo`, `jenis_id`, `nama_penuh`, `no_tel`, `e_mail`, `d_cipta`)";
		$sql .= " VALUES(".tosql($uid).", ".tosql($rs->fields['ICNo']).", 'A', ".tosql($rs->fields['nama']).", ".tosql($rs->fields['notel']).", 
			".tosql($rs->fields['emel']).", ".tosql(date("Y-m-d H:i:s")).")";
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
	'dob'=> $rs->fields['dob'], 'addr1'=> $rs->fields['addr1'], 'addr2'=> $rs->fields['addr2'], 'addr3'=> $rs->fields['addr3'], 'poskod'=> $rs->fields['poskod'], 'bandar'=> $rs->fields['bandar'], 'negeri'=> $rs->fields['negeri'], 'no_depan'=> $rs->fields['no_depan'], 'no_tel'=> $rs->fields['no_tel'], 'e_mail'=> $rs->fields['e_mail'], 'negeri_lahir_pemohon'=> $rs->fields['negeri_lahir_pemohon'], 'negeri_lahir_ibu'=> $rs->fields['negeri_lahir_ibu'], 'negeri_lahir_bapa'=> $rs->fields['negeri_lahir_bapa'], 'jantina'=> $rs->fields['jantina'], 'agama'=> $rs->fields['agama'], 'keturunan'=> $rs->fields['keturunan'], 'warganegara'=> $rs->fields['warganegara'], 'lesen_kenderaan'=> $rs->fields['lesen_kenderaan'], 'taraf_kawin'=> $rs->fields['taraf_kawin'], 'ketinggian'=> $rs->fields['ketinggian'], 'berat'=> $rs->fields['berat'], 'masih_khidmat'=> $rs->fields['masih_khidmat'], 'oku'=> $rs->fields['oku'], 'no_rujukan_oku'=> $rs->fields['no_rujukan_oku'], 'bantuan'=> $rs->fields['bantuan'], 'no_rujukan_bantuan'=> $rs->fields['no_rujukan_bantuan'], 'pengakuan'=> $rs->fields['pengakuan'], 'tarikh_akuan'=> $rs->fields['tarikh_akuan'], 'status_pemohon'=> $rs->fields['status_pemohon']); 

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
	$sql = "SELECT * FROM $schema2.`ref_negeri` WHERE status=0";
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

function get_pusat_temuduga($conn, $kods){
	global $schema1;
	//$conn->debug=true;
	$sql = "SELECT * FROM $schema1.`ref_pusat_temuduga` WHERE jenis_pusat=0 AND sah_yt='Y' AND is_deleted=0 AND status=0 ORDER BY `ref_pusat_temuduga`.`neg_kod` ASC";
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
	//$conn->debug=true;
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

		$data .= '<option value="1"';
		if($kods=='1'){ $data .= " selected"; }
		$data .= '>BUJANG</option>';

		$data .= '<option value="2"';
		if($kods=='2'){ $data .= " selected"; }
		$data .= '>BERKAHWIN</option>';

		$data .= '<option value="3"';
		if($kods=='3'){ $data .= " selected"; }
		$data .= '>JANDA</option>';

		$data .= '<option value="4"';
		if($kods=='4'){ $data .= " selected"; }
		$data .= '>DUDA</option>';

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
	$sql = "SELECT * FROM $schema1.`ref_kecacatan_calon` WHERE is_deleted=0 AND status=0";
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
	$des = '';
	//$conn->debug=true;

	//print $kods;
	$res = $conn->query("SELECT B.DISKRIPSI AS NAMA, B.`KOD` AS kods FROM $schema1.`ref_skim` A, $schema1.`ref_gred_gaji` B WHERE A.`GGH_KOD`=B.`KOD` AND A.`KOD`='{$skim}'");
	if(!$res->EOF){
		$des = $res->fields['NAMA'];
		$gred_kod = $res->fields['kods'];
	}

	$grds = substr($kods,0,1);

	// $sql = "SELECT KOD FROM $schema1.`ref_gred_gaji` WHERE `SAH_YT`='Y' AND GAB_YT='T' AND KOD IS NOT NULL ORDER BY KOD";
	$sql = "SELECT KOD FROM $schema1.`ref_gred_gaji` WHERE `SAH_YT`='Y' AND GAB_YT='T' AND `DISKRIPSI` IN ('{$des}') AND KOD IS NOT NULL AND `KOD` LIKE '%$grds%' ORDER BY KOD";
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
	$sql = "SELECT KOD, DISKRIPSI FROM $schema1.`ref_kelulusan` WHERE KATEGORI='P' AND JENIS=1 AND DISKRIPSI IS NOT NULL";
	$sql .= " AND DISKRIPSI NOT LIKE 'PENGALAMAN%'";
	$sql .= " ORDER BY DISKRIPSI";
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
	 //$conn->debug=true; 
	if($pro=='SAVE'){
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$addr1=isset($_REQUEST["addr1"])?$_REQUEST["addr1"]:"";
		$addr2=isset($_REQUEST["addr2"])?$_REQUEST["addr2"]:"";
		$addr3=isset($_REQUEST["addr3"])?$_REQUEST["addr3"]:"";
		$poskod=isset($_REQUEST["poskod"])?$_REQUEST["poskod"]:"";
		$negeri=isset($_REQUEST["negeri"])?$_REQUEST["negeri"]:"";
		$bandar=isset($_REQUEST["bandar"])?$_REQUEST["bandar"]:"";
		$e_mail=isset($_REQUEST["e_mail"])?$_REQUEST["e_mail"]:"";
		$noDepan=isset($_REQUEST["noDepan"])?$_REQUEST["noDepan"]:"";
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

		if(!empty($ketinggian) && !empty($berat)){ 
		$sqh=($ketinggian/100)*($ketinggian/100);
		if(!empty($sqh)){ 
			$BMI = number_format($berat/$sqh,2);
		} else { $BMI=0; }
	}		

		if(!empty($_FILES['fileBiodata']['name'])){ 
			$new_file = $_FILES['fileBiodata'];
			// $conn->debug=true;
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif','pdf'); // valid extensions
	        $path = '/var/www/upload/'.$id_pemohon.'/'; // upload directory
	        if (file_exists($path)) {
	            $path = $path;
	        } else {
	            mkdir($path);
	        }

	        $file_size = $new_file['size']; 
			$file_tmp = $new_file['tmp_name'];
			//echo "Mana fail-->".$file_name;
			//$file_extension = end(explode(".", $file_name));
			$file_name = strtolower($new_file['name']);
			$upload_extension =  explode(".", $file_name);
			$file_extension = end($upload_extension);
			//echo "<br>File Ext-->".$file_extension;
			if(in_array($file_extension, $valid_extensions)){

				switch( $file_extension ) { 
					case "jpg": $jenisfail1="image/JPEG"; break; 
					case "jpeg": $jenisfail1="image/JPEG"; break; 
					case "png": $jenisfail1="image/PNG"; break; 
					case "gif": $jenisfail1="image/GIF"; break; default: 
					$jenisfail1="image/GIF";
				}
				// This is the temporary file created by PHP
				$uploadedfile = $_FILES['fileBiodata']['tmp_name'];
				// Create an Image from it so we can do the resize
				if($file_extension=='jpg'){
					$src = imagecreatefromjpeg($file_tmp);
				} else if($file_extension=='jpeg'){
					$src = imagecreatefromjpeg($file_tmp);
				} else if($file_extension=='gif'){
					$src = imagecreatefromgif($file_tmp);
				} else if($file_extension=='png'){
					$src = imagecreatefrompng($file_tmp);
				}
				// Capture the original size of the uploaded image
		        	// print $path;
				list($width,$height)=getimagesize($uploadedfile);
				if($width>120 || $height> 180){
					if($width > $height){
						$newwidth=120;
						$newheight=round(($height/$width)*180);
					} else {
						$newheight=180;
						$newwidth=round(($height/$width)*120);
					}
					//echo "<br>".$width ."/" .$height;
					//echo "<br>".$newwidth ."/" .$newheight;
				} else {
					$newwidth = $width;
					$newheight = $height;
				}
				//$newwidth = $width;
				//$newheight = $height;
				$final_image = strtolower($id_pemohon.".".$file_extension);
				$tmp=imagecreatetruecolor($newwidth,$newheight);
				// this line actually does the image resizing, copying from the original image into the $tmp image
				imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
				imagejpeg($tmp,$path.$final_image,100);
				if($file_extension=='jpg'){
					imagejpeg($tmp,$path.$final_image,100);
				} else if($file_extension=='jpeg'){
					imagejpeg($tmp,$path.$final_image);
				} else if($file_extension=='png'){
					imagepng($tmp,$path.$final_image);
				} else if($file_extension=='gif'){
					imagegif($tmp,$path.$final_image);
				}


				// $path = $path.strtolower($final_image);
				// print $tmp.":".$path;	
				// move_uploaded_file($tmp,$path);
				// $path;
				$dt = date("Y-m-d H:i:s");
				$rs = $conn->query("SELECT * FROM $schema2.`calon_gambar` WHERE `id_pemohon`=".tosql($id_pemohon));
				if($rs->EOF){ 
					$sqlu = "INSERT INTO $schema2.`calon_gambar`(`id_pemohon`, `gambar`, `create_dt`, `update_dt`) 
					VALUES('{$id_pemohon}', ".tosqln($final_image).", '{$dt}', '{$dt}')";
				} else {
					$sqlu = "UPDATE $schema2.`calon_gambar` SET `gambar`=".tosqln($final_image)." WHERE `id_pemohon`=".tosql($id_pemohon);
				}
				$rsn = $conn->execute($sqlu);		
			}

			
			// check's valid format
			// $conn->debug=true;
			// if(in_array($ext, $valid_extensions)){ 
			// 	$path = $path.strtolower($final_image); 
			// 	// print "n:".$path.'>'.$tmp; exit();
			// 	move_uploaded_file($tmp,$path);
			// 	// $err = $path;
			// 	$dt = date("Y-m-d H:i:s");
			// 	$rs = $conn->query("SELECT * FROM $schema2.`calon_gambar` WHERE `id_pemohon`=".tosql($id_pemohon));
			// 	if($rs->EOF){ 
			// 		$sqlu = "INSERT INTO $schema2.`calon_gambar`(`id_pemohon`, `gambar`, `create_dt`, `update_dt`) 
			// 		VALUES('{$id_pemohon}', ".tosqln($final_image).", '{$dt}', '{$dt}')";
			// 	} else {
			// 		$sqlu = "UPDATE $schema2.`calon_gambar` SET `gambar`=".tosqln($final_image)." WHERE `id_pemohon`=".tosql($id_pemohon);
			// 	}
			// 	$rsn = $conn->execute($sqlu);		
			// }
		}

		$strSQL = "UPDATE $schema2.`calon` SET ";
		$strSQL .= "addr1=".tosql($addr1).", addr2=".tosql($addr2).", addr3=".tosql($addr3).", poskod=".tosql($poskod); 
		$strSQL .= ", negeri=".tosql($negeri) . ", bandar=".tosql($bandar); 
		$strSQL .= ", no_tel=".tosql($no_tel) . ", no_depan =".tosql($noDepan) . ", negeri_lahir_pemohon=".tosql($negeri_lahir_pemohon).", taraf_kawin=".tosql($taraf_kawin); 
		$strSQL .= ", negeri_lahir_ibu=".tosql($negeri_lahir_ibu) . ", ketinggian=".tosql($ketinggian).", berat=".tosql($berat);
		$strSQL .= ", lesen_kenderaan=".tosql($lesen_kenderaan) . ", masih_khidmat=".tosql($masih_khidmat); 
		$strSQL .= ", negeri_lahir_bapa=".tosql($negeri_lahir_bapa).", d_kemaskini='{$date}'";	
		//$strSQL .= ", jantina=".tosql($jantina) . ", agama=".tosql($agama) . ", dob=".tosql(DBDate($dob)); 
		$strSQL .= ", dob=".tosql(DBDate($dob)); 
		$strSQL .= ", oku=".tosql($oku) . ", no_rujukan_oku=".tosql($no_rujukan_oku); 
		$strSQL .= ", bantuan=".tosql($bantuan) . ", no_rujukan_bantuan=".tosql($no_rujukan_bantuan); 
		$strSQL .= ", bmi=".tosql($BMI);
		$strSQL .= " WHERE id_pemohon=".tosql($id_pemohon);
		$rss = $conn->execute($strSQL);
		
		$strSQL1 = "UPDATE $schema2.`myid` SET ";
		$strSQL1 .= "addr1=".tosql($addr1).", addr2=".tosql($addr2).", addr3=".tosql($addr3).", poskod=".tosql($poskod); 
		$strSQL1 .= ", negeri=".tosql($negeri) . ", bandar=".tosql($bandar); 
		$strSQL1 .= ", notel=".tosql($no_tel) . ", no_depan=".tosql($noDepan);	
		$strSQL1 .= " WHERE id_pemohon=".tosql($id_pemohon);
		//.", e_mail=".tosql($e_mail)
		$conn->execute($strSQL1);
		// audit_trail($strSQL, "KEMASKINI");

		
		//exit;
		if($rss){
			if($masih_khidmat=='T'){
				$rsD = $conn->query("SELECT * FROM $schema2.`calon_masih_khidmat` WHERE `id_pemohon`=".tosql($id_pemohon));
				if(!$rsD->EOF){
					$conn->execute("DELETE FROM $schema2.`calon_masih_khidmat` WHERE `id_pemohon`=".tosql($id_pemohon));
				}
			}
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
	//$conn->debug=true;
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
				d_lantikan_jpa=".tosql(DBDate($d_lantikan_jpa)).", d_lantikan_kontrak=".tosql(DBDate($d_lantikan_kontrak)).", 
				skim_sekarang=".tosql($skim_sekarang).", skim_sekarang_jika_tiada=".tosql($skim_sekarang_jika_tiada).", 
				d_lantikan_khidmat_sekarang=".tosql(DBDate($d_lantikan_khidmat_sekarang)).", d_sah_khidmat_sekarang=".tosql(DBDate($d_sah_khidmat_sekarang)).", 
				gred_jawatan_sekarang=".tosql($gred_jawatan_sekarang).", tpt_bertugas=".tosql($tpt_bertugas).", 
				negeri_tpt_bertugas=".tosql($negeri_tpt_bertugas).", d_lulus_kpsl=".tosql(DBDate($d_lulus_kpsl)).", 
				jenis_xm=".tosql($jenis_xm).", d_kemaskini=".tosql($d_kemaskini);
			$strSQL1 .= " WHERE id_pemohon=".tosql($id_pemohon);
		} else {
			$strSQL1 = "INSERT INTO $schema2.`calon_masih_khidmat`(id_pemohon, jenis_perkhidmatan, taraf_jawatan, 
				d_lantikan_jpa, d_lantikan_kontrak, skim_sekarang, d_lantikan_khidmat_sekarang, 
				d_sah_khidmat_sekarang, gred_jawatan_sekarang, tpt_bertugas,  
				negeri_tpt_bertugas, d_lulus_kpsl, jenis_xm, d_cipta)
				VALUES(".tosql($id_pemohon).", ".tosql($jenis_perkhidmatan).", ".tosql($taraf_jawatan).", 
				".tosql(DBDate($d_lantikan_jpa)).", ".tosql(DBDate($d_lantikan_kontrak)).", ".tosql($skim_sekarang).", ".tosql(DBDate($d_lantikan_khidmat_sekarang)).",
				".tosql(DBDate($d_sah_khidmat_sekarang)).", ".tosql($gred_jawatan_sekarang).", ".tosql($tpt_bertugas).",  
				".tosql($negeri_tpt_bertugas).", ".tosql(DBDate($d_lulus_kpsl)).", ".tosql($jenis_xm).", ".tosql($date).")";	
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

if($frm=='KHIDMAT'){
	set_tarikh($id_pemohon, "tkh_upd_awam");
}

// header("Content-Type: text/json");
// print json_encode($err); 
print $err;
?>
