<?php
include '../connection/common_log.php';
//$conn->debug=true;

$srp_tahun=isset($_REQUEST["srp_tahun"])?$_REQUEST["srp_tahun"]:"";
$jenis_sijil_arr = array();
$gred_arr = array();
if(!empty($srp_tahun)){ 
	if($srp_tahun <= 1992){
		$query = "SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='3' AND is_aktif=0 AND KOD=2";

		$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE `TKT`='3' AND `GRED` NOT IN ('A','B','C','D','E','F') ORDER BY `SUSUNAN`");
	} else {
		$query = "SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='3' AND is_aktif=0 AND KOD=1";	

		$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE `TKT`='3' AND `GRED` IN ('A','B','C','D','E','F') ORDER BY `SUSUNAN`");
	}
	$results = $conn->query($query);

	//$jenis_sijil_arr[] = array("kod" => "", "jenis_sijil" => "Sila pilih jenis sijil");
	while(!$results->EOF) {
		$kep = '';
		if(!empty($results->fields['KOD'])){ 
			$kep = $results->fields['DISKRIPSI']; 
		}

		$jenis_sijil_arr[] = array("kod" => strtoupper($results->fields['KOD']), "jenis_sijil" => strtoupper($kep));
		$results->movenext(); 
	}

	$gred_arr[] = array("KOD" => "", "gred" => "Sila pilih gred");
	while(!$rsGred->EOF) {
		$gred = '';
		if(!empty($rsGred->fields['GRED'])){ 
			if(!empty($gred)){ $gred .= " / "; }
			$gred .= $rsGred->fields['GRED']; 
		}

		$gred_arr[] = array("KOD" => strtoupper($rsGred->fields['GRED']), "gred" => strtoupper($gred));
		$rsGred->movenext(); 
	}

}
//echo json_encode($jenis_sijil_arr);
echo json_encode([$jenis_sijil_arr, $gred_arr]);

//$conn->close();
?>