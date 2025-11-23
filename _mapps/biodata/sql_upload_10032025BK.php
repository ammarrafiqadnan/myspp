<?php
@session_start();
error_reporting(E_ERROR | E_PARSE);
//include_once '../../connection/formatdate.php';
if(file_exists('../connection/common_oracle.php')){
	// include '../connection/common.php';
	include '../connection/common_oracle.php';
} else {
	include '../../connection/common_oracle.php';
	// include '../../connection/common_oracle.php';
}

// Function to get the client IP address
function get_client_ipSubmit() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

//$conn->debug=true;
//$sql = "SELECT * FROM $schema2.`calon` WHERE `status_pemohon` IS NULL AND `pengakuan`='Y' AND `tarikh_akuan`<=".tosql(date("Y-m-d"));
// GET CALON DATA
$sql = "SELECT * FROM $schema2.`calon` WHERE `id_pemohon`=".tosql($id_pemohon);
$rs = $conn->query($sql);

$pk_key=$nexval;
$no_kelompok='';
$no_siri='';
$litho_code='';
$jenis_pendaftaran='03';
$no_kp_baru=$rs->fields['ICNo'];
$no_kp_lama='';
$nama_penuh=$rs->fields['nama_penuh'];
$tarikh_lahir=str_replace("/","",DisplayDate($rs->fields['dob']));
$tempat_lahir=$rs->fields['negeri_lahir_pemohon'];
$jantina=$rs->fields['jantina'];
$taraf_perkahwinan=$rs->fields['taraf_kawin'];
$keturunan=$rs->fields['keturunan'];
$agama=$rs->fields['agama'];
$warganegara=$rs->fields['kewarganegaraan'];
$tempat_lahir_ibu=$rs->fields['negeri_lahir_ibu'];
$tempat_lahir_bapa=$rs->fields['negeri_lahir_bapa'];
$kod_tel=$rs->fields['no_depan'];
$no_tel=$rs->fields['no_tel'];
$alamat=substr($rs->fields['addr1'],0,52);
$alama2=substr($rs->fields['addr2'],0,52);
$alama3=substr($rs->fields['addr3'],0,52);
$poskod=$rs->fields['poskod'];
$bandar=substr($rs->fields['bandar'],0,52);
$negeri_tinggal=$rs->fields['negeri'];
$bahagian_tinggal='';

$kategori=$rs->fields['kategori_tentera_polis'];
$pangkat=$rs->fields['bandar']; // DARI tbl calon_polis_ban_oku
$pencen=$rs->fields['pencen'];
$tarikh_ahli=str_replace("/","",DisplayDate($rs->fields['professional_d_1']));
$profesional=$rs->fields['profesional_1'];
$tarikh_lulus='';
$jab_khas='';
$pengguna=$rs->fields['ICNo'];
$tkh_ubah='';

$lesen_memandu=str_replace("-", "", $rs->fields['lesen_kenderaan']);
$pencapaian_khas=$rs->fields['khas_flag'];
$email=$rs->fields['e_mail'];

$ketinggian=$rs->fields['ketinggian'];
$berat=$rs->fields['berat'];
$umur=$rs->fields['umur'];
$bmi=$rs->fields['bmi'];

// SRP
$tahun_sijil3=$rs->fields['srp_tahun'];
$jenis_sijil3=$rs->fields['srp_jenis_sijil'];
$pangkat_sijil3=$rs->fields['srp_pangkat'];
// SPM
$tahun_sijil5=$rs->fields['spm_tahun_1'];
$jenis_sijil5=$rs->fields['spm_jenis_sijil_1'];
$pangkat_sijil5=$rs->fields['spm_pangkat_1'];
$ujian_lisan=$rs->fields['spm_lisan_1'];
$tahun_sijil52=$rs->fields['spm_tahun_2'];
$jenis_sijil52=$rs->fields['spm_jenis_sijil_2'];
$pangkat_sijil52='';
$ujian_lisan52='';
//STPM
$tahun_sijil6_1=$rs->fields['stp_tahun_1'];
$jenis_sijil6_1=$rs->fields['stp_jenis_1'];
$pangkat_sijil6_1='';
$tahun_sijil6_2=$rs->fields['stp_tahun_2'];
$jenis_sijil6_2=$rs->fields['stp_jenis_2'];
$pangkat_sijil6_2='';
//STAM
$tahun_stam1=$rs->fields['stam_tahun_1'];
$jenis_stam1=$rs->fields['stam_jenis_1'];
$pangkat_stam1=$rs->fields['stam_pangkat_1'];
$tahun_stam2=$rs->fields['stam_tahun_2'];
$jenis_stam2=$rs->fields['stam_jenis_2'];
$pangkat_stam2=$rs->fields['stam_pangkat_2'];

$tarikh_cipta=$rs->fields['tarikh_akuan'];
$tarikh_mohon_jobsm=$rs->fields['d_cipta'];
$tarikh_mohon_spp=$rs->fields['d_cipta'];
$tarikh_kemaskini_spp=$rs->fields['tarikh_akuan'];

$rsTemuduga = $conn->query("SELECT * FROM $schema2.calon_pusat_temuduga WHERE `id_pemohon`=".tosql($id_pemohon));
$pusat_td=$rsTemuduga->fields['pusat_temuduga'];

// POLIS
$rsData = $conn->query("SELECT * FROM $schema2.calon_polis_ban_oku WHERE `ind`='P' AND `id_pemohon`=".tosql($id_pemohon));
$kategori_tentera_polis=$rsData->fields['kategori'];
$pangkat=$rsData->fields['pangkat'];
// OKU
$rsData = $conn->query("SELECT * FROM $schema2.calon_polis_ban_oku WHERE `ind`='O' AND `id_pemohon`=".tosql($id_pemohon));
$daftar_cacat='2';
if(!$rsData->EOF){
	$kecacatan_calon=$rsData->fields['kategori'];
	$daftar_cacat='1';
	$nom_daftar=$rsData->fields['rujukan_ganjaran'];
}
// BANTUAN
$rsData = $conn->query("SELECT * FROM $schema2.calon_polis_ban_oku WHERE `ind`='B' AND `id_pemohon`=".tosql($id_pemohon));
$bantuan=$rsData->fields['kategori'];
$nom_daftar_bantuan=$rsData->fields['rujukan_ganjaran'];


$rsjawatan = $conn->query("SELECT * FROM $schema2.calon_jawatan_dipohon WHERE `id_pemohon`=".tosql($id_pemohon));
$bil=0; $jenis_pohon='';
while(!$rsjawatan->EOF){
	if($bil==0){
		$skim_1=$rsjawatan->fields['kod_jawatan'];
	} else if($bil==1){
		$skim_2=$rsjawatan->fields['kod_jawatan'];
	} else if($bil==2){
		$skim_3=$rsjawatan->fields['kod_jawatan'];
	}
	if(empty($jenis_pohon)){
		$jenis_pohon = "5";//$rsjawatan->fields['peringkat'];
	}
	$bil++;
	$rsjawatan->movenext();
}
$skim_4=''; $skim_5=''; $skim_6=''; $skim_7=''; $skim_8=''; $skim_9=''; $skim_10='';
$skim_10=''; $skim_11=''; $skim_12=''; $skim_13=''; $skim_14=''; $skim_15=''; 
$skim_16=''; $skim_17=''; $skim_18=''; $skim_19=''; $skim_20=''; 


if(!empty($tahun_sijil3)){ 
	$rsSRP = $conn->query("SELECT * FROM $schema2.calon_srp WHERE `id_pemohon`=".tosql($id_pemohon));
	$bil=0;
	while(!$rsSRP->EOF){
		$bil++;
		if($bil==1){
			$mpel3_1=$rsSRP->fields['matapelajaran'];
			$gred3_1=$rsSRP->fields['gred'];
		} else if($bil==2){
			$mpel3_2=$rsSRP->fields['matapelajaran'];
			$gred3_2=$rsSRP->fields['gred'];
		} else if($bil==3){
			$mpel3_3=$rsSRP->fields['matapelajaran'];
			$gred3_3=$rsSRP->fields['gred'];
		} else if($bil==4){
			$mpel3_4=$rsSRP->fields['matapelajaran'];
			$gred3_4=$rsSRP->fields['gred'];
		} else if($bil==5){
			$mpel3_5=$rsSRP->fields['matapelajaran'];
			$gred3_5=$rsSRP->fields['gred'];
		} else if($bil==6){
			$mpel3_6=$rsSRP->fields['matapelajaran'];
			$gred3_6=$rsSRP->fields['gred'];
		} else if($bil==7){
			$mpel3_7=$rsSRP->fields['matapelajaran'];
			$gred3_7=$rsSRP->fields['gred'];
		} else if($bil==8){
			$mpel3_8=$rsSRP->fields['matapelajaran'];
			$gred3_8=$rsSRP->fields['gred'];
		} else if($bil==9){
			$mpel3_10=$rsSRP->fields['matapelajaran'];
			$gred3_10=$rsSRP->fields['gred'];
		} else if($bil==10){
			$mpel3_10=$rsSRP->fields['matapelajaran'];
			$gred3_10=$rsSRP->fields['gred'];
		}
		$rsSRP->movenext();
	}
}

// SPM
// SPM
if(!empty($tahun_sijil5) && $jenis_sijil5==5){ 
	$rsSPM = $conn->query("SELECT * FROM $schema2.calon_svm WHERE `tahun`=".tosql($tahun_sijil5)." AND `id_pemohon`=".tosql($id_pemohon));
	$mpel5_1='103';
	$gred5_1=$rsSPM->fields['gred_bm'];
	$mpel5_2=$rsSPM->fields['nama_sijil'];
	$gred5_2="A";
} else if(!empty($tahun_sijil5) && $jenis_sijil5<>5){ 
	$rsSPM = $conn->query("SELECT * FROM $schema2.calon_spm WHERE `jenis_xm`=1 AND `tahun`=".tosql($tahun_sijil5)." AND `id_pemohon`=".tosql($id_pemohon));
	$bil=0;
	while(!$rsSPM->EOF){
		$bil++;
		if($bil==1){
			$mpel5_1=$rsSPM->fields['matapelajaran'];
			$gred5_1=$rsSPM->fields['gred'];
		} else if($bil==2){
			$mpel5_2=$rsSPM->fields['matapelajaran'];
			$gred5_2=$rsSPM->fields['gred'];
		} else if($bil==3){
			$mpel5_3=$rsSPM->fields['matapelajaran'];
			$gred5_3=$rsSPM->fields['gred'];
		} else if($bil==4){
			$mpel5_4=$rsSPM->fields['matapelajaran'];
			$gred5_4=$rsSPM->fields['gred'];
		} else if($bil==5){
			$mpel5_5=$rsSPM->fields['matapelajaran'];
			$gred5_5=$rsSPM->fields['gred'];
		} else if($bil==6){
			$mpel5_6=$rsSPM->fields['matapelajaran'];
			$gred5_6=$rsSPM->fields['gred'];
		} else if($bil==7){
			$mpel5_7=$rsSPM->fields['matapelajaran'];
			$gred5_7=$rsSPM->fields['gred'];
		} else if($bil==8){
			$mpel5_8=$rsSPM->fields['matapelajaran'];
			$gred5_8=$rsSPM->fields['gred'];
		} else if($bil==9){
			$mpel5_10=$rsSPM->fields['matapelajaran'];
			$gred5_10=$rsSPM->fields['gred'];
		} else if($bil==10){
			$mpel5_10=$rsSPM->fields['matapelajaran'];
			$gred5_10=$rsSPM->fields['gred'];
		}
		$rsSPM->movenext();
	}
}
// SPM2
if(!empty($tahun_sijil52) && $jenis_sijil52==52){ 
	$rsSPM = $conn->query("SELECT * FROM $schema2.calon_svm WHERE `tahun`=".tosql($tahun_sijil52)." AND `id_pemohon`=".tosql($id_pemohon));
	$mpel5_1='103';
	$gred5_1=$rsSPM->fields['gred_bm'];
	$mpel5_2=$rsSPM->fields['nama_sijil'];
	$gred5_2="A";
} else if(!empty($tahun_sijil52) && $jenis_sijil5<>52){ 
	$rsSPM = $conn->query("SELECT * FROM $schema2.calon_spm WHERE `jenis_xm`=1 AND `tahun`=".tosql($tahun_sijil52)." AND `id_pemohon`=".tosql($id_pemohon));
	$bil=0;
	while(!$rsSPM->EOF){
		$bil++;
		if($bil==1){
			$mpel5_1=$rsSPM->fields['matapelajaran'];
			$gred5_1=$rsSPM->fields['gred'];
		} else if($bil==2){
			$mpel5_2=$rsSPM->fields['matapelajaran'];
			$gred5_2=$rsSPM->fields['gred'];
		} else if($bil==3){
			$mpel5_3=$rsSPM->fields['matapelajaran'];
			$gred5_3=$rsSPM->fields['gred'];
		} else if($bil==4){
			$mpel5_4=$rsSPM->fields['matapelajaran'];
			$gred5_4=$rsSPM->fields['gred'];
		} else if($bil==5){
			$mpel5_5=$rsSPM->fields['matapelajaran'];
			$gred5_5=$rsSPM->fields['gred'];
		} else if($bil==6){
			$mpel5_6=$rsSPM->fields['matapelajaran'];
			$gred5_6=$rsSPM->fields['gred'];
		} else if($bil==7){
			$mpel5_7=$rsSPM->fields['matapelajaran'];
			$gred5_7=$rsSPM->fields['gred'];
		} else if($bil==8){
			$mpel5_8=$rsSPM->fields['matapelajaran'];
			$gred5_8=$rsSPM->fields['gred'];
		} else if($bil==9){
			$mpel5_10=$rsSPM->fields['matapelajaran'];
			$gred5_10=$rsSPM->fields['gred'];
		} else if($bil==10){
			$mpel5_10=$rsSPM->fields['matapelajaran'];
			$gred5_10=$rsSPM->fields['gred'];
		}
		$rsSPM->movenext();
	}
}
$bm_sap_tahun='';
$bm_sap_gred='';
$bm_sap_lisan='';

// SPM TAMBAHAN
$rsSPM = $conn->query("SELECT * FROM $schema2.calon_spm WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($id_pemohon));
while(!$rsSPM->EOF){

	if($rsSPM->fields['matapelajaran']=='101' && ($rsData->fields['jenis_sijil']=='1' || $rsData->fields['jenis_sijil']=='2' || $rsData->fields['jenis_sijil']=='3' || $rsData->fields['jenis_sijil']=='4')){
			$bm_setaraf_tahun=$rsSPM->fields['tahun'];
			$bm_setaraf_jenis=$rsSPM->fields['jenis_sijil'];
			$bm_setaraf_gred=$rsSPM->fields['gred'];
			$bm_setaraf_lisan=$rsSPM->fields['ujian_lisan'];
	} else if($rsSPM->fields['matapelajaran']=='301'){
			$math5_tahun=$rsSPM->fields['tahun'];
			$math5_gred=$rsSPM->fields['gred'];
	}

	$rsSPM->movenext();	
}

// SVM 1
$rsSPM = $conn->query("SELECT * FROM $schema2.calon_svm WHERE `id_pemohon`=".tosql($id_pemohon)." ORDER BY `tahun`");
$bil=0;
while(!$rsSPM->EOF){
	if($bil==0){
		$tahun1 = $rsSPM->fields['tahun'];
		$jenis_sijil1 = $rsSPM->fields['jenis_sijil'];
		$nama_sijil1 = $rsSPM->fields['nama_sijil'];
		$gred_bm1 = $rsSPM->fields['gred_bm'];
		$svm_pngk1 = $rsSPM->fields['svm_pngk'];
		$svm_pngkv1 = $rsSPM->fields['svm_pngkv'];
	} else {
		$tahun2 = $rsSPM->fields['tahun'];
		$jenis_sijil2 = $rsSPM->fields['jenis_sijil'];
		$nama_sijil2 = $rsSPM->fields['nama_sijil'];
		$gred_bm2 = $rsSPM->fields['gred_bm'];
		$svm_pngk2 = $rsSPM->fields['svm_pngk'];
		$svm_pngkv2 = $rsSPM->fields['svm_pngkv'];
	}
	$bil++;
	$rsSPM->movenext();
}


if(!empty($tahun_sijil6_1)){ 
	$rsSTPM = $conn->query("SELECT * FROM $schema2.calon_stp_stam WHERE `jenis_xm`='B' AND `tahun`=".tosql($tahun_sijil6_1)." AND `id_pemohon`=".tosql($id_pemohon));
	$bil=0;
	while(!$rsSTPM->EOF){
		$bil++;
		if($bil==1){
			$mpel61_1=$rsSTPM->fields['matapelajaran'];
			$gred61_1=$rsSTPM->fields['gred'];
		} else if($bil==2){
			$mpel61_2=$rsSTPM->fields['matapelajaran'];
			$gred61_2=$rsSTPM->fields['gred'];
		} else if($bil==3){
			$mpel61_3=$rsSTPM->fields['matapelajaran'];
			$gred61_3=$rsSTPM->fields['gred'];
		} else if($bil==4){
			$mpel61_4=$rsSTPM->fields['matapelajaran'];
			$gred61_4=$rsSTPM->fields['gred'];
		} else if($bil==5){
			$mpel61_5=$rsSTPM->fields['matapelajaran'];
			$gred61_5=$rsSTPM->fields['gred'];
		}
		$rsSTPM->movenext();
	}
}
if(!empty($tahun_sijil6_2)){ 
	$rsSTPM = $conn->query("SELECT * FROM $schema2.calon_stp_stam WHERE `jenis_xm`='B' AND `tahun`=".tosql($tahun_sijil6_2)." AND `id_pemohon`=".tosql($id_pemohon));
	$bil=0;
	while(!$rsSTPM->EOF){
		$bil++;
		if($bil==1){
			$mpel62_1=$rsSTPM->fields['matapelajaran'];
			$gred62_1=$rsSTPM->fields['gred'];
		} else if($bil==2){
			$mpel62_2=$rsSTPM->fields['matapelajaran'];
			$gred62_2=$rsSTPM->fields['gred'];
		} else if($bil==3){
			$mpel62_3=$rsSTPM->fields['matapelajaran'];
			$gred62_3=$rsSTPM->fields['gred'];
		} else if($bil==4){
			$mpel62_4=$rsSTPM->fields['matapelajaran'];
			$gred62_4=$rsSTPM->fields['gred'];
		} else if($bil==5){
			$mpel62_5=$rsSTPM->fields['matapelajaran'];
			$gred62_5=$rsSTPM->fields['gred'];
		}
		$rsSTPM->movenext();
	}
}


if(!empty($tahun_stam1)){ 
	$rsS = $conn->query("SELECT * FROM $schema2.calon_stp_stam WHERE `jenis_xm`='A' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($tahun_stam1));
	$bil=0;
	while(!$rsS->EOF){
		$bil++;
		$greds='';
		if($rsS->fields['gred']=='Mumtaz'){ $greds='A'; }
		else if($rsS->fields['gred']=='Jayyid Jiddan'){ $greds='B'; }
		else if($rsS->fields['gred']=='Jayyid'){ $greds='C'; }
		else if($rsS->fields['gred']=='Maqbul'){ $greds='D'; }
		else if($rsS->fields['gred']=='Rasib'){ $greds='F'; }
		
		if($bil==1){
			$mpel_stam2_1=$rsS->fields['matapelajaran'];
			$gred_stam2_1=$greds;
		} else if($bil==2){
			$mpel_stam2_2=$rsS->fields['matapelajaran'];
			$gred_stam2_2=$greds;
		} else if($bil==3){
			$mpel_stam2_3=$rsS->fields['matapelajaran'];
			$gred_stam2_3=$greds;
		} else if($bil==4){
			$mpel_stam2_4=$rsS->fields['matapelajaran'];
			$gred_stam2_4=$greds;
		} else if($bil==5){
			$mpel_stam2_5=$rsS->fields['matapelajaran'];
			$gred_stam2_5=$greds;
		} else if($bil==6){
			$mpel_stam2_6=$rsS->fields['matapelajaran'];
			$gred_stam2_6=$greds;
		} else if($bil==7){
			$mpel_stam2_7=$rsS->fields['matapelajaran'];
			$gred_stam2_7=$greds;
		} else if($bil==8){
			$mpel_stam2_8=$rsS->fields['matapelajaran'];
			$gred_stam2_8=$greds;
		} else if($bil==9){
			$mpel_stam2_10=$rsS->fields['matapelajaran'];
			$gred_stam2_10=$greds;
		} else if($bil==10){
			$mpel_stam2_10=$rsS->fields['matapelajaran'];
			$gred_stam2_10=$greds;
		}
		$rsS->movenext();
	}
}

if(!empty($tahun_stam2)){ 
	$rsS = $conn->query("SELECT * FROM $schema2.calon_stp_stam WHERE `jenis_xm`='A' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($tahun_stam2));
	$bil=0;
	while(!$rsS->EOF){
		$bil++;
		$greds='';
		if($rsS->fields['gred']=='Mumtaz'){ $greds='A'; }
		else if($rsS->fields['gred']=='Jayyid Jiddan'){ $greds='B'; }
		else if($rsS->fields['gred']=='Jayyid'){ $greds='C'; }
		else if($rsS->fields['gred']=='Maqbul'){ $greds='D'; }
		else if($rsS->fields['gred']=='Rasib'){ $greds='F'; }
		
		if($bil==1){
			$mpel_stam2_1=$rsS->fields['matapelajaran'];
			$gred_stam2_1=$greds;
		} else if($bil==2){
			$mpel_stam2_2=$rsS->fields['matapelajaran'];
			$gred_stam2_2=$greds;
		} else if($bil==3){
			$mpel_stam2_3=$rsS->fields['matapelajaran'];
			$gred_stam2_3=$greds;
		} else if($bil==4){
			$mpel_stam2_4=$rsS->fields['matapelajaran'];
			$gred_stam2_4=$greds;
		} else if($bil==5){
			$mpel_stam2_5=$rsS->fields['matapelajaran'];
			$gred_stam2_5=$greds;
		} else if($bil==6){
			$mpel_stam2_6=$rsS->fields['matapelajaran'];
			$gred_stam2_6=$greds;
		} else if($bil==7){
			$mpel_stam2_7=$rsS->fields['matapelajaran'];
			$gred_stam2_7=$greds;
		} else if($bil==8){
			$mpel_stam2_8=$rsS->fields['matapelajaran'];
			$gred_stam2_8=$greds;
		} else if($bil==9){
			$mpel_stam2_10=$rsS->fields['matapelajaran'];
			$gred_stam2_10=$greds;
		} else if($bil==10){
			$mpel_stam2_10=$rsS->fields['matapelajaran'];
			$gred_stam2_10=$greds;
		}
		$rsS->movenext();
	}
}	

// BAKAT
$rsData = $conn->query("SELECT * FROM $schema2.calon_bakat_bahasa WHERE `bakat_bahasa_ind`='B' AND `id_pemohon`=".tosql($id_pemohon));
$bil=0;
while(!$rsData->EOF){
	$bil++;
	if($bil==1){
		$bakat_1=$rsData->fields['bakat_bahasa'];
	} else if($bil==2){
		$bakat_2=$rsData->fields['bakat_bahasa'];
	} else if($bil==3){
		$bakat_3=$rsData->fields['bakat_bahasa'];
	}
	$rsData->movenext();
}

// BAHASA
$rsData = $conn->query("SELECT * FROM $schema2.calon_bakat_bahasa WHERE `bakat_bahasa_ind`='L' AND `id_pemohon`=".tosql($id_pemohon));
$bil=0;
while(!$rsData->EOF){
	$bil++;
	if($bil==1){
		$jenis_bahasa1=$rsData->fields['bakat_bahasa'];
		$penguasaan1=$rsData->fields['penguasaan'];
	} else if($bil==2){
		$jenis_bahasa2=$rsData->fields['bakat_bahasa'];
		$penguasaan2=$rsData->fields['penguasaan'];
	} else if($bil==3){
		$jenis_bahasa3=$rsData->fields['bakat_bahasa'];
		$penguasaan3=$rsData->fields['penguasaan'];
	}
	$rsData->movenext();
}


// IPT
$rsData = $conn->query("SELECT * FROM $schema2.calon_ipt WHERE `id_pemohon`=".tosql($id_pemohon)." ORDER BY `bil_keputusan`");
$bil=0; $biasiswa_p='';
while(!$rsData->EOF){
	$bil++;
	if($rsData->fields['bil_keputusan']==1){
		$tarikh_lulus1=str_replace("/","",DisplayDate($rsData->fields['tahun']));
		$cgpa1=$rsData->fields['cgpa'];
		$institusi1=$rsData->fields['inst_keluar_sijil'];
		$p_layak1=$rsData->fields['peringkat'];
		$kelayakan1='';
		$pengkhususan1=$rsData->fields['pengkhususan'];

		if($rsData->fields['inst_francais']=='1' || $rsData->fields['inst_francais']=='Y'){
			$institusi1_fln=1;
		} else {
			$institusi1_fln=2;
		}

	} else if($rsData->fields['bil_keputusan']==2){
		$tarikh_lulus2=str_replace("/","",DisplayDate($rsData->fields['tahun']));
		$cgpa2=$rsData->fields['cgpa'];
		$institusi2=$rsData->fields['inst_keluar_sijil'];
		$p_layak2=$rsData->fields['peringkat'];
		$kelayakan2='';
		$pengkhususan2=$rsData->fields['pengkhususan'];

		if($rsData->fields['inst_francais']=='1' || $rsData->fields['inst_francais']=='Y'){
			$institusi2_fln=1;
		} else {
			$institusi2_fln=2;
		}

	} else if($rsData->fields['bil_keputusan']==3){
		$tarikh_lulus3=str_replace("/","",DisplayDate($rsData->fields['tahun']));
		$cgpa3=$rsData->fields['cgpa'];
		$institusi3=$rsData->fields['inst_keluar_sijil'];
		$p_layak3=$rsData->fields['peringkat'];
		$kelayakan3='';
		$pengkhususan3=$rsData->fields['pengkhususan'];

		if($rsData->fields['inst_francais']=='1' || $rsData->fields['inst_francais']=='Y'){
			$institusi3_fln=1;
		} else {
			$institusi3_fln=2;
		}

	}
	if(empty($biasiswa_p)){
		$biasiswa_p=$rsData->fields['biasiswa'];
	}
	$rsData->movenext();
}

$rsData = $conn->query("SELECT * FROM $schema2.calon_masih_khidmat WHERE `id_pemohon`=".tosql($id_pemohon));
$jenis_perkhidmatan=$rsData->fields['jenis_perkhidmatan'];
$no_kadp_baru='';
$no_kadp_lama='';
$tarikh_lantik_1=$rsData->fields['d_lantikan_jpa'];
$skim_pekerjaan=$rsData->fields['skim_sekarang'];
$jabatan=$rsData->fields['tpt_bertugas'];
$negeri_jabatan=$rsData->fields['negeri_tpt_bertugas'];
$gred_gaji=$rsData->fields['gred_jawatan_sekarang'];
$taraf_jawatan=$rsData->fields['taraf_jawatan'];
$tarikh_mula=str_replace("/","",DisplayDate($rsData->fields['d_lantikan_khidmat_sekarang']));
$tarikh_disahkan=str_replace("/","",DisplayDate($rsData->fields['d_sah_khidmat_sekarang']));
$gaji_bulanan='';
$pergerakan_gaji='';
$tarikh_pepkhas=str_replace("/","",DisplayDate($rsData->fields['d_lulus_kpsl']));
$kod_pepkhas=$rsData->fields['jenis_xm'];

$skim_pekerjaan_lain=$rsData->fields['skim_sekarang_jika_tiada'];
$jabatan_lain=$rsData->fields['tpt_bertugas_jika_tiada'];
$pepkhas_lain=$rsData->fields['jenis_xm_jika_tiada'];
$id_pencipta='JCSADM';

$tatatertib_1='';
$tkh_hukum_1='';
$tatatertib_2='';
$tkh_hukum_2='';
$harta='';
$indicator='';
$jenis_borang='6';

// SUKAN
$rsData = $conn->query("SELECT * FROM $schema2.`calon_ko_sukan` A, $schema1.`ref_sukan` B WHERE A.`sukan`=B.`kod` AND A.`id_pemohon`=".tosql($id_pemohon));
$bil=0;
while(!$rsData->EOF){
	$bil++;
	if($bil==1){
		$sukan_1 = $rsData->fields['sukan'];
		$sukan_nama_1 = $rsData->fields['deskripsi'];
		$sukan_peringkat_1 = $rsData->fields['peringkat'];
	} else if($bil==2){
		$sukan_2 = $rsData->fields['sukan'];
		$sukan_nama_2 = $rsData->fields['deskripsi'];
		$sukan_peringkat_2 = $rsData->fields['peringkat'];
	} else if($bil==3){
		$sukan_3 = $rsData->fields['sukan'];
		$sukan_nama_3 = $rsData->fields['deskripsi'];
		$sukan_peringkat_3 = $rsData->fields['peringkat'];
	}

	$rsData->movenext();
}

// PERSATUAN
$rsData = $conn->query("SELECT * FROM $schema2.`calon_ko_persatuan` WHERE `id_pemohon`=".tosql($id_pemohon));
$bil=0;
while(!$rsData->EOF){
	$bil++;
	if($bil==1){
		$persatuan_1='';
		$persatuan_nama_1 = $rsData->fields['persatuan'];
		$persatuan_jawatan_1 = $rsData->fields['jawatan'];
		$persatuan_peringkat_1 = $rsData->fields['peringkat'];
	} else if($bil==2){
		$persatuan_2='';
		$persatuan_nama_2 = $rsData->fields['persatuan'];
		$persatuan_jawatan_2 = $rsData->fields['jawatan'];
		$persatuan_peringkat_2 = $rsData->fields['peringkat'];
	} else if($bil==3){
		$persatuan_3='';
		$persatuan_nama_3 = $rsData->fields['persatuan'];
		$persatuan_jawatan_3 = $rsData->fields['jawatan'];
		$persatuan_peringkat_3 = $rsData->fields['peringkat'];
	}

	$rsData->movenext();
}

// REKACIPTA
$rsData = $conn->query("SELECT * FROM $schema2.`calon_ko_rekacipta` WHERE `id_pemohon`=".tosql($id_pemohon));
$sumbangan_rekacipta = $rsData->fields['sumbangan'];
$sumbangan_rekacipta_nama = $rsData->fields['rekacipta'];
$sumbangan_rekacipta_peringkat = $rsData->fields['peringkat'];

// REKACIPTA
$rsData = $conn->query("SELECT * FROM $schema2.`calon_ko_khas` WHERE `id_pemohon`=".tosql($id_pemohon));
if(!$rsData->EOF){
	$pencapaian_khas = 'Y';
	$pencapaian_khas_nama = $rsData->fields['pencapaian'];
}
// PLKN
$rsData = $conn->query("SELECT * FROM $schema2.`calon_ko_plkn` WHERE `id_pemohon`=".tosql($id_pemohon));
$plkn = $rsData->fields['plkn'];

$status_pekerjaan='';
$tarikh_isytihar_harta='';
$abai_semak_rekod='';
if(empty($abai_semak_rekod)){ $abai_semak_rekod='T'; }
$sebab_abai_semak='';
$tarikh_abai_semak='';
$id_abai_semak='';
$institusi1_lain='';
$institusi2_lain='';
$institusi3_lain='';
$pengkhususan1_lain='';
$pengkhususan2_lain='';
$pengkhususan3_lain='';
$profesional_lain='';
$sumber_daftar=1;

$flag_upload='T';
$tarikh_upload=date("Y-m-d H:i:s");
$ip_address=get_client_ipSubmit();
$INDICATOR_DESC=''; 
$KOD_PROGRAM=''; 
$KOD_OPSYEN='';

$tkh_cipta=date("Y-m-d H:i:s");


if(!empty($tarikh_lantik_1)){ $tarikh_lantik_1="TIMESTAMP'".$tarikh_lantik_1." 00:00:00.0'"; }	
if(!empty($tkh_cipta)){ $tkh_cipta="TIMESTAMP'".$tkh_cipta.".0'"; }	
if(!empty($tarikh_upload)){ $tarikh_upload="TIMESTAMP'".$tarikh_upload.".0'"; }	
if(!empty($tarikh_mohon_jobsm)){ $tarikh_mohon_jobsm="TIMESTAMP'".$tarikh_mohon_jobsm.".0'"; }	
if(!empty($tarikh_mohon_spp)){ $tarikh_mohon_spp="TIMESTAMP'".$tarikh_mohon_spp.".0'"; }	
if(!empty($tarikh_kemaskini_spp)){ $tarikh_kemaskini_spp="TIMESTAMP'".$tarikh_kemaskini_spp.".0'"; }	

// GET $pk Value from oracle database
//$rsOra = $conn_ora->query("SELECT s_calon8i_seq.NEXTVAL AS vals FROM dual");
//$nexval = $rsOra->fields['vals'];
//print_r($results);

$result = odbc_exec($connOra, "SELECT s_calon8i_seq.NEXTVAL FROM dual");
$nexval=odbc_result($result,1);
//print $nexval;
//$nexval = '54940158';

$sql="INSERT INTO ESMSM_DATA.S_CALON8I (PK_KEY,NO_KELOMPOK,NO_SIRI,LITHO_CODE,JENIS_PENDAFTARAN,NO_KP_BARU,NO_KP_LAMA,
SKIM_1,SKIM_2,SKIM_3,SKIM_4,SKIM_5,SKIM_6,SKIM_7,SKIM_8,SKIM_9,SKIM_10,SKIM_11,SKIM_12,SKIM_13,SKIM_14,SKIM_15,SKIM_16,SKIM_17,SKIM_18,SKIM_19,SKIM_20,
PUSAT_TD,NAMA_PENUH,TARIKH_LAHIR,TEMPAT_LAHIR,JANTINA,TARAF_PERKAHWINAN,KETURUNAN,
AGAMA,KEWARGANEGARAAN,KECACATAN_CALON,DAFTAR_CACAT,NOM_DAFTAR,BIASISWA_P,
BANTUAN,NOM_DAFTAR_BANTUAN,TEMPAT_LAHIR_IBU,TEMPAT_LAHIR_BAPA,KOD_TEL,NO_TEL,
ALAMAT,ALAMAT2,ALAMAT3,POSKOD,BANDAR,NEGERI_TINGGAL,BAHAGIAN_TINGGAL,
TAHUN_SIJIL3,JENIS_SIJIL3,PANGKAT_SIJIL3,MPEL3_1,GRED3_1,MPEL3_2,GRED3_2,MPEL3_3,GRED3_3,MPEL3_4,GRED3_4,MPEL3_5,GRED3_5,MPEL3_6,GRED3_6,MPEL3_7,GRED3_7,MPEL3_8,GRED3_8,MPEL3_9,GRED3_9,MPEL3_10,GRED3_10,
TAHUN_SIJIL5,JENIS_SIJIL5,PANGKAT_SIJIL5,UJIAN_LISAN,MPEL5_1,GRED5_1,MPEL5_2,GRED5_2,MPEL5_3,GRED5_3,MPEL5_4,GRED5_4,MPEL5_5,GRED5_5,MPEL5_6,GRED5_6,MPEL5_7,GRED5_7,MPEL5_8,GRED5_8,MPEL5_9,GRED5_9,MPEL5_10,GRED5_10,
TAHUN_SIJIL52,JENIS_SIJIL52,PANGKAT_SIJIL52,UJIAN_LISAN52,MPEL52_1,GRED52_1,MPEL52_2,GRED52_2,MPEL52_3,GRED52_3,MPEL52_4,GRED52_4,MPEL52_5,GRED52_5,MPEL52_6,GRED52_6,MPEL52_7,GRED52_7,MPEL52_8,GRED52_8,MPEL52_9,GRED52_9,MPEL52_10,GRED52_10,
BM_SAP_TAHUN,BM_SAP_GRED,BM_SAP_LISAN,BM_SETARAF_TAHUN,BM_SETARAF_JENIS,BM_SETARAF_GRED,BM_SETARAF_LISAN,MATH5_TAHUN,MATH5_GRED,
TAHUN_SIJIL6_1,JENIS_SIJIL6_1,PANGKAT_SIJIL6_1,MPEL61_1,GRED61_1,MPEL61_2,GRED61_2,MPEL61_3,GRED61_3,MPEL61_4,GRED61_4,MPEL61_5,GRED61_5,
TAHUN_SIJIL6_2,JENIS_SIJIL6_2,PANGKAT_SIJIL6_2,MPEL62_1,GRED62_1,MPEL62_2,GRED62_2,MPEL62_3,GRED62_3,MPEL62_4,GRED62_4,MPEL62_5,GRED62_5,
BAKAT_1,BAKAT_2,BAKAT_3,JENIS_BAHASA1,PENGUASAAN1,JENIS_BAHASA2,PENGUASAAN2,JENIS_BAHASA3,PENGUASAAN3,KATEGORI,PANGKAT,PENCEN,TARIKH_AHLI,PROFESIONAL,TARIKH_LULUS,JAB_KHAS,
TARIKH_LULUS1,CGPA1,INSTITUSI1,P_LAYAK1,KELAYAKAN1,PENGKHUSUSAN1,
TARIKH_LULUS2,CGPA2,INSTITUSI2,P_LAYAK2,KELAYAKAN2,PENGKHUSUSAN2,
TARIKH_LULUS3,CGPA3,INSTITUSI3,P_LAYAK3,KELAYAKAN3,PENGKHUSUSAN3,
JENIS_PERKHIDMATAN,NO_KADP_BARU,NO_KADP_LAMA,TARIKH_LANTIK_1,SKIM_PEKERJAAN,JABATAN,NEGERI_JABATAN,GRED_GAJI,TARAF_JAWATAN,TARIKH_MULA,TARIKH_DISAHKAN,GAJI_BULANAN,PERGERAKAN_GAJI,TARIKH_PEPKHAS,KOD_PEPKHAS,TATATERTIB_1,TKH_HUKUM_1,TATATERTIB_2,TKH_HUKUM_2,HARTA,INDICATOR,
JENIS_BORANG,PENGGUNA,TKH_UBAH,LESEN_MEMANDU,INSTITUSI1_FLN,INSTITUSI2_FLN,INSTITUSI3_FLN,
SUKAN_1,SUKAN_NAMA_1,SUKAN_PERINGKAT_1,SUKAN_2,SUKAN_NAMA_2,SUKAN_PERINGKAT_2,SUKAN_3,SUKAN_NAMA_3,SUKAN_PERINGKAT_3,
PERSATUAN_1,PERSATUAN_NAMA_1,PERSATUAN_JAWATAN_1,PERSATUAN_PERINGKAT_1,PERSATUAN_2,PERSATUAN_NAMA_2,PERSATUAN_JAWATAN_2,PERSATUAN_PERINGKAT_2,PERSATUAN_3,PERSATUAN_NAMA_3,PERSATUAN_JAWATAN_3,PERSATUAN_PERINGKAT_3,
SUMBANGAN_REKACIPTA,SUMBANGAN_REKACIPTA_NAMA,SUMBANGAN_REKACIPTA_PERINGKAT,PENCAPAIAN_KHAS,PENCAPAIAN_KHAS_NAMA,PLKN,STATUS_PEKERJAAN,
TARIKH_ISYTIHAR_HARTA,ABAI_SEMAK_REKOD,SEBAB_ABAI_SEMAK,TARIKH_ABAI_SEMAK,ID_ABAI_SEMAK,EMAIL,
INSTITUSI1_LAIN,INSTITUSI2_LAIN,INSTITUSI3_LAIN,PENGKHUSUSAN1_LAIN,PENGKHUSUSAN2_LAIN,PENGKHUSUSAN3_LAIN,
PROFESIONAL_LAIN,SKIM_PEKERJAAN_LAIN,JABATAN_LAIN,PEPKHAS_LAIN,TARIKH_CIPTA,ID_PENCIPTA,JENIS_POHON,FLAG_UPLOAD,TARIKH_UPLOAD,IP_ADDRESS,
TAHUN_STAM1,JENIS_STAM1,PANGKAT_STAM1,MPEL_STAM1_1,GRED_STAM1_1,MPEL_STAM1_2,GRED_STAM1_2,MPEL_STAM1_3,GRED_STAM1_3,MPEL_STAM1_4,GRED_STAM1_4,MPEL_STAM1_5,GRED_STAM1_5,MPEL_STAM1_6,GRED_STAM1_6,MPEL_STAM1_7,GRED_STAM1_7,MPEL_STAM1_8,GRED_STAM1_8,MPEL_STAM1_9,GRED_STAM1_9,MPEL_STAM1_10,GRED_STAM1_10,
TAHUN_STAM2,MPEL_STAM2_1,GRED_STAM2_1,MPEL_STAM2_2,GRED_STAM2_2,MPEL_STAM2_3,GRED_STAM2_3,MPEL_STAM2_4,GRED_STAM2_4,MPEL_STAM2_5,GRED_STAM2_5,MPEL_STAM2_6,GRED_STAM2_6,MPEL_STAM2_7,GRED_STAM2_7,MPEL_STAM2_8,GRED_STAM2_8,MPEL_STAM2_9,GRED_STAM2_9,MPEL_STAM2_10,GRED_STAM2_10,SUMBER_DAFTAR,JENIS_STAM2,PANGKAT_STAM2,

KETINGGIAN,INDICATOR_DESC,KOD_PROGRAM,KOD_OPSYEN,
TARIKH_MOHON_JOBSM,TARIKH_MOHON_SPP,TARIKH_KEMASKINI_SPP) 
VALUES(".tosql($nexval,"Number").",".tosql($no_kelompok).",".tosql($no_siri).",".tosql($litho_code).",".tosql($jenis_pendaftaran).",".tosql($no_kp_baru).",".tosql($no_kp_lama).", 
".tosql($skim_1).",".tosql($skim_2).",".tosql($skim_3).",".tosql($skim_4).",".tosql($skim_5).",".tosql($skim_6).",".tosql($skim_7).",".tosql($askim_8).",".tosql($skim_9).",".tosql($skim_10).",".tosql($skim_11).",".tosql($skim_12).",".tosql($skim_13).",".tosql($skim_14).",".tosql($skim_15).",".tosql($skim_16).",".tosql($skim_17).",".tosql($skim_18).",".tosql($skim_19).",".tosql($skim_20).", 
".tosql($pusat_td).",".tosqlnama($nama_penuh).",".tosql($tarikh_lahir).",".tosql($tempat_lahir).",".tosql($jantina).",".tosql($taraf_perkahwinan).",".tosql($keturunan).", 
    	".tosql($agama).",".tosql($warganegara).",".tosql($kecacatan_calon).",".tosql($daftar_cacat).",".tosql($nom_daftar).",".tosql($biasiswa_p).", 
    	".tosql($bantuan).",".tosql($nom_daftar_bantuan).",".tosql($tempat_lahir_ibu).",".tosql($tempat_lahir_bapa).",".tosql($kod_tel).",".tosql($no_tel).", 
    	".tosqlnama($alamat).",".tosqlnama($alama2).",".tosqlnama($alama3).",".tosql($poskod).",".tosqlnama($bandar).",".tosql($negeri_tinggal).",".tosql($bahagian_tinggal).", 
    	".tosql($tahun_sijil3).",".tosql($jenis_sijil3).",".tosql($pangkat_sijil3).",".tosql($mpel3_1).",".tosql($gred3_1).",".tosql($mpel3_2).",".tosql($gred3_2).", 
    	".tosql($mpel3_3).",".tosql($gred3_3).",".tosql($mpel3_4).",".tosql($gred3_4).",".tosql($mpel3_5).",".tosql($gred3_5).",".tosql($mpel3_6).",".tosql($gred3_6).", 
    	".tosql($mpel3_7).",".tosql($gred3_7).",".tosql($mpel3_8).",".tosql($gred3_8).",".tosql($mpel3_9).",".tosql($gred3_9).",".tosql($mpel3_10).",".tosql($gred3_10).", 
    	".tosql($tahun_sijil5).",".tosql($jenis_sijil5).",".tosql($pangkat_sijil5).",".tosql($ujian_lisan).",".tosql($mpel5_1).",".tosql($gred5_1).", 
    	".tosql($mpel5_2).",".tosql($gred5_2).",".tosql($mpel5_3).",".tosql($gred5_3).",".tosql($mpel5_4).",".tosql($gred5_4).",".tosql($mpel5_5).",".tosql($gred5_5).", 
    	".tosql($mpel5_6).",".tosql($gred5_6).",".tosql($mpel5_7).",".tosql($gred5_7).",".tosql($mpel5_8).",".tosql($gred5_8).",".tosql($mpel5_9).",".tosql($gred5_9).", 
    	".tosql($mpel5_10).",".tosql($gred5_10).", 
	 	".tosql($tahun_sijil52).",".tosql($jenis_sijil52).",".tosql($pangkat_sijil52).",".tosql($ujian_lisan52).",".tosql($mpel52_1).",".tosql($gred52_1).", 
    	".tosql($mpel52_2).",".tosql($gred52_2).",".tosql($mpel52_3).",".tosql($gred52_3).",".tosql($mpel52_4).",".tosql($gred52_4).",".tosql($mpel52_5).",".tosql($gred52_5).", 
    	".tosql($mpel52_6).",".tosql($gred52_6).",".tosql($mpel52_7).",".tosql($gred52_7).",".tosql($mpel52_8).",".tosql($gred52_8).",".tosql($mpel52_9).",".tosql($gred52_9).", 
    	".tosql($mpel52_10).",".tosql($gred52_10).", 
    	".tosql($bm_sap_tahun).",".tosql($bm_sap_gred).",".tosql($bm_sap_lisan).",".tosql($bm_setaraf_tahun).",".tosql($bm_setaraf_jenis).",".tosql($bm_setaraf_gred).",".tosql($bm_setaraf_lisan).",".tosql($math5_tahun).",".tosql($math5_gred).", 
    	".tosql($tahun_sijil6_1).",".tosql($jenis_sijil6_1).",".tosql($pangkat_sijil6_1).",".tosql($mpel61_1).",".tosql($gred61_1).",".tosql($mpel61_2).",".tosql($gred61_2).",".tosql($mpel61_3).",".tosql($gred61_3).",".tosql($mpel61_4).",".tosql($gred61_4).",".tosql($mpel61_5).",".tosql($gred61_5).", 
    	".tosql($tahun_sijil6_2).",".tosql($jenis_sijil6_2).",".tosql($pangkat_sijil6_2).",".tosql($mpel62_1).",".tosql($gred62_1).",".tosql($mpel62_2).",".tosql($gred62_2).",".tosql($mpel62_3).",".tosql($gred62_3).",".tosql($mpel62_4).",".tosql($gred62_4).",".tosql($mpel62_5).",".tosql($gred62_5).", 
    	".tosql($bakat_1).",".tosql($bakat_2).",".tosql($bakat_3).",".tosql($jenis_bahasa1).",".tosql($penguasaan1).",".tosql($jenis_bahasa2).",".tosql($aapenguasaan2).",".tosql($jenis_bahasa3).",".tosql($penguasaan3).", 
    	".tosql($kategori).",".tosql($pangkat).",".tosql($pencen).",".tosql($tarikh_ahli).",".tosql($profesional).",".tosql($tarikh_lulus).",".tosql($jab_khas).", 
    	".tosql($tarikh_lulus1).",".tosql($cgpa1).",".tosql($institusi1).",".tosql($p_layak1).",".tosql($kelayakan1).",".tosql($pengkhususan1).", 
    	".tosql($tarikh_lulus2).",".tosql($cgpa2).",".tosql($institusi2).",".tosql($p_layak2).",".tosql($kelayakan2).",".tosql($pengkhususan2).", 
    	".tosql($tarikh_lulus3).",".tosql($cgpa3).",".tosql($institusi3).",".tosql($p_layak3).",".tosql($kelayakan3).",".tosql($pengkhususan3).", 
		".tosql($jenis_perkhidmatan).",".tosql($no_kadp_baru).",".tosql($no_kadp_lama).",$tarikh_lantik_1,".tosql($skim_pekerjaan).",".tosql($jabatan).",".tosql($negeri_jabatan).", 
		".tosql($gred_gaji).",".tosql($taraf_jawatan).",".tosql($tarikh_mula).",".tosql($tarikh_disahkan).",".tosql($gaji_bulanan).",".tosql($pergerakan_gaji).",".tosql($tarikh_pepkhas).",".tosql($kod_pepkhas).", ".tosql($tatatertib_1).",".tosql($tkh_hukum_1).",".tosql($tatatertib_2).",".tosql($tkh_hukum_2).",".tosql($harta).",".tosql($indicator).",
		".tosql($jenis_borang).",".tosql($pengguna).",".tosql($tkh_ubah).",".tosql($lesen_memandu).", 
		".tosql($institusi1_fln).",".tosql($institusi2_fln).",".tosql($institusi3_fln).", 
		".tosql($sukan_1).",".tosql($sukan_nama_1).",".tosql($sukan_peringkat_1).",".tosql($sukan_2).",".tosql($sukan_nama_2).",".tosql($sukan_peringkat_2).", 
		".tosql($sukan_3).",".tosql($sukan_nama_3).",".tosql($sukan_peringkat_3).", 
		".tosql($persatuan_1).",".tosql($persatuan_nama_1).",".tosql($persatuan_jawatan_1).",".tosql($persatuan_peringkat_1).", ".tosql($persatuan_2).",".tosql($persatuan_nama_2).",".tosql($persatuan_jawatan_2).",".tosql($persatuan_peringkat_2).", 
		".tosql($persatuan_3).",".tosql($persatuan_nama_3).",".tosql($persatuan_jawatan_3).",".tosql($persatuan_peringkat_3).", 
		".tosql($sumbangan_rekacipta).",".tosql($sumbangan_rekacipta_nama).",".tosql($sumbangan_rekacipta_peringkat).",".tosql($pencapaian_khas).", 
		".tosql($pencapaian_khas_nama).",".tosql($plkn).",".tosql($status_pekerjaan).",".tosql($tarikh_isytihar_harta).",".tosql($abai_semak_rekod).",".tosql($sebab_abai_semak).",".tosql($tarikh_abai_semak).",".tosql($id_abai_semak).",".tosqln($email).", 
		".tosql($institusi1_lain).",".tosql($institusi2_lain).",".tosql($institusi3_lain).",".tosql($pengkhususan1_lain).",".tosql($pengkhususan2_lain).",".tosql($pengkhususan3_lain).", 
		".tosql($profesional_lain).",".tosql($skim_pekerjaan_lain).",".tosql($jabatan_lain).",".tosql($pepkhas_lain).",$tkh_cipta,".tosql($id_pencipta).",".tosql($jenis_pohon).",".tosql($flag_upload).",$tarikh_upload,".tosql($ip_address).",
		".tosql($tahun_stam1).",".tosql($jenis_stam1).",".tosql($pangkat_stam1).",".tosql($mpel_stam1_1).",".tosql($gred_stam1_1).",".tosql($mpel_stam1_2).",".tosql($gred_stam1_2).", 
		".tosql($mpel_stam1_3).",".tosql($gred_stam1_3).",".tosql($mpel_stam1_4).",".tosql($gred_stam1_4).",".tosql($mpel_stam1_5).",".tosql($gred_stam1_5).", 
		".tosql($mpel_stam1_6).",".tosql($gred_stam1_6).",".tosql($mpel_stam1_7).",".tosql($gred_stam1_7).",".tosql($mpel_stam1_8).",".tosql($gred_stam1_8).", 
		".tosql($mpel_stam1_9).",".tosql($gred_stam1_9).",".tosql($mpel_stam1_10).",".tosql($gred_stam1_10).", 
		".tosql($tahun_stam2).",".tosql($mpel_stam2_1).",".tosql($gred_stam2_1).",".tosql($mpel_stam2_2).",".tosql($gred_stam2_2).",".tosql($mpel_stam2_3).",
		".tosql($gred_stam2_3).",".tosql($mpel_stam2_4).",".tosql($gred_stam2_4).",  
		".tosql($mpel_stam2_5).",".tosql($gred_stam2_5).",".tosql($mpel_stam2_6).",".tosql($gred_stam2_6).",".tosql($mpel_stam2_7).",".tosql($gred_stam2_7).", 
		".tosql($mpel_stam2_8).",".tosql($gred_stam2_8).",".tosql($mpel_stam2_9).",".tosql($gred_stam2_9).",".tosql($mpel_stam2_10).",".tosql($gred_stam2_10).",".tosql($sumber_daftar).",
".tosql($jenis_stam2).",".tosql($pangkat_stam2).",".tosql($ketinggian,"Number").", ".tosql($INDICATOR_DESC).",".tosql($KOD_PROGRAM).",".tosql($KOD_OPSYEN).",$tarikh_mohon_jobsm,$tarikh_mohon_spp,$tarikh_kemaskini_spp)";


	//print $sql;
	$results = odbc_exec($connOra, $sql);
        if ($results){
             	//echo "Query Executed";
		$err='OK';
		$sql = "UPDATE $schema2.`calon` SET `status_pemohon`='Y' WHERE `id_pemohon`=".tosql($id_pemohon);
		$rss = $conn->execute($sql);
		$sql2 = "UPDATE $schema2.`calon_tarikh` SET `status_pemohon`='Y' WHERE `id_pemohon`=".tosql($id_pemohon);
		$rss = $conn->execute($sql2);


        } else {
		$err='ERRORA';
              //echo "Query failed " .odbc_errormsg();
        }   
//print $err;
?>